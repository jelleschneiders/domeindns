@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 text-center">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Retry {{ $record->failed_reason }} for {{ $record->record_type }} record (@if ($record->name == NULL){{ $zone->domain }}@else{{ $record->name }}.{{ $zone->domain }}@endif)</h6>
                    </div>
                    <div class="card-body">
                        The {{ $record->failed_reason }} for this record has unfortunately failed. You can press the button below to retry.

                        <form method="POST" class="py-3">
                            @csrf
                            <button type="submit" class="btn btn-info">Retry {{ $record->failed_reason }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
