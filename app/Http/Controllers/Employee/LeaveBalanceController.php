<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\AvailableLeave;
use App\Models\LeaveRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class LeaveBalanceController extends Controller
{
    /**
     * Display the leave balance for the current user.
     */
    public function index()
    {
        $userId = Session::get('user_id');
        
        if (!$userId) {
            return redirect()->route('login');
        }

        $currentYear = date('Y');
        
        // Get available leaves for current year
        $availableLeaves = AvailableLeave::where('user_id', $userId)
            ->where('year', $currentYear)
            ->get()
            ->keyBy('leave_type');

        // Get used leaves from approved requests
        $usedLeaves = LeaveRequest::where('user_id', $userId)
            ->where('status', 'approved')
            ->whereYear('start_date', $currentYear)
            ->get()
            ->groupBy('leave_type')
            ->map(function ($requests) {
                return $requests->sum(function ($request) {
                    return $request->start_date->diffInDays($request->end_date) + 1;
                });
            });

        // Prepare data for view
        $leaveTypes = ['vacation', 'sick', 'personal', 'emergency'];
        $leaveData = [];

        foreach ($leaveTypes as $type) {
            $available = $availableLeaves->get($type);
            $used = $usedLeaves->get($type, 0);
            
            $leaveData[$type] = [
                'total' => $available ? $available->total_requests : 0,
                'used' => $used,
                'remaining' => $available ? $available->remaining_requests : 0,
                'submitted' => $available ? $available->submitted_requests : 0,
            ];
        }

        return view('employee.leave-balance', [
            'leaveData' => $leaveData,
            'currentYear' => $currentYear,
        ]);
    }
}
