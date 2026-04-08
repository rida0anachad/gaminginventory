@extends('admin.layouts.admin')
@section('page-title', 'Sales Report')
@section('page-heading', 'Sales Report')
@section('breadcrumb', 'Reports')

@section('content')

{{-- Filtres --}}
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('reports.sales') }}" method="GET"
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
                    <a href="{{ route('reports.sales') }}" class="btn btn-secondary">
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
                    <h4 class="card-title mb-0">Sales Report</h4>
                    <span class="badge badge-success badge-pill font-14">
                        Total : ${{ number_format($totalSales, 2) }}
                    </span>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Sale Date</th>
                                <th>Transaction No</th>
                                <th>Member Name</th>
                                <th>Total Amount</th>
                                <th>Discount</th>
                                <th>Net Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($sales as $index => $sale)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    {{ \Carbon\Carbon::parse($sale->date)->format('d/m/Y') }}
                                </td>
                                <td><code>{{ $sale->sale_no }}</code></td>
                                <td>{{ $sale->member->name ?? '—' }}</td>
                                <td>${{ number_format($sale->total_amount, 2) }}</td>
                                <td>
                                    @if($sale->discount > 0)
                                        <span class="text-danger">
                                            -${{ number_format($sale->discount, 2) }}
                                        </span>
                                    @else —
                                    @endif
                                </td>
                                <td>
                                    <strong class="text-success">
                                        ${{ number_format($sale->net_total, 2) }}
                                    </strong>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">
                                    No sales found for this period.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                        @if($sales->count() > 0)
                        <tfoot>
                            <tr class="table-success">
                                <td colspan="6" class="text-right">
                                    <strong>Grand Total :</strong>
                                </td>
                                <td>
                                    <strong>${{ number_format($totalSales, 2) }}</strong>
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