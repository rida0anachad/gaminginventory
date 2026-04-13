@extends('admin.layouts.admin')
@section('page-title', 'Games Stock')
@section('page-heading', 'Games Stock')
@section('breadcrumb', 'Games Stock')

@section('content')

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
    </div>
@endif

<div class="alert alert-info">
    <i class="mdi mdi-information m-r-5"></i>
    Stock quantities are updated automatically :
    <strong>Stock In</strong> increases stock —
    <strong>Sales</strong> decrease stock.
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-0 m-b-20">Current Stock Status</h4>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Game Title</th>
                                <th>Platform</th>
                                <th>Genre</th>
                                <th>Publisher</th>
                                <th>Sale Rate</th>
                                <th>Qty Available</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($stocks as $index => $stock)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td><strong>{{ $stock->game->title ?? '—' }}</strong></td>
                                <td>
                                    <span class="badge badge-info">
                                        {{ $stock->game->platform ?? '—' }}
                                    </span>
                                </td>
                                <td>{{ $stock->game->genre ?? '—' }}</td>
                                <td>{{ $stock->game->publisher->company_name ?? '—' }}</td>
                                <td>
                                    <strong class="text-success">
                                        ${{ number_format($stock->sale_rate, 2) }}
                                    </strong>
                                </td>
                                <td>
                                    @if($stock->qty == 0)
                                        <span class="badge badge-danger">
                                            <i class="mdi mdi-alert"></i> Out of Stock
                                        </span>
                                    @elseif($stock->qty <= 5)
                                        <span class="badge badge-warning">
                                            {{ $stock->qty }} — Low Stock
                                        </span>
                                    @else
                                        <span class="badge badge-success">
                                            {{ $stock->qty }} units
                                        </span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">
                                    <i class="mdi mdi-package-variant font-30"></i><br>
                                    No stock yet. Add stock via
                                    <a href="{{ route('stockin.create') }}">Stock In</a>.
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