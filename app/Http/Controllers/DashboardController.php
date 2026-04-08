<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Publisher;
use App\Models\GameStock;
use App\Models\Game;


class DashboardController extends Controller
{
            public function dashboard()
    {
        return view('admin.dashboard.list', [
            'totalMembers'     => \App\Models\Member::count(),
            'totalPublishers'  => \App\Models\Publisher::count(),
            'totalGames'       => \App\Models\Game::count(),
            'outOfStock'       => \App\Models\GameStock::where('qty', 0)->count(),
            'newReleases'      => \App\Models\Game::whereHas('stock', function($q) {
                $q->where('release_date', '>=', now()->subDays(30));
            })->count(),
            'totalSales'       => 0, 
            'recentPublishers' => \App\Models\Publisher::latest()->take(5)->get(),
        ]);
    }



// public function dashboard()
    //{
       // return view('admin.dashboard.list', [
        //    'totalMembers'     => 0, // ← dynamique après migration Members
          //  'totalPublishers'  => Publisher::count(),
          //  'totalGames'       => 0, // ← dynamique après migration Games
          //  'outOfStock'       => 0, // ← dynamique après migration GameStock
           // 'newReleases'      => 0, // ← dynamique après migration Games
           // 'totalSales'       => 0, // ← dynamique après migration Sales
           // 'recentPublishers' => Publisher::latest()->take(5)->get(),
     //   ]);
   // }
    
}