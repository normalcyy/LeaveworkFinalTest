<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\AdminController;

/*
|--------------------------------------------------------------------------
| Auth Routes
|--------------------------------------------------------------------------
*/

// Login page
Route::get('/login', fn() => view('auth.login'))->name('login');

// Handle login submission (database-driven)
Route::post('/login', function (\Illuminate\Http\Request $request) {
    $request->validate([
        'email'    => 'required|email',
        'password' => 'required',
    ]);

    // Fetch user from the database
    $user = DB::table('users')->where('email', $request->email)->first();

    if ($user && Hash::check($request->password, $user->password_hash)) {
        // Store user info in session
        Session::put([
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

        // Redirect based on role
        return match($user->role) {
            'employee'   => redirect()->route('employee.dashboard'),
            'admin'      => redirect()->route('admin.dashboard'),
            'superuser'  => redirect()->route('su.dashboard'),
            default      => redirect('/'),
        };
    }

    return back()->withErrors(['email' => 'Invalid email or password.']);
})->name('login.post'); // <-- fix: define route name

// Logout
Route::get('/logout', function () {
    Session::flush();
    return redirect()->route('login');
})->name('logout');

// Register page
Route::get('/register', fn() => view('auth.register'))->name('register');

// Reset / Forgot password (UI only)
Route::get('/reset-password', fn() => view('auth.reset_password'))->name('password.request');
Route::post('/reset-password', fn() => redirect()->route('login')->with('success', 'Password reset successfully!'))->name('password.update');
Route::get('/forgot-password', fn() => view('auth.forgot_password'))->name('password.forgot');

// Redirect '/' to login
Route::get('/', fn() => redirect()->route('login'));

/*
|--------------------------------------------------------------------------
| Employee Routes
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
| Admin Routes
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->group(function () {
    Route::get('/dashboard', fn() => view('admin.admin_dashboard')->with(session()->all()))->name('admin.dashboard');
    Route::get('/manage-employees', fn() => view('admin.manage-employees')->with(session()->all()))->name('admin.manage_employees');
    Route::get('/add-user', fn() => view('admin.add-user')->with(session()->all()))->name('admin.add_user');

    // Edit user
    Route::get('/edit-user', fn() => view('admin.edit-user'))->name('admin.edit_user');

    // Store user via controller
    Route::post('/users', [AdminController::class, 'storeUser'])->name('admin.store-user');

    Route::get('/requests', fn() => view('admin.requests')->with(session()->all()))->name('admin.requests');
});

/*
|--------------------------------------------------------------------------
| Superuser Routes
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
