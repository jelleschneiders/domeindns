<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">
            {{ config('app.name', 'DomeinDNS') }}
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#mainNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="mainNavbar">

            <ul class="navbar-nav mr-auto"></ul>
            @auth
                <ul class="nav navbar-nav mx-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="/domains">Domains</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/templates">Templates</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/tags">Tags</a>
                    </li>
                </ul>
            @endauth

            <ul class="navbar-nav ml-auto">
                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                    </li>
                    @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                    @endif
                @else

                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ auth()->user()->email }} <span class="caret"></span>
                        </a>

                        <div class="dropdown-menu dropdown-menu-right">

                            <a class="dropdown-item" href="/account/api-key">
                                API keys
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="/account/password/change">
                                Change password
                            </a>
                            <a class="dropdown-item" href="/account/2fa">
                                Two-factor authentication
                            </a>
                            <a class="dropdown-item" href="/account/delete">
                                Delete account
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="{{ route('logout') }}" handle-logout>
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>
