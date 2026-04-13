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
                            @foreach($publishers as $pub)
                                <option value="{{ $pub->id }}"
                                    {{ old('publisher_id', $stockin->publisher_id) == $pub->id ? 'selected' : '' }}>
                                    {{ $pub->company_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Game Received <span class="text-danger">*</span></label>
                        <select name="game_id" class="form-control" required>
                            <option value="">-- Select Game --</option>
                            @foreach($games as $game)
                                <option value="{{ $game->id }}"
                                    {{ old('game_id', $stockin->game_id) == $game->id ? 'selected' : '' }}>
                                    {{ $game->title }} — {{ $game->platform }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Quantity Received <span class="text-danger">*</span></label>
                                <input type="number" name="quantity_received"
                                       class="form-control"
                                       value="{{ old('quantity_received', $stockin->quantity_received) }}"
                                       min="1" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Reference Number</label>
                                <input type="text" name="reference_number"
                                       class="form-control"
                                       value="{{ old('reference_number', $stockin->reference_number) }}">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Cost Price (per unit) <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">$</span>
                                    </div>
                                    <input type="number" name="cost_price"
                                           class="form-control"
                                           value="{{ old('cost_price', $stockin->cost_price) }}"
                                           step="0.01" min="0" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Sale Rate (per unit) <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">$</span>
                                    </div>
                                    <input type="number" name="sale_rate"
                                           class="form-control"
                                           value="{{ old('sale_rate', $stockin->sale_rate) }}"
                                           step="0.01" min="0" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Arrival Date <span class="text-danger">*</span></label>
                                <input type="date" name="arrival_date"
                                       class="form-control"
                                       value="{{ old('arrival_date', $stockin->arrival_date) }}"
                                       required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Payment Status <span class="text-danger">*</span></label>
                                <select name="payment_status" class="form-control" required>
                                    @foreach(['paid' => 'Paid', 'pending' => 'Pending', 'partial' => 'Partial'] as $val => $label)
                                        <option value="{{ $val }}"
                                            {{ old('payment_status', $stockin->payment_status) == $val ? 'selected' : '' }}>
                                            {{ $label }}
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