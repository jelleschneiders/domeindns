@extends('layouts.loginapp')

@section('content')
    <div class="col-lg-12">
        <div class="p-5">
            <div class="text-center">
                <h1 class="h4 text-gray-900 mb-4">Welcome back!</h1>
            </div>
            @include('flash::message')

            <form method="POST" action="{{ route('login') }}" class="user">
                @csrf
                <div class="form-group">
                    <input type="email" class="form-control @error('email') is-invalid-register @enderror form-control-user" id="email" aria-describedby="emailHelp" name="email" placeholder="Email address" value="{{ old('email') }}" required autocomplete="email" autofocus>
                </div>
                <div class="form-group">
                    <input type="password" class="form-control @error('password') is-invalid-register @enderror form-control-user" id="password" name="password" placeholder="Password" required autocomplete="current-password">
                </div>
                <button type="submit" class="btn btn-primary btn-user btn-block">
                    {{ __('Login') }}
                </button>
                <a class="btn btn-outline-success btn-user btn-block" href="{{ url('/register') }}">
                    Create an account
                </a>
            </form>
            <hr>
            <div class="text-center">
                <a class="small" href="{{ url('/password/reset') }}">Forgot password?</a>
            </div>
        </div>
    </div>
@endsection
