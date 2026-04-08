@extends('admin.layouts.admin')

@section('page-title', 'Members')
@section('page-heading', 'Members')
@section('breadcrumb', 'Members')

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
                    <h4 class="card-title mb-0">All Members</h4>
                    <a href="{{ route('members.create') }}" class="btn btn-primary">
                        <i class="mdi mdi-plus"></i> Add Member
                    </a>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Member ID</th>
                                <th>Name</th>
                                <th>Contact</th>
                                <th>Address</th>
                                <th>Fav. Genre</th>
                                <th>Platform</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($members as $index => $member)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    <span class="badge badge-info">
                                        {{ $member->member_id }}
                                    </span>
                                </td>
                                <td>{{ $member->name }}</td>
                                <td>{{ $member->contact_number ?? '—' }}</td>
                                <td>{{ $member->address ?? '—' }}</td>
                                <td>{{ $member->favorite_genre ?? '—' }}</td>
                                <td>{{ $member->platform_preference ?? '—' }}</td>
                                <td>
                                    <a href="{{ route('members.edit', $member) }}"
                                       class="btn btn-sm btn-info">
                                        <i class="mdi mdi-pencil"></i> Edit
                                    </a>
                                    <form action="{{ route('members.destroy', $member) }}"
                                          method="POST" class="d-inline"
                                          onsubmit="return confirm('Delete this member?')">
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
                                    <i class="mdi mdi-account-multiple font-30"></i><br>
                                    No members found.
                                    <a href="{{ route('members.create') }}">Add first member</a>
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