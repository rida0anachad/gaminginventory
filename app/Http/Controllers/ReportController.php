<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\StockIn;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function salesReport(Request $request)
    {
        $query = Sale::with('member');

        if ($request->filled('from')) {
            $query->whereDate('date', '>=', $request->from);
        }
        if ($request->filled('to')) {
            $query->whereDate('date', '<=', $request->to);
        }

        $sales      = $query->latest()->get();
        $totalSales = $sales->sum('net_total');

        return view('admin.reports.sales', compact('sales', 'totalSales'));
    }

    public function stockInReport(Request $request)
    {
        $query = StockIn::with('publisher');

        if ($request->filled('from')) {
            $query->whereDate('arrival_date', '>=', $request->from);
        }
        if ($request->filled('to')) {
            $query->whereDate('arrival_date', '<=', $request->to);
        }

        $stockins   = $query->latest()->get();
        $totalCost  = $stockins->sum('total_cost');

        return view('admin.reports.stockin', compact('stockins', 'totalCost'));
    }
}