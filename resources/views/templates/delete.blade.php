@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 text-center">
                <i style="font-size: 4rem;" class="fa fa-exclamation-circle text-danger py-5"></i>
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Delete template {{ $template->name }}</h6>
                    </div>
                    <div class="card-body">
                        Are you sure you want to delete this template?

                        <form method="POST" class="@if(auth()->user()->dangerzone) danger-zone @endif py-3">
                            @csrf
                            @method('DELETE')

                            <button type="submit" class="btn btn-danger">Delete template</button>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
