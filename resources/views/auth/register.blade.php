@extends('layouts.loginapp')

@section('content')
    <div class="col-lg-12">
        <div class="p-5">
            <div class="text-center">
                <h1 class="h4 text-gray-900 mb-4">Create an account</h1>
            </div>
            <form class="user" method="POST" action="{{ route('register') }}">
                @csrf
                <div class="form-group row">
                    <div class="col-sm-6 mb-3 mb-sm-0">
                        <input id="first_name" type="text" class="form-control @error('first_name') is-invalid-register @enderror form-control-user" placeholder="First name" name="first_name" value="{{ old('first_name') }}" required autofocus>
                    </div>
                    <div class="col-sm-6">
                        <input id="last_name" type="text" class="form-control @error('last_name') is-invalid-register @enderror form-control-user" placeholder="Last name" name="last_name" value="{{ old('last_name') }}" required>
                    </div>
                </div>
                <div class="form-group">
                    <input id="email" type="email" class="form-control @error('email') is-invalid-register @enderror form-control-user" placeholder="Email address" name="email" value="{{ old('email') }}" required autocomplete="email">
                </div>
                <div class="form-group row">
                    <div class="col-sm-6 mb-3 mb-sm-0">
                        <input id="password" type="password" class="form-control @error('password') is-invalid-register @enderror form-control-user" placeholder="Password" name="password" required autocomplete="new-password">
                    </div>
                    <div class="col-sm-6">
                        <input id="password-confirm" type="password" class="form-control form-control-user" placeholder="Confirm password" name="password_confirmation" required autocomplete="new-password">
                    </div>
                </div>
                <p class="small" style="margin-top: 1rem;">By signing up, you agree to our <a href="{{ url('/legal/tos') }}" target="_blank">Terms</a>. Learn how we collect, use and share your data in our <a href="{{ url('/legal/privacy') }}" target="_blank">Privacy Policy</a>.</p>

                <button type="submit" class="btn btn-primary btn-user btn-block">
                    {{ __('Register') }}
                </button>
            </form>
            <hr>
            <div class="text-center">
                <a class="small" href="{{ url('/password/reset') }}">Forgot password?</a>
            </div>
            <div class="text-center">
                <a class="small" href="{{ url('/login') }}">Already have an account? Login</a>
            </div>
        </div>
    </div>
@endsection
