<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateDomain;
use App\Http\Requests\CreateDomainTemplate;
use App\Jobs\CreateDNSSEC;
use App\Jobs\CreateRecord;
use App\Jobs\CreateZone;
use App\Jobs\DeleteDNSSEC;
use App\Jobs\DeleteZone;
use App\Record;
use App\Status;
use App\Zone;
use Illuminate\Http\Request;

class ZonesController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified', 'two_factor']);
    }

    public function index(){
        $tags = auth()->user()->tags()->get();

        return view('domains.list', [
            'zones' => auth()->user()->zones->sortBy('domain'),
            'tagview' => false,
            'tags' => $tags,
            'searchview' => false,
        ]);
    }

    public function indexTag(string $tagid)
    {
        $tag = auth()->user()->tags()->where('id', $tagid)->firstOrFail();
        $tags = auth()->user()->tags()->get();

        $zones = [];

        foreach ($tag->zones as $key => $zoneids){
            $zones[$key] = auth()->user()->zones()->where('id', $zoneids->zone_id)->firstOrFail();
        }

        return view('domains.list', [
            'zones' => $zones,
            'tagview' => true,
            'tag' => $tag,
            'tags' => $tags,
            'searchview' => false,
        ]);
    }

    public function search(Request $request)
    {
        $tags = auth()->user()->tags()->get();

        $zones = Zone::where([
            ['user_id', '=', auth()->user()->id],
            ['domain', 'like', "%{$request->get('search')}%"]
        ])->get();

        return view('domains.list', [
            'zones' => $zones,
            'tagview' => false,
            'tags' => $tags,
            'searchview' => true,
            'searchstring' => $request->get('search'),
        ]);
    }

    public function show(string $domain){
        $zones = $this->check_domain_owner($domain);

        return view('domains.edit', compact('zones'));
    }

    public function store(CreateDomain $request){
        $attribute['domain'] = $request->get('domain');

        if($request->get('domain') == 'domeindns.nl'){
            return back()->withErrors(['domain' => 'This domain is not allowed.']);
        }

        $zone = auth()->user()->zones()->create($attribute);
        $zone->insertDefaultRecords();
        CreateZone::dispatch($zone);

        return redirect('/domains');
    }

    public function returnDeletePage(string $domain) {
        $zone = $this->check_domain_owner($domain);

        return view('domains.delete', compact('zone'));
    }

    public function destroy(string $domain){
        $zone = $this->check_domain_owner($domain);

        $zone['status'] = Status::$PENDING_DELETION;
        $zone->update();

        DeleteZone::dispatch($zone);

        return redirect('/domains');
    }

    public function showDNSSEC(string $domain){
        $zone = $this->check_domain_owner($domain);

        $pubkeysplit[5] = null;
        $dssplit[5] = null;

        if($zone->dnssec) {
            $pubkeysplit = explode(" ", $zone->dns_sec->dnskey);
            $dssplit = explode(" ", $zone->dns_sec->ds2);
        }

        return view('domains.dnssec', compact('zone', 'pubkeysplit', 'dssplit'));
    }

    public function storeDNSSEC(string $domain){
        $zone = $this->check_domain_owner($domain);

        if($zone->dnssec != false){
            abort(404);
        }

        $zone['status'] = Status::$PENDING_DNSSEC_CREATION;
        $zone->update();

        CreateDNSSEC::dispatch($zone);

        return redirect('/domains');
    }

    public function destroyDNSSEC(string $domain){
        $zone = $this->check_domain_owner($domain);

        if($zone->dnssec != true){
            abort(404);
        }

        $zone->update(['status' => Status::$PENDING_DNSSEC_CREATION]);

        DeleteDNSSEC::dispatch($zone);

        return redirect('/domains');
    }

    public function storeTemplateView()
    {
        $templates = auth()->user()->templates;

        return view('domains.createtemplate', compact('templates'));
    }

    public function storeTemplate(CreateDomainTemplate $request)
    {
        $template = auth()->user()->templates()->where('id', $request->template)->firstOrFail();

        $attribute['domain'] = $request->get('domain');

        $zone = auth()->user()->zones()->create($attribute);
        CreateZone::dispatch($zone);

        foreach ($template->records as $record){
            Record::create_new($zone->id, $record->record_type, $record->ttl, $record->name, $record->content);
        }

        return redirect('/domains');
    }

    public function check_domain_owner(string $domain)
    {
        $zone = Zone::where([
            ['user_id', '=', auth()->user()->id],
            ['domain', '=', $domain],
            ['status', '=', Status::$OK]
        ])->firstOrFail();

        return $zone;
    }
}
