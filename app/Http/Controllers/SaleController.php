<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Member;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    public function index()
    {
        $sales = Sale::with('member')->latest()->get();
        return view('admin.sales.index', compact('sales'));
    }

    public function create()
    {
        $members = Member::orderBy('name')->get();
        return view('admin.sales.create', compact('members'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'member_id'    => 'required|exists:members,id',
            'date'         => 'required|date',
            'total_amount' => 'required|numeric|min:0',
            'discount'     => 'nullable|numeric|min:0',
        ], [
            'member_id.required'    => 'Please select a member.',
            'date.required'         => 'Sale date is required.',
            'total_amount.required' => 'Total amount is required.',
        ]);

        try {
            $count = Sale::count() + 1;
            $sale_no = 'SALE-' . str_pad($count, 5, '0', STR_PAD_LEFT);

            $discount   = $request->discount ?? 0;
            $net_total  = $request->total_amount - $discount;

            Sale::create([
                'sale_no'      => $sale_no,
                'member_id'    => $request->member_id,
                'date'         => $request->date,
                'total_amount' => $request->total_amount,
                'discount'     => $discount,
                'net_total'    => $net_total,
            ]);

            return redirect()->route('sales.index')
                ->with('success', 'Sale added successfully.');

        } catch (\Exception $e) {
            return back()->withInput()
                ->with('error', 'Error: ' . $e->getMessage());
        }
    }

    public function edit(Sale $sale)
    {
        $members = Member::orderBy('name')->get();
        return view('admin.sales.edit', compact('sale', 'members'));
    }

    public function update(Request $request, Sale $sale)
    {
        $request->validate([
            'member_id'    => 'required|exists:members,id',
            'date'         => 'required|date',
            'total_amount' => 'required|numeric|min:0',
            'discount'     => 'nullable|numeric|min:0',
        ]);

        try {
            $discount  = $request->discount ?? 0;
            $net_total = $request->total_amount - $discount;

            $sale->update([
                'member_id'    => $request->member_id,
                'date'         => $request->date,
                'total_amount' => $request->total_amount,
                'discount'     => $discount,
                'net_total'    => $net_total,
            ]);

            return redirect()->route('sales.index')
                ->with('success', 'Sale updated successfully.');

        } catch (\Exception $e) {
            return back()->withInput()
                ->with('error', 'Error updating. Please try again.');
        }
    }

    public function destroy(Sale $sale)
    {
        try {
            $sale->delete();
            return redirect()->route('sales.index')
                ->with('success', 'Sale deleted successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error deleting.');
        }
    }
}