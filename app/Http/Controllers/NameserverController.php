<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangeNameservers;
use App\Nameserver;
use Illuminate\Http\Request;

class NameserverController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified', 'two_factor']);
    }

    public function index()
    {
        $nameservers = $this->getNameservers();

        return view('account.nameservers.show', compact('nameservers'));
    }

    public function show()
    {
        $nameservers = $this->getNameservers();

        return view('account.nameservers.edit', compact('nameservers'));
    }

    public function destroy()
    {
        $nameservers = auth()->user()->nameservers;

        foreach ($nameservers as $nameserver){
            $nameserver->delete();
        }

        flash('Nameservers have been set back to the default.');
        return redirect('/account/nameservers');
    }

    public function store(ChangeNameservers $request)
    {
        $ns1['nameserver'] = $request->ns1;
        $ns1['ipv4'] = '159.69.91.103';
        $ns1['ipv6'] = '2a01:4f8:c2c:51f0::1';

        $ns2['nameserver'] = $request->ns2;
        $ns2['ipv4'] = '137.74.118.155';
        $ns2['ipv6'] = '2001:41d0:302:2200::1bc0';

        $ns3['nameserver'] = $request->ns3;
        $ns3['ipv4'] = '128.199.37.162';
        $ns3['ipv6'] = '2a03:b0c0:2:d0::3e6:2001';

        auth()->user()->nameservers()->create($ns1);
        auth()->user()->nameservers()->create($ns2);
        auth()->user()->nameservers()->create($ns3);

        flash('Nameservers have been changed.');
        return redirect('/account/nameservers');
    }

    public function getNameservers()
    {
        $nameservers = auth()->user()->nameservers()->orderByDesc('ipv4')->get();

        if($nameservers->count() == 0){
            $nameservers = Nameserver::where('default', true)->orderByDesc('ipv4')->get();
        }

        return $nameservers;
    }
}
