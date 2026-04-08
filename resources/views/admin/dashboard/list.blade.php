@extends('admin.layouts.admin')

@section('page-title', 'Dashboard — Gaming Inventory')
@section('page-heading', 'Dashboard')
@section('breadcrumb', 'Dashboard')

@push('styles')
@endpush

@section('content')

{{-- ═══ STAT CARDS ═══ --}}
<div class="row">

    {{-- Total Members --}}
    <div class="col-lg-2 col-md-4 col-sm-6">
        <div class="card">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-8">
                        <i class="mdi mdi-account-multiple font-24 text-info"></i>
                        <p class="font-14 m-b-5 m-t-5">Total Members</p>
                    </div>
                    <div class="col-4">
                        <h2 class="font-light text-right mb-0 text-info">
                            {{ $totalMembers ?? 0 }}
                        </h2>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Total Publishers --}}
    <div class="col-lg-2 col-md-4 col-sm-6">
        <div class="card">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-8">
                        <i class="mdi mdi-domain font-24 text-success"></i>
                        <p class="font-14 m-b-5 m-t-5">Publishers</p>
                    </div>
                    <div class="col-4">
                        <h2 class="font-light text-right mb-0 text-success">
                            {{ $totalPublishers ?? 0 }}
                        </h2>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Total Games --}}
    <div class="col-lg-2 col-md-4 col-sm-6">
        <div class="card">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-8">
                        <i class="mdi mdi-gamepad-variant font-24 text-purple"></i>
                        <p class="font-14 m-b-5 m-t-5">Total Games</p>
                    </div>
                    <div class="col-4">
                        <h2 class="font-light text-right mb-0" style="color:#7460ee">
                            {{ $totalGames ?? 0 }}
                        </h2>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Out of Stock --}}
    <div class="col-lg-2 col-md-4 col-sm-6">
        <div class="card">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-8">
                        <i class="mdi mdi-alert font-24 text-danger"></i>
                        <p class="font-14 m-b-5 m-t-5">Out of Stock</p>
                    </div>
                    <div class="col-4">
                        <h2 class="font-light text-right mb-0 text-danger">
                            {{ $outOfStock ?? 0 }}
                        </h2>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- New Releases --}}
    <div class="col-lg-2 col-md-4 col-sm-6">
        <div class="card">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-8">
                        <i class="mdi mdi-new-box font-24 text-warning"></i>
                        <p class="font-14 m-b-5 m-t-5">New Releases</p>
                    </div>
                    <div class="col-4">
                        <h2 class="font-light text-right mb-0 text-warning">
                            {{ $newReleases ?? 0 }}
                        </h2>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Total Sales --}}
    <div class="col-lg-2 col-md-4 col-sm-6">
        <div class="card">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-8">
                        <i class="mdi mdi-receipt font-24 text-primary"></i>
                        <p class="font-14 m-b-5 m-t-5">Total Sales</p>
                    </div>
                    <div class="col-4">
                        <h2 class="font-light text-right mb-0 text-primary">
                            {{ $totalSales ?? 0 }}
                        </h2>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
{{-- ═══ END STAT CARDS ═══ --}}

{{-- ═══ TABLES ROW ═══ --}}
<div class="row m-t-20">

    {{-- Recent Publishers --}}
    <div class="col-lg-6">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center m-b-15">
                    <h4 class="card-title mb-0">
                        <i class="mdi mdi-domain text-success m-r-5"></i>
                        Recent Publishers
                    </h4>
                    <a href="{{ route('publishers.index') }}" class="btn btn-sm btn-outline-success">
                        View All
                    </a>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover table-sm">
                        <thead class="thead-light">
                            <tr>
                                <th>ID</th>
                                <th>Company</th>
                                <th>Email</th>
                                <th>Phone</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentPublishers ?? [] as $publisher)
                            <tr>
                                <td><span class="badge badge-success">{{ $publisher->publisher_id }}</span></td>
                                <td>{{ $publisher->company_name }}</td>
                                <td class="text-muted">{{ $publisher->email ?? '—' }}</td>
                                <td class="text-muted">{{ $publisher->contact_number ?? '—' }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted py-3">
                                    <i class="mdi mdi-domain font-20"></i><br>
                                    No publishers yet.
                                    <a href="{{ route('publishers.create') }}">Add one</a>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- Out of Stock Alert --}}
    <div class="col-lg-6">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center m-b-15">
                    <h4 class="card-title mb-0">
                        <i class="mdi mdi-alert text-danger m-r-5"></i>
                        Out of Stock Alerts
                    </h4>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover table-sm">
                        <thead class="thead-light">
                            <tr>
                                <th>Game</th>
                                <th>Platform</th>
                                <th>Qty</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- Will be dynamic after Games migration --}}
                            <tr>
                                <td colspan="4" class="text-center text-muted py-3">
                                    <i class="mdi mdi-check-circle text-success font-20"></i><br>
                                    All games in stock.
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>
{{-- ═══ END TABLES ROW ═══ --}}

@endsection

@push('scripts')
@endpush