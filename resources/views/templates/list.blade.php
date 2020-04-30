@extends('layouts.app')

@section('content')

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Templates</h1>
        <div class="float-md-right">
            <a href="/template/create-from-domain" class="btn btn-info btn-sm">
                Create new template from domain
            </a>
            <a href="/template/create" class="btn btn-primary btn-sm">
                Create new template
            </a>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="table-responsive">
            <table class="table table-hover table-striped" style="font-size: 0.9rem;">
                <thead>
                <tr>
                    <th width="50%">Name</th>
                    <th width="20%">Records</th>
                    <th width="30%"></th>
                </tr>
                </thead>
                <tbody>
                @foreach ($templates as $template)
                    <tr>
                        <td><a href="/template/{{ $template->id }}">{{ $template->name }}</a></td>
                        <td>{{ $template->records->count() }}</td>
                        <td class="text-right">
                            <a href="/template/{{ $template->id }}" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></a>
                            <a href="/template/{{ $template->id }}/delete"><button type="button" class="btn btn-danger btn-sm"><i class="fa fa-trash-alt"></i></button></a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection
