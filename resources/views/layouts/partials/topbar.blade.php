<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fa fa-bars"></i>
    </button>

    <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search" method="POST" action="/domains">
        @csrf
        <div class="input-group">
            <input type="text" class="form-control bg-light border-0 small" placeholder="Search for domain..." aria-label="Search" aria-describedby="basic-addon2" name="search">
            <div class="input-group-append">
                <button class="btn btn-primary" type="submit">
                    <i class="fas fa-search fa-sm"></i>
                </button>
            </div>
        </div>
    </form>

    <ul class="navbar-nav ml-auto">
        <li class="nav-item dropdown no-arrow d-sm-none">
            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-search fa-fw"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in" aria-labelledby="searchDropdown">
                <form class="form-inline mr-auto w-100 navbar-search">
                    <div class="input-group">
                        <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="button">
                                <i class="fas fa-search fa-sm"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </li>

        <li class="nav-item dropdown no-arrow mx-1">
            <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-bell fa-fw"></i>
                <span class="badge badge-danger badge-counter">@if(auth()->user()->notifications->where('seen', false)->count() != 0) {{ auth()->user()->notifications->where('seen', false)->count() }}@endif</span>
            </a>

            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="alertsDropdown">
                <h6 class="dropdown-header">
                    Notifications Center
                </h6>
                @if(auth()->user()->notifications->where('seen', false)->count() == 0)
                    <p class="dropdown-item text-center small text-gray-500" style="margin-bottom: 0rem;">There aren't any notifications to display right now.</p>
                @endif
                @foreach(auth()->user()->notifications->where('seen', false)->sortByDesc('created_at') as $notification)
                <a class="dropdown-item d-flex align-items-center" href="{{ url('/notifications/'. $notification->id) }}">
                    <div class="mr-3">
                        <div class="icon-circle bg-{{ $notification->type }}">
                            <i class="fas fa-{{ $notification->icon }} text-white"></i>
                        </div>
                    </div>
                    <div>
                        <div class="small text-gray-500">{{ \Carbon\Carbon::parse($notification->created_at)->format('F d, Y H:i') }}</div>
                        <span class="font-weight-bold">{{ $notification->text }}</span>
                    </div>
                </a>
                @endforeach

                <a class="dropdown-item text-center small text-gray-500" href="{{ url('/notifications') }}">Show All Notifications</a>
            </div>
        </li>

        <div class="topbar-divider d-none d-sm-block"></div>

        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{ auth()->user()->email }}</span>
                <img class="img-profile rounded-circle" src="https://www.gravatar.com/avatar/{{ md5(auth()->user()->email) }}">
            </a>
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="{{ url('/account/api-key') }}">
                    <i class="fas fa-key fa-sm fa-fw mr-2 text-gray-400"></i>
                    API key
                </a>
                <a class="dropdown-item" href="{{ url('/account/nameservers') }}">
                    <i class="fas fa-server fa-sm fa-fw mr-2 text-gray-400"></i>
                    Nameservers
                </a>
                <a class="dropdown-item" href="{{ url('/domains/transfer') }}">
                    <i class="fas fa-people-carry fa-sm fa-fw mr-2 text-gray-400"></i>
                    Domain transfers
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="{{ url('/account/password/change') }}">
                    <i class="fas fa-shield-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                    Change password
                </a>
                <a class="dropdown-item" href="{{ url('/account/2fa') }}">
                    <i class="fas fa-mobile-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                    Two-factor authentication
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="{{ url('/account/export') }}">
                    <i class="fas fa-file-download fa-sm fa-fw mr-2 text-gray-400"></i>
                    Export data
                </a>
                @if(!isset(auth()->user()->managed_by))
                <a class="dropdown-item" href="{{ url('/account/delete') }}">
                    <i class="fas fa-trash-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                    Delete account
                </a>
                @endif
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="{{ url('/account/settings') }}">
                    <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                    Account settings
                </a>
                <div class="dropdown-divider"></div>
                @if(\Session::has('logged_in_as'))
                    <form action="{{ url('/logout-to-user') }}" method="POST">
                        @csrf
                        <a class="dropdown-item submit-link" href="#">
                            <i class="fas fa-backspace fa-sm fa-fw mr-2 text-gray-400"></i>
                            Logout to main user
                        </a>
                    </form>
                @endif
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <a class="dropdown-item submit-link" href="#">
                        <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                        Logout
                    </a>
                </form>
            </div>
        </li>
    </ul>
</nav>
