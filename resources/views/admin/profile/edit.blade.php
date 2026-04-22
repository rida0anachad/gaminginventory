@extends('admin.layouts.admin')
@section('page-title', 'My Profile')
@section('page-heading', 'My Profile')
@section('breadcrumb', 'Profile')

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

    {{-- Info Card --}}
    <div class="col-lg-4">
        <div class="card">
            <div class="card-body text-center">
                <div class="m-b-20">
                    <img src="{{ asset('assets/images/users/2.jpg') }}"
                         alt="user" class="rounded-circle"
                         width="100" height="100"
                         style="object-fit:cover;">
                </div>
                <h4 class="card-title">{{ Auth::user()->name }}</h4>
                <p class="text-muted">{{ Auth::user()->email }}</p>
                <span class="badge badge-success">Administrator</span>
            </div>
        </div>
    </div>

    {{-- Edit Form --}}
    <div class="col-lg-8">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title m-b-20">
                    <i class="mdi mdi-account text-primary m-r-5"></i>
                    Edit Profile
                </h4>

                <form action="{{ route('profile.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label>Full Name <span class="text-danger">*</span></label>
                        <input type="text" name="name"
                               class="form-control @error('name') is-invalid @enderror"
                               value="{{ old('name', $user->name) }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Email Address <span class="text-danger">*</span></label>
                        <input type="email" name="email"
                               class="form-control @error('email') is-invalid @enderror"
                               value="{{ old('email', $user->email) }}" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <hr>

                    <h5 class="m-b-15">
                        <i class="mdi mdi-lock text-warning m-r-5"></i>
                        Change Password
                        <small class="text-muted">(leave blank to keep current)</small>
                    </h5>

                    <div class="form-group">
                        <label>Current Password</label>
                        <input type="password" name="current_password"
                               class="form-control"
                               placeholder="Enter current password">
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>New Password</label>
                                <input type="password" name="new_password"
                                       class="form-control @error('new_password') is-invalid @enderror"
                                       placeholder="Min 8 characters">
                                @error('new_password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Confirm New Password</label>
                                <input type="password"
                                       name="new_password_confirmation"
                                       class="form-control"
                                       placeholder="Repeat new password">
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">
                        <i class="mdi mdi-check m-r-5"></i> Update Profile
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection