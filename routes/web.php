<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Auth Routes (UI Only)
|--------------------------------------------------------------------------
*/

// Login page
Route::get('/login', fn() => view('auth.login'))->name('login');

// Handle login submission (UI demo only, no real auth)
Route::post('/login', function (\Illuminate\Http\Request $request) {
    $email = $request->input('email');
    $password = $request->input('password');

    $users = [
        'emp@test.com' => [
            'dashboard' => 'employee.dashboard',
            'role' => 'employee',
        ],
        'admin@test.com' => [
            'dashboard' => 'admin.dashboard',
            'role' => 'admin',
        ],
        'su@test.com' => [
            'dashboard' => 'su.dashboard',
            'role' => 'su',
        ],
    ];

    if (isset($users[$email]) && $password === '123456') {
        session(['user' => $email, 'role' => $users[$email]['role']]);
        return redirect()->route($users[$email]['dashboard']);
    }

    return redirect()->route('login')->withErrors(['Invalid email or password.']);
});

// Register page
Route::get('/register', fn() => view('auth.register'))->name('register');

// Reset Password
Route::get('/reset-password', fn() => view('auth.reset_password'))->name('password.request');
Route::post('/reset-password', fn() => redirect()->route('login')->with('success', 'Password reset successfully!'))->name('password.update');

// Forgot Password
Route::get('/forgot-password', fn() => view('auth.forgot_password'))->name('password.forgot');

// Redirect '/' to login
Route::get('/', fn() => redirect()->route('login'));

// Logout
Route::get('/logout', function () {
    Auth::logout();
    session()->flush();
    return redirect()->route('login');
})->name('logout');

/*
|--------------------------------------------------------------------------
| Employee Routes (UI Only)
|--------------------------------------------------------------------------
*/
Route::prefix('employee')->group(function () {
    Route::get('/dashboard', fn() => view('employee.emp_dashboard')->with(session()->all()))->name('employee.dashboard');
Route::get('/new-request', fn() => view('employee.new-request')->with(session()->all()))->name('employee.new_request');
Route::get('/my-requests', fn() => view('employee.my-requests')->with(session()->all()))->name('employee.my_requests');
Route::get('/leave-balance', fn() => view('employee.leave-balance')->with(session()->all()))->name('employee.leave_balance');

});

/*
|--------------------------------------------------------------------------
| Admin Routes (UI Only)
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->group(function () {
    Route::get('/dashboard', fn() => view('admin.admin_dashboard')->with(session()->all()))->name('admin.dashboard');
Route::get('/manage-employees', fn() => view('admin.manage-employees')->with(session()->all()))->name('admin.manage_employees');
Route::get('/add-user', fn() => view('admin.add-user')->with(session()->all()))->name('admin.add_user');
    Route::get('/requests', fn() => view('admin.requests')->with(session()->all()))->name('admin.requests');
});

/*
|--------------------------------------------------------------------------
| Superuser Routes (UI Only)
|--------------------------------------------------------------------------
*/
Route::prefix('superuser')->group(function () {
    Route::get('/dashboard', fn() => view('su.su_dashboard')->with(session()->all()))->name('su.dashboard');
    Route::get('/create-admin', fn() => view('su.create_admin')->with(session()->all()))->name('su.create_admin');
});

/*
|--------------------------------------------------------------------------
| Profile Route (Shared by All Roles)
|--------------------------------------------------------------------------
*/
Route::get('/profile', fn() => view('layouts.profile')->with(session()->all()))->name('profile');
