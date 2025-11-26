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

    // Sample users data for different roles
    $users = [
        'emp@test.com' => [
            'id' => 'EMP001',
            'first_name' => 'John',
            'middle_name' => 'A.',
            'last_name' => 'Doe',
            'email' => 'emp@test.com',
            'position' => 'Software Engineer',
            'department' => 'IT',
            'company' => 'TechCorp',
            'role' => 'employee',
            'dashboard' => 'employee.dashboard',
        ],
        'admin@test.com' => [
            'id' => 'ADM001',
            'first_name' => 'Jane',
            'middle_name' => 'B.',
            'last_name' => 'Smith',
            'email' => 'admin@test.com',
            'position' => 'Team Lead',
            'department' => 'Operations',
            'company' => 'BizSolutions',
            'role' => 'admin',
            'dashboard' => 'admin.dashboard',
        ],
        'su@test.com' => [
            'id' => 'SU001',
            'first_name' => 'Alice',
            'middle_name' => 'C.',
            'last_name' => 'Johnson',
            'email' => 'su@test.com',
            'position' => 'Superuser',
            'department' => 'Management',
            'company' => 'LeaveWork HQ',
            'role' => 'su',
            'dashboard' => 'su.dashboard',
        ],
    ];

    if (isset($users[$email]) && $password === '123456') {
        // Store user data in session
        session([
            'user' => $users[$email]['email'],
            'id' => $users[$email]['id'],
            'first_name' => $users[$email]['first_name'],
            'middle_name' => $users[$email]['middle_name'],
            'last_name' => $users[$email]['last_name'],
            'position' => $users[$email]['position'],
            'department' => $users[$email]['department'],
            'company' => $users[$email]['company'],
            'role' => $users[$email]['role'],
        ]);

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
Route::post('/admin/users', [AdminController::class, 'storeUser'])->name('admin.store-user');
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
