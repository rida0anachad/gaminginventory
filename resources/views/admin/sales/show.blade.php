@extends('admin.layouts.admin')
@section('page-title', 'Sale Detail')
@section('page-heading', 'Sale Detail')
@section('breadcrumb', 'Sales')

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-body">

                <div class="d-flex justify-content-between align-items-center m-b-20">
                    <h4 class="card-title mb-0">
                        Invoice — {{ $sale->sale_no }}
                    </h4>
                    <a href="{{ route('sales.index') }}" class="btn btn-secondary btn-sm">
                        <i class="mdi mdi-arrow-left"></i> Back
                    </a>
                </div>

                <div class="row m-b-20">
                    <div class="col-md-6">
                        <p><strong>Member :</strong>
                            {{ $sale->member->name ?? '—' }}
                            ({{ $sale->member->member_id ?? '' }})
                        </p>
                        <p><strong>Date :</strong>
                            {{ \Carbon\Carbon::parse($sale->date)->format('d/m/Y') }}
                        </p>
                    </div>
                    <div class="col-md-6 text-right">
                        <p><strong>Sale No :</strong>
                            <span class="badge badge-primary">{{ $sale->sale_no }}</span>
                        </p>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="thead-light">
                            <tr>
                                <th>#</th>
                                <th>Game</th>
                                <th>Platform</th>
                                <th>Qty</th>
                                <th>Unit Price</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($sale->items as $index => $item)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $item->game->title ?? '—' }}</td>
                                <td>
                                    <span class="badge badge-info">
                                        {{ $item->game->platform ?? '—' }}
                                    </span>
                                </td>
                                <td>{{ $item->quantity }}</td>
                                <td>${{ number_format($item->unit_price, 2) }}</td>
                                <td>${{ number_format($item->subtotal, 2) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="5" class="text-right">Total Amount</td>
                                <td>${{ number_format($sale->total_amount, 2) }}</td>
                            </tr>
                            <tr>
                                <td colspan="5" class="text-right text-danger">Discount</td>
                                <td class="text-danger">
                                    -${{ number_format($sale->discount, 2) }}
                                </td>
                            </tr>
                            <tr class="table-success">
                                <td colspan="5" class="text-right">
                                    <strong>Net Total</strong>
                                </td>
                                <td>
                                    <strong>
                                        ${{ number_format($sale->net_total, 2) }}
                                    </strong>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <div class="mt-3">
                    <form action="{{ route('sales.destroy', $sale) }}"
                          method="POST" class="d-inline"
                          onsubmit="return confirm('Delete this sale and restore stock?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm">
                            <i class="mdi mdi-delete"></i> Delete Sale & Restore Stock
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection