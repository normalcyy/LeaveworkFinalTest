<?php

namespace App\Http\Controllers\Superuser;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;

class CompanyController extends Controller
{
    /**
     * Display company creation form with list of existing companies
     * 
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Get all unique companies with statistics
        $companies = $this->getCompaniesWithStats();
        
        return view('su.create-company', [
            'companies' => $companies,
        ])->with(session()->all());
    }
    
    /**
     * Store a new company
     * 
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        try {
            // Validate company name
            $validator = Validator::make($request->all(), [
                'company_name' => [
                    'required',
                    'string',
                    'max:100',
                    function ($attribute, $value, $fail) {
                        // Check if company already exists
                        $existingCompany = DB::table('users')
                            ->where('company', $value)
                            ->whereNotNull('company')
                            ->where('company', '!=', '')
                            ->first();
                        
                        if ($existingCompany) {
                            $fail("Company '{$value}' already exists.");
                        }
                    }
                ],
            ], [
                'company_name.required' => 'Company name is required.',
                'company_name.string' => 'Company name must be a string.',
                'company_name.max' => 'Company name must not exceed 100 characters.',
            ]);
            
            if ($validator->fails()) {
                if ($request->ajax()) {
                    return response()->json([
                        'errors' => $validator->errors()
                    ], 422);
                }
                
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }
            
            // Since companies are stored in users table, we create a placeholder admin user
            // This "registers" the company in the system
            // The placeholder admin can be replaced when a real admin is created for this company
            $companyName = $request->company_name;
            
            // Generate a unique emp_id for the placeholder (max 20 chars)
            // Format: PLH + company code (max 8 chars) + timestamp (last 6 digits)
            $companyCode = strtoupper(substr(preg_replace('/[^A-Za-z0-9]/', '', $companyName), 0, 8));
            $timestamp = substr(time(), -6); // Last 6 digits of timestamp
            $empId = 'PLH' . $companyCode . $timestamp;
            
            // Ensure emp_id doesn't exceed 20 characters
            if (strlen($empId) > 20) {
                $empId = substr($empId, 0, 20);
            }
            
            // Check if emp_id already exists, if so, append more digits
            $originalEmpId = $empId;
            $counter = 0;
            while (DB::table('users')->where('emp_id', $empId)->exists()) {
                $counter++;
                $suffix = substr($counter . time(), -3);
                $empId = substr($originalEmpId, 0, 17) . $suffix;
                if (strlen($empId) > 20) {
                    $empId = substr($empId, 0, 20);
                }
            }
            
            // Generate a unique email (max 100 chars)
            $emailPrefix = 'plh_' . strtolower(substr(preg_replace('/[^A-Za-z0-9]/', '_', $companyName), 0, 30));
            $emailSuffix = '@plh.com';
            $email = $emailPrefix . '_' . $timestamp . $emailSuffix;
            
            // Ensure email doesn't exceed 100 characters
            if (strlen($email) > 100) {
                $maxPrefixLength = 100 - strlen($emailSuffix) - strlen($timestamp) - 1; // -1 for underscore
                $emailPrefix = substr($emailPrefix, 0, $maxPrefixLength);
                $email = $emailPrefix . '_' . $timestamp . $emailSuffix;
            }
            
            // Check if email already exists, if so, append more digits
            $originalEmail = $email;
            $emailCounter = 0;
            while (DB::table('users')->where('email', $email)->exists()) {
                $emailCounter++;
                $emailSuffixNum = substr($emailCounter . time(), -4);
                $email = substr($originalEmail, 0, strpos($originalEmail, '@')) . '_' . $emailSuffixNum . '@plh.com';
                if (strlen($email) > 100) {
                    $maxPrefixLength = 100 - strlen('@plh.com') - strlen($emailSuffixNum) - 1;
                    $emailPrefix = substr($emailPrefix, 0, $maxPrefixLength);
                    $email = $emailPrefix . '_' . $emailSuffixNum . '@plh.com';
                }
            }
            
            // Create placeholder admin user
            $placeholderUserId = DB::table('users')->insertGetId([
                'emp_id' => $empId,
                'email' => $email,
                'password_hash' => Hash::make('placeholder_' . time()), // Random password, user will never login
                'first_name' => 'Placeholder',
                'middle_name' => null,
                'last_name' => 'Admin',
                'role' => 'admin',
                'position' => 'Placeholder',
                'department' => 'System',
                'company' => $companyName,
                'must_change_password' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            
            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'title' => 'Company Created Successfully!',
                    'message' => "Company '{$companyName}' has been created and is now available for selection when creating admins."
                ]);
            }
            
            return redirect()->route('su.create_company')
                ->with('success', "Company '{$companyName}' has been created successfully.");
                
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'error' => 'Failed to create company: ' . $e->getMessage()
                ], 500);
            }
            
            return redirect()->back()
                ->with('error', 'Failed to create company: ' . $e->getMessage())
                ->withInput();
        }
    }
    
    /**
     * Get companies with statistics
     * 
     * @return array
     */
    private function getCompaniesWithStats()
    {
        try {
            $companies = DB::table('users')
                ->whereNotNull('company')
                ->where('company', '!=', '')
                ->select('company')
                ->distinct()
                ->get()
                ->map(function ($item) {
                    $companyName = $item->company;
                    
                    // Get statistics for this company (exclude placeholder admins)
                    $adminCount = DB::table('users')
                        ->where('company', $companyName)
                        ->where('role', 'admin')
                        ->where('email', 'not like', '%@plh.com')
                        ->where('emp_id', 'not like', 'PLH%')
                        ->count();
                    
                    $employeeCount = DB::table('users')
                        ->where('company', $companyName)
                        ->where('role', 'employee')
                        ->count();
                    
                    $totalUsers = $adminCount + $employeeCount;
                    
                    return [
                        'name' => $companyName,
                        'admin_count' => $adminCount,
                        'employee_count' => $employeeCount,
                        'total_users' => $totalUsers,
                    ];
                })
                ->sortBy('name')
                ->values()
                ->toArray();
            
            return $companies;
        } catch (\Exception $e) {
            return [];
        }
    }
}

