@extends('admin.layouts.admin')
@section('page-title', 'Stock In')
@section('page-heading', 'Stock In')
@section('breadcrumb', 'Stock In')

@section('content')

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
    </div>
@endif
@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show">
        {{ session('error') }}
        <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
    </div>
@endif

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center m-b-20">
                    <h4 class="card-title mb-0">Stock In — Purchases</h4>
                    <a href="{{ route('stockin.create') }}" class="btn btn-primary">
                        <i class="mdi mdi-plus"></i> Add Stock In
                    </a>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Transaction ID</th>
                                <th>Publisher</th>
                                <th>Game Received</th>
                                <th>Qty Received</th>
                                <th>Reference No</th>
                                <th>Arrival Date</th>
                                <th>Total Cost</th>
                                <th>Payment Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($stockins as $index => $stockin)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td><code>{{ $stockin->transaction_id }}</code></td>
                                <td>{{ $stockin->publisher->company_name ?? '—' }}</td>
                                <td>
                                    @if($stockin->game)
                                        <strong>{{ $stockin->game->title }}</strong>
                                        <br>
                                        <span class="badge badge-info">
                                            {{ $stockin->game->platform }}
                                        </span>
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge badge-primary">
                                        {{ $stockin->quantity_received }} units
                                    </span>
                                </td>
                                <td>{{ $stockin->reference_number ?? '—' }}</td>
                                <td>
                                    {{ \Carbon\Carbon::parse($stockin->arrival_date)
                                        ->format('d/m/Y') }}
                                </td>
                                <td>${{ number_format($stockin->total_cost, 2) }}</td>
                                <td>
                                    @if($stockin->payment_status == 'paid')
                                        <span class="badge badge-success">Paid</span>
                                    @elseif($stockin->payment_status == 'pending')
                                        <span class="badge badge-warning">Pending</span>
                                    @else
                                        <span class="badge badge-info">Partial</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('stockin.edit', $stockin) }}"
                                       class="btn btn-sm btn-info">
                                        <i class="mdi mdi-pencil"></i> Edit
                                    </a>
                                    <form action="{{ route('stockin.destroy', $stockin) }}"
                                          method="POST" class="d-inline"
                                          onsubmit="return confirm('Delete this entry and reverse stock?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger">
                                            <i class="mdi mdi-delete"></i> Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="10" class="text-center text-muted py-4">
                                    No stock in entries found.
                                    <a href="{{ route('stockin.create') }}">Add first entry</a>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection