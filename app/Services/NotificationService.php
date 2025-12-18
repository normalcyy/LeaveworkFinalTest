<?php

namespace App\Services;

use App\Models\Notification;
use App\Models\User;
use App\Models\LeaveRequest;

class NotificationService
{
    /**
     * Create a notification when leave request status changes.
     */
    public function createLeaveStatusNotification(int $userId, int $leaveRequestId, string $status): void
    {
        $leaveRequest = LeaveRequest::find($leaveRequestId);
        if (!$leaveRequest) {
            return;
        }

        $statusMessages = [
            'approved' => "Your {$leaveRequest->leave_type} leave request has been approved.",
            'rejected' => "Your {$leaveRequest->leave_type} leave request has been rejected.",
            'pending' => "Your {$leaveRequest->leave_type} leave request is pending review.",
        ];

        $message = $statusMessages[$status] ?? "Your leave request status has been updated to {$status}.";

        Notification::create([
            'user_id' => $userId,
            'leave_request_id' => $leaveRequestId,
            'type' => 'leave_status',
            'message' => $message,
            'is_read' => false,
        ]);
    }

    /**
     * Create notification for admin when new leave request is submitted.
     */
    public function createNewRequestNotification(int $adminId, int $leaveRequestId): void
    {
        $leaveRequest = LeaveRequest::with('user')->find($leaveRequestId);
        if (!$leaveRequest) {
            return;
        }

        $employeeName = $leaveRequest->user->first_name . ' ' . $leaveRequest->user->last_name;
        $message = "New leave request from {$employeeName} ({$leaveRequest->leave_type} leave)";

        Notification::create([
            'user_id' => $adminId,
            'leave_request_id' => $leaveRequestId,
            'type' => 'leave_status',
            'message' => $message,
            'is_read' => false,
        ]);
    }

    /**
     * Create notifications for all admins in the same company when a new request is submitted.
     */
    public function notifyAdminsOfNewRequest(int $employeeId, int $leaveRequestId): void
    {
        $employee = User::find($employeeId);
        if (!$employee || $employee->role !== 'employee') {
            return;
        }

        // Find all admins in the same company
        $admins = User::where('role', 'admin')
            ->where('company', $employee->company)
            ->get();

        foreach ($admins as $admin) {
            $this->createNewRequestNotification($admin->id, $leaveRequestId);
        }
    }
}


