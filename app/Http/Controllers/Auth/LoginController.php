<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = DB::table('users')->where('email', $request->email)->first();

        if ($user && Hash::check($request->password, $user->password_hash)) {
            if ($user->must_change_password) {
                Session::put('reset_user_id', $user->id);
                
                if ($request->ajax()) {
                    return response()->json([
                        'password_reset_required' => true,
                        'redirect' => route('password.reset.form')
                    ]);
                }
                
                return redirect()->route('password.reset.form');
            }

            // Set session data
            session([
                'user_id'     => $user->id,
                'emp_id'      => $user->emp_id,
                'first_name'  => $user->first_name,
                'middle_name' => $user->middle_name,
                'last_name'   => $user->last_name,
                'email'       => $user->email,
                'role'        => $user->role,
                'position'    => $user->position,
                'department'  => $user->department,
                'company'     => $user->company,
            ]);

            // Determine redirect URL based on role
            $redirectUrl = match ($user->role) {
                'admin'      => route('admin.dashboard'),
                'superuser'  => route('su.dashboard'),
                'employee'   => route('employee.dashboard'),
                default      => url('/'),
            };

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'redirect' => $redirectUrl,
                    'role' => $user->role
                ]);
            }

            return redirect($redirectUrl);
        }

        // Handle AJAX error response
        if ($request->ajax()) {
            return response()->json([
                'errors' => [
                    'email' => ['Invalid email or password. Please try again.']
                ]
            ], 422);
        }

        return back()->withErrors(['email' => 'Invalid credentials']);
    }

    public function showResetPasswordForm()
    {
        if (!Session::has('reset_user_id')) {
            return redirect()->route('login');
        }

        return view('auth.reset_password');
    }

    public function resetPassword(Request $request)
    {
        // 1. Check if the user is authorized to reset password
        if (!Session::has('reset_user_id')) {
            if ($request->ajax()) {
                return response()->json([
                    'errors' => [
                        'session' => 'Password reset session expired. Please request a new reset link.'
                    ]
                ], 422);
            }
            return redirect()->route('password.reset.request')->withErrors([
                'session' => 'Password reset session expired. Please request a new reset link.'
            ]);
        }

        // 2. Get user ID from session
        $userId = Session::get('reset_user_id');
        
        // 3. Validate the password with more robust rules
        $request->validate([
            'password' => [
                'required',
                'confirmed',
                'min:8',
            ],
        ], [
            'password.regex' => 'Password must contain at least one uppercase letter, one lowercase letter, one number, and one special character.'
        ]);

        // 4. Verify user still exists before updating
        $user = DB::table('users')->where('id', $userId)->first();
        
        if (!$user) {
            Session::forget('reset_user_id');
            if ($request->ajax()) {
                return response()->json([
                    'errors' => ['user' => 'User account not found.']
                ], 422);
            }
            return redirect()->route('login')->withErrors([
                'user' => 'User account not found.'
            ]);
        }

        // 5. Update password
        DB::table('users')
            ->where('id', $userId)
            ->update([
                'password_hash' => Hash::make($request->password),
                'must_change_password' => false,
                'updated_at' => now(),
            ]);

        // 6. Clear the session
        Session::forget('reset_user_id');
        
        // 7. Return response based on request type
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Your password has been reset successfully. Redirecting to login...'
            ]);
        }

        // 8. For non-AJAX requests
        return view('auth.reset_password', [
            'password_reset_success' => true,
            'success_message' => 'Your password has been reset successfully. Please log in with your new password.'
        ]);
    }

    public function logout()
    {
        session()->flush();
        return redirect()->route('login');
    }
}