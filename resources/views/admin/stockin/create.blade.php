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
                @if(session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                <form action="{{ route('stockin.store') }}" method="POST">
                    @csrf

                    {{-- Publisher --}}
                    <div class="form-group">
                        <label>Publisher <span class="text-danger">*</span></label>
                        <select name="publisher_id"
                                class="form-control @error('publisher_id') is-invalid @enderror"
                                required>
                            <option value="">-- Select Publisher --</option>
                            @foreach($publishers as $pub)
                                <option value="{{ $pub->id }}"
                                    {{ old('publisher_id') == $pub->id ? 'selected' : '' }}>
                                    {{ $pub->company_name }}
                                </option>
                            @endforeach
                        </select>
                        @error('publisher_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Game --}}
                    <div class="form-group">
                        <label>Game Received <span class="text-danger">*</span></label>
                        <select name="game_id"
                                class="form-control @error('game_id') is-invalid @enderror"
                                required>
                            <option value="">-- Select Game --</option>
                            @foreach($games as $game)
                                <option value="{{ $game->id }}"
                                    {{ old('game_id') == $game->id ? 'selected' : '' }}>
                                    {{ $game->title }} — {{ $game->platform }}
                                </option>
                            @endforeach
                        </select>
                        @error('game_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Quantity + Reference --}}
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Quantity Received <span class="text-danger">*</span></label>
                                <input type="number" name="quantity_received"
                                       class="form-control @error('quantity_received') is-invalid @enderror"
                                       value="{{ old('quantity_received', 1) }}"
                                       min="1" required>
                                @error('quantity_received')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Reference Number</label>
                                <input type="text" name="reference_number"
                                       class="form-control"
                                       value="{{ old('reference_number') }}"
                                       placeholder="Invoice/Reference No">
                            </div>
                        </div>
                    </div>

                    {{-- Cost Price + Sale Rate --}}
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>
                                    Cost Price (per unit)
                                    <span class="text-danger">*</span>
                                    
                                </label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">$</span>
                                    </div>
                                    <input type="number" name="cost_price"
                                           class="form-control @error('cost_price') is-invalid @enderror"
                                           value="{{ old('cost_price', 0) }}"
                                           step="0.01" min="0" required>
                                </div>
                                @error('cost_price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>
                                    Sale Rate (per unit)
                                    <span class="text-danger">*</span>
                                    
                                </label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">$</span>
                                    </div>
                                    <input type="number" name="sale_rate"
                                           class="form-control @error('sale_rate') is-invalid @enderror"
                                           value="{{ old('sale_rate', 0) }}"
                                           step="0.01" min="0" required>
                                </div>
                                @error('sale_rate')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- Profit preview --}}
                    <div class="alert alert-light border m-b-20">
                        <i class="mdi mdi-calculator text-success m-r-5"></i>
                        Profit per unit :
                        <strong id="profitPreview" class="text-success">$0.00</strong>
                    </div>

                    {{-- Arrival Date + Payment Status --}}
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Arrival Date <span class="text-danger">*</span></label>
                                <input type="date" name="arrival_date"
                                       class="form-control"
                                       value="{{ old('arrival_date', date('Y-m-d')) }}"
                                       required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Payment Status <span class="text-danger">*</span></label>
                                <select name="payment_status" class="form-control" required>
                                    @foreach(['pending' => 'Pending', 'paid' => 'Paid', 'partial' => 'Partial'] as $val => $label)
                                        <option value="{{ $val }}"
                                            {{ old('payment_status', 'pending') == $val ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <a href="{{ route('stockin.index') }}" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary">
                        <i class="mdi mdi-check m-r-5"></i> Save & Update Stock
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function calcProfit() {
    const cost = parseFloat(document.querySelector('[name=cost_price]').value) || 0;
    const rate = parseFloat(document.querySelector('[name=sale_rate]').value) || 0;
    const profit = rate - cost;
    const el = document.getElementById('profitPreview');
    el.textContent = '$' + profit.toFixed(2);
    el.className = profit >= 0 ? 'text-success' : 'text-danger';
}
document.querySelector('[name=cost_price]').addEventListener('input', calcProfit);
document.querySelector('[name=sale_rate]').addEventListener('input', calcProfit);
</script>
@endpush