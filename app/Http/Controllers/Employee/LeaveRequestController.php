<?php

namespace App\Http\Controllers\Employee;

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

class LeaveRequestController extends Controller
{
    /**
     * Display a listing of the user's leave requests.
     */
    public function index()
    {
        $userId = Session::get('user_id');
        
        if (!$userId) {
            return redirect()->route('login');
        }

        $leaveRequests = LeaveRequest::where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('employee.my-requests', [
            'leaveRequests' => $leaveRequests,
        ]);
    }

    /**
     * Store a newly created leave request.
     */
    public function store(Request $request)
    {
        $userId = Session::get('user_id');
        
        if (!$userId) {
            if ($request->ajax()) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }
            return redirect()->route('login');
        }

        // Validate the request
        $validated = $request->validate([
            'leave_type' => 'required|in:vacation,sick,personal,emergency',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after_or_equal:start_date',
            'reason' => 'required|string|min:10',
            'priority' => 'nullable|in:normal,urgent,emergency',
            'message' => 'nullable|string|max:255',
            'emergency_contact' => 'nullable|string|max:100',
            'handover_to' => 'nullable|string|max:100',
        ], [
            'start_date.after_or_equal' => 'Start date must be today or later.',
            'end_date.after_or_equal' => 'End date must be on or after start date.',
            'reason.min' => 'Reason must be at least 10 characters.',
        ]);

        try {
            DB::beginTransaction();

            // Get current year
            $currentYear = date('Y');
            
            // Check available leave balance
            $availableLeave = AvailableLeave::where('user_id', $userId)
                ->where('leave_type', $validated['leave_type'])
                ->where('year', $currentYear)
                ->first();

            if (!$availableLeave) {
                DB::rollBack();
                if ($request->ajax()) {
                    return response()->json([
                        'error' => 'Leave balance not found for this leave type. Please contact admin.'
                    ], 422);
                }
                return back()->withErrors(['leave_type' => 'Leave balance not found for this leave type.']);
            }

            // Calculate number of days
            $startDate = Carbon::parse($validated['start_date']);
            $endDate = Carbon::parse($validated['end_date']);
            $days = $startDate->diffInDays($endDate) + 1;

            // Check if enough leave balance
            if ($availableLeave->remaining_requests < $days) {
                DB::rollBack();
                if ($request->ajax()) {
                    return response()->json([
                        'error' => "Insufficient leave balance. You have {$availableLeave->remaining_requests} days remaining, but requested {$days} days."
                    ], 422);
                }
                return back()->withErrors(['leave_type' => "Insufficient leave balance. You have {$availableLeave->remaining_requests} days remaining."]);
            }

            // Create leave request
            $leaveRequest = LeaveRequest::create([
                'user_id' => $userId,
                'leave_type' => $validated['leave_type'],
                'priority' => $validated['priority'] ?? 'normal',
                'start_date' => $validated['start_date'],
                'end_date' => $validated['end_date'],
                'reason' => $validated['reason'],
                'message' => $validated['message'] ?? null,
                'emergency_contact' => $validated['emergency_contact'] ?? null,
                'handover_to' => $validated['handover_to'] ?? null,
                'status' => 'pending',
            ]);

            // Update available leave balance
            $availableLeave->submitted_requests += $days;
            $availableLeave->remaining_requests -= $days;
            $availableLeave->save();

            // Create notification for admin using service
            $notificationService = new NotificationService();
            $notificationService->notifyAdminsOfNewRequest($userId, $leaveRequest->id);

            DB::commit();

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Leave request submitted successfully!'
                ]);
            }

            return redirect()->route('employee.my_requests')
                ->with('success', 'Leave request submitted successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            
            if ($request->ajax()) {
                return response()->json([
                    'error' => 'Failed to submit leave request: ' . $e->getMessage()
                ], 500);
            }

            return back()->withErrors(['error' => 'Failed to submit leave request. Please try again.']);
        }
    }

}
