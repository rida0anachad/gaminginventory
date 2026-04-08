@extends('layouts.admin')

@section('page-title', 'Edit Publisher')
@section('page-heading', 'Edit Publisher')
@section('breadcrumb', 'Publishers')

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title m-b-20">Edit Publisher — {{ $publisher->publisher_id }}</h4>
                <form action="{{ route('publishers.update', $publisher) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label>Company Name <span class="text-danger">*</span></label>
                        <input type="text" name="company_name"
                               class="form-control @error('company_name') is-invalid @enderror"
                               value="{{ old('company_name', $publisher->company_name) }}">
                        @error('company_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email"
                               class="form-control @error('email') is-invalid @enderror"
                               value="{{ old('email', $publisher->email) }}">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Contact Number</label>
                        <input type="text" name="contact_number" class="form-control"
                               value="{{ old('contact_number', $publisher->contact_number) }}">
                    </div>
                    <div class="form-group">
                        <label>Address</label>
                        <textarea name="address" class="form-control" rows="3">{{ old('address', $publisher->address) }}</textarea>
                    </div>
                    <a href="{{ route('publishers.index') }}" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary">Update Publisher</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection