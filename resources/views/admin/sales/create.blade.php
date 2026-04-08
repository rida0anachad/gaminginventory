@extends('admin.layouts.admin')
@section('page-title', 'New Sale')
@section('page-heading', 'New Sale')
@section('breadcrumb', 'Sales')

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title m-b-20">New Sale / Invoice</h4>

                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('sales.store') }}" method="POST">
                    @csrf

                    <div class="form-group">
                        <label>Member <span class="text-danger">*</span></label>
                        <select name="member_id"
                                class="form-control @error('member_id') is-invalid @enderror"
                                required>
                            <option value="">-- Select Member --</option>
                            @foreach($members as $member)
                                <option value="{{ $member->id }}"
                                    {{ old('member_id') == $member->id ? 'selected' : '' }}>
                                    {{ $member->name }} ({{ $member->member_id }})
                                </option>
                            @endforeach
                        </select>
                        @error('member_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Sale Date <span class="text-danger">*</span></label>
                        <input type="date" name="date"
                               class="form-control @error('date') is-invalid @enderror"
                               value="{{ old('date', date('Y-m-d')) }}"
                               required>
                        @error('date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Total Amount <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">$</span>
                                    </div>
                                    <input type="number" name="total_amount"
                                           id="total_amount"
                                           class="form-control @error('total_amount') is-invalid @enderror"
                                           value="{{ old('total_amount', 0) }}"
                                           step="0.01" min="0" required>
                                </div>
                                @error('total_amount')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Discount</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">$</span>
                                    </div>
                                    <input type="number" name="discount"
                                           id="discount"
                                           class="form-control"
                                           value="{{ old('discount', 0) }}"
                                           step="0.01" min="0">
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Net Total auto-calculé --}}
                    <div class="form-group">
                        <label>Net Total</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">$</span>
                            </div>
                            <input type="number" id="net_total_display"
                                   class="form-control" value="0"
                                   readonly style="background:#f5f5f5">
                        </div>
                        <small class="text-muted">Auto-calculated</small>
                    </div>

                    <a href="{{ route('sales.index') }}" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary">Save Sale</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function calcNet() {
    const total    = parseFloat(document.getElementById('total_amount').value) || 0;
    const discount = parseFloat(document.getElementById('discount').value) || 0;
    document.getElementById('net_total_display').value = (total - discount).toFixed(2);
}
document.getElementById('total_amount').addEventListener('input', calcNet);
document.getElementById('discount').addEventListener('input', calcNet);
</script>
@endpush