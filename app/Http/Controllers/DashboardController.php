<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'total_members'    => 0,
            'total_publishers' => 0,
            'total_games'      => 0,
            'out_of_stock'     => 0,
            'new_releases'     => 0,
            'total_sales'      => 0,
        ];

        return view('admin.dashboard.list', compact('stats'));
    }
    
}