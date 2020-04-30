@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Change your password</h6>
                    </div>

                    <div class="card-body">
                        @include('errors')

                        <form method="POST" action="/account/password/change">
                            @method('PATCH')
                            @csrf
                            <div class="form-group row">
                                <label for="inputPassword" class="col-sm-4 col-form-label">Current password</label>
                                <div class="col-sm-8">
                                    <input type="password" class="form-control{{ $errors->has('current') ? ' is-invalid' : '' }}" name="current" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputPassword" class="col-sm-4 col-form-label">New password</label>
                                <div class="col-sm-8">
                                    <input type="password" class="form-control{{ $errors->has('new') ? ' is-invalid' : '' }}{{ $errors->has('notsame') ? ' is-invalid' : '' }}" name="new" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputPassword" class="col-sm-4 col-form-label">New password confirmation</label>
                                <div class="col-sm-8">
                                    <input type="password" class="form-control{{ $errors->has('newconfirm') ? ' is-invalid' : '' }}{{ $errors->has('notsame') ? ' is-invalid' : '' }}" name="newconfirm" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputPassword" class="col-sm-4 col-form-label"></label>
                                <div class="col-sm-8">
                                    <button type="submit" class="btn btn-primary">Change password</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
