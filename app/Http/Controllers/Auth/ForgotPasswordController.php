<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ForgotPasswordController extends Controller
{
    /**
     * Show the forgot password form.
     *
     * @return \Illuminate\View\View
     */
    public function showForgotPasswordForm()
    {
        return view('auth.forgot_password');
    }

    /**
     * Handle the forgot password request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function resetPassword(Request $request)
    {
        // Validate the email input
        $validator = Validator::make($request->all(), [
            'email' => 'required|email'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Please enter a valid email address.'
            ], 422);
        }

        try {
            // Check if email exists in the users table
            $user = DB::table('users')->where('email', $request->email)->first();

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'Email address not found in our system.'
                ], 404);
            }

            // Reset password to 123456 - UPDATE THE CORRECT COLUMN
            DB::table('users')
                ->where('email', $request->email)
                ->update([
                    'password_hash' => Hash::make('12345678'), // Changed from 'password' to 'password_hash'
                    'updated_at' => now()
                ]);

            return response()->json([
                'success' => true,
                'message' => 'Password has been reset to 12345678. Please login with this temporary password and change it immediately.'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred. Please try again later. Error: ' . $e->getMessage()
            ], 500);
        }
    }
}