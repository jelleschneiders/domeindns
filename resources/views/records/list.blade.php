@extends('layouts.app')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">DNS records for {{ $zone->domain }}</h1>
        <div class="float-md-right">
            @if($zone->dnssec)
                <a href="/domain/{{ $zone->domain }}/dnssec" class="btn btn-secondary btn-sm">Manage DNSSEC</a>
            @else
                <a href="/domain/{{ $zone->domain }}/dnssec" class="btn btn-success btn-sm">Enable DNSSEC</a>
            @endif
            <a href="/domain/{{ $zone->domain }}/records/create/preset" class="btn btn-outline-info btn-sm">Add a preset</a>
            <a href="/domain/{{ $zone->domain }}/records/create">
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
                    @if($record->status != \App\Status::$PENDING_UPDATE_DELETION)
                        <tr @if ($record->status != \App\Status::$OK) class="text-danger" @endif>
                            <td>{{ $record->record_type }}</td>
                            <td>@if ($record->name == NULL){{ $zone->domain }}@else{{ $record->name }}.{{ $zone->domain }}@endif</td>
                            <td class="recordcontent">{{ $record->content }}</td>
                            <td>{{ $record->ttl }}</td>
                            <td class="text-right">
                                @if($record->status == \App\Status::$FAILED)
                                    <button type="button" disabled class="btn btn-danger btn-sm">
                                        <li class="fas fa-exclamation"></li> Failed to execute
                                    </button>
                                    <a href="/domain/{{ $zone->domain }}/records/{{ $record->id }}/retry" class="btn btn-primary btn-sm">Retry</a>
                                @elseif ($record->status != \App\Status::$OK)
                                    <button type="button" disabled class="btn btn-primary btn-sm">
                                        <span class="spinner-border spinner-border-sm"></span>
                                    </button>
                                @else
                                    <form method="POST" action="/domain/{{ $zone->domain }}/records/{{ $record->id }}/delete">
                                        @csrf
                                        @method('DELETE')
                                        <a href="/domain/{{ $zone->domain }}/records/{{ $record->id }}/edit" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></a>
                                        <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-trash-alt"></i></button>
                                    </form>
                                @endif</td>
                        </tr>
                    @endif
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
