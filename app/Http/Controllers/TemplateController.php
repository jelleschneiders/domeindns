<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTemplate;
use App\Http\Requests\CreateTemplateDomain;
use App\Status;
use App\Zone;
use Illuminate\Http\Request;

class TemplateController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified', 'two_factor']);
    }

    public function index()
    {
        return view('templates.list', [
            'templates' => auth()->user()->templates->sortBy('name')
        ]);
    }

    public function store(CreateTemplate $request)
    {
        $attribute['name'] = $request->get('name');

        $template = auth()->user()->templates()->create($attribute);
        $template->insertDefaultRecords();

        return redirect('/templates');
    }

    public function show(string $id)
    {
        $template = auth()->user()->templates()->where('id', $id)->firstOrFail();
        $records = $template->records->sortBy('record_type');

        return view('templates.show', compact('template', 'records'));
    }

    public function destroyView(string $id)
    {
        $template = auth()->user()->templates()->where('id', $id)->firstOrFail();

        return view('templates.delete', compact('template'));
    }

    public function destroy(string $id)
    {
        $template = auth()->user()->templates()->where('id', $id)->firstOrFail();

        $template->delete();

        return redirect('/templates');
    }

    public function showCreateDomain()
    {
        $domains = auth()->user()->zones->sortBy('domain');

        return view('templates.createdomain', compact('domains'));
    }

    public function storeDomain(CreateTemplateDomain $request)
    {
        $zone = Zone::where([
            ['user_id', '=', auth()->user()->id],
            ['id', '=', $request->domain]
        ])->firstOrFail();

        $attribute['name'] = $request->get('name');

        $template = auth()->user()->templates()->create($attribute);

        foreach ($zone->records as $record){
            $template->records()->create([
                'record_type' => $record['record_type'],
                'ttl' => $record['ttl'],
                'name' => $record['name'],
                'content' => $record['content']
            ]);
        }

        return redirect('/templates');
    }

}
