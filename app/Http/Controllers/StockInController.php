<?php

namespace App\Http\Controllers;

use App\Models\StockIn;
use App\Models\Publisher;
use App\Models\Game;
use App\Models\GameStock;
use Illuminate\Http\Request;

class StockInController extends Controller
{
    public function index()
    {
        $stockins = StockIn::with(['publisher', 'game'])->latest()->get();
        return view('admin.stockin.index', compact('stockins'));
    }

    public function create()
    {
        $publishers = Publisher::orderBy('company_name')->get();
        $games      = Game::orderBy('title')->get();
        return view('admin.stockin.create', compact('publishers', 'games'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'publisher_id'      => 'required|exists:publishers,id',
            'game_id'           => 'required|exists:games,id',
            'quantity_received' => 'required|integer|min:1',
            'cost_price'        => 'required|numeric|min:0',
            'sale_rate'         => 'required|numeric|min:0',
            'reference_number'  => 'nullable|string|max:100',
            'arrival_date'      => 'required|date',
            'payment_status'    => 'required|in:paid,pending,partial',
        ], [
            'publisher_id.required'      => 'Please select a publisher.',
            'game_id.required'           => 'Please select a game.',
            'quantity_received.required' => 'Quantity received is required.',
            'quantity_received.min'      => 'Quantity must be at least 1.',
            'cost_price.required'        => 'Cost price is required.',
            'sale_rate.required'         => 'Sale rate is required.',
        ]);

        try {
            $lastId = StockIn::max('id') ?? 0;
            $transaction_id = 'TXN-' . str_pad($lastId + 1, 5, '0', STR_PAD_LEFT);

            // 1. Créer l'entrée Stock In
            StockIn::create([
                'transaction_id'    => $transaction_id,
                'publisher_id'      => $request->publisher_id,
                'game_id'           => $request->game_id,
                'quantity_received' => $request->quantity_received,
                'cost_price'        => $request->cost_price,
                'sale_rate'         => $request->sale_rate,
                'reference_number'  => $request->reference_number,
                'arrival_date'      => $request->arrival_date,
                'payment_status'    => $request->payment_status,
            ]);

            // 2. Mettre à jour GameStock
            $stock = GameStock::where('game_id', $request->game_id)->first();

            if ($stock) {
                $stock->update([
                    'qty'       => $stock->qty + $request->quantity_received,
                    'sale_rate' => $request->sale_rate,
                ]);
            } else {
                GameStock::create([
                    'game_id'   => $request->game_id,
                    'qty'       => $request->quantity_received,
                    'sale_rate' => $request->sale_rate,
                ]);
            }

            return redirect()->route('stockin.index')
                ->with('success', $request->quantity_received
                    . ' units of "'
                    . Game::find($request->game_id)->title
                    . '" added to stock at $'
                    . $request->sale_rate . '/unit.');

        } catch (\Exception $e) {
            return back()->withInput()
                ->with('error', 'Error: ' . $e->getMessage());
        }
    }

    public function edit(StockIn $stockin)
    {
        $publishers = Publisher::orderBy('company_name')->get();
        $games      = Game::orderBy('title')->get();
        return view('admin.stockin.edit', compact('stockin', 'publishers', 'games'));
    }

    public function update(Request $request, StockIn $stockin)
    {
        $request->validate([
            'publisher_id'      => 'required|exists:publishers,id',
            'game_id'           => 'required|exists:games,id',
            'quantity_received' => 'required|integer|min:1',
            'cost_price'        => 'required|numeric|min:0',
            'sale_rate'         => 'required|numeric|min:0',
            'reference_number'  => 'nullable|string|max:100',
            'arrival_date'      => 'required|date',
            'payment_status'    => 'required|in:paid,pending,partial',
        ]);

        try {
            // Annuler l'ancien stock
            $oldStock = GameStock::where('game_id', $stockin->game_id)->first();
            if ($oldStock) {
                $oldStock->decrement('qty', $stockin->quantity_received);
            }

            // Appliquer le nouveau stock
            $newStock = GameStock::where('game_id', $request->game_id)->first();
            if ($newStock) {
                $newStock->increment('qty', $request->quantity_received);
                $newStock->update(['sale_rate' => $request->sale_rate]);
            } else {
                GameStock::create([
                    'game_id'   => $request->game_id,
                    'qty'       => $request->quantity_received,
                    'sale_rate' => $request->sale_rate,
                ]);
            }

            $stockin->update([
                'publisher_id'      => $request->publisher_id,
                'game_id'           => $request->game_id,
                'quantity_received' => $request->quantity_received,
                'cost_price'        => $request->cost_price,
                'sale_rate'         => $request->sale_rate,
                'reference_number'  => $request->reference_number,
                'arrival_date'      => $request->arrival_date,
                'payment_status'    => $request->payment_status,
            ]);

            return redirect()->route('stockin.index')
                ->with('success', 'Stock In updated successfully.');

        } catch (\Exception $e) {
            return back()->withInput()
                ->with('error', 'Error: ' . $e->getMessage());
        }
    }

    public function destroy(StockIn $stockin)
    {
        try {
            // Annuler le stock
            $stock = GameStock::where('game_id', $stockin->game_id)->first();
            if ($stock) {
                $stock->decrement('qty', $stockin->quantity_received);
            }

            $stockin->delete();

            return redirect()->route('stockin.index')
                ->with('success', 'Stock In deleted and stock reversed.');

        } catch (\Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }
}