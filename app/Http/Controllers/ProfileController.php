<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        return view('admin.profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name'             => 'required|string|max:100',
            'email'            => 'required|email|unique:users,email,' . $user->id,
            'current_password' => 'nullable|string',
            'new_password'     => 'nullable|string|min:8|confirmed',
        ], [
            'name.required'          => 'Name is required.',
            'email.unique'           => 'This email is already used.',
            'new_password.min'       => 'Min 8 characters.',
            'new_password.confirmed' => 'Passwords do not match.',
        ]);

        try {
            if ($request->filled('current_password')) {
                if (!Hash::check($request->current_password, $user->password)) {
                    return back()->with('error', 'Current password is incorrect.');
                }
                if ($request->filled('new_password')) {
                    $user->password = Hash::make($request->new_password);
                }
            }
            $user->name  = $request->name;
            $user->email = $request->email;
            $user->save();

            return back()->with('success', 'Profile updated successfully.');

        } catch (\Exception $e) {
            return back()->with('error', 'Error updating profile.');
        }
    }
}