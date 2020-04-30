@extends('layouts.app')

@section('content')
    @include('flash::message')
    @if($incoming_transfers_c != 0)
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Pending incoming transfers</h1>
        </div>
        <div class="card shadow mb-4">
            <div class="table-responsive">
                <table class="table table-hover table-striped" width="100%" cellspacing="0" style="font-size: 0.9rem;">
                    <thead>
                    <tr>
                        <th width="25%">Domain</th>
                        <th width="35%">Transfer from</th>
                        <th width="25%">Date</th>
                        <th width="15%"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($incoming_transfers->where('status', \App\Status::$TRANSFER_PENDING)->sortByDesc('created_at') as $incoming_transfer)
                        <tr>
                            <td>{{ $incoming_transfer->domain->domain }}</td>
                            <td>{{ $incoming_transfer->from_user->name }} ({{ $incoming_transfer->from_user->email }})</td>
                            <td>{{ $incoming_transfer->created_at }}</td>
                            <td class="text-right">
                                <form method="POST" action="/domains/transfer/{{ $incoming_transfer->id }}">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" name="status" value="accept" class="btn btn-success btn-sm"><i class="fa fa-check"></i></button>
                                    <button type="submit" name="status" value="reject" class="btn btn-danger btn-sm"><i class="fa fa-times"></i></button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <hr>
        @endif
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Outgoing transfers</h1>
        <div class="float-md-right">
            <a href="/domains/transfer/new">
                <button type="button" class="btn btn-primary btn-sm">Transfer domain</button>
            </a>
        </div>
    </div>
    <div class="card shadow mb-4">
        <div class="table-responsive">
            <table class="table table-hover table-striped" width="100%" cellspacing="0" style="font-size: 0.9rem;">
                <thead>
                <tr>
                    <th width="25%">Domain</th>
                    <th width="35%">Transfer to</th>
                    <th width="25%">Date</th>
                    <th width="15%"></th>
                </tr>
                </thead>
                <tbody>
                @foreach ($transfers->sortByDesc('created_at') as $transfer)
                    <tr>
                        <td>{{ $transfer->domain->domain }}</td>
                        <td>{{ $transfer->to_user->email }}</td>
                        <td>{{ $transfer->created_at }}</td>
                        <td @if($transfer->status == \App\Status::$TRANSFER_PENDING)class="text-right" @endif>
                            @if($transfer->status == \App\Status::$TRANSFER_PENDING)
                                <form method="POST" action="/domains/transfer/{{ $transfer->id }}">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" name="status" value="reject" class="btn btn-danger btn-sm"><i class="fa fa-times"></i></button>
                                </form>
                            @endif
                                @if($transfer->status == \App\Status::$TRANSFER_REJECTED)
                                    Rejected
                                @endif
                                @if($transfer->status == \App\Status::$TRANSFER_ACCEPTED)
                                    Approved
                                @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Incoming transfers (history)</h1>
    </div>
    <div class="card shadow mb-4">
        <div class="table-responsive">
            <table class="table table-hover table-striped" width="100%" cellspacing="0" style="font-size: 0.9rem;">
                <thead>
                <tr>
                    <th width="25%">Domain</th>
                    <th width="35%">Transfer from</th>
                    <th width="25%">Date</th>
                    <th width="15%">Status</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($incoming_transfers->whereNotIn('status', \App\Status::$TRANSFER_PENDING)->sortByDesc('created_at') as $incoming_transfer)
                    <tr>
                        <td>{{ $incoming_transfer->domain->domain }}</td>
                        <td>{{ $incoming_transfer->to_user->name }} ({{ $incoming_transfer->to_user->email }})</td>
                        <td>{{ $incoming_transfer->created_at }}</td>
                        <td>
                            @if($incoming_transfer->status == \App\Status::$TRANSFER_REJECTED)
                                Rejected
                            @endif
                            @if($incoming_transfer->status == \App\Status::$TRANSFER_ACCEPTED)
                                Approved
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection
