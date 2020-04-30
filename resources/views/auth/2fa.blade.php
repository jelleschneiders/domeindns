@extends('layouts.loginapp')

@section('content')
    <div class="col-lg-12">
        <div class="p-5">
            <div class="text-center mb-4">
                <h1 class="h4 text-gray-900 mb-2">Two-factor authentication</h1>
                <small>{{ auth()->user()->email }}</small>
            </div>
            @include('flash::message')

            <form method="POST" class="user">
                @csrf
                <div class="form-group">
                    <input type="input" class="form-control{{ $errors->has('totp') ? ' is-invalid-register' : '' }} form-control-user" name="totp" placeholder="123456" maxlength="6" autofocus required>
                </div>
                <button type="submit" class="btn btn-primary btn-user btn-block">
                    Sign in
                </button>
            </form>
        </div>
    </div>
@endsection
