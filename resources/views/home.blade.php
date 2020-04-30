@extends('layouts.app')

@section('content')
    @if(isset($user->managed_by))
        <div class="alert alert-info">This is a managed account. The account manager is able to see and manage all the data in this account.</div>
    @endif

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
    </div>

    <div class="row">
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Domains</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $user->zones->count() }}</div>
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
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $user->templates->count() }}</div>
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
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $user->tags->count() }}</div>
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
        <div class="col-xl-5 col-lg-7">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Latest Notifications</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped" width="100%" cellspacing="0" style="font-size: 0.9rem;">
                            <thead>
                            <tr>
                                <th width="35%">Date</th>
                                <th>Notification</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($notifications as $notification)
                                <tr>
                                    <td>{{ $notification->created_at }}</td>
                                    <td>{{ $notification->text }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-7 col-lg-7">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Latest Logins</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
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
                                @foreach($loginlogs as $log)
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
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
