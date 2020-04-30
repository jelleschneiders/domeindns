@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Change nameservers</h6>
                    </div>

                    <div class="card-body">
                        <p>If you want to use custom nameservers this page is for you. Change here the default nameservers used for your account.</p>
                        <br />
                        <p>@include('errors')</p>
                        @include('flash::message')
                        <form method="POST" action="{{ url('/account/nameservers/change') }}">
                            @csrf
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label">Nameserver 1</label>
                                <div class="col-sm-8">
                                    <input type="input" class="form-control{{ $errors->has('ns1') ? ' is-invalid' : '' }}" name="ns1" required value="{{ old('ns1') }}" placeholder="ns1.domeindns.nl">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label">Nameserver 2</label>
                                <div class="col-sm-8">
                                    <input type="input" class="form-control{{ $errors->has('ns2') ? ' is-invalid' : '' }}" name="ns2" required value="{{ old('ns2') }}" placeholder="ns2.domeindns.nl">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label">Nameserver 3</label>
                                <div class="col-sm-8">
                                    <input type="input" class="form-control{{ $errors->has('ns3') ? ' is-invalid' : '' }}" name="ns3" required value="{{ old('ns3') }}" placeholder="ns3.domeindns.org">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputPassword" class="col-sm-4 col-form-label"></label>
                                <div class="col-sm-8">
                                    <button type="submit" class="btn btn-info">Change nameservers</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
