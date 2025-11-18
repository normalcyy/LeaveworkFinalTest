<?php

use Illuminate\Support\Facades\Route;

// Login page
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

// Handle login submission
Route::post('/login', function (\Illuminate\Http\Request $request) {
    $email = $request->input('email');
    $password = $request->input('password');

    // Sample users with plaintext password: 123456
    $users = [
        'emptest@user.com' => [
            'role' => 'employee',
            'dashboard' => 'employee.emp_dashboard',
        ],
        'admin@test.com' => [
            'role' => 'admin',
            'dashboard' => 'admin.admin_dashboard',
        ],
        'su@user.com' => [
            'role' => 'su',
            'dashboard' => 'su.su_dashboard',
        ],
    ];

    if (isset($users[$email]) && $password === '123456') {
        $dashboard = $users[$email]['dashboard'];
        return view($dashboard)->with('user', $email);
    }

    return redirect()->route('login')->withErrors(['Invalid email or password.']);
});

// Register page
Route::get('/register', function () {
    return view('auth.register');
})->name('register');

// Reset password page
Route::get('/reset-password', function () {
    return view('auth.reset_password');
})->name('password.request');

Route::post('/reset-password', function () {
    // Redirect back to login page after form submission
    return redirect()->route('login')->with('success', 'Password reset successfully! You can now log in.');
})->name('password.update');

// Forgot Password page
Route::get('/forgot-password', function () {
    return view('auth.forgot_password');
})->name('password.forgot');

// Redirect '/' to login
Route::get('/', function () {
    return redirect()->route('login');
});
