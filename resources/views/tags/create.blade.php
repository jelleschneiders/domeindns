@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Create a new tag</h6>
                    </div>

                    <div class="card-body">
                        @include('errors')

                        <form method="POST" action="/tags/create">
                            @csrf
                            <div class="form-group">
                                <label>Tag name</label>
                                <input type="text" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" name="name" value="{{ old('name') }}" placeholder="Enter tag name" autofocus required>
                            </div>

                            <button type="submit" class="btn btn-primary">Create tag</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
