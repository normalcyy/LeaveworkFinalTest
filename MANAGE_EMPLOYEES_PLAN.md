# Implementation Plan - Manage Employees Screen

## Current Issues:
1. ❌ Hardcoded employee data (temporary data shown instead of database)
2. ❌ "Add New Employee" button not working
3. ❌ Edit button not working
4. ❌ Delete button not working

## Implementation Plan:

### Phase 1: Create Controller & Update Route
**File:** `app/Http/Controllers/Admin/ManageEmployeesController.php` (NEW)
- Create new controller for managing employees
- Method: `index()` - Get all employees from database for admin's company
- Method: `destroy($id)` - Delete employee with confirmation
- Method: `getStats()` - Get employee statistics (total, active, on leave, etc.)

**File:** `routes/web.php`
- Update route: `Route::get('/manage-employees', [ManageEmployeesController::class, 'index'])`

### Phase 2: Replace Hardcoded Data with Real Data
**File:** `resources/views/admin/manage-employees.blade.php`
- Replace hardcoded `$employees` array with real data from controller
- Update stats cards with real counts from database
- Display: Employee ID, Name, Email, Department, Position, Join Date
- Add pagination if needed
- Update search functionality to work with real data

### Phase 3: Fix "Add New Employee" Button
**File:** `resources/views/admin/manage-employees.blade.php`
- Change button from `<button>` to `<a>` tag
- Link to: `{{ route('admin.add_user') }}`
- Or use JavaScript to redirect

### Phase 4: Implement Edit Functionality
**File:** `app/Http/Controllers/Admin/ManageEmployeesController.php`
- Method: `edit($id)` - Show edit form (can reuse existing edit-user view)
- Method: `update($id)` - Update employee data
- Verify employee belongs to admin's company before allowing edit

**File:** `resources/views/admin/manage-employees.blade.php`
- Update Edit button to link to edit route: `route('admin.employees.edit', $employee->id)`
- Or use JavaScript to open modal/form

**File:** `resources/views/admin/edit-user.blade.php`
- Verify this view exists and works for editing employees
- If not, create/edit it to match the add-user form structure

**File:** `routes/web.php`
- Add routes:
  - `Route::get('/employees/{id}/edit', [ManageEmployeesController::class, 'edit'])`
  - `Route::put('/employees/{id}', [ManageEmployeesController::class, 'update'])`

### Phase 5: Implement Delete Functionality
**File:** `app/Http/Controllers/Admin/ManageEmployeesController.php`
- Method: `destroy($id)` - Delete employee
- Verify employee belongs to admin's company
- Check if employee has pending leave requests (optional: prevent deletion if active requests)
- Delete related records (available_leaves, leave_requests, notifications)
- Return success/error response

**File:** `resources/views/admin/manage-employees.blade.php`
- Add JavaScript confirmation dialog for delete
- Make delete button call delete route via AJAX or form submission
- Show success/error message after deletion
- Refresh table after successful deletion

**File:** `routes/web.php`
- Add route: `Route::delete('/employees/{id}', [ManageEmployeesController::class, 'destroy'])`

### Phase 6: Enhancements
- Add employee status (Active/Inactive) - may need to add status column to users table or calculate from leave requests
- Improve search functionality (server-side search)
- Add filters (by department, position, etc.)
- Add pagination
- Add success/error flash messages

---

## Implementation Order:

1. **Create ManageEmployeesController** with index method
2. **Update route** to use controller
3. **Replace hardcoded data** in view with real data
4. **Fix Add New Employee button** (simple link fix)
5. **Implement Edit functionality** (controller methods + routes + view update)
6. **Implement Delete functionality** (controller method + route + JavaScript confirmation)
7. **Test all functionality**

---

## Files to Create/Modify:

### New Files:
- `app/Http/Controllers/Admin/ManageEmployeesController.php`

### Files to Modify:
- `routes/web.php` - Add new routes
- `resources/views/admin/manage-employees.blade.php` - Replace data, fix buttons, add functionality
- `resources/views/admin/edit-user.blade.php` - Verify/update for employee editing

---

## Database Considerations:

- Employees are filtered by `company` (admin can only see employees from their company)
- When deleting employee, consider:
  - Cascade delete for related records (available_leaves, leave_requests, notifications)
  - Or soft delete (add deleted_at column)
  - Check for pending leave requests before deletion

---

## Security Considerations:

- Verify admin has permission to edit/delete (same company check)
- Use CSRF protection for all forms
- Validate all input data
- Prevent admin from deleting themselves


