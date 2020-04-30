@extends('layouts.app')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Tags</h1>
        <div class="float-md-right">
            <a href="/tags/create">
                <button type="button" class="btn btn-primary btn-sm">Create new tag</button>
            </a>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="table-responsive">
            <table class="table table-hover table-striped" style="font-size: 0.9rem;">
                <thead>
                <tr>
                    <th width="40%">Name</th>
                    <th width="10%">Domains</th>
                    <th width="30%"></th>
                    <th width="20%"></th>
                </tr>
                </thead>
                <tbody>
                @foreach ($tags as $tag)
                    <tr>
                        <td>{{ $tag->name }}</td>
                        <td><a href="/domains/tag/{{ $tag->id }}">{{ $tag->zones->count() }}</a></td>
                        <td class="text-right">
                            <a href="/tags/{{ $tag->id }}/assign" class="btn btn-info btn-sm">Assign to domain</a>
                            <a href="/tags/{{ $tag->id }}/dismiss" class="btn btn-secondary btn-sm">Remove from domain</a>
                        </td>
                        <td class="text-right">
                            <form method="POST" action="/tags/{{ $tag->id }}">
                                @csrf
                                @method('DELETE')
                                <a href="/tags/{{ $tag->id }}" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></a>
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
