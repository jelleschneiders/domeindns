@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Create a new record for template {{ $template->name }}</h6>
                    </div>

                    <div class="card-body">
                        @include('errors')

                        <form method="POST" action="/template/{{ $template->id }}/records/create">
                            @csrf
                            <input name="template_id" type="hidden" value="{{ $template->id }}">
                            <div class="form-group">
                                <label for="InputType">Type</label>
                                <select class="form-control {{ $errors->has('type') ? 'is-invalid' : '' }}" name="type">
                                    @foreach(config('domeindns.dns.types') as $type)
                                        <option @if($type == old('type')) selected @endif value="{{ $type }}">{{ $type }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="InputName">Name</label>
                                <div class="input-group mb-2">
                                    <input type="text" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" name="name" value="{{ old('name') }}" placeholder="Name">
                                    <div class="input-group-append">
                                        <div class="input-group-text">.[DOMAIN]</div>
                                    </div>
                                </div>
                                <small id="nameHelpBlock" class="form-text text-muted">
                                    Leave empty if you want this record on the root domain.
                                </small>
                            </div>
                            <div class="form-group">
                                <label for="InputContent">Content</label>
                                <input type="text" class="form-control {{ $errors->has('content') ? 'is-invalid' : '' }}" name="content" value="{{ old('content') }}" required>
                            </div>
                            <div class="form-group">
                                <label for="InputTTL">TTL</label>
                                <input type="number" class="form-control {{ $errors->has('ttl') ? 'is-invalid' : '' }}" name="ttl" value="3600">
                                <small id="nameHelpBlock" class="form-text text-muted">
                                    Has to be at least 60 seconds.
                                </small>
                            </div>

                            <button type="submit" class="btn btn-primary">Create</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
