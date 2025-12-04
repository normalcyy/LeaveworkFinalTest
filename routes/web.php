<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Users\UserProfileController;
use App\Http\Controllers\Users\AddUserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Superuser\SUDashboardController;

/*
|--------------------------------------------------------------------------
| Auth Routes
|--------------------------------------------------------------------------
*/

// Login routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');

// Show forgot password form
Route::get('/forgot-password', [ForgotPasswordController::class, 'showForgotPasswordForm'])
    ->name('forgot.password');

// Handle AJAX reset request
Route::post('/forgot-password/reset', [ForgotPasswordController::class, 'resetPassword'])
    ->name('password.reset.post');

Route::get('/forgot-password', fn() => view('auth.forgot_password'))->name('password.forgot');

// Password reset routes
Route::get('/password-reset', [LoginController::class, 'showResetPasswordForm'])->name('password.reset.form');
Route::post('/password-reset', [LoginController::class, 'resetPassword'])->name('password.reset');

// Logout
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

// Register page
Route::get('/register', fn() => view('auth.register'))->name('register');

// Reset password (UI only) - Keep for existing views
Route::get('/reset-password', fn() => view('auth.reset_password'))->name('password.request');
Route::post('/reset-password', fn() => redirect()->route('login')->with('success', 'Password reset successfully!'))->name('password.update');

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

    Route::post('/admin/add-user', [AddUserController::class, 'createUser'])
    ->name('admin.add_user.post');

    Route::get('/requests', fn() => view('admin.requests')->with(session()->all()))->name('admin.requests');
});

/*
|--------------------------------------------------------------------------
| Superuser Routes
|--------------------------------------------------------------------------
*/
Route::prefix('superuser')->group(function () {
    // Dashboard with real data using the new controller
    Route::get('/dashboard', [SUDashboardController::class, 'index'])->name('su.dashboard');
    
    Route::get('/create-admin', fn() => view('su.create_admin')->with(session()->all()))->name('su.create_admin');
    
    // Superuser creating admin
    Route::post('/superuser/create-admin', [AddUserController::class, 'createUser'])
        ->name('su.create_admin.post');
});

/*
|--------------------------------------------------------------------------
| Profile Route (Shared by All Roles)
|--------------------------------------------------------------------------
*/

Route::get('/profile', [UserProfileController::class, 'show'])->name('profile.show');
Route::post('/profile/update-info', [UserProfileController::class, 'updateInfo'])->name('profile.update.info');
Route::post('/profile/update-password', [UserProfileController::class, 'updatePassword'])->name('profile.update.password');