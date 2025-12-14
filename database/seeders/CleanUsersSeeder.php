<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\AvailableLeave;
use Illuminate\Support\Facades\Hash;

class CleanUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $passwordHash = Hash::make('12345678'); // Default password for all users
        
        // Get IDs of users to keep
        $keepEmails = ['admin@test.com', 'emp2@test.com', 'su@test.com'];
        $usersToKeep = User::whereIn('email', $keepEmails)->pluck('id')->toArray();
        
        // Delete all users except the ones to keep
        $deletedCount = User::whereNotIn('id', $usersToKeep)->count();
        User::whereNotIn('id', $usersToKeep)->delete();
        
        $this->command->info("Deleted {$deletedCount} users.");
        
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
            $this->command->info("Created admin@test.com");
        } else {
            // Update admin to ensure correct data
            $admin->update([
                'role' => 'admin',
                'company' => 'UC',
                'password_hash' => $passwordHash,
            ]);
            $this->command->info("Updated admin@test.com");
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
            $this->command->info("Created emp2@test.com");
        } else {
            // Update employee to ensure correct data
            $employee->update([
                'role' => 'employee',
                'company' => 'UC',
                'password_hash' => $passwordHash,
            ]);
            $this->command->info("Updated emp2@test.com");
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
            $this->command->info("Created su@test.com");
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
            $this->command->info("Created leave balances for emp2@test.com");
        }
        
        $this->command->info('User cleanup completed!');
        $this->command->info('Remaining users: admin@test.com, emp2@test.com, su@test.com');
    }
}

