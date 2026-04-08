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
                    <h4 class="card-title mb-0">Games Stock</h4>
                    <a href="{{ route('gamestock.create') }}" class="btn btn-primary">
                        <i class="mdi mdi-plus"></i> Add Stock Entry
                    </a>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Game Title</th>
                                <th>Platform</th>
                                <th>Genre</th>
                                <th>SKU</th>
                                <th>Release Date</th>
                                <th>Publisher</th>
                                <th>Qty</th>
                                <th>M.R.P</th>
                                <th>Rate</th>
                                <th>Actions</th>
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
                                <td>
                                    <code>{{ $stock->sku ?? '—' }}</code>
                                </td>
                                <td>
                                    {{ $stock->release_date
                                        ? \Carbon\Carbon::parse($stock->release_date)->format('d/m/Y')
                                        : '—' }}
                                </td>
                                <td>
                                    {{ $stock->game->publisher->company_name ?? '—' }}
                                </td>
                                <td>
                                    @if($stock->qty == 0)
                                        <span class="badge badge-danger">Out of Stock</span>
                                    @elseif($stock->qty <= 5)
                                        <span class="badge badge-warning">{{ $stock->qty }} — Low</span>
                                    @else
                                        <span class="badge badge-success">{{ $stock->qty }}</span>
                                    @endif
                                </td>
                                <td>${{ number_format($stock->mrp, 2) }}</td>
                                <td>${{ number_format($stock->rate, 2) }}</td>
                                <td>
                                    <a href="{{ route('gamestock.edit', $stock) }}"
                                       class="btn btn-sm btn-info">
                                        <i class="mdi mdi-pencil"></i> Edit
                                    </a>
                                    <form action="{{ route('gamestock.destroy', $stock) }}"
                                          method="POST" class="d-inline"
                                          onsubmit="return confirm('Delete this stock entry?')">
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
                                <td colspan="11" class="text-center text-muted py-4">
                                    <i class="mdi mdi-package-variant font-30"></i><br>
                                    No stock entries found.
                                    <a href="{{ route('gamestock.create') }}">Add first entry</a>
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