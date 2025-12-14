<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\LeaveRequest;
use App\Models\AvailableLeave;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;

class ManageEmployeesController extends Controller
{
    /**
     * Display a listing of employees for the admin's company.
     */
    public function index(Request $request)
    {
        $adminCompany = Session::get('company');
        $adminId = Session::get('user_id');
        
        if (!$adminCompany || !$adminId) {
            return redirect()->route('login');
        }

        // Get all employees in the same company
        $query = User::where('role', 'employee')
            ->where('company', $adminCompany)
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
                  ->orWhere('position', 'like', "%{$search}%");
            });
        }

        $employees = $query->paginate(15);

        // Get statistics
        $totalEmployees = User::where('role', 'employee')
            ->where('company', $adminCompany)
            ->count();

        // Count employees with pending leave requests (on leave)
        $onLeaveCount = LeaveRequest::whereIn('user_id', function($query) use ($adminCompany) {
                $query->select('id')
                    ->from('users')
                    ->where('role', 'employee')
                    ->where('company', $adminCompany);
            })
            ->where('status', 'approved')
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->distinct('user_id')
            ->count('user_id');

        $activeCount = $totalEmployees - $onLeaveCount;
        $inactiveCount = 0; // Can be enhanced later with status field

        return view('admin.manage-employees', [
            'employees' => $employees,
            'totalEmployees' => $totalEmployees,
            'activeCount' => $activeCount,
            'onLeaveCount' => $onLeaveCount,
            'inactiveCount' => $inactiveCount,
        ]);
    }

    /**
     * Show the form for editing the specified employee.
     */
    public function edit($id)
    {
        $adminCompany = Session::get('company');
        
        $employee = User::findOrFail($id);

        // Verify employee belongs to admin's company
        if ($employee->company !== $adminCompany || $employee->role !== 'employee') {
            return redirect()->route('admin.manage_employees')
                ->with('error', 'Unauthorized to edit this employee.');
        }

        return view('admin.edit-user', [
            'user' => $employee,
            'isEdit' => true,
        ]);
    }

    /**
     * Update the specified employee in storage.
     */
    public function update(Request $request, $id)
    {
        $adminCompany = Session::get('company');
        
        $employee = User::findOrFail($id);

        // Verify employee belongs to admin's company
        if ($employee->company !== $adminCompany || $employee->role !== 'employee') {
            if ($request->ajax()) {
                return response()->json(['error' => 'Unauthorized'], 403);
            }
            return redirect()->route('admin.manage_employees')
                ->with('error', 'Unauthorized to update this employee.');
        }

        // Validate input
        $validated = $request->validate([
            'emp_id' => 'required|string|max:20|unique:users,emp_id,' . $id,
            'first_name' => 'required|string|max:50',
            'middle_name' => 'nullable|string|max:50',
            'last_name' => 'required|string|max:50',
            'email' => 'required|email|max:100|unique:users,email,' . $id,
            'position' => 'required|string|max:100',
            'department' => 'required|string|max:50',
        ]);

        try {
            $employee->update($validated);

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Employee updated successfully!'
                ]);
            }

            return redirect()->route('admin.manage_employees')
                ->with('success', 'Employee updated successfully!');

        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'error' => 'Failed to update employee: ' . $e->getMessage()
                ], 500);
            }

            return back()->withErrors(['error' => 'Failed to update employee. Please try again.'])
                ->withInput();
        }
    }

    /**
     * Remove the specified employee from storage.
     */
    public function destroy($id)
    {
        $adminCompany = Session::get('company');
        $adminId = Session::get('user_id');
        
        $employee = User::findOrFail($id);

        // Verify employee belongs to admin's company
        if ($employee->company !== $adminCompany || $employee->role !== 'employee') {
            return response()->json(['error' => 'Unauthorized to delete this employee.'], 403);
        }

        // Prevent admin from deleting themselves (shouldn't happen but safety check)
        if ($employee->id == $adminId) {
            return response()->json(['error' => 'You cannot delete yourself.'], 422);
        }

        // Check for pending leave requests
        $pendingRequests = LeaveRequest::where('user_id', $employee->id)
            ->where('status', 'pending')
            ->count();

        if ($pendingRequests > 0) {
            return response()->json([
                'error' => "Cannot delete employee. They have {$pendingRequests} pending leave request(s). Please process them first."
            ], 422);
        }

        try {
            DB::beginTransaction();

            // Delete related records (cascade should handle this, but being explicit)
            AvailableLeave::where('user_id', $employee->id)->delete();
            LeaveRequest::where('user_id', $employee->id)->delete();
            Notification::where('user_id', $employee->id)->delete();

            // Delete the employee
            $employee->delete();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Employee deleted successfully!'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'error' => 'Failed to delete employee: ' . $e->getMessage()
            ], 500);
        }
    }
}
