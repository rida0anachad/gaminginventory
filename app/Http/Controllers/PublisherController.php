<?php

namespace App\Http\Controllers;

use App\Models\Publisher;
use Illuminate\Http\Request;

class PublisherController extends Controller
{
    public function index()
    {
        $publishers = Publisher::latest()->get();
        return view('admin.publishers.index', compact('publishers'));
    }

    public function create()
    {
        return view('admin.publishers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'company_name'   => 'required|string|max:255',
            'email'          => 'nullable|email|max:255',
            'contact_number' => 'nullable|string|max:50',
            'address'        => 'nullable|string',
        ]);

        try {
            $lastId       = Publisher::max('id') ?? 0;
            $publisher_id = 'PUB-' . str_pad($lastId + 1, 4, '0', STR_PAD_LEFT);

            Publisher::create([
                'publisher_id'   => $publisher_id,
                'company_name'   => $request->company_name,
                'email'          => $request->email,
                'contact_number' => $request->contact_number,
                'address'        => $request->address,
            ]);

            return redirect()->route('publishers.index')
                ->with('success', 'Publisher added successfully.');

        } catch (\Exception $e) {
            return back()->withInput()
                ->with('error', 'Error adding publisher. Please try again.');
        }
    }

    public function edit(Publisher $publisher)
    {
        return view('admin.publishers.edit', compact('publisher'));
    }

    public function update(Request $request, Publisher $publisher)
    {
        $request->validate([
            'company_name'   => 'required|string|max:255',
            'email'          => 'nullable|email|max:255',
            'contact_number' => 'nullable|string|max:50',
            'address'        => 'nullable|string',
        ]);

        
        try {
            $publisher->update($request->only([
                'company_name', 'email', 'contact_number', 'address'
            ]));

            return redirect()->route('publishers.index')
                ->with('success', 'Publisher updated successfully.');

        } catch (\Exception $e) {
            return back()->withInput()
                ->with('error', 'Error updating publisher. Please try again.');
        }
    }

    public function destroy(Publisher $publisher)
    {
        try {
            if ($publisher->games()->exists()) {
                return back()->with('error',
                    'Cannot delete publisher with existing games.');
            }

            if ($publisher->stockIns()->exists()) {
                return back()->with('error',
                    'Cannot delete publisher with existing stock entries.');
            }

            $publisher->delete();

            return redirect()->route('publishers.index')
                ->with('success', 'Publisher deleted successfully.');

        } catch (\Exception $e) {
            return back()->with('error', 'Error deleting publisher. Please try again.');
        }
    }
}