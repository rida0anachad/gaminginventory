@extends('admin.layouts.admin')

@section('page-title', 'Edit Stock')
@section('page-heading', 'Edit Stock Entry')
@section('breadcrumb', 'Games Stock')

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title m-b-20">
                    Edit Stock — {{ $gamestock->game->title ?? '' }}
                </h4>

                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('gamestock.update', $gamestock) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label>Game Title <span class="text-danger">*</span></label>
                        <select name="game_id" class="form-control" required>
                            <option value="">-- Select Game --</option>
                            @foreach($games as $game)
                                <option value="{{ $game->id }}"
                                    {{ old('game_id', $gamestock->game_id) == $game->id ? 'selected' : '' }}>
                                    {{ $game->title }} — {{ $game->platform }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Serial / SKU</label>
                                <input type="text" name="sku" class="form-control"
                                       value="{{ old('sku', $gamestock->sku) }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Release Date</label>
                                <input type="date" name="release_date" class="form-control"
                                       value="{{ old('release_date', $gamestock->release_date) }}">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Quantity <span class="text-danger">*</span></label>
                                <input type="number" name="qty" class="form-control"
                                       value="{{ old('qty', $gamestock->qty) }}"
                                       min="0" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>M.R.P <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">$</span>
                                    </div>
                                    <input type="number" name="mrp" class="form-control"
                                           value="{{ old('mrp', $gamestock->mrp) }}"
                                           step="0.01" min="0" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Sale Rate <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">$</span>
                                    </div>
                                    <input type="number" name="rate" class="form-control"
                                           value="{{ old('rate', $gamestock->rate) }}"
                                           step="0.01" min="0" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <a href="{{ route('gamestock.index') }}" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary">Update Stock</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection