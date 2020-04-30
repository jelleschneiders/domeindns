@extends('layouts.loginapp')

@section('content')
    <div class="col-lg-12">
        <div class="p-5">
            <div class="text-center">
                <h1 class="h4 text-gray-900 mb-2">Reset your password</h1>
                <p class="mb-4">Please enter a new password below</p>
            </div>
            @error('email')
            <div class="mb-4">
                <div class="card bg-warning text-white shadow">
                    <div class="card-body">
                        {{ $message }}
                    </div>
                </div>
            </div>
            @enderror
            <form class="user" method="POST" action="{{ route('password.update') }}">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">
                <div class="form-group">
                    <input type="email" class="form-control @error('email') is-invalid-register @enderror form-control-user" id="email" placeholder="Email address" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>
                </div>
                <div class="form-group row">
                    <div class="col-sm-6 mb-3 mb-sm-0">
                        <input id="password" type="password" class="form-control @error('password') is-invalid-register @enderror form-control-user" placeholder="Password" name="password" required autocomplete="new-password">
                    </div>
                    <div class="col-sm-6">
                        <input id="password-confirm" type="password" class="form-control form-control-user" placeholder="Confirm password" name="password_confirmation" required autocomplete="new-password">
                    </div>
                </div>
                <button type="submit" class="btn btn-primary btn-user btn-block">
                    {{ __('Reset Password') }}
                </button>
            </form>
            <hr>
            <div class="text-center">
                <a class="small" href="{{ url('/register') }}">Create an account</a>
            </div>
            <div class="text-center">
                <a class="small" href="{{ url('/login') }}">Already have an account? Login</a>
            </div>
        </div>
    </div>
@endsection
