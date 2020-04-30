@extends('layouts.errorapp')

@section('content')
    <div class="text-center">
        <img class="img-fluid px-3 px-sm-4 mt-3 mb-4" style="width: 25rem;" src="{{ url('/img/undraw_page_not_found_su7k.svg') }}">
        <p>We couldn't find the page you were looking for!</p>
        <p><a href="#" id="back_btn" class="btn btn-secondary btn-icon-split">
                    <span class="icon text-white-50">
                      <i class="fas fa-arrow-left"></i>
                    </span>
                <span class="text">Go back to the previous page</span>
            </a></p>
    </div>
@endsection
