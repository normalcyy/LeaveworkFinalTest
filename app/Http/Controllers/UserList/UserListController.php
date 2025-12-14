<?php

namespace App\Http\Controllers\UserList;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\LeaveRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class UserListController extends Controller
{
    /**
     * Display a paginated list of users based on role permissions
     */
    public function index()
    {
        $currentUserRole = Session::get('role');
        $currentUserCompany = Session::get('company');

        if (!$currentUserRole) {
            return redirect()->route('login')->with('error', 'Please login first.');
        }

        $users = User::query();

        if ($currentUserRole === 'admin') {
            $users->where('role', 'employee')
                ->where('company', $currentUserCompany);
            $view = 'SU.employee-list';
        } elseif ($currentUserRole === 'superuser') {
            $users->where('role', 'admin');
            $view = 'SU.admin-list';
        } else {
            return view('users.list', ['users' => []]);
        }

        $paginatedUsers = $users
            ->orderBy('emp_id', 'asc')
            ->select([
                'id',
                'emp_id',
                'first_name',
                'middle_name',
                'last_name',
                'email',
                'role',
                'position',
                'department',
                'company',
                'created_at'
            ])
            ->paginate(12);

        $paginatedUsers->transform(function ($user) {
            $user->emp_id = $this->normalizeEmpId($user->emp_id);
            $user->first_name = $this->normalizeName($user->first_name);
            $user->middle_name = $user->middle_name
                ? $this->normalizeName($user->middle_name)
                : null;
            $user->last_name = $this->normalizeName($user->last_name);
            $user->position = $this->normalizeTitleCase($user->position);
            $user->department = $this->normalizeTitleCase($user->department);
            $user->company = $this->normalizeTitleCase($user->company);
            return $user;
        });

        return view($view, ['users' => $paginatedUsers]);
    }

    /* ==========================
       Helpers
       ========================== */

    private function normalizeName(string $name): string
    {
        return Str::title(Str::lower(trim($name)));
    }

    private function normalizeEmpId(string $empId): string
    {
        return strtoupper(preg_replace('/\s+/', '', trim($empId)));
    }

    private function normalizeTitleCase(string $text): string
    {
        return Str::title(Str::lower(trim($text)));
    }

    private function canEditUser($currentUserRole, $currentUserCompany, $targetUser): bool
    {
        if ($currentUserRole === 'admin') {
            return $targetUser->role === 'employee'
                && $targetUser->company === $currentUserCompany;
        }

        if ($currentUserRole === 'superuser') {
            return $targetUser->role === 'admin';
        }

        return false;
    }

    /**
     * Display a listing of admins for superuser
     */
    public function manageAdmins(Request $request)
    {
        $currentUserRole = Session::get('role');

        if ($currentUserRole !== 'superuser') {
            return redirect()->route('login')->with('error', 'Unauthorized access.');
        }

        // Get all admins
        $query = User::where('role', 'admin')
            ->where('email', 'not like', '%@plh.com') // Exclude placeholder admins
            ->orderBy('created_at', 'desc');

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('emp_id', 'like', "%{$search}%")
                  ->orWhere('department', 'like', "%{$search}%")
                  ->orWhere('company', 'like', "%{$search}%");
            });
        }

        $admins = $query->paginate(15);

        // Get statistics
        $totalAdmins = User::where('role', 'admin')
            ->where('email', 'not like', '%@plh.com')
            ->count();

        $totalCompanies = User::whereNotNull('company')
            ->where('company', '!=', '')
            ->where('email', 'not like', '%@plh.com')
            ->distinct('company')
            ->count('company');

        return view('su.manage-admins', [
            'admins' => $admins,
            'totalAdmins' => $totalAdmins,
            'totalCompanies' => $totalCompanies,
        ]);
    }

    /**
     * Show the form for editing the specified admin.
     */
    public function editAdmin($id)
    {
        $currentUserRole = Session::get('role');

        if ($currentUserRole !== 'superuser') {
            return redirect()->route('login')->with('error', 'Unauthorized access.');
        }

        $admin = User::findOrFail($id);

        // Verify it's an admin
        if ($admin->role !== 'admin') {
            return redirect()->route('su.manage_admins')
                ->with('error', 'User is not an admin.');
        }

        // Get companies for dropdown
        $companies = DB::table('users')
            ->whereNotNull('company')
            ->where('company', '!=', '')
            ->distinct()
            ->pluck('company')
            ->sort()
            ->values();

        return view('su.edit-admin', [
            'admin' => $admin,
            'companies' => $companies,
        ]);
    }

    /**
     * Update the specified admin in storage.
     */
    public function updateAdmin(Request $request, $id)
    {
        $currentUserRole = Session::get('role');

        if ($currentUserRole !== 'superuser') {
            if ($request->ajax()) {
                return response()->json(['error' => 'Unauthorized'], 403);
            }
            return redirect()->route('login')->with('error', 'Unauthorized access.');
        }

        $admin = User::findOrFail($id);

        // Verify it's an admin
        if ($admin->role !== 'admin') {
            if ($request->ajax()) {
                return response()->json(['error' => 'User is not an admin.'], 403);
            }
            return redirect()->route('su.manage_admins')
                ->with('error', 'User is not an admin.');
        }

        // Validate input
        $validated = $request->validate([
            'emp_id' => [
                'required',
                'string',
                'max:20',
                function ($attribute, $value, $fail) use ($admin, $id) {
                    // Check uniqueness within company
                    $existingUser = DB::table('users')
                        ->where('emp_id', $value)
                        ->where('company', $admin->company)
                        ->where('id', '!=', $id)
                        ->first();
                    
                    if ($existingUser) {
                        $fail("Admin ID '{$value}' already exists in company '{$admin->company}'.");
                    }
                }
            ],
            'first_name' => 'required|string|max:50',
            'middle_name' => 'nullable|string|max:50',
            'last_name' => 'required|string|max:50',
            'email' => 'required|email|max:100|unique:users,email,' . $id,
            'department' => 'required|string|max:50',
            'company' => 'required|string|max:100',
        ]);

        try {
            // Position is auto-set to "Administrator" for admins
            $validated['position'] = 'Administrator';
            
            $admin->update($validated);

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Admin updated successfully!'
                ]);
            }

            return redirect()->route('su.manage_admins')
                ->with('success', 'Admin updated successfully!');

        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'error' => 'Failed to update admin: ' . $e->getMessage()
                ], 500);
            }

            return back()->withErrors(['error' => 'Failed to update admin. Please try again.'])
                ->withInput();
        }
    }

    /**
     * Remove the specified admin from storage.
     */
    public function destroyAdmin($id)
    {
        $currentUserRole = Session::get('role');

        if ($currentUserRole !== 'superuser') {
            return response()->json(['error' => 'Unauthorized access.'], 403);
        }

        $admin = User::findOrFail($id);

        // Verify it's an admin
        if ($admin->role !== 'admin') {
            return response()->json(['error' => 'User is not an admin.'], 403);
        }

        // Check if admin has employees
        $employeeCount = User::where('company', $admin->company)
            ->where('role', 'employee')
            ->count();

        if ($employeeCount > 0) {
            return response()->json([
                'error' => "Cannot delete admin. There are {$employeeCount} employee(s) in company '{$admin->company}'. Please reassign or remove them first."
            ], 422);
        }

        // Check for pending leave requests (if admin has any)
        $pendingRequests = LeaveRequest::where('user_id', $admin->id)
            ->where('status', 'pending')
            ->count();

        if ($pendingRequests > 0) {
            return response()->json([
                'error' => "Cannot delete admin. They have {$pendingRequests} pending leave request(s). Please process them first."
            ], 422);
        }

        try {
            DB::beginTransaction();

            // Delete related records
            DB::table('available_leaves')->where('user_id', $admin->id)->delete();
            DB::table('leave_requests')->where('user_id', $admin->id)->delete();
            DB::table('notifications')->where('user_id', $admin->id)->delete();

            // Delete the admin
            $admin->delete();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Admin deleted successfully!'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'error' => 'Failed to delete admin: ' . $e->getMessage()
            ], 500);
        }
    }
}