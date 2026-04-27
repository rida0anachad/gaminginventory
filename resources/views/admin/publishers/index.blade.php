@extends('admin.layouts.admin')

@section('page-title', 'Publishers')
@section('page-heading', 'Publishers')
@section('breadcrumb', 'Publishers')

@section('content')

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
    </div>
@endif
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
    </div>
@endif

{{-- Add this --}}
@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
    </div>
@endif

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center m-b-20">
                    <h4 class="card-title mb-0">All Publishers</h4>
                    <a href="{{ route('publishers.create') }}" class="btn btn-primary">
                        <i class="mdi mdi-plus"></i> Add Publisher
                    </a>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Publisher ID</th>
                                <th>Company Name</th>
                                <th>Email</th>
                                <th>Contact Number</th>
                                <th>Address</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($publishers as $index => $publisher)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td><span class="badge badge-primary">{{ $publisher->publisher_id }}</span></td>
                                <td>{{ $publisher->company_name }}</td>
                                <td>{{ $publisher->email ?? '—' }}</td>
                                <td>{{ $publisher->contact_number ?? '—' }}</td>
                                <td>{{ $publisher->address ?? '—' }}</td>
                                <td>
                                    <a href="{{ route('publishers.edit', $publisher) }}"
                                       class="btn btn-sm btn-info">
                                        <i class="mdi mdi-pencil"></i> Edit
                                    </a>
                                    <form action="{{ route('publishers.destroy', $publisher) }}"
                                          method="POST" class="d-inline"
                                          onsubmit="return confirm('Delete this publisher?')">
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
                                <td colspan="7" class="text-center text-muted">No publishers found.</td>
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