@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Get your API key
                            <div class="float-md-right">
                                <a href="https://documenter.getpostman.com/view/7839833/S1Zw7qMW" target="_blank" class="btn btn-outline-secondary btn-sm">
                                    API documentation
                                </a>
                            </div>
                        </h6>
                    </div>

                    <div class="card-body">
                        <p>You can generate a new API key below. It will replace an existing API key.</p>
                        <hr>
                        <p>@include('errors')
                            @include('flash::message')</p>
                        <form method="POST" action="/account/api-key">
                            @method('PATCH')
                            @csrf
                            <div class="form-group row">
                                <label for="inputPassword" class="col-sm-4 col-form-label">Account password</label>
                                <div class="col-sm-8">
                                    <input type="password" class="form-control{{ $errors->has('current') ? ' is-invalid' : '' }}" name="current" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="submitField" class="col-sm-4 col-form-label"></label>
                                <div class="col-sm-8">
                                    <button type="submit" class="btn btn-warning">Generate API key</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
