<?php

namespace App\Http\Controllers;

use App\Models\StockIn;
use App\Models\Publisher;
use Illuminate\Http\Request;

class StockInController extends Controller
{
    public function index()
    {
        $stockins = StockIn::with('publisher')->latest()->get();
        return view('admin.stockin.index', compact('stockins'));
    }

    public function create()
    {
        $publishers = Publisher::orderBy('company_name')->get();
        return view('admin.stockin.create', compact('publishers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'publisher_id'     => 'required|exists:publishers,id',
            'reference_number' => 'nullable|string|max:100',
            'arrival_date'     => 'required|date',
            'total_cost'       => 'required|numeric|min:0',
            'payment_status'   => 'required|in:paid,pending,partial',
        ], [
            'publisher_id.required' => 'Please select a publisher.',
            'arrival_date.required' => 'Arrival date is required.',
            'total_cost.required'   => 'Total cost is required.',
        ]);

        try {
            $count = StockIn::count() + 1;
            $transaction_id = 'TXN-' . str_pad($count, 5, '0', STR_PAD_LEFT);

            StockIn::create([
                'transaction_id'   => $transaction_id,
                'publisher_id'     => $request->publisher_id,
                'reference_number' => $request->reference_number,
                'arrival_date'     => $request->arrival_date,
                'total_cost'       => $request->total_cost,
                'payment_status'   => $request->payment_status,
            ]);

            return redirect()->route('stockin.index')
                ->with('success', 'Stock In entry added successfully.');

        } catch (\Exception $e) {
            return back()->withInput()
                ->with('error', 'Error: ' . $e->getMessage());
        }
    }

    public function edit(StockIn $stockin)
    {
        $publishers = Publisher::orderBy('company_name')->get();
        return view('admin.stockin.edit', compact('stockin', 'publishers'));
    }

    public function update(Request $request, StockIn $stockin)
    {
        $request->validate([
            'publisher_id'     => 'required|exists:publishers,id',
            'reference_number' => 'nullable|string|max:100',
            'arrival_date'     => 'required|date',
            'total_cost'       => 'required|numeric|min:0',
            'payment_status'   => 'required|in:paid,pending,partial',
        ]);

        try {
            $stockin->update($request->only([
                'publisher_id', 'reference_number',
                'arrival_date', 'total_cost', 'payment_status'
            ]));

            return redirect()->route('stockin.index')
                ->with('success', 'Stock In updated successfully.');

        } catch (\Exception $e) {
            return back()->withInput()
                ->with('error', 'Error updating. Please try again.');
        }
    }

    public function destroy(StockIn $stockin)
    {
        try {
            $stockin->delete();
            return redirect()->route('stockin.index')
                ->with('success', 'Stock In deleted successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error deleting.');
        }
    }
}