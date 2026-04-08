@extends('admin.layouts.admin')
@section('page-title', 'Edit Stock In')
@section('page-heading', 'Edit Stock In')
@section('breadcrumb', 'Stock In')

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title m-b-20">
                    Edit — {{ $stockin->transaction_id }}
                </h4>

                <form action="{{ route('stockin.update', $stockin) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label>Publisher <span class="text-danger">*</span></label>
                        <select name="publisher_id" class="form-control" required>
                            <option value="">-- Select Publisher --</option>
                            @foreach($publishers as $publisher)
                                <option value="{{ $publisher->id }}"
                                    {{ old('publisher_id', $stockin->publisher_id) == $publisher->id ? 'selected' : '' }}>
                                    {{ $publisher->company_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Reference Number</label>
                                <input type="text" name="reference_number" class="form-control"
                                       value="{{ old('reference_number', $stockin->reference_number) }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Arrival Date <span class="text-danger">*</span></label>
                                <input type="date" name="arrival_date" class="form-control"
                                       value="{{ old('arrival_date', $stockin->arrival_date) }}"
                                       required>
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
                                    <input type="number" name="total_cost" class="form-control"
                                           value="{{ old('total_cost', $stockin->total_cost) }}"
                                           step="0.01" min="0" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Payment Status <span class="text-danger">*</span></label>
                                <select name="payment_status" class="form-control" required>
                                    @foreach(['paid','pending','partial'] as $status)
                                        <option value="{{ $status }}"
                                            {{ old('payment_status', $stockin->payment_status) == $status ? 'selected' : '' }}>
                                            {{ ucfirst($status) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <a href="{{ route('stockin.index') }}" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary">Update Entry</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection