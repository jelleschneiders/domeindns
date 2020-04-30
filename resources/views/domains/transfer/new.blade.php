@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Transfer domain</h6>
                    </div>

                    <div class="card-body">
                        @include('errors')

                        <form method="POST" action="{{ url('/domains/transfer/new') }}">
                            @csrf
                            <div class="form-group">
                                <label for="InputDomain">Transfer to</label>
                                <input type="text" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" name="email" value="{{ old('email') }}" placeholder="Enter email address of new user" autofocus required>
                            </div>

                            <div class="form-group">
                                <label>Domain</label>
                                <select class="form-control {{ $errors->has('domain') ? 'is-invalid' : '' }}" name="domain">
                                    @foreach($domains as $zone)
                                        <option value="{{ $zone->id }}">{{ $zone->domain }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <button type="submit" class="btn btn-primary">Transfer domain</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
