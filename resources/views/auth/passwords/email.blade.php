@extends('layouts.loginapp')

@section('content')
    <div class="col-lg-12">
        <div class="p-5">
            <div class="text-center">
                <h1 class="h4 text-gray-900 mb-2">Forgot your password?</h1>
                <p class="mb-4">We get it, stuff happens. Just enter your email address below and we'll send you a link to reset your password!</p>
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
            @if (session('status'))
                <div class="mb-4">
                    <div class="card bg-success text-white shadow">
                        <div class="card-body">
                            {{ session('status') }}
                        </div>
                    </div>
                </div>
            @endif
            <form class="user" method="POST" action="{{ route('password.email') }}">
                @csrf
                <div class="form-group">
                    <input type="email" class="form-control @error('email') is-invalid-register @enderror form-control-user" id="email" placeholder="Email address" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                </div>
                <button type="submit" class="btn btn-primary btn-user btn-block">
                    Send password reset link
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
