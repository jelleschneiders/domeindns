@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 text-center">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">DNSSEC settings for domain {{ $zone->domain }}</h6>
                    </div>
                    <div class="card-body">
                        @if(! $zone->dnssec)
                            DNSSEC is currently <strong>disabled</strong> for this domain.

                            <form method="POST" class="py-3">
                               @csrf
                              <button type="submit" class="btn btn-info">Enable DNSSEC</button>
                            </form>
                        @else
                            DNSSEC is currently <strong>enabled</strong> for this domain.
                            <hr>
                            <div class="form-group">
                                <label for="Input">DS Record</label>
                                <div class="input-group mb-2">
                                    <input type="text" class="form-control " value="{{ $zone->dns_sec->ds2 }}">
                                    <div class="input-group-append">
                                        <div class="input-group mb-2">
                                            <button type="button" class="btn btn-default btn-copy js-tooltip js-copy" data-toggle="tooltip" data-placement="bottom"
                                                    data-copy="{{ $zone->dns_sec->ds2 }}" title="Copy to clipboard"><span class="fa fa-clipboard fa-xs"></span></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="Input">Digest</label>
                                <div class="input-group mb-2">
                                    <input type="text" class="form-control " value="{{ $dssplit[3] }}">
                                    <div class="input-group-append">
                                        <div class="input-group mb-2">
                                            <button type="button" class="btn btn-default btn-copy js-tooltip js-copy" data-toggle="tooltip" data-placement="bottom"
                                                    data-copy="{{ $dssplit[3] }}" title="Copy to clipboard"><span class="fa fa-clipboard fa-xs"></span></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="Input">Digest Type</label>
                                <div class="input-group mb-2">
                                    <input type="text" class="form-control " value="SHA256">
                                    <div class="input-group-append">
                                        <div class="input-group mb-2">
                                            <button type="button" class="btn btn-default btn-copy js-tooltip js-copy" data-toggle="tooltip" data-placement="bottom"
                                                    data-copy="SHA256" title="Copy to clipboard"><span class="fa fa-clipboard fa-xs"></span></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="Input">Algorithm</label>
                                <div class="input-group mb-2">
                                    <input type="text" class="form-control " value="{{ $pubkeysplit[2] }}">
                                    <div class="input-group-append">
                                        <div class="input-group mb-2">
                                            <button type="button" class="btn btn-default btn-copy js-tooltip js-copy" data-toggle="tooltip" data-placement="bottom"
                                                    data-copy="{{ $pubkeysplit[2] }}" title="Copy to clipboard"><span class="fa fa-clipboard fa-xs"></span></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="Input">Public Key</label>
                                <div class="input-group mb-2">
                                    <input type="text" class="form-control " value="{{ $pubkeysplit[3] }}">
                                    <div class="input-group-append">
                                        <div class="input-group mb-2">
                                            <button type="button" class="btn btn-default btn-copy js-tooltip js-copy" data-toggle="tooltip" data-placement="bottom"
                                                    data-copy="{{ $pubkeysplit[3] }}" title="Copy to clipboard"><span class="fa fa-clipboard fa-xs"></span></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="Input">Key Tag</label>
                                <div class="input-group mb-2">
                                    <input type="text" class="form-control " value="{{ $dssplit[0] }}">
                                    <div class="input-group-append">
                                        <div class="input-group mb-2">
                                            <button type="button" class="btn btn-default btn-copy js-tooltip js-copy" data-toggle="tooltip" data-placement="bottom"
                                                    data-copy="{{ $dssplit[0] }}" title="Copy to clipboard"><span class="fa fa-clipboard fa-xs"></span></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="Input">Flags</label>
                                <div class="input-group mb-2">
                                    <input type="text" class="form-control " value="{{ $zone->dns_sec->flags }}">
                                    <div class="input-group-append">
                                        <div class="input-group mb-2">
                                            <button type="button" class="btn btn-default btn-copy js-tooltip js-copy" data-toggle="tooltip" data-placement="bottom"
                                                    data-copy="{{ $zone->dns_sec->flags }}" title="Copy to clipboard"><span class="fa fa-clipboard fa-xs"></span></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <form method="POST" class="py-3">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-warning">Disable DNSSEC</button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
