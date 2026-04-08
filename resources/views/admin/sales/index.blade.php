@extends('admin.layouts.admin')
@section('page-title', 'Sales / Invoices')
@section('page-heading', 'Sales / Invoices')
@section('breadcrumb', 'Sales')

@section('content')

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
    </div>
@endif

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center m-b-20">
                    <h4 class="card-title mb-0">All Sales</h4>
                    <a href="{{ route('sales.create') }}" class="btn btn-primary">
                        <i class="mdi mdi-plus"></i> New Sale
                    </a>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Sale No</th>
                                <th>Member</th>
                                <th>Date</th>
                                <th>Total Amount</th>
                                <th>Discount</th>
                                <th>Net Total</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($sales as $index => $sale)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    <span class="badge badge-primary">
                                        {{ $sale->sale_no }}
                                    </span>
                                </td>
                                <td>{{ $sale->member->name ?? '—' }}</td>
                                <td>
                                    {{ \Carbon\Carbon::parse($sale->date)->format('d/m/Y') }}
                                </td>
                                <td>${{ number_format($sale->total_amount, 2) }}</td>
                                <td>
                                    @if($sale->discount > 0)
                                        <span class="text-danger">
                                            -${{ number_format($sale->discount, 2) }}
                                        </span>
                                    @else
                                        —
                                    @endif
                                </td>
                                <td>
                                    <strong class="text-success">
                                        ${{ number_format($sale->net_total, 2) }}
                                    </strong>
                                </td>
                                <td>
                                        <a href="{{ route('sales.show', $sale) }}"
                                             class="btn btn-sm btn-success">
                                        <i class="mdi mdi-eye"></i> View
                                         </a>
                                     <a href="{{ route('sales.edit', $sale) }}"
                                             class="btn btn-sm btn-info">
                                          <i class="mdi mdi-pencil"></i> Edit
                                                         </a>
                                         <form action="{{ route('sales.destroy', $sale) }}"
                                        method="POST" class="d-inline"
                                            onsubmit="return confirm('Delete this sale?')">
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
                                <td colspan="8" class="text-center text-muted py-4">
                                    No sales found.
                                    <a href="{{ route('sales.create') }}">Add first sale</a>
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