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

        // Auto-generate publisher_id like PUB-0001
        $count = Publisher::count() + 1;
        $publisher_id = 'PUB-' . str_pad($count, 4, '0', STR_PAD_LEFT);

        Publisher::create([
            'publisher_id'   => $publisher_id,
            'company_name'   => $request->company_name,
            'email'          => $request->email,
            'contact_number' => $request->contact_number,
            'address'        => $request->address,
        ]);

        return redirect()->route('publishers.index')
                         ->with('success', 'Publisher added successfully.');
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

        $publisher->update($request->only([
            'company_name', 'email', 'contact_number', 'address'
        ]));

        return redirect()->route('publishers.index')
                         ->with('success', 'Publisher updated successfully.');
    }

    public function destroy(Publisher $publisher)
    {
        $publisher->delete();
        return redirect()->route('publishers.index')
                         ->with('success', 'Publisher deleted successfully.');
    }
}