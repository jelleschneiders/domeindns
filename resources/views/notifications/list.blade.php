@extends('layouts.app')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Notifications</h1>
    </div>

    <div class="card shadow mb-4">
        <div class="table-responsive">
            <table class="table table-hover table-striped" style="font-size: 0.9rem;">
                <thead>
                <tr>
                    <th width="25%">Date</th>
                    <th width="55%">Text</th>
                    <th width="20%"></th>
                </tr>
                </thead>
                <tbody>
                @foreach ($notifications as $notification)
                    @php
                    \App\Notification::where([['id', $notification->id]])->update(['seen' => true])
                    @endphp
                    <tr @if(!$notification->seen) class="bg-primary text-white" @endif>
                        <td>{{ $notification->created_at }}</td>
                        <td>{{ $notification->text }}</td>
                        <td class="text-right">
                            <form method="POST" action="{{ url('/notifications/'.$notification->id) }}">
                                @csrf
                                @method('DELETE')
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
