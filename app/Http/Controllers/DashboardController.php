<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Publisher;
use App\Models\Game;
use App\Models\GameStock;
use App\Models\Sale;

class DashboardController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard.list', [
            'totalMembers'     => Member::count(),
            'totalPublishers'  => Publisher::count(),
            'totalGames'       => Game::count(),
            'outOfStock'       => GameStock::where('qty', 0)->count(),

            
            

            
            'newReleases'      => Game::where('created_at', '>=', now()->subDays(30))->count(),

            'totalSales'       => Sale::count(),
            'recentPublishers' => Publisher::latest()->take(5)->get(),
        ]);
    }
}