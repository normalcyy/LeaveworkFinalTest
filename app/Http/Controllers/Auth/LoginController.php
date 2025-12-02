<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login'); // your login blade view
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = DB::table('users')->where('email', $request->email)->first();

        if ($user && Hash::check($request->password, $user->password_hash)) {
            // Credentials match
            session([
                'user_id' => $user->id,
                'role' => $user->role,
                'name' => $user->first_name . ' ' . $user->last_name,
            ]);

            // Redirect based on role (example)
            if ($user->role === 'admin') {
                return redirect()->route('admin.dashboard');
            } elseif ($user->role === 'superuser') {
                return redirect()->route('superuser.dashboard');
            } else {
                return redirect()->route('employee.dashboard');
            }
        }

        return back()->withErrors(['email' => 'Invalid credentials']);
    }

    public function logout()
    {
        session()->flush();
        return redirect()->route('login');
    }
}
