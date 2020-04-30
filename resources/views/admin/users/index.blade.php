@extends('layouts.app')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">All users</h1>
    </div>

    <div class="card shadow mb-4">
        <div class="table-responsive">
            <table class="table table-hover table-striped" style="font-size: 0.9rem;">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Domains</th>
                    <th>Templates</th>
                    <th>Tags</th>
                    <th>TOTP enabled</th>
                    <th>TOTP recovery</th>
                    <th>Support access</th>
                    <th>Notifications to email</th>
                    <th>Reseller</th>
                    <th>Admin</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td><a href="{{ url('/admin/users/'.$user->id) }}">{{ $user->id }}</a></td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        @if($user->allow_support)
                            <td>{{ $user->zones->count() }}</td>
                            <td>{{ $user->templates->count() }}</td>
                            <td>{{ $user->tags->count() }}</td>
                        @else
                            <td><i class="text-info fas fa-eye-slash"></i></td>
                            <td><i class="text-info fas fa-eye-slash"></i></td>
                            <td><i class="text-info fas fa-eye-slash"></i></td>
                        @endif
                        <td>@if($user->totp_status) <i class="text-success fas fa-check"></i> @else <i class="text-danger fas fa-times"></i> @endif</td>
                        <td>@if($user->allow_totp_recovery) <i class="text-success fas fa-check"></i> @else <i class="text-danger fas fa-times"></i> @endif</td>
                        <td>@if($user->allow_support) <i class="text-success fas fa-check"></i> @else <i class="text-danger fas fa-times"></i> @endif</td>
                        <td>@if($user->receive_notifications) <i class="text-success fas fa-check"></i> @else <i class="text-danger fas fa-times"></i> @endif</td>
                        <td>@if($user->reseller) <i class="text-success fas fa-check"></i> @else <i class="text-danger fas fa-times"></i> @endif</td>
                        <td>@if($user->is_admin) <i class="text-success fas fa-check"></i> @else <i class="text-danger fas fa-times"></i> @endif</td>

                    </tr>
                @endforeach

                <tr class="table-primary">
                    <td>Total: {{ $users->count() }}</td>
                    <td></td>
                    <td></td>
                    <td>{{ $zones }}</td>
                    <td>{{ $templates }}</td>
                    <td>{{ $tags }}</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection
