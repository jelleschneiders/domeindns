@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 text-center">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Retry {{ $zone->failed_reason }} for {{ $zone->domain }}</h6>
                    </div>
                    <div class="card-body">
                        The {{ $zone->failed_reason }} for this domain has unfortunately failed. You can press the button below to retry.

                        <form method="POST" class="py-3">
                            @csrf
                            <button type="submit" class="btn btn-info">Retry {{ $zone->failed_reason }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
