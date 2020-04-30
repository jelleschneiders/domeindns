@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Create a new user</h6>
                    </div>

                    <div class="card-body">
                        @include('errors')

                        <form method="POST" action="{{ url('/reseller/users/create') }}">
                            @csrf
                            <div class="form-group row">
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                    <input id="first_name" type="text" class="form-control @error('first_name') is-invalid @enderror form-control-user" placeholder="First name" name="first_name" value="{{ old('first_name') }}" required autofocus>
                                </div>
                                <div class="col-sm-6">
                                    <input id="last_name" type="text" class="form-control @error('last_name') is-invalid @enderror form-control-user" placeholder="Last name" name="last_name" value="{{ old('last_name') }}" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror form-control-user" placeholder="Email address" name="email" value="{{ old('email') }}" required autocomplete="email">
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror form-control-user" placeholder="Password" name="password" required autocomplete="new-password">
                                </div>
                                <div class="col-sm-6">
                                    <input id="password-confirm" type="password" class="form-control form-control-user" placeholder="Confirm password" name="password_confirmation" required autocomplete="new-password">
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary">Create user</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
