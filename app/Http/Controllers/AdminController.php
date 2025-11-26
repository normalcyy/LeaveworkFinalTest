<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function storeUser(Request $request)
    {
        // Validate input
        $validated = $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed',
            'department' => 'required|string',
            'position' => 'required|string',
            'join_date' => 'required|date',
            'employment_type' => 'required|string',
            'role' => 'required|string',
            'profile_picture' => 'nullable|image|max:2048',
        ]);

        // Create user
        User::create([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'department' => $validated['department'],
            'position' => $validated['position'],
            'join_date' => $validated['join_date'],
            'employment_type' => $validated['employment_type'],
            'role' => $validated['role'],
        ]);

        return redirect()->route('admin.users')->with('success', 'User added successfully!');
    }
}