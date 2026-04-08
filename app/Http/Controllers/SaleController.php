<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\Member;
use App\Models\Game;
use App\Models\GameStock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SaleController extends Controller
{
    public function index()
    {
        $sales = Sale::with(['member', 'items.game'])->latest()->get();
        return view('admin.sales.index', compact('sales'));
    }

    public function create()
{
    $members = Member::orderBy('name')->get();
    $games   = Game::with('stock')
        ->whereHas('stock', fn($q) => $q->where('qty', '>', 0))
        ->orderBy('title')
        ->get();

    // Préparer les données JSON proprement
    $gamesJson = $games->map(function($g) {
        return [
            'id'    => $g->id,
            'title' => $g->title . ' (' . $g->platform . ')',
            'price' => $g->stock ? (float)$g->stock->rate : 0,
            'stock' => $g->stock ? (int)$g->stock->qty  : 0,
        ];
    })->toJson();

    return view('admin.sales.create', compact('members', 'games', 'gamesJson'));
}

    public function store(Request $request)
    {
        $request->validate([
            'member_id'    => 'required|exists:members,id',
            'date'         => 'required|date',
            'discount'     => 'nullable|numeric|min:0',
            'games'        => 'required|array|min:1',
            'games.*.id'   => 'required|exists:games,id',
            'games.*.qty'  => 'required|integer|min:1',
        ], [
            'member_id.required' => 'Please select a member.',
            'games.required'     => 'Please add at least one game.',
        ]);

        // Vérifier stock disponible pour chaque jeu
        foreach ($request->games as $item) {
            $stock = GameStock::where('game_id', $item['id'])->first();
            $game  = Game::find($item['id']);

            if (!$stock || $stock->qty < $item['qty']) {
                return back()->withInput()
                    ->with('error', 'Not enough stock for: ' . ($game->title ?? 'Unknown'));
            }
        }

        // Transaction DB — tout ou rien
        DB::transaction(function () use ($request) {
            $count   = Sale::count() + 1;
            $sale_no = 'SALE-' . str_pad($count, 5, '0', STR_PAD_LEFT);

            $totalAmount = 0;

            // Calculer le total
            foreach ($request->games as $item) {
                $stock        = GameStock::where('game_id', $item['id'])->first();
                $unitPrice    = $stock->rate ?? 0;
                $totalAmount += $unitPrice * $item['qty'];
            }

            $discount  = $request->discount ?? 0;
            $netTotal  = $totalAmount - $discount;

            // Créer la vente
            $sale = Sale::create([
                'sale_no'      => $sale_no,
                'member_id'    => $request->member_id,
                'date'         => $request->date,
                'total_amount' => $totalAmount,
                'discount'     => $discount,
                'net_total'    => $netTotal,
            ]);

            // Créer les items + DIMINUER le stock
            foreach ($request->games as $item) {
                $stock     = GameStock::where('game_id', $item['id'])->first();
                $unitPrice = $stock->rate ?? 0;
                $subtotal  = $unitPrice * $item['qty'];

                SaleItem::create([
                    'sale_id'    => $sale->id,
                    'game_id'    => $item['id'],
                    'quantity'   => $item['qty'],
                    'unit_price' => $unitPrice,
                    'subtotal'   => $subtotal,
                ]);

                // DIMINUER le stock
                $stock->decrement('qty', $item['qty']);
            }
        });

        return redirect()->route('sales.index')
            ->with('success', 'Sale saved and stock updated.');
    }

    public function show(Sale $sale)
    {
        $sale->load(['member', 'items.game']);
        return view('admin.sales.show', compact('sale'));
    }

    public function destroy(Sale $sale)
    {
        try {
            DB::transaction(function () use ($sale) {
                // Remettre le stock
                foreach ($sale->items as $item) {
                    $stock = GameStock::where('game_id', $item->game_id)->first();
                    if ($stock) {
                        $stock->increment('qty', $item->quantity);
                    }
                }
                $sale->items()->delete();
                $sale->delete();
            });

            return redirect()->route('sales.index')
                ->with('success', 'Sale deleted and stock restored.');

        } catch (\Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }
}