@extends('admin.layouts.admin')
@section('page-title', 'Add Stock In')
@section('page-heading', 'Add Stock In')
@section('breadcrumb', 'Stock In')

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title m-b-20">New Stock In Entry</h4>

                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('stockin.store') }}" method="POST">
                    @csrf

                    <div class="form-group">
                        <label>Publisher <span class="text-danger">*</span></label>
                        <select name="publisher_id"
                                class="form-control @error('publisher_id') is-invalid @enderror"
                                required>
                            <option value="">-- Select Publisher --</option>
                            @foreach($publishers as $publisher)
                                <option value="{{ $publisher->id }}"
                                    {{ old('publisher_id') == $publisher->id ? 'selected' : '' }}>
                                    {{ $publisher->company_name }}
                                </option>
                            @endforeach
                        </select>
                        @error('publisher_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Reference Number</label>
                                <input type="text" name="reference_number"
                                       class="form-control"
                                       value="{{ old('reference_number') }}"
                                       placeholder="Invoice/Reference No">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Arrival Date <span class="text-danger">*</span></label>
                                <input type="date" name="arrival_date"
                                       class="form-control @error('arrival_date') is-invalid @enderror"
                                       value="{{ old('arrival_date', date('Y-m-d')) }}"
                                       required>
                                @error('arrival_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Total Cost <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">$</span>
                                    </div>
                                    <input type="number" name="total_cost"
                                           class="form-control @error('total_cost') is-invalid @enderror"
                                           value="{{ old('total_cost', 0) }}"
                                           step="0.01" min="0" required>
                                </div>
                                @error('total_cost')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Payment Status <span class="text-danger">*</span></label>
                                <select name="payment_status"
                                        class="form-control @error('payment_status') is-invalid @enderror"
                                        required>
                                    <option value="pending"
                                        {{ old('payment_status') == 'pending' ? 'selected' : '' }}>
                                        Pending
                                    </option>
                                    <option value="paid"
                                        {{ old('payment_status') == 'paid' ? 'selected' : '' }}>
                                        Paid
                                    </option>
                                    <option value="partial"
                                        {{ old('payment_status') == 'partial' ? 'selected' : '' }}>
                                        Partial
                                    </option>
                                </select>
                                @error('payment_status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <a href="{{ route('stockin.index') }}" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary">Save Entry</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection