@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Account settings</h6>
                    </div>

                    <div class="card-body">
                        @include('errors')
                        @include('flash::message')

                        <form method="POST" action="{{ url('/account/settings') }}">
                            @method('PATCH')
                            @csrf
                            <div class="form-group">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="allow_totp_recovery" name="allow_totp_recovery" @if($user->allow_totp_recovery) checked @endif>
                                    <label class="form-check-label" for="allow_totp_recovery">
                                        Allow two-factor authentication recovery
                                    </label>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="allow_support" name="allow_support" @if($user->allow_support) checked @endif>
                                    <label class="form-check-label" for="allow_support">
                                        Allow customer support to view your account data
                                    </label>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="receive_notifications" name="receive_notifications" @if($user->receive_notifications) checked @endif>
                                    <label class="form-check-label" for="receive_notifications">
                                        Send notifications to my email
                                    </label>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="dangerzone" name="dangerzone" @if($user->dangerzone) checked @endif>
                                    <label class="form-check-label" for="dangerzone">
                                        Show danger zone warning
                                    </label>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="allow_transfers" name="allow_transfers" @if($user->allow_transfers) checked @endif>
                                    <label class="form-check-label" for="allow_transfers">
                                        Allow domain transfers to this account
                                    </label>
                                </div>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Change settings</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
