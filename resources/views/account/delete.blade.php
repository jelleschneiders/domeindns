@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="text-center mb-4">
                    <img class="img-fluid px-3 px-sm-4 mt-3 mb-4" style="width: 20rem;" src="{{ url('/img/undraw_warning_cyit.svg') }}" alt="">
                </div>

                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Delete your account</h6>
                    </div>

                    <div class="card-body">
                        <p>Are you sure you want to delete your account? <span class="text-warning">Please make sure you have deleted all of your domains/templates/tags before deleting your account.</span></p>
                        <p>There is no way to recover your account once you have deleted it. Of course, you're always welcome to create a new account.</p>
                        <p>@include('errors')</p>
                        @include('flash::message')
                        <form method="POST" action="{{ url('/account/delete') }}" autocomplete="false" @if(auth()->user()->dangerzone) class="danger-zone" @endif>
                            @method('DELETE')
                            @csrf
                            <div class="form-group row">
                                <label for="inputPassword" class="col-sm-4 col-form-label">Current password</label>
                                <div class="col-sm-8">
                                    <input type="password" class="form-control{{ $errors->has('current') ? ' is-invalid' : '' }}" name="current" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputPassword" class="col-sm-4 col-form-label"></label>
                                <div class="col-sm-8">
                                    <button type="submit" class="btn btn-danger">Permanently delete my account</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
