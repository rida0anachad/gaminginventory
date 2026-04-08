<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function index()
    {
        $members = Member::latest()->get();
        return view('admin.members.index', compact('members'));
    }

    public function create()
    {
        return view('admin.members.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'                => 'required|string|max:100',
            'contact_number'      => 'nullable|string|max:50',
            'address'             => 'nullable|string',
            'favorite_genre'      => 'nullable|string|max:80',
            'platform_preference' => 'nullable|string|max:80',
        ], [
            'name.required' => 'Le nom est obligatoire.',
        ]);

        try {
            $count = Member::count() + 1;
            $member_id = 'MEM-' . str_pad($count, 4, '0', STR_PAD_LEFT);

            Member::create([
                'member_id'           => $member_id,
                'name'                => $request->name,
                'contact_number'      => $request->contact_number,
                'address'             => $request->address,
                'favorite_genre'      => $request->favorite_genre,
                'platform_preference' => $request->platform_preference,
            ]);

            return redirect()->route('members.index')
                ->with('success', 'Member added successfully.');

        } catch (\Exception $e) {
            return back()->withInput()
                ->with('error', 'Error adding member. Please try again.');
        }
    }

    public function edit(Member $member)
    {
        return view('admin.members.edit', compact('member'));
    }

    public function update(Request $request, Member $member)
    {
        $request->validate([
            'name'                => 'required|string|max:100',
            'contact_number'      => 'nullable|string|max:50',
            'address'             => 'nullable|string',
            'favorite_genre'      => 'nullable|string|max:80',
            'platform_preference' => 'nullable|string|max:80',
        ]);

        try {
            $member->update($request->only([
                'name', 'contact_number', 'address',
                'favorite_genre', 'platform_preference'
            ]));

            return redirect()->route('members.index')
                ->with('success', 'Member updated successfully.');

        } catch (\Exception $e) {
            return back()->withInput()
                ->with('error', 'Error updating member. Please try again.');
        }
    }

    public function destroy(Member $member)
    {
        try {
            $member->delete();
            return redirect()->route('members.index')
                ->with('success', 'Member deleted successfully.');

        } catch (\Exception $e) {
            return back()
                ->with('error', 'Error deleting member. Please try again.');
        }
    }
}