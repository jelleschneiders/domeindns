@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Nameservers
                            <div class="float-md-right">
                                <form method="POST" action="{{ url('account/nameservers/change') }}">
                                    @csrf
                                    @method('DELETE')
                                    <a href="{{ url('/account/nameservers/change') }}" class="btn btn-outline-secondary btn-sm">
                                        Change nameservers
                                    </a>
                                    <button type="submit" class="btn btn-danger btn-sm">Reset nameservers</button>
                                </form>
                            </div>
                        </h6>
                    </div>

                    <div class="card-body">
                        @include('flash::message')
                        <p>Please set the nameservers defined in the table below on your domains.</p>
                    </div>
                    <table class="table table-hover table-striped" style="font-size: 0.9rem;">
                        <thead>
                            <tr>
                                <th width="30%">Nameserver</th>
                                <th width="30%">IPv4</th>
                                <th width="40%">IPv6</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($nameservers as $nameserver)
                            <tr>
                                <td>
                                    {{ $nameserver->nameserver }}
                                    <button type="button" class="btn btn-default btn-copy btn-sm js-tooltip js-copy" data-toggle="tooltip" data-placement="bottom"
                                            data-copy="{{ $nameserver->nameserver }}" title="Copy to clipboard"><span class="fa fa-clipboard fa-xs"></span></button>
                                </td>
                                <td>
                                    <code>{{ $nameserver->ipv4 }}</code>
                                    <button type="button" class="btn btn-default btn-copy btn-sm js-tooltip js-copy" data-toggle="tooltip" data-placement="bottom"
                                            data-copy="{{ $nameserver->ipv4 }}" title="Copy to clipboard"><span class="fa fa-clipboard fa-xs"></span></button>
                                </td>
                                <td>
                                    <code>{{ $nameserver->ipv6 }}</code>
                                    <button type="button" class="btn btn-default btn-copy btn-sm js-tooltip js-copy" data-toggle="tooltip" data-placement="bottom"
                                            data-copy="{{ $nameserver->ipv6 }}" title="Copy to clipboard"><span class="fa fa-clipboard fa-xs"></span></button>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection
