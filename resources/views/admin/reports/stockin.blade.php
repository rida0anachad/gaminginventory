@extends('admin.layouts.admin')
@section('page-title', 'Stock In Report')
@section('page-heading', 'Stock In Report')
@section('breadcrumb', 'Reports')

@section('content')

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('reports.stockin') }}" method="GET"
                      class="form-inline">
                    <div class="form-group mr-3">
                        <label class="mr-2">From</label>
                        <input type="date" name="from" class="form-control"
                               value="{{ request('from') }}">
                    </div>
                    <div class="form-group mr-3">
                        <label class="mr-2">To</label>
                        <input type="date" name="to" class="form-control"
                               value="{{ request('to') }}">
                    </div>
                    <button type="submit" class="btn btn-primary mr-2">
                        <i class="mdi mdi-filter"></i> Filter
                    </button>
                    <a href="{{ route('reports.stockin') }}" class="btn btn-secondary">
                        Reset
                    </a>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center m-b-20">
                    <h4 class="card-title mb-0">Stock In Report</h4>
                    <span class="badge badge-info badge-pill font-14">
                        Total Cost Price : ${{ number_format($totalCost, 2) }}
                    </span>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Entry Date</th>
                                <th>Transaction ID</th>
                                <th>Reference No</th>
                                <th>Publisher</th>
                                <th>Cost Price</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($stockins as $index => $stockin)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    {{ \Carbon\Carbon::parse($stockin->arrival_date)->format('d/m/Y') }}
                                </td>
                                <td><code>{{ $stockin->transaction_id }}</code></td>
                                <td>{{ $stockin->reference_number ?? '—' }}</td>
                                <td>{{ $stockin->publisher->company_name ?? '—' }}</td>
                                <td>
                                    <strong class="text-danger">
                                        ${{ number_format($stockin->cost_price, 2) }}
                                    </strong>
                                </td>
                                <td>
                                    @if($stockin->payment_status == 'paid')
                                        <span class="badge badge-success">Paid</span>
                                    @elseif($stockin->payment_status == 'pending')
                                        <span class="badge badge-warning">Pending</span>
                                    @else
                                        <span class="badge badge-info">Partial</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">
                                    No entries found for this period.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                        @if($stockins->count() > 0)
                        <tfoot>
                            <tr class="table-info">
                                <td colspan="5" class="text-right">
                                    <strong>Grand Total :</strong>
                                </td>
                                <td colspan="2">
                                    <strong>${{ number_format($totalCost, 2) }}</strong>
                                </td>
                            </tr>
                        </tfoot>
                        @endif
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection