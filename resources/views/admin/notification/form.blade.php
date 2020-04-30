@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Send a notification ({{ $user->name }} - {{ $user->email }})</h6>
                    </div>

                    <div class="card-body">
                        @include('errors')

                        <form method="POST">
                            @csrf
                            <div class="form-group">
                                <label>Type</label>
                                <select class="form-control {{ $errors->has('type') ? 'is-invalid' : '' }}" name="type">
                                    @foreach(config('domeindns.bootstrap.types') as $type)
                                        <option @if($type == old('type')) selected @endif value="{{ $type }}">{{ $type }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Icon</label>
                                <input type="text" class="form-control {{ $errors->has('icon') ? 'is-invalid' : '' }}" name="icon" value="{{ old('icon') }}" placeholder="Enter icon name without fa-">
                            </div>
                            <div class="form-group">
                                <label>Text</label>
                                <input type="text" class="form-control {{ $errors->has('text') ? 'is-invalid' : '' }}" name="text" value="{{ old('text') }}" placeholder="Enter text in notification">
                            </div>

                            <button type="submit" class="btn btn-primary">Send notification to user</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
