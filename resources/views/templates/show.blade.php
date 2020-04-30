@extends('layouts.app')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">DNS records for template ({{ $template->name }})</h1>
        <div class="float-md-right">
            <a href="/template/{{ $template->id }}/records/create">
                <button type="button" class="btn btn-primary btn-sm">Create record</button>
            </a>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="table-responsive">
            <table class="table table-hover table-striped" style="font-size: 0.9rem;">
                <thead>
                <tr>
                    <th>Type</th>
                    <th>Name</th>
                    <th>Content</th>
                    <th>TTL</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach($records as $record)
                    <tr>
                        <td>{{ $record->record_type }}</td>
                        <td>@if ($record->name == NULL) [DOMAIN] @else{{ $record->name }}.[DOMAIN]@endif</td>
                        <td class="recordcontent">{{ $record->content }}</td>
                        <td>{{ $record->ttl }}</td>
                        <td class="text-right">
                            <form method="POST" action="/template/{{ $template->id }}/records/{{ $record->id }}/delete">
                                @csrf
                                @method('DELETE')
                                <a href="/template/{{ $template->id }}/records/{{ $record->id }}/edit" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></a>
                                <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-trash-alt"></i></button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
