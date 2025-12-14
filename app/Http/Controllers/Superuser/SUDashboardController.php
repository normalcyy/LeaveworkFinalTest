<?php

namespace App\Http\Controllers\Superuser;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class SUDashboardController extends Controller
{
    /**
     * Display superuser dashboard with real statistics
     * 
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Get the counts from database
        $adminCount = $this->getAdminCount();
        $companyCount = $this->getCompanyCount();
        
        // Get companies list with statistics
        $companies = $this->getCompaniesList();
        
        return view('SU.su_dashboard', [
            'adminCount' => $adminCount,
            'companyCount' => $companyCount,
            'companies' => $companies,
        ]);
    }
    
    /**
     * Get list of companies with statistics
     * 
     * @return array
     */
    private function getCompaniesList()
    {
        try {
            $companies = DB::table('users')
                ->whereNotNull('company')
                ->where('company', '!=', '')
                ->select('company')
                ->distinct()
                ->pluck('company')
                ->sort()
                ->map(function ($company) {
                    $adminCount = DB::table('users')
                        ->where('company', $company)
                        ->where('role', 'admin')
                        ->count();
                    
                    $employeeCount = DB::table('users')
                        ->where('company', $company)
                        ->where('role', 'employee')
                        ->count();
                    
                    $totalUsers = $adminCount + $employeeCount;
                    
                    return [
                        'name' => $company,
                        'admin_count' => $adminCount,
                        'employee_count' => $employeeCount,
                        'total_users' => $totalUsers,
                    ];
                })
                ->values()
                ->toArray();
            
            return $companies;
        } catch (\Exception $e) {
            return [];
        }
    }

    /**
     * Count all users with admin role
     * 
     * @return int
     */
    private function getAdminCount()
    {
        try {
            return DB::table('users')
                ->where('role', 'admin')
                ->count();
        } catch (\Exception $e) {
            // Log error if needed
            // Log::error('Error counting admins: ' . $e->getMessage());
            return 0; // Return 0 on error
        }
    }

    /**
     * Count unique companies from database
     * 
     * @return int
     */
    private function getCompanyCount()
    {
        try {
            return DB::table('users')
                ->whereNotNull('company')
                ->where('company', '!=', '') // Exclude empty company names
                ->distinct('company')
                ->count('company');
        } catch (\Exception $e) {
            // Log error if needed
            // Log::error('Error counting companies: ' . $e->getMessage());
            return 0; // Return 0 on error
        }
    }
}