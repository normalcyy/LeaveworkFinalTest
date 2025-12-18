# Comprehensive Implementation Plan - Leave Management System

## Overview
This plan outlines all the work needed to make the leave management system fully functional with MySQL database integration.

---

## PHASE 1: Database Migrations & Models

### 1.1 Update Users Table Migration
**File:** `database/migrations/0001_01_01_000000_create_users_table.php`
- ✅ Already exists but needs verification
- ⚠️ **Issue:** Missing `must_change_password` column (used in LoginController)
- **Action:** Add `must_change_password` boolean column with default false
- **Note:** Migration already has correct structure matching schema

### 1.2 Update Available Leaves Migration
**File:** `database/migrations/2025_12_03_044255_create_available_leaves_table.php`
- ✅ Table structure exists
- ⚠️ **Issue:** Missing foreign key constraint
- **Action:** Add foreign key: `$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');`
- **Action:** Add unique constraint: `$table->unique(['user_id', 'leave_type', 'year']);`

### 1.3 Create Leave Requests Migration
**File:** `database/migrations/YYYY_MM_DD_HHMMSS_create_leave_requests_table.php` (NEW)
- Create new migration file
- Fields:
  - `id` (primary key, auto increment)
  - `user_id` (foreign key to users)
  - `leave_type` (enum: vacation, sick, personal, emergency)
  - `priority` (enum: normal, urgent, emergency, default: normal)
  - `start_date` (date)
  - `end_date` (date)
  - `reason` (text)
  - `message` (varchar 255, nullable)
  - `emergency_contact` (varchar 100, nullable)
  - `handover_to` (varchar 100, nullable)
  - `status` (enum: pending, approved, rejected, default: pending)
  - `created_at`, `updated_at` (timestamps)
- Add foreign key constraint to users table
- Add index on `user_id`

### 1.4 Create Notifications Migration
**File:** `database/migrations/YYYY_MM_DD_HHMMSS_create_notifications_table.php` (NEW)
- Create new migration file
- Fields:
  - `id` (primary key, auto increment)
  - `user_id` (foreign key to users)
  - `leave_request_id` (foreign key to leave_requests)
  - `type` (enum: leave_status, default: leave_status)
  - `message` (varchar 255)
  - `is_read` (tinyint/boolean, default: 0)
  - `created_at` (timestamp)
- Add foreign keys to users and leave_requests
- Add indexes on `user_id` and `leave_request_id`

### 1.5 Create Password Resets Migration
**File:** `database/migrations/YYYY_MM_DD_HHMMSS_create_password_resets_table.php` (NEW)
- Create new migration file
- Fields:
  - `id` (primary key, auto increment)
  - `user_id` (foreign key to users)
  - `reset_token` (varchar 255)
  - `expires_at` (datetime)
  - `used` (tinyint/boolean, default: 0)
  - `created_at` (timestamp)
- Add foreign key to users table
- Add index on `user_id`

### 1.6 Update User Model
**File:** `app/Models/User.php`
- Update `$fillable` to match database schema:
  - `emp_id`, `first_name`, `middle_name`, `last_name`, `email`, `role`, `position`, `department`, `company`, `password_hash`, `must_change_password`
- Update password field mapping: `password` → `password_hash` in casts
- Add relationships:
  - `leaveRequests()` - hasMany LeaveRequest
  - `availableLeaves()` - hasMany AvailableLeave
  - `notifications()` - hasMany Notification

### 1.7 Create New Models
**Files to create:**
- `app/Models/LeaveRequest.php`
- `app/Models/AvailableLeave.php`
- `app/Models/Notification.php`
- `app/Models/PasswordReset.php` (optional, if using custom password reset)

---

## PHASE 2: Employee Functionality

### 2.1 Leave Request Submission
**Controller:** `app/Http/Controllers/Employee/LeaveRequestController.php` (NEW)
- **Method:** `store(Request $request)`
  - Validate: leave_type, start_date, end_date, reason, priority, message, emergency_contact, handover_to
  - Check available leave balance
  - Calculate number of days
  - Create leave request with status 'pending'
  - Update available_leaves (increment submitted_requests, decrement remaining_requests)
  - Create notification for admin
  - Return success response

**Route:** `routes/web.php`
- `POST /employee/leave-request` → `LeaveRequestController@store`

**View:** `resources/views/employee/new-request.blade.php`
- Update form action to point to new route
- Add name attributes to all form fields
- Add CSRF token
- Add validation error display
- Add success/error message display
- Add AJAX form submission (optional but recommended)

### 2.2 View My Leave Requests
**Controller:** `app/Http/Controllers/Employee/LeaveRequestController.php`
- **Method:** `index()`
  - Get current user from session
  - Fetch all leave requests for user
  - Order by created_at DESC
  - Pass to view

**Route:** `routes/web.php`
- `GET /employee/my-requests` → `LeaveRequestController@index` (replace current closure)

**View:** `resources/views/employee/my-requests.blade.php`
- Replace hardcoded data with real data from controller
- Display: leave type, start date, end date, status, days, reason
- Add "View Details" functionality
- Add pagination if needed

### 2.3 View Leave Balance
**Controller:** `app/Http/Controllers/Employee/LeaveBalanceController.php` (NEW)
- **Method:** `index()`
  - Get current user from session
  - Fetch available_leaves for current year
  - Calculate used leaves from leave_requests
  - Pass to view

**Route:** `routes/web.php`
- `GET /employee/leave-balance` → `LeaveBalanceController@index` (replace current closure)

**View:** `resources/views/employee/leave-balance.blade.php`
- Replace hardcoded data with real data
- Display: leave type, total, used, remaining
- Show visual indicators (progress bars, colors)

### 2.4 Employee Dashboard
**Controller:** `app/Http/Controllers/Employee/EmployeeDashboardController.php` (NEW)
- **Method:** `index()`
  - Get current user
  - Count pending requests
  - Count approved requests
  - Count rejected requests
  - Get recent requests (last 5)
  - Get leave balance summary
  - Get unread notifications count
  - Pass all to view

**Route:** `routes/web.php`
- `GET /employee/dashboard` → `EmployeeDashboardController@index` (replace current closure)

**View:** `resources/views/employee/emp_dashboard.blade.php`
- Replace hardcoded stats with real data
- Display real recent requests
- Display real leave balance summary
- Add notifications section

---

## PHASE 3: Admin Functionality

### 3.1 View All Leave Requests
**Controller:** `app/Http/Controllers/Admin/AdminRequestController.php` (NEW)
- **Method:** `index()`
  - Get current admin's company from session
  - Fetch all leave requests from employees in same company
  - Support filtering by: status, leave_type, date range
  - Support search by employee name
  - Count by status (pending, approved, rejected, total)
  - Pass to view with pagination

**Route:** `routes/web.php`
- `GET /admin/requests` → `AdminRequestController@index` (replace current closure)

**View:** `resources/views/admin/requests.blade.php`
- Replace hardcoded data with real data
- Update stats cards with real counts
- Implement filtering functionality
- Implement search functionality

### 3.2 View Leave Request Details
**Controller:** `app/Http/Controllers/Admin/AdminRequestController.php`
- **Method:** `show($id)`
  - Get leave request by ID
  - Verify admin has access (same company)
  - Get employee details
  - Return JSON for modal or view

**Route:** `routes/web.php`
- `GET /admin/requests/{id}` → `AdminRequestController@show`

### 3.3 Approve Leave Request
**Controller:** `app/Http/Controllers/Admin/AdminRequestController.php`
- **Method:** `approve($id)`
  - Get leave request
  - Verify admin access
  - Update status to 'approved'
  - Update available_leaves (decrement remaining if needed)
  - Create notification for employee
  - Return success response

**Route:** `routes/web.php`
- `POST /admin/requests/{id}/approve` → `AdminRequestController@approve`

**View:** Update approve button to call this route

### 3.4 Reject Leave Request
**Controller:** `app/Http/Controllers/Admin/AdminRequestController.php`
- **Method:** `reject($id)`
  - Get leave request
  - Verify admin access
  - Update status to 'rejected'
  - Revert available_leaves (increment remaining, decrement submitted)
  - Create notification for employee
  - Return success response

**Route:** `routes/web.php`
- `POST /admin/requests/{id}/reject` → `AdminRequestController@reject`

**View:** Update reject button to call this route

### 3.5 Admin Dashboard
**Controller:** `app/Http/Controllers/Admin/AdminDashboardController.php` (NEW)
- **Method:** `index()`
  - Get current admin's company
  - Count total employees
  - Count pending requests
  - Count approved requests (this month)
  - Count rejected requests (this month)
  - Get recent requests
  - Pass to view

**Route:** `routes/web.php`
- `GET /admin/dashboard` → `AdminDashboardController@index` (replace current closure)

**View:** `resources/views/admin/admin_dashboard.blade.php`
- Replace hardcoded stats with real data
- Display real recent requests
- Add notifications section

---

## PHASE 4: Notifications System

### 4.1 Notification Model & Migration
- ✅ Already planned in Phase 1.4

### 4.2 Notification Controller
**Controller:** `app/Http/Controllers/NotificationController.php` (NEW)
- **Method:** `index()` - Get all notifications for current user
- **Method:** `markAsRead($id)` - Mark notification as read
- **Method:** `markAllAsRead()` - Mark all as read
- **Method:** `getUnreadCount()` - Get count of unread notifications (AJAX)

**Routes:** `routes/web.php`
- `GET /notifications` → `NotificationController@index`
- `POST /notifications/{id}/read` → `NotificationController@markAsRead`
- `POST /notifications/read-all` → `NotificationController@markAllAsRead`
- `GET /notifications/unread-count` → `NotificationController@getUnreadCount`

### 4.3 Notification Service
**File:** `app/Services/NotificationService.php` (NEW)
- **Method:** `createLeaveStatusNotification($userId, $leaveRequestId, $status)`
  - Create notification when leave request status changes
- **Method:** `createNewRequestNotification($adminId, $leaveRequestId)`
  - Create notification for admin when new request is submitted

### 4.4 Update Views
- Add notification bell icon to topnav
- Add notification dropdown/modal
- Display unread count badge
- Update notification list when actions occur

---

## PHASE 5: Password Reset System Enhancement

### 5.1 Update ForgotPasswordController
**File:** `app/Http/Controllers/Auth/ForgotPasswordController.php`
- Currently resets password directly
- **Enhancement:** Generate reset token, store in password_resets table
- Send email with reset link (if email configured)
- Or show reset token to user

### 5.2 Password Reset Token Verification
- Create route to verify token
- Allow password reset with valid token
- Mark token as used after reset

---

## PHASE 6: Additional Features & Fixes

### 6.1 User Model Fixes
- Fix UserProfileController to use correct column names
- Ensure all controllers use `password_hash` instead of `password`

### 6.2 Edit User Functionality
**Controller:** `app/Http/Controllers/UserList/UserListController.php`
- **Method:** `update($id)` - Already exists, verify it works
- **Route:** Already exists, verify it works
- **View:** `resources/views/admin/edit-user.blade.php` - Verify form works

### 6.3 Superuser Functionality
- Verify superuser dashboard works (already functional)
- Verify admin creation works (already functional)
- Verify admin list works (already functional)

### 6.4 Validation & Error Handling
- Add proper validation messages
- Add error handling for database operations
- Add success/error flash messages
- Add form validation on frontend

### 6.5 Date Calculations
- Create helper/service for calculating business days
- Exclude weekends and holidays
- Use in leave request submission

---

## PHASE 7: Testing & Verification

### 7.1 Test Employee Functions
- ✅ Submit leave request
- ✅ View my requests
- ✅ View leave balance
- ✅ View dashboard with real data

### 7.2 Test Admin Functions
- ✅ View all requests
- ✅ Filter and search requests
- ✅ Approve request
- ✅ Reject request
- ✅ View dashboard with real data

### 7.3 Test Notifications
- ✅ Receive notification on request submission
- ✅ Receive notification on status change
- ✅ Mark as read
- ✅ View notification list

### 7.4 Test Authentication
- ✅ Login works
- ✅ Password reset works
- ✅ Forgot password works
- ✅ Session management works

---

## Implementation Order

1. **Phase 1** - Database & Models (Foundation)
2. **Phase 2** - Employee Functions (Core functionality)
3. **Phase 3** - Admin Functions (Core functionality)
4. **Phase 4** - Notifications (Enhancement)
5. **Phase 5** - Password Reset Enhancement (Enhancement)
6. **Phase 6** - Fixes & Polish
7. **Phase 7** - Testing

---

## Notes

- All migrations should be created with proper timestamps
- All foreign keys should have `onDelete('cascade')` where appropriate
- All controllers should validate user permissions (role, company)
- All views should handle empty states gracefully
- All forms should have CSRF protection
- All AJAX calls should handle errors properly
- Use Laravel's built-in validation
- Use Laravel's pagination for lists
- Follow Laravel naming conventions

---

## Files to Create/Modify Summary

### New Files (Controllers):
- `app/Http/Controllers/Employee/LeaveRequestController.php`
- `app/Http/Controllers/Employee/LeaveBalanceController.php`
- `app/Http/Controllers/Employee/EmployeeDashboardController.php`
- `app/Http/Controllers/Admin/AdminRequestController.php`
- `app/Http/Controllers/Admin/AdminDashboardController.php`
- `app/Http/Controllers/NotificationController.php`

### New Files (Models):
- `app/Models/LeaveRequest.php`
- `app/Models/AvailableLeave.php`
- `app/Models/Notification.php`
- `app/Models/PasswordReset.php` (optional)

### New Files (Services):
- `app/Services/NotificationService.php`

### New Files (Migrations):
- `database/migrations/YYYY_MM_DD_HHMMSS_create_leave_requests_table.php`
- `database/migrations/YYYY_MM_DD_HHMMSS_create_notifications_table.php`
- `database/migrations/YYYY_MM_DD_HHMMSS_create_password_resets_table.php`

### Files to Modify:
- `app/Models/User.php`
- `database/migrations/0001_01_01_000000_create_users_table.php`
- `database/migrations/2025_12_03_044255_create_available_leaves_table.php`
- `routes/web.php`
- `resources/views/employee/new-request.blade.php`
- `resources/views/employee/my-requests.blade.php`
- `resources/views/employee/leave-balance.blade.php`
- `resources/views/employee/emp_dashboard.blade.php`
- `resources/views/admin/requests.blade.php`
- `resources/views/admin/admin_dashboard.blade.php`
- `app/Http/Controllers/Auth/ForgotPasswordController.php` (optional enhancement)

---

## Estimated Implementation Time

- Phase 1: 2-3 hours
- Phase 2: 4-5 hours
- Phase 3: 4-5 hours
- Phase 4: 2-3 hours
- Phase 5: 1-2 hours
- Phase 6: 2-3 hours
- Phase 7: 2-3 hours

**Total: 17-24 hours**

---

**Ready to proceed with implementation?**

