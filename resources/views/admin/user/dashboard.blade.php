@extends('layouts.app')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">User overview
            ({{ $user->name }} - {{ $user->email }})
        </h1>
    </div>

    <div class="row">
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Domains</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">@if($user->allow_support) {{ $user->zones->count() }} @else - @endif</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-globe-europe fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Templates</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">@if($user->allow_support) {{ $user->templates->count() }} @else - @endif</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-list fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Tags</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">@if($user->allow_support) {{ $user->tags->count() }} @else - @endif</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-tags fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-3 col-lg-7">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Admin tools</h6>
                </div>
                <div class="card-body">
                    @include('flash::message')
                    @if(isset($user->managed_by))
                        <div class="alert alert-warning">This is a managed user. Managed by <a href="/admin/users/{{ $user->managed_by }}">{{ $user->managed_by }}</a></div>
                    @endif
                    <ul class="list-group">
                        <li class="list-group-item">
                            <form method="POST" action="{{ url('/admin/users/'.$user->id.'/login') }}">
                                @csrf
                                <i class="fas fa-sign-in-alt"></i> <button type="submit" class="btn btn-link">Login as this user</button>
                            </form>
                        </li>
                        <li class="list-group-item"><i class="fas fa-bell"></i> <a href="{{ url('/admin/users/'.$user->id.'/notification') }}">Send notification</a></li>
                        <li class="list-group-item">
                            <form method="POST" action="{{ url('/admin/users/'.$user->id.'/reseller') }}">
                                @csrf
                                @method('PATCH')
                                <i class="fas @if($user->reseller) fa-user @else fa-user-friends @endif"></i> <button type="submit" class="btn btn-link">@if($user->reseller) Remove reseller @else Make reseller @endif</button>
                            </form>
                        </li>
                        <li class="list-group-item">
                            <form method="POST" action="{{ url('/admin/users/'.$user->id.'/block') }}">
                                @csrf
                                @method('PATCH')
                                <i class="fas @if($user->is_blocked) fa-unlock @else fa-lock @endif"></i> <button type="submit" class="btn btn-link">@if($user->is_blocked) Unblock user @else Block user @endif</button>
                            </form>
                            </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-7">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Domains</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        @if($user->allow_support)
                            <table class="table table-hover table-striped" width="100%" cellspacing="0" style="font-size: 0.9rem;">
                                <thead>
                                <tr>
                                    <th>Domain</th>
                                    <th>Records</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($user->zones as $zone)
                                    <tr>
                                        <td>{{ $zone->domain }}</td>
                                        <td>{{ $zone->records()->count() }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        @else
                            This user has chosen not to share any data with the support team.
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-7">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Templates</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        @if($user->allow_support)
                            <table class="table table-hover table-striped" width="100%" cellspacing="0" style="font-size: 0.9rem;">
                                <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Records</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($user->templates as $template)
                                    <tr>
                                        <td>{{ $template->name }}</td>
                                        <td>{{ $template->records()->count() }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        @else
                            This user has chosen not to share any data with the support team.
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-7">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Tags</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        @if($user->allow_support)
                            <table class="table table-hover table-striped" width="100%" cellspacing="0" style="font-size: 0.9rem;">
                                <thead>
                                <tr>
                                    <th>Name</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($user->tags as $tag)
                                    <tr>
                                        <td>{{ $tag->name }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        @else
                            This user has chosen not to share any data with the support team.
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-xl-5 col-lg-7">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">All notifications</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        @if($user->allow_support)
                        <table class="table table-hover table-striped" width="100%" cellspacing="0" style="font-size: 0.9rem;">
                            <thead>
                            <tr>
                                <th width="35%">Date</th>
                                <th>Notification</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($user->notifications->sortByDesc('created_at') as $notification)
                                <tr>
                                    <td>{{ $notification->created_at }}</td>
                                    <td>{{ $notification->text }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                            @else
                            This user has chosen not to share any data with the support team.
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-7 col-lg-7">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">All logins</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                            @if($user->allow_support)
                            <table class="table table-hover table-striped" width="100%" cellspacing="0" style="font-size: 0.9rem;">
                                <thead>
                                <tr>
                                    <th width="25%">Date</th>
                                    <th>IP</th>
                                    <th>Platform</th>
                                    <th>Browser</th>
                                    <th>Version</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($user->loginlogs->sortByDesc('created_at') as $log)
                                    <tr>
                                        <td>{{ $log->created_at }}</td>
                                        <td>{{ $log->ip }}</td>
                                        <td>{{ parse_user_agent($log->useragent)['platform'] }}</td>
                                        <td>{{ parse_user_agent($log->useragent)['browser'] }}</td>
                                        <td>{{ parse_user_agent($log->useragent)['version'] }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                            @else
                                This user has chosen not to share any data with the support team.
                            @endif
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
