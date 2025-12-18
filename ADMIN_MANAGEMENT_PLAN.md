# Admin Management Enhancement Plan

## Requirements:
1. ✅ Add Edit/Delete functionality for admins (similar to admin managing employees)
2. ✅ Update create admin form:
   - Change "Employee ID *" label to "Admin ID *"
   - Format should be ADM000 (like EMP000 for employees)
   - Email placeholder should be admin@company.com

---

## Phase 1: Update Create Admin Form

### 1.1 Update Form Labels and Placeholders
**File:** `resources/views/su/create_admin.blade.php`
- Change label from "Employee ID *" to "Admin ID *"
- Update placeholder to show format like "ADM001" or "ADM000"
- Update email placeholder to "admin@company.com"
- Update any help text or examples

### 1.2 Update JavaScript/Validation (if needed)
- Update any client-side validation messages
- Update any format hints or examples

---

## Phase 2: Create Admin Management Page

### 2.1 Update UserListController (or create new AdminManagementController)
**File:** `app/Http/Controllers/UserList/UserListController.php` OR
**File:** `app/Http/Controllers/Superuser/AdminManagementController.php` (NEW)

**Options:**
- **Option A:** Extend existing `UserListController` to handle admin management
- **Option B:** Create new `AdminManagementController` specifically for admin CRUD

**Recommended:** Extend `UserListController` since it already has some admin list functionality

**Methods needed:**
- `index()` - List all admins with search/filter
- `edit($id)` - Show edit form for admin
- `update($id)` - Update admin details
- `destroy($id)` - Delete admin (with validation)

### 2.2 Create Admin Management View
**File:** `resources/views/su/manage-admins.blade.php` (NEW)
- Similar structure to `admin/manage-employees.blade.php`
- Display list of admins with:
  - Admin ID
  - Name
  - Email
  - Company
  - Department
  - Actions (Edit, Delete buttons)
- Search and filter functionality
- Statistics (total admins, etc.)

### 2.3 Create Admin Edit View
**File:** `resources/views/su/edit-admin.blade.php` (NEW)
- Similar to `admin/edit-user.blade.php`
- Form fields:
  - Admin ID (read-only or editable?)
  - Email
  - First Name, Middle Name, Last Name
  - Department
  - Company (dropdown, read-only or editable?)
- Update button
- Cancel button

---

## Phase 3: Add Routes

### 3.1 Update Routes
**File:** `routes/web.php`
- Add route for manage admins page: `GET /superuser/manage-admins`
- Add route for edit admin: `GET /superuser/manage-admins/edit/{id}`
- Add route for update admin: `PUT /superuser/manage-admins/{id}`
- Add route for delete admin: `DELETE /superuser/manage-admins/{id}`

**Routes structure:**
```php
Route::prefix('superuser')->group(function () {
    // ... existing routes ...
    
    // Admin Management
    Route::get('/manage-admins', [UserListController::class, 'manageAdmins'])->name('su.manage_admins');
    Route::get('/manage-admins/edit/{id}', [UserListController::class, 'editAdmin'])->name('su.admin.edit');
    Route::put('/manage-admins/{id}', [UserListController::class, 'updateAdmin'])->name('su.admin.update');
    Route::delete('/manage-admins/{id}', [UserListController::class, 'destroyAdmin'])->name('su.admin.destroy');
});
```

---

## Phase 4: Update Sidebar Navigation

### 4.1 Add Manage Admins Link
**File:** `resources/views/layouts/sidebar.blade.php`
- Add "Manage Admins" menu item in superuser section
- Place it after "Admins List" or replace "Admins List" with "Manage Admins"
- Link to `route('su.manage_admins')`

**Sidebar Structure (Superuser):**
```
- Dashboard
- Create Admin
- Admins List (or Manage Admins)
- Create Company
```

---

## Phase 5: Update Controller Logic

### 5.1 Update UserListController Methods
**File:** `app/Http/Controllers/UserList/UserListController.php`

**New/Updated Methods:**

1. **`manageAdmins()`** - List all admins
   - Get all users with role 'admin'
   - Support search/filter
   - Return view with admins list

2. **`editAdmin($id)`** - Show edit form
   - Get admin by ID
   - Validate admin exists and is actually an admin
   - Get companies list for dropdown
   - Return edit form view

3. **`updateAdmin($id)`** - Update admin
   - Validate input (similar to create admin)
   - Update admin details
   - Handle AJAX and non-AJAX requests
   - Return success/error response

4. **`destroyAdmin($id)`** - Delete admin
   - Check if admin has pending leave requests
   - Check if admin has employees under them
   - Delete admin if safe
   - Return success/error response

### 5.2 Validation Rules
- Admin ID: Required, unique within company
- Email: Required, unique globally
- Name fields: Required
- Department: Required
- Company: Required (from dropdown)

---

## Phase 6: Update Admin List View (Optional)

### 6.1 Update Existing Admin List
**File:** `resources/views/su/admin-list.blade.php` (if exists)
- Add Edit/Delete buttons to each admin row
- Or redirect to new manage-admins page

---

## Implementation Order:

1. **Phase 1** - Update create admin form (labels, placeholders)
2. **Phase 2** - Create admin management views
3. **Phase 3** - Add routes
4. **Phase 4** - Update sidebar
5. **Phase 5** - Implement controller methods
6. **Phase 6** - Update existing admin list (if needed)

---

## Files to Create:

### New Files:
- `resources/views/su/manage-admins.blade.php`
- `resources/views/su/edit-admin.blade.php`

### Files to Modify:
- `resources/views/su/create_admin.blade.php` (labels, placeholders)
- `app/Http/Controllers/UserList/UserListController.php` (add methods)
- `routes/web.php` (add routes)
- `resources/views/layouts/sidebar.blade.php` (add menu item)
- `resources/views/su/admin-list.blade.php` (optional - add buttons)

---

## UI/UX Details:

### Create Admin Form:
- Label: "Admin ID *" (instead of "Employee ID *")
- Placeholder: "ADM001" or "ADM000"
- Email placeholder: "admin@company.com"

### Manage Admins Page:
- Table with columns: Admin ID, Name, Email, Company, Department, Actions
- Search bar
- Filter options (by company)
- Edit button (opens edit form)
- Delete button (with confirmation)
- Statistics at top (total admins, etc.)

### Edit Admin Form:
- Similar to create form but pre-filled
- Admin ID: Read-only or editable?
- Company: Dropdown (read-only or editable?)
- Update button
- Cancel button

---

## Validation Rules:

### When Editing Admin:
- Admin ID: Must be unique within company (unless unchanged)
- Email: Must be unique globally (unless unchanged)
- All other fields: Standard validation

### When Deleting Admin:
- Check for pending leave requests
- Check for employees under this admin's company
- Show warning if admin has associated data
- Allow deletion with confirmation

---

## Notes:

- Follow the same pattern as `ManageEmployeesController` for consistency
- Use AJAX for form submissions where appropriate
- Show success/error messages
- Handle edge cases (admin with employees, pending requests, etc.)
- Ensure proper authorization (only superuser can manage admins)


