@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Edit tag ({{ $tag->name }})</h6>
                    </div>

                    <div class="card-body">
                        @include('errors')

                        <form method="POST">
                            @csrf
                            @method('PATCH')
                            <div class="form-group">
                                <label>Tag name</label>
                                <input type="text" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" name="name" value="{{ $tag->name }}" placeholder="Enter tag name" required autofocus>
                            </div>

                            <button type="submit" class="btn btn-primary">Update tag</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
