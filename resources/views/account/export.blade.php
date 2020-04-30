@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="text-center mb-4">
                    <img class="img-fluid px-3 px-sm-4 mt-3 mb-4" style="width: 20rem;" src="{{ url('/img/undraw_collecting_fjjl.svg') }}" alt="">
                </div>

                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Export your data</h6>
                    </div>

                    <div class="card-body">
                        <p>Please fill in your password below and request a data export.</p>
                        <p>This export contains all the data we have on you in JSON format.</p>
                        <br />
                        <p>@include('errors')</p>
                        @include('flash::message')
                        <form method="POST" action="{{ url('/account/export') }}" autocomplete="false">
                            @csrf
                            <div class="form-group row">
                                <label for="inputPassword" class="col-sm-4 col-form-label">Current password</label>
                                <div class="col-sm-8">
                                    <input type="password" class="form-control{{ $errors->has('current') ? ' is-invalid' : '' }}" name="current" autofocus required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputPassword" class="col-sm-4 col-form-label"></label>
                                <div class="col-sm-8">
                                    <button type="submit" class="btn btn-info">Request export</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
