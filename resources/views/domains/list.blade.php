@extends('layouts.app')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Domains
            @if($tagview)
                with <a href="/domains" class="btn btn-outline-secondary btn-sm">{{ $tag->name }} <i class="fas fa-times-circle"></i></a>
            @endif
            @if($searchview)
                (searching for {{ $searchstring }})
            @endif</h1>
        <div class="float-md-right">
        <a href="" class="btn btn-outline-secondary btn-sm">
            <i class="fas fa-sync"></i>
        </a>
        <a href="/domain/create/template" class="btn btn-outline-secondary btn-sm">
            Create new domain with template
        </a>
        <a href="/domain/create">
            <button type="button" class="btn btn-primary btn-sm">Create new domain</button>
        </a>
        </div>
    </div>
    <div class="card shadow mb-4">
        <div class="">
            @if($tags->count() != 0)
                <div class="card-body" style="padding: 0.4rem;">
                    Filter on tag:
                    @foreach($tags as $tag)
                        <a href="/domains/tag/{{ $tag->id }}" class="btn btn-outline-secondary btn-sm">{{ $tag->name }}</a>
                    @endforeach
                </div>
            @endif
        </div>

            <div class="table-responsive">
                <table class="table table-hover table-striped" width="100%" cellspacing="0" style="font-size: 0.9rem;">
                    <thead>
                    <tr>
                        <th width="50%">Domain</th>
                        <th width="20%">Records</th>
                        <th width="30%"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($zones as $zone)
                        <tr @if ($zone->status != \App\Status::$OK) class="text-danger" @endif>
                            <td>@if ($zone->status != \App\Status::$OK) {{ $zone->domain }} @else <a href="/domain/{{ $zone->domain }}/records">{{ $zone->domain }}</a>@endif
                                @foreach($zone->tags as $tag)
                                    <a href="/domains/tag/{{ \App\Tag::where('id', $tag->tag_id)->value('id') }}" class="badge badge-secondary badge-outline">
                                        {{ \App\Tag::where('id', $tag->tag_id)->value('name') }}
                                    </a>
                                @endforeach</td>
                            <td>{{ $zone->records->count() }}</td>
                            <td class="text-right">
                                @if ($zone->status == \App\Status::$FAILED)
                                    <button type="button" disabled class="btn btn-danger btn-sm">
                                        <li class="fas fa-exclamation"></li> Failed to execute
                                    </button>
                                    <a href="/domain/{{ $zone->domain }}/retry" class="btn btn-primary btn-sm">Retry</a>
                                @elseif($zone->status != \App\Status::$OK)
                                    <button type="button" disabled class="btn btn-primary btn-sm">
                                        <span class="spinner-border spinner-border-sm"></span>
                                    </button>
                                @else
                                    <a href="/domain/{{ $zone->domain }}/records" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></a>
                                    <a href="/domain/{{ $zone->domain }}/delete"><button type="button" class="btn btn-danger btn-sm"><i class="fa fa-trash-alt"></i></button></a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>

@endsection
