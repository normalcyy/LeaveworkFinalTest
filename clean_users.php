<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;
use App\Models\AvailableLeave;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

$passwordHash = Hash::make('12345678');

echo "Cleaning up users...\n";

// Get IDs of users to keep
$keepEmails = ['admin@test.com', 'emp2@test.com', 'su@test.com'];
$usersToKeep = User::whereIn('email', $keepEmails)->pluck('id')->toArray();

// Delete all users except the ones to keep
$deletedCount = User::whereNotIn('id', $usersToKeep)->count();
User::whereNotIn('id', $usersToKeep)->delete();

echo "Deleted {$deletedCount} users.\n";

// Ensure admin@test.com exists
$admin = User::where('email', 'admin@test.com')->first();
if (!$admin) {
    $admin = User::create([
        'emp_id' => 'ADM001',
        'first_name' => 'Admin',
        'middle_name' => 'A.',
        'last_name' => 'User',
        'email' => 'admin@test.com',
        'role' => 'admin',
        'position' => 'Administrator',
        'department' => 'IT',
        'company' => 'UC',
        'password_hash' => $passwordHash,
        'must_change_password' => false,
    ]);
    echo "Created admin@test.com\n";
} else {
    $admin->update([
        'role' => 'admin',
        'company' => 'UC',
        'password_hash' => $passwordHash,
    ]);
    echo "Updated admin@test.com\n";
}

// Ensure emp2@test.com exists
$employee = User::where('email', 'emp2@test.com')->first();
if (!$employee) {
    $employee = User::create([
        'emp_id' => 'EMP002',
        'first_name' => 'Employee',
        'middle_name' => '',
        'last_name' => 'Two',
        'email' => 'emp2@test.com',
        'role' => 'employee',
        'position' => 'Software Developer',
        'department' => 'IT',
        'company' => 'UC',
        'password_hash' => $passwordHash,
        'must_change_password' => false,
    ]);
    echo "Created emp2@test.com\n";
} else {
    $employee->update([
        'role' => 'employee',
        'company' => 'UC',
        'password_hash' => $passwordHash,
    ]);
    echo "Updated emp2@test.com\n";
}

// Ensure superuser exists
$superuser = User::where('email', 'su@test.com')->first();
if (!$superuser) {
    User::create([
        'emp_id' => 'SU001',
        'first_name' => 'Super',
        'middle_name' => '',
        'last_name' => 'User',
        'email' => 'su@test.com',
        'role' => 'superuser',
        'position' => 'Supervisor',
        'department' => 'IT',
        'company' => 'UC',
        'password_hash' => $passwordHash,
        'must_change_password' => false,
    ]);
    echo "Created su@test.com\n";
}

// Create leave balances for emp2@test.com if they don't exist
$currentYear = date('Y');
$employeeId = $employee->id;

$existingBalances = AvailableLeave::where('user_id', $employeeId)
    ->where('year', $currentYear)
    ->count();

if ($existingBalances == 0) {
    $leaveTypes = [
        'vacation' => 8,
        'sick' => 10,
        'personal' => 5,
        'emergency' => 5,
    ];
    
    foreach ($leaveTypes as $type => $balance) {
        AvailableLeave::create([
            'user_id' => $employeeId,
            'leave_type' => $type,
            'total_requests' => $balance,
            'submitted_requests' => 0,
            'remaining_requests' => $balance,
            'year' => $currentYear,
        ]);
    }
    echo "Created leave balances for emp2@test.com\n";
}

echo "User cleanup completed!\n";
echo "Remaining users: admin@test.com, emp2@test.com, su@test.com\n";
echo "Password for all: 12345678\n";

