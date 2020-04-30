@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Request reseller access</h6>
                    </div>
                    <div class="card-body">
                        If you're a reseller of DomeinDNS you will receive unique features such as:
                        <ul>
                            <li>Creating sub-accounts</li>
                            <li>Unique sub-account dashboard</li>
                            <li>Logging in to the sub-accounts</li>
                            <li>Blocking sub-accounts</li>
                            <li>Deleting sub-accounts</li>
                        </ul>
                        <hr>
                        @if($authorized == true)
                            Your account currently has no access to this feature. Please describe your use case below to request access to this feature. We may contact you if we need additional information.

                            <form method="POST" class="py-3">
                                @csrf
                                @include('errors')
                                <div class="form-group">
                                    <textarea rows="3" class="form-control {{ $errors->has('reason') ? 'is-invalid' : '' }}" name="reason" autofocus required>{{ old('reason') }}</textarea>
                                </div>
                                <button type="submit" class="btn btn-success">Request reseller access</button>
                            </form>
                            @else
                        <div class="alert alert-primary" role="alert">
                                Your request has been received! We will process your request within 2 business days. We may contact you for additional information.
                            <br /><br />
                            You will receive a notification once we have processed your request.
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
