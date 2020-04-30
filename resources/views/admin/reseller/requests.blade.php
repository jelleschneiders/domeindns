@extends('layouts.app')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Reseller requests</h1>
    </div>

    <div class="card shadow mb-4">
        <div class="table-responsive">
            <table class="table table-hover table-striped" style="font-size: 0.9rem;">
                <thead>
                <tr>
                    <th>User</th>
                    <th>Reason</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach ($requests as $request)
                    <tr>
                        <td><a href="{{ url('/admin/users/'.$request->user_id) }}">{{ $request->user_id }}</a></td>
                        <td>{{ $request->reason }}</td>
                        <td><form method="POST">
                                @csrf
                                <input type="text" name="reqid" value="{{ $request->id }}" hidden>
                                <button type="submit" class="btn btn-secondary">Handle request</button>
                            </form></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
