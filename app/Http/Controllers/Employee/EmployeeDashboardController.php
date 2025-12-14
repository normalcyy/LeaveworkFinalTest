<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\LeaveRequest;
use App\Models\AvailableLeave;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class EmployeeDashboardController extends Controller
{
    /**
     * Display the employee dashboard.
     */
    public function index()
    {
        $userId = Session::get('user_id');
        
        if (!$userId) {
            return redirect()->route('login');
        }

        // Get leave request statistics
        $pendingCount = LeaveRequest::where('user_id', $userId)
            ->where('status', 'pending')
            ->count();

        $approvedCount = LeaveRequest::where('user_id', $userId)
            ->where('status', 'approved')
            ->count();

        $rejectedCount = LeaveRequest::where('user_id', $userId)
            ->where('status', 'rejected')
            ->count();

        // Get recent leave requests (last 5)
        $recentRequests = LeaveRequest::where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Get leave balance summary
        $currentYear = date('Y');
        $leaveBalance = AvailableLeave::where('user_id', $userId)
            ->where('year', $currentYear)
            ->get()
            ->mapWithKeys(function ($leave) {
                return [$leave->leave_type => [
                    'total' => $leave->total_requests,
                    'remaining' => $leave->remaining_requests,
                ]];
            });

        // Get unread notifications count
        $unreadNotificationsCount = Notification::where('user_id', $userId)
            ->where('is_read', false)
            ->count();

        return view('employee.emp_dashboard', [
            'pendingCount' => $pendingCount,
            'approvedCount' => $approvedCount,
            'rejectedCount' => $rejectedCount,
            'recentRequests' => $recentRequests,
            'leaveBalance' => $leaveBalance,
            'unreadNotificationsCount' => $unreadNotificationsCount,
        ]);
    }
}
