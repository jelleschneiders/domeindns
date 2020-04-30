<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateRecordTemplate;
use App\Http\Requests\EditRecordTemplate;
use App\TemplateRecord;
use Illuminate\Http\Request;

class TemplateRecordController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified', 'two_factor']);
    }

    public function storeView(string $id)
    {
        $template = auth()->user()->templates()->where('id', $id)->firstOrFail();

        return view('templates.records.create', compact('template'));
    }

    public function store(CreateRecordTemplate $request)
    {
        $template = auth()->user()->templates()->where('id', $request->id)->firstOrFail();

        $attribute['template_id'] = $template->id;
        $attribute['record_type'] = $request->get('type');
        $attribute['ttl'] = $request->get('ttl');
        $attribute['name'] = $request->get('name');
        $attribute['content'] = $request->get('content');

        TemplateRecord::create($attribute);

        return redirect('/template/'.$template->id);
    }

    public function destroy(string $id, string $recordid)
    {
        $template = auth()->user()->templates()->where('id', $id)->firstOrFail();
        $record = $template->records()->where('id', $recordid)->firstOrFail();

        $record->delete();

        return redirect('/template/'.$template->id);
    }

    public function show(string $id, string $recordid)
    {
        $template = auth()->user()->templates()->where('id', $id)->firstOrFail();
        $record = $template->records()->where('id', $recordid)->firstOrFail();

        return view('templates.records.edit', compact('template', 'record'));
    }

    public function update(EditRecordTemplate $request)
    {
        $template = auth()->user()->templates()->where('id', $request->id)->firstOrFail();
        $record = $template->records()->where('id', $request->recordid)->firstOrFail();

        $attribute['record_type'] = $request->get('type');
        $attribute['ttl'] = $request->get('ttl');
        $attribute['name'] = $request->get('name');
        $attribute['content'] = $request->get('content');

        $record->update($attribute);

        return redirect('/template/'.$template->id);
    }
}
