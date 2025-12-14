<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class LeaveBalanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get current year
        $currentYear = date('Y');
        
        // Default leave balances
        $defaultBalances = [
            'vacation' => 8,
            'sick' => 10,
            'personal' => 5,
            'emergency' => 5,
        ];
        
        // Get all employees
        $employees = User::where('role', 'employee')->get();
        
        foreach ($employees as $employee) {
            // Check if employee already has leave balances for this year
            $existingBalances = DB::table('available_leaves')
                ->where('user_id', $employee->id)
                ->where('year', $currentYear)
                ->count();
            
            // If no balances exist, create them
            if ($existingBalances == 0) {
                foreach ($defaultBalances as $type => $balance) {
                    DB::table('available_leaves')->insert([
                        'user_id' => $employee->id,
                        'leave_type' => $type,
                        'total_requests' => $balance,
                        'submitted_requests' => 0,
                        'remaining_requests' => $balance,
                        'year' => $currentYear,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
                
                $this->command->info("Added leave balances for employee: {$employee->first_name} {$employee->last_name} (ID: {$employee->id})");
            } else {
                $this->command->info("Employee {$employee->first_name} {$employee->last_name} already has leave balances for {$currentYear}");
            }
        }
        
        $this->command->info('Leave balance seeding completed!');
    }
}
