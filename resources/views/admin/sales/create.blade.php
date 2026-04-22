@extends('admin.layouts.admin')
@section('page-title', 'New Sale')
@section('page-heading', 'New Sale')
@section('breadcrumb', 'Sales')

@section('content')

@if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif

<div class="row">
    <div class="col-lg-10 col-md-12">
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

                <form action="{{ route('sales.store') }}" method="POST" id="saleForm">
                    @csrf

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Member <span class="text-danger">*</span></label>
                                <select name="member_id" class="form-control" required>
                                    <option value="">-- Select Member --</option>
                                    @foreach($members as $member)
                                        <option value="{{ $member->id }}"
                                            {{ old('member_id') == $member->id ? 'selected' : '' }}>
                                            {{ $member->name }} ({{ $member->member_id }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Sale Date <span class="text-danger">*</span></label>
                                <input type="date" name="date" class="form-control"
                                       value="{{ old('date', date('Y-m-d')) }}" required>
                            </div>
                        </div>
                    </div>

                    {{-- Game Items --}}
                    <hr>
                    <h5 class="m-b-15">
                        <i class="mdi mdi-gamepad-variant text-primary"></i>
                        Games Sold
                    </h5>

                    <div id="gameItems">
                        <div class="game-item row align-items-end mb-2" data-index="0">
                            <div class="col-md-6">
                                <label>Game <span class="text-danger">*</span></label>
                                <select name="games[0][id]"
                                        class="form-control game-select" required>
                                    <option value="">-- Select Game --</option>
                                    @foreach($games as $game)
                                        <option value="{{ $game->id }}"
                                                data-price="{{ $game->stock->sale_rate ?? 0 }}"
                                                data-stock="{{ $game->stock->qty ?? 0 }}">
                                            {{ $game->title }}
                                            ({{ $game->platform }})
                                            — Stock: {{ $game->stock->qty ?? 0 }}
                                            — ${{ number_format($game->stock->sale_rate ?? 0, 2) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label>Qty</label>
                                <input type="number" name="games[0][qty]"
                                       class="form-control qty-input"
                                       value="1" min="1" required>
                            </div>
                            <div class="col-md-2">
                                <label>Unit Price</label>
                                <input type="text" class="form-control unit-price"
                                       value="0.00" readonly
                                       style="background:#f5f5f5">
                            </div>
                            <div class="col-md-2">
                                <label>total</label>
                                <input type="text" class="form-control subtotal"
                                       value="0.00" readonly
                                       style="background:#f5f5f5">
                            </div>
                        </div>
                    </div>

                    <button type="button" class="btn btn-sm btn-outline-primary mb-3"
                            id="addGame">
                        <i class="mdi mdi-plus"></i> Add Another Game
                    </button>

                    <hr>

                    <div class="row justify-content-end">
                        <div class="col-md-4">
                            <table class="table table-sm">
                                <tr>
                                    <td>Total Amount</td>
                                    <td class="text-right">
                                        <strong id="displayTotal">$0.00</strong>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Discount ($)
                                        <input type="number" name="discount"
                                               id="discountInput"
                                               class="form-control form-control-sm mt-1"
                                               value="0" min="0" step="0.01">
                                    </td>
                                    <td class="text-right text-danger" id="displayDiscount">
                                        -$0.00
                                    </td>
                                </tr>
                                <tr class="table-success">
                                    <td><strong>Net Total</strong></td>
                                    <td class="text-right">
                                        <strong id="displayNet">$0.00</strong>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <a href="{{ route('sales.index') }}" class="btn btn-secondary">
                        Cancel
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="mdi mdi-check"></i> Save Sale & Update Stock
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
let itemIndex = 0;

const gamesData = {!! $gamesJson !!};

function getGameOptions(selectedId = null) {
    let opts = '<option value="">-- Select Game --</option>';
    gamesData.forEach(g => {
        const sel = selectedId == g.id ? 'selected' : '';
        opts += `<option value="${g.id}" data-price="${g.price}"
                         data-stock="${g.stock}" ${sel}>
                    ${g.title} — Stock: ${g.stock} — $${parseFloat(g.price).toFixed(2)}
                 </option>`;
    });
    return opts;
}

function calcRow(row) {
    const sel   = row.querySelector('.game-select');
    const qty   = parseFloat(row.querySelector('.qty-input').value) || 0;
    const opt   = sel.options[sel.selectedIndex];
    const price = opt ? parseFloat(opt.dataset.price || 0) : 0;
    const sub   = price * qty;
    row.querySelector('.unit-price').value = price.toFixed(2);
    row.querySelector('.subtotal').value   = sub.toFixed(2);
    calcTotals();
}

function calcTotals() {
    let total = 0;
    document.querySelectorAll('.subtotal').forEach(s => {
        total += parseFloat(s.value) || 0;
    });
    const discount = parseFloat(document.getElementById('discountInput').value) || 0;
    const net      = total - discount;
    document.getElementById('displayTotal').textContent    = '$' + total.toFixed(2);
    document.getElementById('displayDiscount').textContent = '-$' + discount.toFixed(2);
    document.getElementById('displayNet').textContent      = '$' + net.toFixed(2);
}

// Ajouter une ligne
document.getElementById('addGame').addEventListener('click', function() {
    itemIndex++;
    const div = document.createElement('div');
    div.className = 'game-item row align-items-end mb-2';
    div.dataset.index = itemIndex;
    div.innerHTML = `
        <div class="col-md-6">
            <select name="games[${itemIndex}][id]" class="form-control game-select" required>
                ${getGameOptions()}
            </select>
        </div>
        <div class="col-md-2">
            <input type="number" name="games[${itemIndex}][qty]"
                   class="form-control qty-input" value="1" min="1" required>
        </div>
        <div class="col-md-2">
            <input type="text" class="form-control unit-price"
                   value="0.00" readonly style="background:#f5f5f5">
        </div>
        <div class="col-md-2 d-flex align-items-center gap-2">
            <input type="text" class="form-control subtotal"
                   value="0.00" readonly style="background:#f5f5f5">
            <button type="button" class="btn btn-sm btn-danger ml-1 remove-row">
                <i class="mdi mdi-close"></i>
            </button>
        </div>`;
    document.getElementById('gameItems').appendChild(div);
    attachEvents(div);
});

function attachEvents(row) {
    row.querySelector('.game-select').addEventListener('change', () => calcRow(row));
    row.querySelector('.qty-input').addEventListener('input',  () => calcRow(row));
    const removeBtn = row.querySelector('.remove-row');
    if (removeBtn) {
        removeBtn.addEventListener('click', function() {
            row.remove();
            calcTotals();
        });
    }
}

// Attacher events à la première ligne
const firstRow = document.querySelector('.game-item');
attachEvents(firstRow);

// Discount input
document.getElementById('discountInput').addEventListener('input', calcTotals);
</script>
@endpush