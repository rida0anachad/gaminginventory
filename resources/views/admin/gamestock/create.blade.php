@extends('admin.layouts.admin')

@section('page-title', 'Add Stock Entry')
@section('page-heading', 'Add Stock Entry')
@section('breadcrumb', 'Games Stock')

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title m-b-20">New Stock Entry</h4>

                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('gamestock.store') }}" method="POST">
                    @csrf

                    <div class="form-group">
                        <label>Game Title <span class="text-danger">*</span></label>
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

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Serial / SKU</label>
                                <input type="text" name="sku"
                                       class="form-control @error('sku') is-invalid @enderror"
                                       value="{{ old('sku') }}"
                                       placeholder="e.g. PS5-ELDENRING-001">
                                @error('sku')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Release Date</label>
                                <input type="date" name="release_date"
                                       class="form-control"
                                       value="{{ old('release_date') }}">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Quantity <span class="text-danger">*</span></label>
                                <input type="number" name="qty"
                                       class="form-control @error('qty') is-invalid @enderror"
                                       value="{{ old('qty', 0) }}"
                                       min="0" required>
                                @error('qty')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Market Price (M.R.P) <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">$</span>
                                    </div>
                                    <input type="number" name="mrp"
                                           class="form-control @error('mrp') is-invalid @enderror"
                                           value="{{ old('mrp', 0) }}"
                                           step="0.01" min="0" required>
                                </div>
                                @error('mrp')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Sale Rate <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">$</span>
                                    </div>
                                    <input type="number" name="rate"
                                           class="form-control @error('rate') is-invalid @enderror"
                                           value="{{ old('rate', 0) }}"
                                           step="0.01" min="0" required>
                                </div>
                                @error('rate')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <a href="{{ route('gamestock.index') }}" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary">Save Stock Entry</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection