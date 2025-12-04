<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class AddUserController extends Controller
{
    /**
     * Handle user creation based on role
     */
    public function createUser(Request $request)
    {
        try {
            // Get current user from session
            $currentUser = $this->getCurrentUser();
            
            // Validate based on current user's role
            $validator = $this->validateUserData($request, $currentUser);
            
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
            
            // Prepare user data
            $userData = $this->prepareUserData($request, $currentUser);
            
            // Insert user into database
            $userId = DB::table('users')->insertGetId($userData);
            
            // Create leave balance record for employees
            if ($userData['role'] === 'employee') {
                $this->createLeaveBalance($userId, $request);
            }
            
            // Return response based on request type
            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'title' => 'User Created Successfully!',
                    'message' => 'The account has been created successfully. ' .
                                'The default password is <strong>123456</strong>.'
                ]);
            }
            
            // For non-AJAX requests
            return $this->redirectWithSuccess($currentUser['role']);
            
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'error' => 'Failed to create user: ' . $e->getMessage()
                ], 500);
            }
            
            return redirect()->back()
                ->with('error', 'Failed to create user: ' . $e->getMessage())
                ->withInput();
        }
    }
    
    /**
     * Get current user from session
     */
    private function getCurrentUser()
    {
        return [
            'role' => Session::get('role'),
            'company' => Session::get('company'),
            'id' => Session::get('user_id')
        ];
    }
    
    /**
     * Validate user data based on role with company-specific EMP ID uniqueness
     */
    private function validateUserData(Request $request, $currentUser)
    {
        // Determine company for validation
        $company = $currentUser['role'] === 'superuser' 
            ? $request->company 
            : $currentUser['company'];
        
        // Define base validation rules
        $rules = [
            'emp_id' => [
                'required',
                'string',
                'max:50',
                // Custom validation for company-specific uniqueness
                function ($attribute, $value, $fail) use ($company) {
                    $existingUser = DB::table('users')
                        ->where('emp_id', $value)
                        ->where('company', $company)
                        ->first();
                    
                    if ($existingUser) {
                        $fail("Employee ID '{$value}' already exists in company '{$company}'.");
                    }
                }
            ],
            'email' => [
                'required',
                'email',
                'max:100',
                // Email uniqueness across all companies (global uniqueness)
                'unique:users,email'
            ],
            'first_name' => 'required|string|max:50',
            'middle_name' => 'nullable|string|max:50',
            'last_name' => 'required|string|max:50',
            'position' => 'required|string|max:100',
            'department' => 'required|string|max:100',
        ];
        
        // Add company validation for superuser only
        if ($currentUser['role'] === 'superuser') {
            $rules['company'] = 'required|string|max:100';
        }
        
        // Custom error messages
        $messages = [
            'emp_id.required' => 'Employee ID is required.',
            'emp_id.string' => 'Employee ID must be a string.',
            'emp_id.max' => 'Employee ID must not exceed 50 characters.',
            'email.required' => 'Email address is required.',
            'email.email' => 'Please enter a valid email address.',
            'email.max' => 'Email address must not exceed 100 characters.',
            'email.unique' => 'This email is already registered in the system.',
            'first_name.required' => 'First name is required.',
            'first_name.string' => 'First name must be a string.',
            'first_name.max' => 'First name must not exceed 50 characters.',
            'last_name.required' => 'Last name is required.',
            'last_name.string' => 'Last name must be a string.',
            'last_name.max' => 'Last name must not exceed 50 characters.',
            'position.required' => 'Position is required.',
            'position.string' => 'Position must be a string.',
            'position.max' => 'Position must not exceed 100 characters.',
            'department.required' => 'Department is required.',
            'department.string' => 'Department must be a string.',
            'department.max' => 'Department must not exceed 100 characters.',
        ];
        
        if ($currentUser['role'] === 'superuser') {
            $messages['company.required'] = 'Company name is required for admin creation.';
            $messages['company.string'] = 'Company name must be a string.';
            $messages['company.max'] = 'Company name must not exceed 100 characters.';
        }
        
        return Validator::make($request->all(), $rules, $messages);
    }
    
    /**
     * Prepare user data for insertion
     */
    private function prepareUserData(Request $request, $currentUser)
    {
        // Determine role and company
        if ($currentUser['role'] === 'superuser') {
            $role = 'admin';
            $company = $request->company;
        } else {
            $role = 'employee';
            $company = $currentUser['company'];
        }
        
        // Return only the columns that exist in your table
        return [
            'emp_id' => $request->emp_id,
            'email' => $request->email,
            'password_hash' => Hash::make('123456'), // Default password
            'first_name' => $request->first_name,
            'middle_name' => $request->middle_name ?? null,
            'last_name' => $request->last_name,
            'role' => $role,
            'position' => $request->position,
            'department' => $request->department,
            'company' => $company,
            'must_change_password' => true, // Set to true so user must change password on first login
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
    
    /**
     * Create leave balance record for new employee
     */
    private function createLeaveBalance($userId, Request $request)
    {
        // Check if available_leaves table exists
        if (!DB::getSchemaBuilder()->hasTable('available_leaves')) {
            return; // Table doesn't exist, skip creation
        }
        
        // Define the four leave types with their default values
        $leaveTypes = [
            'vacation' => $request->input('vacation_leaves', 8),
            'sick' => $request->input('sick_leaves', 10),
            'personal' => $request->input('personal_leaves', 5),
            'emergency' => $request->input('emergency_leaves', 5),
        ];
        
        // Get current year
        $currentYear = date('Y');
        
        // Insert each leave type into the database
        foreach ($leaveTypes as $type => $balance) {
            DB::table('available_leaves')->insert([
                'user_id' => $userId,
                'leave_type' => $type,
                'total_requests' => $balance,
                'submitted_requests' => 0,
                'remaining_requests' => $balance,
                'year' => $currentYear,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
    
    /**
     * Redirect with success message based on role
     */
    private function redirectWithSuccess($currentUserRole)
    {
        $message = $currentUserRole === 'superuser' 
            ? 'Admin created successfully with default password: 123456'
            : 'Employee created successfully with default password: 123456';
        
        $route = $currentUserRole === 'superuser' 
            ? 'su.dashboard' 
            : 'admin.dashboard';
        
        return redirect()->route($route)
            ->with('success', $message)
            ->with('admin_created', true);
    }
    
    /**
     * Check EMP ID availability (for AJAX validation)
     */
    public function checkEmpIdAvailability(Request $request)
    {
        try {
            $empId = $request->input('emp_id');
            $company = $request->input('company');
            
            if (!$empId || !$company) {
                return response()->json([
                    'available' => false,
                    'message' => 'Employee ID and company are required.'
                ]);
            }
            
            $existingUser = DB::table('users')
                ->where('emp_id', $empId)
                ->where('company', $company)
                ->first();
            
            if ($existingUser) {
                return response()->json([
                    'available' => false,
                    'message' => "Employee ID '{$empId}' already exists in company '{$company}'."
                ]);
            }
            
            return response()->json([
                'available' => true,
                'message' => "Employee ID '{$empId}' is available for company '{$company}'."
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'available' => false,
                'message' => 'Error checking Employee ID availability: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Check email availability (for AJAX validation)
     */
    public function checkEmailAvailability(Request $request)
    {
        try {
            $email = $request->input('email');
            
            if (!$email) {
                return response()->json([
                    'available' => false,
                    'message' => 'Email address is required.'
                ]);
            }
            
            $existingUser = DB::table('users')
                ->where('email', $email)
                ->first();
            
            if ($existingUser) {
                return response()->json([
                    'available' => false,
                    'message' => "Email '{$email}' is already registered in the system."
                ]);
            }
            
            return response()->json([
                'available' => true,
                'message' => "Email '{$email}' is available."
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'available' => false,
                'message' => 'Error checking email availability: ' . $e->getMessage()
            ], 500);
        }
    }
}