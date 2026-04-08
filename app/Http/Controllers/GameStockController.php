<?php

namespace App\Http\Controllers;

use App\Models\GameStock;
use App\Models\Game;
use Illuminate\Http\Request;

class GameStockController extends Controller
{
    public function index()
    {
        $stocks = GameStock::with(['game', 'game.publisher'])->latest()->get();
        return view('admin.gamestock.index', compact('stocks'));
    }

    public function create()
    {
        $games = Game::orderBy('title')->get();
        return view('admin.gamestock.create', compact('games'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'game_id'      => 'required|exists:games,id',
            'sku'          => 'nullable|string|max:100|unique:game_stocks,sku',
            'release_date' => 'nullable|date',
            'qty'          => 'required|integer|min:0',
            'mrp'          => 'required|numeric|min:0',
            'rate'         => 'required|numeric|min:0',
        ], [
            'game_id.required' => 'Please select a game.',
            'qty.required'     => 'Quantity is required.',
            'mrp.required'     => 'Market price is required.',
            'rate.required'    => 'Sale rate is required.',
            'sku.unique'       => 'This SKU already exists.',
        ]);

        try {
            GameStock::create([
                'game_id'      => $request->game_id,
                'sku'          => $request->sku,
                'release_date' => $request->release_date,
                'qty'          => $request->qty,
                'mrp'          => $request->mrp,
                'rate'         => $request->rate,
            ]);

            return redirect()->route('gamestock.index')
                ->with('success', 'Stock entry added successfully.');

        } catch (\Exception $e) {
            return back()->withInput()
                ->with('error', 'Error adding stock: ' . $e->getMessage());
        }
    }

    public function edit(GameStock $gamestock)
    {
        $games = Game::orderBy('title')->get();
        return view('admin.gamestock.edit', compact('gamestock', 'games'));
    }

    public function update(Request $request, GameStock $gamestock)
    {
        $request->validate([
            'game_id'      => 'required|exists:games,id',
            'sku'          => 'nullable|string|max:100|unique:game_stocks,sku,' . $gamestock->id,
            'release_date' => 'nullable|date',
            'qty'          => 'required|integer|min:0',
            'mrp'          => 'required|numeric|min:0',
            'rate'         => 'required|numeric|min:0',
        ]);

        try {
            $gamestock->update([
                'game_id'      => $request->game_id,
                'sku'          => $request->sku,
                'release_date' => $request->release_date,
                'qty'          => $request->qty,
                'mrp'          => $request->mrp,
                'rate'         => $request->rate,
            ]);

            return redirect()->route('gamestock.index')
                ->with('success', 'Stock updated successfully.');

        } catch (\Exception $e) {
            return back()->withInput()
                ->with('error', 'Error updating stock. Please try again.');
        }
    }

    public function destroy(GameStock $gamestock)
    {
        try {
            $gamestock->delete();
            return redirect()->route('gamestock.index')
                ->with('success', 'Stock entry deleted successfully.');

        } catch (\Exception $e) {
            return back()
                ->with('error', 'Error deleting stock. Please try again.');
        }
    }
}