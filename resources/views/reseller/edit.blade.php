@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Edit user</h6>
                    </div>

                    <div class="card-body">
                        @include('errors')

                        <form method="POST" action="{{ url('/reseller/users/'.$user->id.'/edit') }}">
                            @csrf
                            @method('PATCH')
                            <div class="form-group row">
                                <div class="col-sm-12 mb-3 mb-sm-0">
                                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror form-control-user" placeholder="Name" name="name" value="{{ $user->name }}" required autofocus>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror form-control-user" placeholder="New password" name="password">
                                </div>
                                <div class="col-sm-6">
                                    <input id="password-confirm" type="password" class="form-control form-control-user" placeholder="Confirm new password" name="password_confirmation">
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary">Edit user</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
