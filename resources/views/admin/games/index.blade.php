@extends('admin.layouts.admin')

@section('page-title', 'Games Library')
@section('page-heading', 'Games Library')
@section('breadcrumb', 'Games')

@section('content')

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
    </div>
@endif
@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show">
        {{ session('error') }}
        <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
    </div>
@endif

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center m-b-20">
                    <h4 class="card-title mb-0">All Games</h4>
                    <a href="{{ route('games.create') }}" class="btn btn-primary">
                        <i class="mdi mdi-plus"></i> Add Game
                    </a>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Poster</th>
                                <th>Title</th>
                                <th>Platform</th>
                                <th>Genre</th>
                                <th>Publisher</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($games as $index => $game)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    @if($game->poster)
                                        <img src="{{ asset('storage/' . $game->poster) }}"
                                             alt="{{ $game->title }}"
                                             width="50" height="50"
                                             style="object-fit:cover; border-radius:4px;">
                                    @else
                                        <div style="width:50px;height:50px;background:#eee;
                                                    border-radius:4px;display:flex;
                                                    align-items:center;justify-content:center;">
                                            <i class="mdi mdi-gamepad-variant text-muted"></i>
                                        </div>
                                    @endif
                                </td>
                                <td><strong>{{ $game->title }}</strong></td>
                                <td>
                                    <span class="badge badge-info">
                                        {{ $game->platform }}
                                    </span>
                                </td>
                                <td>{{ $game->genre }}</td>
                                <td>
                                    {{ $game->publisher->company_name ?? '—' }}
                                </td>
                                <td>
                                    <a href="{{ route('games.edit', $game) }}"
                                       class="btn btn-sm btn-info">
                                        <i class="mdi mdi-pencil"></i> Edit
                                    </a>
                                    <form action="{{ route('games.destroy', $game) }}"
                                          method="POST" class="d-inline"
                                          onsubmit="return confirm('Delete this game?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger">
                                            <i class="mdi mdi-delete"></i> Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">
                                    <i class="mdi mdi-gamepad-variant font-30"></i><br>
                                    No games found.
                                    <a href="{{ route('games.create') }}">Add first game</a>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection