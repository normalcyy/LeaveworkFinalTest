<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\PasswordReset;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Carbon\Carbon;

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
            $user = User::where('email', $request->email)->first();

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'Email address not found in our system.'
                ], 404);
            }

            // Generate reset token
            $token = Str::random(64);
            $expiresAt = Carbon::now()->addHours(24); // Token expires in 24 hours

            // Invalidate any existing reset tokens for this user
            PasswordReset::where('user_id', $user->id)
                ->where('used', false)
                ->update(['used' => true]);

            // Create new password reset record
            PasswordReset::create([
                'user_id' => $user->id,
                'reset_token' => Hash::make($token),
                'expires_at' => $expiresAt,
                'used' => false,
            ]);

            // For now, return the token (in production, send via email)
            // In a real application, you would send an email with the reset link
            return response()->json([
                'success' => true,
                'message' => 'Password reset token has been generated. Please use the following token to reset your password: ' . $token,
                'token' => $token, // Remove this in production, only for testing
                'reset_url' => route('password.reset.form') . '?token=' . $token . '&email=' . urlencode($user->email)
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred. Please try again later. Error: ' . $e->getMessage()
            ], 500);
        }
    }
}