@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Add a new preset for {{ $zone->domain }}</h6>
                    </div>
                    <div class="card-body">
                        @include('errors')
                        <form method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="InputPreset">Select preset</label>
                                <select class="form-control {{ $errors->has('preset') ? 'is-invalid' : '' }}" name="preset">
                                    <option value="googlemx">Google MX</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-success">Insert preset record</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
