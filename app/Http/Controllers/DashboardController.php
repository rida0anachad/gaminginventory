<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Publisher;


class DashboardController extends Controller
{
            public function dashboard()
    {
        return view('admin.dashboard.list', [
            'totalMembers'     => 0, // ← dynamique après migration Members
            'totalPublishers'  => Publisher::count(),
            'totalGames'       => 0, // ← dynamique après migration Games
            'outOfStock'       => 0, // ← dynamique après migration GameStock
            'newReleases'      => 0, // ← dynamique après migration Games
            'totalSales'       => 0, // ← dynamique après migration Sales
            'recentPublishers' => Publisher::latest()->take(5)->get(),
        ]);
    }



// public function dashboard()
    //{
        //$stats = [
          //  'total_members'    => 0,
            //'total_publishers' => 0,
            //'total_games'      => 0,
            //'out_of_stock'     => 0,
            //'new_releases'     => 0,
            //'total_sales'      => 0,
        //];

        //return view('admin.dashboard.list', compact('stats'));
   // }
    
}