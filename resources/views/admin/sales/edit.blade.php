@extends('admin.layouts.admin')
@section('page-title', 'Edit Sale')
@section('page-heading', 'Edit Sale')
@section('breadcrumb', 'Sales')

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title m-b-20">Edit — {{ $sale->sale_no }}</h4>

                <form action="{{ route('sales.update', $sale) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label>Member <span class="text-danger">*</span></label>
                        <select name="member_id" class="form-control" required>
                            <option value="">-- Select Member --</option>
                            @foreach($members as $member)
                                <option value="{{ $member->id }}"
                                    {{ old('member_id', $sale->member_id) == $member->id ? 'selected' : '' }}>
                                    {{ $member->name }} ({{ $member->member_id }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Sale Date <span class="text-danger">*</span></label>
                        <input type="date" name="date" class="form-control"
                               value="{{ old('date', $sale->date) }}" required>
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
                                           id="total_amount" class="form-control"
                                           value="{{ old('total_amount', $sale->total_amount) }}"
                                           step="0.01" min="0" required>
                                </div>
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
                                           id="discount" class="form-control"
                                           value="{{ old('discount', $sale->discount) }}"
                                           step="0.01" min="0">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Net Total</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">$</span>
                            </div>
                            <input type="number" id="net_total_display"
                                   class="form-control"
                                   value="{{ $sale->net_total }}"
                                   readonly style="background:#f5f5f5">
                        </div>
                    </div>

                    <a href="{{ route('sales.index') }}" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary">Update Sale</button>
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