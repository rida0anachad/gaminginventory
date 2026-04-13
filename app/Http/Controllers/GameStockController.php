<?php

namespace App\Http\Controllers;

use App\Models\GameStock;

class GameStockController extends Controller
{
    
    public function index()
    {
        $stocks = GameStock::with(['game', 'game.publisher'])->latest()->get();
        return view('admin.gamestock.index', compact('stocks'));
    }

    
}