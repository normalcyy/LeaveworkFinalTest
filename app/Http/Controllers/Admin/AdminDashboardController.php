<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\LeaveRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;

class AdminDashboardController extends Controller
{
    /**
     * Display the admin dashboard.
     */
    public function index()
    {
        $adminCompany = Session::get('company');
        $adminId = Session::get('user_id');
        
        if (!$adminCompany || !$adminId) {
            return redirect()->route('login');
        }

        // Get employee IDs in the same company
        $employeeIds = User::where('role', 'employee')
            ->where('company', $adminCompany)
            ->pluck('id');

        // Get statistics
        $totalEmployees = User::where('role', 'employee')
            ->where('company', $adminCompany)
            ->count();

        $pendingRequests = LeaveRequest::whereIn('user_id', $employeeIds)
            ->where('status', 'pending')
            ->count();

        $approvedThisMonth = LeaveRequest::whereIn('user_id', $employeeIds)
            ->where('status', 'approved')
            ->whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->count();

        $rejectedThisMonth = LeaveRequest::whereIn('user_id', $employeeIds)
            ->where('status', 'rejected')
            ->whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->count();

        // Get recent requests (last 10)
        $recentRequests = LeaveRequest::whereIn('user_id', $employeeIds)
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        return view('admin.admin_dashboard', [
            'totalEmployees' => $totalEmployees,
            'pendingRequests' => $pendingRequests,
            'approvedThisMonth' => $approvedThisMonth,
            'rejectedThisMonth' => $rejectedThisMonth,
            'recentRequests' => $recentRequests,
        ]);
    }
}
