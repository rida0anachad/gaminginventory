@extends('admin.layouts.admin')

@section('page-title', 'Edit Member')
@section('page-heading', 'Edit Member')
@section('breadcrumb', 'Members')

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title m-b-20">
                    Edit Member — {{ $member->member_id }}
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

                <form action="{{ route('members.update', $member) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label>Name <span class="text-danger">*</span></label>
                        <input type="text" name="name"
                               class="form-control @error('name') is-invalid @enderror"
                               value="{{ old('name', $member->name) }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Contact Number</label>
                        <input type="text" name="contact_number" class="form-control"
                               value="{{ old('contact_number', $member->contact_number) }}">
                    </div>

                    <div class="form-group">
                        <label>Address</label>
                        <textarea name="address" class="form-control" rows="2">{{ old('address', $member->address) }}</textarea>
                    </div>

                    <div class="form-group">
                        <label>Favorite Genre</label>
                        <select name="favorite_genre" class="form-control">
                            <option value="">-- Select Genre --</option>
                            @foreach(['Action','Adventure','RPG','Sport','FPS','Strategy','Simulation','Horror','Platform','Fighting'] as $genre)
                                <option value="{{ $genre }}"
                                    {{ old('favorite_genre', $member->favorite_genre) == $genre ? 'selected' : '' }}>
                                    {{ $genre }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Platform Preference</label>
                        <select name="platform_preference" class="form-control">
                            <option value="">-- Select Platform --</option>
                            @foreach(['PC','PlayStation 5','PlayStation 4','Xbox Series X','Xbox One','Nintendo Switch','Mobile'] as $platform)
                                <option value="{{ $platform }}"
                                    {{ old('platform_preference', $member->platform_preference) == $platform ? 'selected' : '' }}>
                                    {{ $platform }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <a href="{{ route('members.index') }}" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary">Update Member</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection