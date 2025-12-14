<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LeaveRequest;
use App\Models\AvailableLeave;
use App\Models\Notification;
use App\Models\User;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;

class AdminRequestController extends Controller
{
    /**
     * Display a listing of all leave requests for admin's company.
     */
    public function index(Request $request)
    {
        $adminCompany = Session::get('company');
        
        if (!$adminCompany) {
            return redirect()->route('login');
        }

        // Get all employees in the same company
        $employeeIds = User::where('role', 'employee')
            ->where('company', $adminCompany)
            ->pluck('id');

        // Build query
        $query = LeaveRequest::whereIn('user_id', $employeeIds)
            ->with('user')
            ->orderBy('created_at', 'desc');

        // Apply filters
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('leave_type')) {
            $query->where('leave_type', $request->leave_type);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('user', function($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('department', 'like', "%{$search}%");
            });
        }

        // Date filter
        if ($request->filled('date_filter')) {
            $dateFilter = $request->date_filter;
            $now = Carbon::now();
            
            switch ($dateFilter) {
                case 'today':
                    $query->whereDate('start_date', $now->toDateString());
                    break;
                case 'week':
                    $query->whereBetween('start_date', [$now->startOfWeek(), $now->copy()->endOfWeek()]);
                    break;
                case 'month':
                    $query->whereMonth('start_date', $now->month)
                          ->whereYear('start_date', $now->year);
                    break;
            }
        }

        $leaveRequests = $query->paginate(15);

        // Get statistics
        $totalCount = LeaveRequest::whereIn('user_id', $employeeIds)->count();
        $pendingCount = LeaveRequest::whereIn('user_id', $employeeIds)->where('status', 'pending')->count();
        $approvedCount = LeaveRequest::whereIn('user_id', $employeeIds)->where('status', 'approved')->count();
        $rejectedCount = LeaveRequest::whereIn('user_id', $employeeIds)->where('status', 'rejected')->count();

        return view('admin.requests', [
            'leaveRequests' => $leaveRequests,
            'totalCount' => $totalCount,
            'pendingCount' => $pendingCount,
            'approvedCount' => $approvedCount,
            'rejectedCount' => $rejectedCount,
        ]);
    }

    /**
     * Display the specified leave request.
     */
    public function show($id)
    {
        $adminCompany = Session::get('company');
        
        $leaveRequest = LeaveRequest::with('user')->findOrFail($id);

        // Verify admin has access (same company)
        if ($leaveRequest->user->company !== $adminCompany) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        return response()->json([
            'success' => true,
            'request' => $leaveRequest,
            'user' => $leaveRequest->user,
            'days' => $leaveRequest->start_date->diffInDays($leaveRequest->end_date) + 1,
        ]);
    }

    /**
     * Approve a leave request.
     */
    public function approve($id)
    {
        $adminCompany = Session::get('company');
        
        try {
            DB::beginTransaction();

            $leaveRequest = LeaveRequest::with('user')->findOrFail($id);

            // Verify admin has access
            if ($leaveRequest->user->company !== $adminCompany) {
                return response()->json(['error' => 'Unauthorized'], 403);
            }

            if ($leaveRequest->status !== 'pending') {
                return response()->json(['error' => 'Request is not pending'], 422);
            }

            // Update status
            $leaveRequest->status = 'approved';
            $leaveRequest->save();

            // Create notification for employee using service
            $notificationService = new NotificationService();
            $notificationService->createLeaveStatusNotification($leaveRequest->user_id, $leaveRequest->id, 'approved');

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Leave request approved successfully!'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'error' => 'Failed to approve request: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Reject a leave request.
     */
    public function reject($id)
    {
        $adminCompany = Session::get('company');
        
        try {
            DB::beginTransaction();

            $leaveRequest = LeaveRequest::with('user')->findOrFail($id);

            // Verify admin has access
            if ($leaveRequest->user->company !== $adminCompany) {
                return response()->json(['error' => 'Unauthorized'], 403);
            }

            if ($leaveRequest->status !== 'pending') {
                return response()->json(['error' => 'Request is not pending'], 422);
            }

            // Calculate days
            $days = $leaveRequest->start_date->diffInDays($leaveRequest->end_date) + 1;
            $currentYear = date('Y');

            // Revert available leave balance
            $availableLeave = AvailableLeave::where('user_id', $leaveRequest->user_id)
                ->where('leave_type', $leaveRequest->leave_type)
                ->where('year', $currentYear)
                ->first();

            if ($availableLeave) {
                $availableLeave->submitted_requests -= $days;
                $availableLeave->remaining_requests += $days;
                $availableLeave->save();
            }

            // Update status
            $leaveRequest->status = 'rejected';
            $leaveRequest->save();

            // Create notification for employee using service
            $notificationService = new NotificationService();
            $notificationService->createLeaveStatusNotification($leaveRequest->user_id, $leaveRequest->id, 'rejected');

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Leave request rejected successfully!'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'error' => 'Failed to reject request: ' . $e->getMessage()
            ], 500);
        }
    }
}
