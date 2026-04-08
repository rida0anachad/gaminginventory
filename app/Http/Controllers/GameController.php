<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Publisher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GameController extends Controller
{
    public function index()
    {
        $games = Game::with('publisher')->latest()->get();
        return view('admin.games.index', compact('games'));
    }

    public function create()
    {
        $publishers = Publisher::orderBy('company_name')->get();
        return view('admin.games.create', compact('publishers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'        => 'required|string|max:200',
            'platform'     => 'required|string|max:80',
            'genre'        => 'required|string|max:80',
            'publisher_id' => 'nullable|exists:publishers,id',
            'poster'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ], [
            'title.required'    => 'Game title is required.',
            'platform.required' => 'Platform is required.',
            'genre.required'    => 'Genre is required.',
            'poster.image'      => 'Poster must be an image.',
            'poster.max'        => 'Poster must be under 2MB.',
        ]);

        try {
            $posterPath = null;

            // Upload poster si fourni
            if ($request->hasFile('poster')) {
                $posterPath = $request->file('poster')
                    ->store('posters', 'public');
            }

            Game::create([
                'title'        => $request->title,
                'platform'     => $request->platform,
                'genre'        => $request->genre,
                'publisher_id' => $request->publisher_id,
                'poster'       => $posterPath,
            ]);

            return redirect()->route('games.index')
                ->with('success', 'Game added successfully.');

        } catch (\Exception $e) {
            return back()->withInput()
                ->with('error', 'Error adding game: ' . $e->getMessage());
        }
    }

    public function edit(Game $game)
    {
        $publishers = Publisher::orderBy('company_name')->get();
        return view('admin.games.edit', compact('game', 'publishers'));
    }

    public function update(Request $request, Game $game)
    {
        $request->validate([
            'title'        => 'required|string|max:200',
            'platform'     => 'required|string|max:80',
            'genre'        => 'required|string|max:80',
            'publisher_id' => 'nullable|exists:publishers,id',
            'poster'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        try {
            $posterPath = $game->poster;

            // Nouveau poster uploadé
            if ($request->hasFile('poster')) {
                // Supprimer l'ancien
                if ($game->poster) {
                    Storage::disk('public')->delete($game->poster);
                }
                $posterPath = $request->file('poster')
                    ->store('posters', 'public');
            }

            $game->update([
                'title'        => $request->title,
                'platform'     => $request->platform,
                'genre'        => $request->genre,
                'publisher_id' => $request->publisher_id,
                'poster'       => $posterPath,
            ]);

            return redirect()->route('games.index')
                ->with('success', 'Game updated successfully.');

        } catch (\Exception $e) {
            return back()->withInput()
                ->with('error', 'Error updating game. Please try again.');
        }
    }

    public function destroy(Game $game)
    {
        try {
            // Supprimer le poster du storage
            if ($game->poster) {
                Storage::disk('public')->delete($game->poster);
            }
            $game->delete();

            return redirect()->route('games.index')
                ->with('success', 'Game deleted successfully.');

        } catch (\Exception $e) {
            return back()
                ->with('error', 'Error deleting game. Please try again.');
        }
    }
}