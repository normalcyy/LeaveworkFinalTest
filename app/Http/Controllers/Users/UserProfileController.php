<?php

namespace App\Http\Controllers\Users;
  use Illuminate\Support\Facades\Session;


use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class UserProfileController extends Controller
{
    // Show current user's profile

public function show()
{
    $userId = Session::get('user_id');
    $user = User::findOrFail($userId);
    return view('layouts.profile', compact('user'));
}

public function update(Request $request)
{
    $userId = Session::get('user_id');
    $user = User::findOrFail($userId);

    $validated = $request->validate([
        'first_name' => 'required|string|max:100',
        'middle_name' => 'nullable|string|max:100',
        'last_name' => 'required|string|max:100',
        'current_password' => 'nullable|string',
        'password' => 'nullable|string|min:6|confirmed',
    ]);

    $user->first_name = $validated['first_name'];
    $user->middle_name = $validated['middle_name'];
    $user->last_name = $validated['last_name'];

    // If the user wants to change password
    if (!empty($validated['password'])) {
        if (empty($validated['current_password'])) {
            return back()->withErrors(['current_password' => 'Current password is required to change your password.']);
        }

        // Verify current password
        if (!Hash::check($validated['current_password'], $user->password_hash)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect.']);
        }

        // Update password
        $user->password_hash = Hash::make($validated['password']);
        $user->must_change_password = false;
    }

    $user->save();

    // Update session data
    Session::put([
        'first_name' => $user->first_name,
        'middle_name' => $user->middle_name,
        'last_name' => $user->last_name,
    ]);

    return redirect()->route('profile.show')->with('success', 'Profile updated successfully.');
}




    // Admin: Show edit employee page
    public function adminEdit($id)
    {
        $employee = User::findOrFail($id);
        return view('admin.edit-employee', compact('employee'));
    }

    // Admin: Update employee details
    public function adminUpdate(Request $request, $id)
    {
        $employee = User::findOrFail($id);
        
        $validated = $request->validate([
            'emp_id' => 'required|string|max:50',
            'first_name' => 'required|string|max:100',
            'middle_name' => 'nullable|string|max:100',
            'last_name' => 'required|string|max:100',
            'email' => 'required|email|max:255|unique:users,email,' . $employee->id,
            'position' => 'required|string|max:100',
            'department' => 'required|string|max:100',
            'company' => 'required|string|max:100',
            'password' => 'nullable|string|min:6|confirmed'
        ]);

        $employee->emp_id = $validated['emp_id'];
        $employee->first_name = $validated['first_name'];
        $employee->middle_name = $validated['middle_name'];
        $employee->last_name = $validated['last_name'];
        $employee->email = $validated['email'];
        $employee->position = $validated['position'];
        $employee->department = $validated['department'];
        $employee->company = $validated['company'];

        if (!empty($validated['password'])) {
            $employee->password_hash = Hash::make($validated['password']);
            $employee->must_change_password = false;
        }

        $employee->save();

        return redirect()->route('admin.employees.edit', $employee->id)->with('success', 'Employee details updated successfully.');
    }
}