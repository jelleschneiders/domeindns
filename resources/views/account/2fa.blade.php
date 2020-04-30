@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Two-factor authentication</h6>
                    </div>

                    <div class="card-body">
                        @if($user->totp_status == false)
                            <form method="POST" action="/account/2fa">
                                @csrf
                                <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-4 col-form-label"></label>
                                    <div class="col-sm-8">
                                        <div class="my-3">
                                            <img src="{{ $qrcodeurl }}">
                                        </div>

                                        <p><strong>Secret:</strong> <code>{{ $secret }}</code></p>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-4 col-form-label">6-digit code</label>
                                    <div class="col-sm-8">
                                        <input type="input" class="form-control{{ $errors->has('totp') ? ' is-invalid' : '' }}" name="totp" placeholder="123456" maxlength="6" autofocus required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="submitField" class="col-sm-4 col-form-label"></label>
                                    <div class="col-sm-8">
                                        <button type="submit" class="btn btn-success">Enable two-factor authentication</button>
                                    </div>
                                </div>
                            </form>
                            @else
                            <form method="POST" action="/account/2fa">
                                @csrf
                                @method('DELETE')
                                <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-4 col-form-label">6-digit code</label>
                                    <div class="col-sm-8">
                                        <input type="input" class="form-control{{ $errors->has('totp') ? ' is-invalid' : '' }}" name="totp" placeholder="123456" maxlength="6" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="submitField" class="col-sm-4 col-form-label"></label>
                                    <div class="col-sm-8">
                                        <button type="submit" class="btn btn-danger">Disable two-factor authentication</button>
                                    </div>
                                </div>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
