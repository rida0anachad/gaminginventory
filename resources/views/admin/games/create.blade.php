@extends('admin.layouts.admin')

@section('page-title', 'Add Game')
@section('page-heading', 'Add Game')
@section('breadcrumb', 'Games Library')

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title m-b-20">New Game</h4>

                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- enctype obligatoire pour upload fichier --}}
                <form action="{{ route('games.store') }}"
                      method="POST"
                      enctype="multipart/form-data">
                    @csrf

                    <div class="form-group">
                        <label>Game Title <span class="text-danger">*</span></label>
                        <input type="text" name="title"
                               class="form-control @error('title') is-invalid @enderror"
                               value="{{ old('title') }}"
                               placeholder="e.g. Elden Ring" required>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Platform <span class="text-danger">*</span></label>
                                <select name="platform"
                                        class="form-control @error('platform') is-invalid @enderror"
                                        required>
                                    <option value="">-- Select Platform --</option>
                                    @foreach(['PC','PlayStation 5','PlayStation 4','Xbox Series X','Xbox One','Nintendo Switch','Mobile'] as $p)
                                        <option value="{{ $p }}"
                                            {{ old('platform') == $p ? 'selected' : '' }}>
                                            {{ $p }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('platform')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Genre <span class="text-danger">*</span></label>
                                <select name="genre"
                                        class="form-control @error('genre') is-invalid @enderror"
                                        required>
                                    <option value="">-- Select Genre --</option>
                                    @foreach(['Action','Adventure','RPG','Sport','FPS','Strategy','Simulation','Horror','Platform','Fighting'] as $g)
                                        <option value="{{ $g }}"
                                            {{ old('genre') == $g ? 'selected' : '' }}>
                                            {{ $g }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('genre')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Publisher</label>
                        <select name="publisher_id" class="form-control">
                            <option value="">-- Select Publisher --</option>
                            @foreach($publishers as $publisher)
                                <option value="{{ $publisher->id }}"
                                    {{ old('publisher_id') == $publisher->id ? 'selected' : '' }}>
                                    {{ $publisher->company_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Game Poster / Cover</label>
                        <div class="custom-file">
                            <input type="file" name="poster"
                                   class="custom-file-input @error('poster') is-invalid @enderror"
                                   id="posterInput"
                                   accept="image/*">
                            <label class="custom-file-label" for="posterInput">
                                Choose image...
                            </label>
                        </div>
                        @error('poster')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">JPG, PNG, WebP — max 2MB</small>
                        {{-- Preview --}}
                        <div class="mt-2" id="previewBox" style="display:none;">
                            <img id="posterPreview" src="#" alt="Preview"
                                 style="height:100px;border-radius:6px;
                                        object-fit:cover;border:1px solid #ddd;">
                        </div>
                    </div>

                    <a href="{{ route('games.index') }}" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary">Save Game</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Preview de l'image avant upload
document.getElementById('posterInput').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(ev) {
            document.getElementById('posterPreview').src = ev.target.result;
            document.getElementById('previewBox').style.display = 'block';
            document.querySelector('.custom-file-label').textContent = file.name;
        };
        reader.readAsDataURL(file);
    }
});
</script>
@endpush