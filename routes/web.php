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
use App\Http\Controllers\Superuser\CompanyController;
use App\Http\Controllers\UserList\UserListController;
use App\Http\Controllers\Employee\LeaveRequestController;
use App\Http\Controllers\Employee\LeaveBalanceController;
use App\Http\Controllers\Employee\EmployeeDashboardController;
use App\Http\Controllers\Admin\AdminRequestController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\ManageEmployeesController;
use App\Http\Controllers\NotificationController;
 

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
    Route::get('/dashboard', [EmployeeDashboardController::class, 'index'])->name('employee.dashboard');
    Route::get('/new-request', fn() => view('employee.new-request')->with(session()->all()))->name('employee.new_request');
    Route::post('/leave-request', [LeaveRequestController::class, 'store'])->name('employee.leave_request.store');
    Route::get('/my-requests', [LeaveRequestController::class, 'index'])->name('employee.my_requests');
    Route::get('/leave-balance', [LeaveBalanceController::class, 'index'])->name('employee.leave_balance');
});

 /*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/manage-employees', [ManageEmployeesController::class, 'index'])->name('admin.manage_employees');
    Route::get('/add-user', fn() => view('admin.add-user')->with(session()->all()))->name('admin.add_user');
    
    // Employee management routes
    Route::get('/employees/{id}/edit', [ManageEmployeesController::class, 'edit'])->name('admin.employees.edit');
    Route::put('/employees/{id}', [ManageEmployeesController::class, 'update'])->name('admin.employees.update');
    Route::delete('/employees/{id}', [ManageEmployeesController::class, 'destroy'])->name('admin.employees.destroy');

    // Edit user
    Route::get('/edit-user', fn() => view('admin.edit-user'))->name('admin.edit_user');

    // Store user via controller
    Route::post('/users', [AdminController::class, 'storeUser'])->name('admin.store-user');

    Route::post('/admin/add-user', [AddUserController::class, 'createUser'])
    ->name('admin.add_user.post');

    // Leave Requests Management
    Route::get('/requests', [AdminRequestController::class, 'index'])->name('admin.requests');
    Route::get('/requests/{id}', [AdminRequestController::class, 'show'])->name('admin.requests.show');
    Route::post('/requests/{id}/approve', [AdminRequestController::class, 'approve'])->name('admin.requests.approve');
    Route::post('/requests/{id}/reject', [AdminRequestController::class, 'reject'])->name('admin.requests.reject');
     
});

/*
|--------------------------------------------------------------------------
| Superuser Routes
|--------------------------------------------------------------------------
*/
Route::prefix('superuser')->group(function () {
    // Dashboard with real data using the new controller
    Route::get('/dashboard', [SUDashboardController::class, 'index'])->name('su.dashboard');
    
    Route::get('/create-admin', function() {
        $companies = \Illuminate\Support\Facades\DB::table('users')
            ->whereNotNull('company')
            ->where('company', '!=', '')
            ->distinct()
            ->pluck('company')
            ->sort()
            ->values();
        return view('su.create_admin')->with([
            'companies' => $companies,
        ])->with(session()->all());
    })->name('su.create_admin');
    
    // Admin List - Using UserListController
    Route::get('/admin-list', [UserListController::class, 'index'])->name('su.admin.list');
    
    // Edit Admin
    Route::get('/admin-list/edit/{id}', [UserListController::class, 'edit'])->name('su.admin.edit');
    
    // Update Admin
    Route::put('/admin-list/update/{id}', [UserListController::class, 'update'])->name('su.admin.update');
    
    // Superuser creating admin
    Route::post('/create-admin', [AddUserController::class, 'createUser'])
        ->name('su.create_admin.post');
    
    // Get companies list for dropdown
    Route::get('/companies', [AddUserController::class, 'getCompanies'])->name('su.companies');
    
    // Company creation routes
    Route::get('/create-company', [CompanyController::class, 'index'])->name('su.create_company');
    Route::post('/companies', [CompanyController::class, 'store'])->name('su.companies.store');
    
    // Admin Management routes
    Route::get('/manage-admins', [UserListController::class, 'manageAdmins'])->name('su.manage_admins');
    Route::get('/manage-admins/edit/{id}', [UserListController::class, 'editAdmin'])->name('su.manage_admins.edit');
    Route::put('/manage-admins/{id}', [UserListController::class, 'updateAdmin'])->name('su.manage_admins.update');
    Route::delete('/manage-admins/{id}', [UserListController::class, 'destroyAdmin'])->name('su.manage_admins.destroy');
});

/*
|--------------------------------------------------------------------------
| Profile Route (Shared by All Roles)
|--------------------------------------------------------------------------
*/

Route::get('/profile', [UserProfileController::class, 'show'])->name('profile.show');
Route::post('/profile/update-info', [UserProfileController::class, 'updateInfo'])->name('profile.update.info');
Route::post('/profile/update-password', [UserProfileController::class, 'updatePassword'])->name('profile.update.password');

/*
||--------------------------------------------------------------------------
|| Notification Routes (Shared by All Roles)
||--------------------------------------------------------------------------
*/

Route::prefix('notifications')->group(function () {
    Route::get('/', [NotificationController::class, 'index'])->name('notifications.index');
    Route::get('/unread-count', [NotificationController::class, 'getUnreadCount'])->name('notifications.unread_count');
    Route::post('/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.mark_read');
    Route::post('/read-all', [NotificationController::class, 'markAllAsRead'])->name('notifications.mark_all_read');
});