@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Create a new domain</h6>
                    </div>

                    <div class="card-body">
                        @include('errors')

                        <form method="POST" action="/domain/create/template">
                            @csrf
                            <div class="form-group">
                                <label for="InputDomain">Domain</label>
                                <input type="text" class="form-control {{ $errors->has('domain') ? 'is-invalid' : '' }}" name="domain" value="{{ old('domain') }}" placeholder="Enter new domain" autofocus required>
                            </div>

                            <div class="form-group">
                                <label for="InputDomain">Template</label>
                                <select class="form-control {{ $errors->has('template') ? 'is-invalid' : '' }}" name="template">
                                    @foreach($templates as $template)
                                        <option value="{{ $template->id }}">{{ $template->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <button type="submit" class="btn btn-primary">Create domain with template</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
