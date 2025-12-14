<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class UserProfileController extends Controller
{
    public function show()
    {
        $userId = Session::get('user_id');
        $user = User::findOrFail($userId);
        return view('layouts.profile', compact('user'));
    }

    // Update Personal Information
    public function updateInfo(Request $request)
    {
        $userId = Session::get('user_id');
        $user = User::findOrFail($userId);

        $validated = $request->validate([
            'first_name' => 'required|string|max:100',
            'middle_name' => 'nullable|string|max:100',
            'last_name' => 'required|string|max:100',
        ]);

        $user->update([
            'first_name' => $validated['first_name'],
            'middle_name' => $validated['middle_name'],
            'last_name' => $validated['last_name'],
        ]);

        // Update session data
        Session::put([
            'first_name' => $user->first_name,
            'middle_name' => $user->middle_name,
            'last_name' => $user->last_name,
        ]);

        return redirect()->route('profile.show')->with('success', 'Personal information updated successfully.');
    }

    // Update Password Only
    public function updatePassword(Request $request)
    {
        $userId = Session::get('user_id');
        $user = User::findOrFail($userId);

        $validated = $request->validate([
            'current_password' => 'required|string',
            'password' => 'required|string|min:8|confirmed|different:current_password',
        ], [
            'password.different' => 'New password must be different from current password.',
        ]);

        // Verify current password - check both password and password_hash columns
        $passwordField = $user->password_hash ?? $user->password;
        if (!Hash::check($validated['current_password'], $passwordField)) {
            return response()->json([
                'errors' => ['current_password' => ['Current password is incorrect.']]
            ], 422);
        }

        // Update password
        $user->update([
            'password_hash' => Hash::make($validated['password']),
            'must_change_password' => false,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Password updated successfully.'
        ]);
    }
}
