<?php

namespace App\Http\Controllers;

use App\Http\Requests\AssignTag;
use App\Http\Requests\CreateTag;
use App\Tag;
use App\ZoneTag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified', 'two_factor']);
    }

    public function index()
    {
        return view('tags.list', [
            'tags' => auth()->user()->tags->sortBy('name')
        ]);
    }

    public function store(CreateTag $request)
    {
        $attribute['name'] = $request->get('name');

        auth()->user()->tags()->create($attribute);

        return redirect('/tags');
    }

    public function destroy(string $id)
    {
        $tag = auth()->user()->tags()->where('id', $id)->firstOrFail();

        $zonetag = ZoneTag::where([
            ['tag_id', $tag->id]
        ]);

        $zonetag->delete();
        $tag->delete();

        return redirect('/tags');
    }

    public function show(string $id)
    {
        $tag = auth()->user()->tags()->where('id', $id)->firstOrFail();

        return view('tags.edit', compact('tag'));
    }

    public function update(CreateTag $request)
    {
        auth()->user()->tags()->where('id', $request->id)->firstOrFail();

        $attribute['name'] = $request->get('name');

        auth()->user()->tags()->where('id', $request->id)->update($attribute);

        return redirect('/tags');
    }

    public function showAssign(string $id)
    {
        $tag = auth()->user()->tags()->where('id', $id)->firstOrFail();
        $zones = auth()->user()->zones->sortBy('domain');
        $domains = [];

        foreach ($zones as $zone){
            $checkifexisting = $zone->tags()->where([
                ['zone_id', $zone->id],
                ['tag_id', $tag->id]
            ]);

            if($checkifexisting->count() == 0){
                $domains[] = $zone;
            }
        }

        return view('tags.assign', compact('tag', 'domains'));
    }

    public function assign(AssignTag $request)
    {
        $zone = auth()->user()->zones()->where('id', $request->domain)->firstOrFail();
        $tag = auth()->user()->tags()->where('id', $request->id)->firstOrFail();

        $checkcount = ZoneTag::where([
            ['zone_id', $zone->id],
            ['tag_id', $tag->id]
        ])->count();

        if($checkcount != 0){
            abort(404);
        }

        $attribute['zone_id'] = $zone->id;
        $attribute['tag_id'] = $tag->id;

        ZoneTag::create($attribute);

        return redirect('/tags');
    }

    public function showDismiss(string $id)
    {
        $tag = auth()->user()->tags()->where('id', $id)->firstOrFail();

        $domains = [];

        foreach ($tag->zones as $key => $zoneids){
            $domains[$key] = auth()->user()->zones()->where('id', $zoneids->zone_id)->firstOrFail();
        }

        return view('tags.dismiss', compact('tag', 'domains'));
    }

    public function dismiss(Request $request)
    {
        $zone = auth()->user()->zones()->where('id', $request->domain)->firstOrFail();
        $tag = auth()->user()->tags()->where('id', $request->id)->firstOrFail();

        $zonetag = ZoneTag::where([
            ['zone_id', $zone->id],
            ['tag_id', $tag->id]
        ]);

        $zonetag->delete();

        return redirect('/tags');
    }
}
