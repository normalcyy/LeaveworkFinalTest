# Leave Request Count System - Implementation Plan

## Current System:
- Tracks **days** (total_requests = total days, submitted_requests = days used)
- Each leave request deducts the number of days from the balance
- Example: 10 vacation days = can take 10 days total (could be 1 request of 10 days, or 10 requests of 1 day each)

## New System Requirement:
- Track **number of leave requests** (not days)
- Each leave request counts as 1 request, regardless of how many days
- Example: 10 vacation requests = can take 10 separate leave periods (each can be 1 day, 5 days, 10 days, etc.)

---

## Phase 1: Database Schema Analysis & Update

### 1.1 Current Schema Review
**File:** `database/migrations/2025_12_03_044255_create_available_leaves_table.php`
- `total_requests` - Currently means "total days"
- `submitted_requests` - Currently means "days used"
- `remaining_requests` - Currently means "days remaining"

### 1.2 Schema Update Decision
**Option A:** Keep same column names, change meaning
- `total_requests` = number of leave requests allowed (not days)
- `submitted_requests` = number of leave requests used (not days)
- `remaining_requests` = number of leave requests remaining (not days)
- **Pros:** No migration needed
- **Cons:** Column names are misleading

**Option B:** Add new columns, keep old for migration
- Add: `total_leave_requests`, `used_leave_requests`, `remaining_leave_requests`
- Keep old columns for backward compatibility
- **Pros:** Clear naming
- **Cons:** More complex migration

**Option C:** Rename columns (recommended)
- Rename to: `total_leave_requests`, `used_leave_requests`, `remaining_leave_requests`
- **Pros:** Clear naming, clean schema
- **Cons:** Requires migration

**Recommended:** Option A (simplest, no migration needed) - just change the logic

### 1.3 Create Migration (if using Option C)
**File:** `database/migrations/YYYY_MM_DD_HHMMSS_update_available_leaves_to_request_count.php`
- Rename columns to reflect "request count" instead of "days"
- Or keep names, just update logic

---

## Phase 2: Update Leave Balance Logic

### 2.1 Update LeaveRequestController
**File:** `app/Http/Controllers/Employee/LeaveRequestController.php`

**Current Logic (in `store()` method):**
```php
// Currently calculates days between start_date and end_date
$days = $startDate->diffInDays($endDate) + 1;
// Deducts days from balance
```

**New Logic:**
```php
// Count as 1 request regardless of days
// Just increment submitted_requests by 1
// Decrement remaining_requests by 1
```

**Changes needed:**
- Remove day calculation logic
- Update balance: `submitted_requests += 1`, `remaining_requests -= 1`
- Keep `total_requests` unchanged

### 2.2 Update AdminRequestController
**File:** `app/Http/Controllers/Admin/AdminRequestController.php`

**Current Logic (in `approve()` and `reject()` methods):**
- Currently adjusts balance based on days
- Need to change to adjust by request count (1 request)

**Changes needed:**
- **Approve:** If status changes from pending to approved, increment submitted_requests by 1
- **Reject:** If status changes from pending to rejected, don't change balance (request was already counted)
- **Reject after approve:** If rejecting an approved request, decrement submitted_requests by 1, increment remaining_requests by 1

### 2.3 Update Leave Balance Calculation
**File:** `app/Http/Controllers/Employee/LeaveBalanceController.php`

**Current Logic:**
- Shows days remaining
- Need to change to show "requests remaining"

**Changes needed:**
- Update display to show "X requests remaining" instead of "X days remaining"
- Update labels and descriptions

---

## Phase 3: Update Leave Balance Creation

### 3.1 Update AddUserController
**File:** `app/Http/Controllers/Users/AddUserController.php`

**Current Logic (in `createLeaveBalance()` method):**
```php
$leaveTypes = [
    'vacation' => $request->input('vacation_leaves', 8),
    'sick' => $request->input('sick_leaves', 10),
    // ...
];
```

**New Logic:**
- Keep same default values, but they now mean "number of requests" not "days"
- Update comments/documentation
- Default values can stay the same (8 vacation requests, 10 sick requests, etc.)

---

## Phase 4: Update Views & UI

### 4.1 Update Leave Balance View
**File:** `resources/views/employee/leave-balance.blade.php`

**Changes needed:**
- Change labels from "Days" to "Requests"
- Update display: "X requests remaining" instead of "X days remaining"
- Update tooltips/help text
- Show: "Total Requests", "Used Requests", "Remaining Requests"

### 4.2 Update New Request Form
**File:** `resources/views/employee/new-request.blade.php`

**Changes needed:**
- Update help text to clarify: "Each leave request counts as 1 request, regardless of duration"
- Show remaining requests (not days)
- Update validation messages

### 4.3 Update My Requests View
**File:** `resources/views/employee/my-requests.blade.php`

**Changes needed:**
- Show duration in days (for information)
- But clarify that it counts as 1 request

### 4.4 Update Employee Dashboard
**File:** `resources/views/employee/emp_dashboard.blade.php`

**Changes needed:**
- Update leave balance display to show "requests" not "days"

### 4.5 Update Admin Views
**Files:** 
- `resources/views/admin/requests.blade.php`
- `resources/views/admin/admin_dashboard.blade.php`

**Changes needed:**
- Update terminology from "days" to "requests"
- Show request count information

---

## Phase 5: Update Validation Logic

### 5.1 Update Leave Request Validation
**File:** `app/Http/Controllers/Employee/LeaveRequestController.php`

**Current Validation:**
- Checks if remaining_requests >= days requested

**New Validation:**
- Check if remaining_requests >= 1 (at least 1 request available)
- Don't check days, just check if they have any requests left

**Changes:**
```php
// OLD:
if ($availableLeave->remaining_requests < $days) {
    // Error: Not enough days
}

// NEW:
if ($availableLeave->remaining_requests < 1) {
    // Error: No leave requests remaining
}
```

---

## Phase 6: Update Database Seeders (if any)

### 6.1 Check for Seeders
- Update any seeders that create initial leave balances
- Ensure they set "request count" values, not "days"

---

## Phase 7: Update Documentation/Comments

### 7.1 Update Code Comments
- Update all comments that mention "days" to "requests"
- Clarify that each request can be for any number of days

### 7.2 Update Model Comments
**File:** `app/Models/AvailableLeave.php`
- Update docblocks to clarify "request count" not "days"

---

## Implementation Order:

1. **Phase 2** - Update core logic (LeaveRequestController, AdminRequestController)
2. **Phase 5** - Update validation
3. **Phase 4** - Update all views/UI
4. **Phase 3** - Update leave balance creation
5. **Phase 7** - Update documentation

---

## Key Changes Summary:

### Database:
- **No schema changes needed** (just change how we interpret the columns)
- `total_requests` = number of leave requests allowed per year
- `submitted_requests` = number of leave requests used
- `remaining_requests` = number of leave requests remaining

### Logic Changes:
- **Submit Request:** Increment `submitted_requests` by 1, decrement `remaining_requests` by 1
- **Approve Request:** No balance change (already counted when submitted)
- **Reject Request:** If approved, restore 1 request; if pending, no change needed
- **Validation:** Check `remaining_requests >= 1` (not checking days)

### UI Changes:
- All labels: "Days" → "Requests"
- Display: "X requests remaining" instead of "X days remaining"
- Help text: "Each leave request counts as 1 request, regardless of duration"

---

## Example Scenarios:

### Scenario 1: Employee has 10 vacation requests
- Can take 10 separate leave periods
- Each can be 1 day, 5 days, 10 days, etc.
- After 10 requests, no more vacation leave available

### Scenario 2: Employee submits 1 request for 5 days
- Uses 1 vacation request
- Remaining: 9 vacation requests
- Can still take 9 more leave periods (any duration)

### Scenario 3: Employee submits 1 request for 1 day
- Uses 1 vacation request
- Remaining: 9 vacation requests
- Same as above - duration doesn't matter

---

## Files to Modify:

### Controllers:
- `app/Http/Controllers/Employee/LeaveRequestController.php`
- `app/Http/Controllers/Admin/AdminRequestController.php`
- `app/Http/Controllers/Employee/LeaveBalanceController.php`
- `app/Http/Controllers/Users/AddUserController.php`

### Views:
- `resources/views/employee/leave-balance.blade.php`
- `resources/views/employee/new-request.blade.php`
- `resources/views/employee/my-requests.blade.php`
- `resources/views/employee/emp_dashboard.blade.php`
- `resources/views/admin/requests.blade.php`
- `resources/views/admin/admin_dashboard.blade.php`

### Models:
- `app/Models/AvailableLeave.php` (update comments)

---

## Testing Checklist:

- [ ] Submit leave request (1 day) - uses 1 request
- [ ] Submit leave request (10 days) - uses 1 request
- [ ] Check remaining requests after submission
- [ ] Approve request - balance unchanged
- [ ] Reject pending request - balance unchanged
- [ ] Reject approved request - balance restored (+1 request)
- [ ] Validation: Can't submit if remaining_requests < 1
- [ ] UI shows "requests" not "days"
- [ ] Dashboard displays correctly

---

## Notes:

- **No migration needed** if we keep column names (just change logic)
- Duration (days) is still stored in `leave_requests` table for reference
- Each leave type (vacation, sick, personal, emergency) works independently
- Year-based tracking remains the same


