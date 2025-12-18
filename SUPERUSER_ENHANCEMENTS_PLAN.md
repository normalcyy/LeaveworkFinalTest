# Superuser Enhancements Implementation Plan

## Requirements Summary:
1. ✅ Create 4th dashboard for superuser showing registered companies
2. ✅ Company dropdown when creating admins (instead of text input)
3. ✅ Auto-set role (admin for superuser creating admin, employee for admin creating employee)
4. ✅ Clean up users - only keep admin@test.com and emp2@test.com
5. ✅ Remove role input field from all forms (auto-determined)

---

## Phase 1: Superuser Dashboard - Companies View

### 1.1 Update SUDashboardController
**File:** `app/Http/Controllers/Superuser/SUDashboardController.php`
- Add method: `getCompaniesList()` - Get all unique companies with stats
- Update `index()` method to pass companies list to view
- Get company statistics:
  - Company name
  - Number of admins per company
  - Number of employees per company
  - Total users per company

### 1.2 Update Superuser Dashboard View
**File:** `resources/views/SU/su_dashboard.blade.php`
- Add new section showing companies table/list
- Display: Company Name, Admins Count, Employees Count, Total Users
- Add styling for companies display
- Show "No companies" message if empty

---

## Phase 2: Company Dropdown for Admin Creation

### 2.1 Update AddUserController
**File:** `app/Http/Controllers/Users/AddUserController.php`
- Add method: `getCompanies()` - Get all unique companies for dropdown
- This can be a route that returns JSON or passed to view

### 2.2 Update Create Admin View
**File:** `resources/views/su/create_admin.blade.php`
- Change company input from text field to dropdown/select
- Populate dropdown with existing companies from database
- Add "Add New Company" option or allow typing new company name
- Remove role input field (auto-set to 'admin' for superuser)

### 2.3 Update Add User View (Admin creating employee)
**File:** `resources/views/admin/add-user.blade.php`
- Remove role input field (auto-set to 'employee' for admin)
- Company is already auto-set from admin's company (no change needed)

---

## Phase 3: Auto-Set Role Throughout System

### 3.1 Update AddUserController
**File:** `app/Http/Controllers/Users/AddUserController.php`
- In `prepareUserData()` method:
  - If current user is superuser → role = 'admin' (no need to check request)
  - If current user is admin → role = 'employee' (no need to check request)
- Remove any role validation/input from request

### 3.2 Update All User Creation Forms
**Files to update:**
- `resources/views/su/create_admin.blade.php` - Remove role field
- `resources/views/admin/add-user.blade.php` - Remove role field (if exists)
- Any other forms that create users

### 3.3 Update Validation
**File:** `app/Http/Controllers/Users/AddUserController.php`
- Remove role from validation rules
- Role is determined automatically based on current user's role

---

## Phase 4: Clean Up Users Database

### 4.1 Create Migration/Seeder to Clean Users
**File:** `database/seeders/CleanUsersSeeder.php` (NEW)
- Delete all users except:
  - admin@test.com (role: admin)
  - emp2@test.com (role: employee) - CREATE if doesn't exist
  - su@test.com (role: superuser) - Keep superuser
- Set proper company for admin and employee
- Create leave balances for emp2@test.com if needed

### 4.2 Update Initial Users Migration (Optional)
**File:** `database/migrations/0001_01_01_000000_create_users_table.php`
- Update seed data to only include:
  - admin@test.com (admin)
  - emp2@test.com (employee) - if not exists, create
  - su@test.com (superuser)

---

## Phase 5: Update Routes & Controllers

### 5.1 Add Company List Route (if needed)
**File:** `routes/web.php`
- Add route: `GET /superuser/companies` - Get companies list (AJAX if needed)

### 5.2 Update Create Admin Route
**File:** `routes/web.php`
- Ensure route passes companies list to view

---

## Implementation Order:

1. **Phase 4** - Clean up users first (so we have clean data to work with)
2. **Phase 3** - Auto-set role (simplifies forms)
3. **Phase 2** - Company dropdown (improves UX)
4. **Phase 1** - Companies dashboard (enhancement)

---

## Files to Create/Modify:

### New Files:
- `database/seeders/CleanUsersSeeder.php`

### Files to Modify:
- `app/Http/Controllers/Superuser/SUDashboardController.php`
- `app/Http/Controllers/Users/AddUserController.php`
- `resources/views/SU/su_dashboard.blade.php`
- `resources/views/su/create_admin.blade.php`
- `resources/views/admin/add-user.blade.php`
- `routes/web.php` (if needed)

---

## Database Changes:

### Users to Keep:
- **Superuser:** su@test.com (role: superuser)
- **Admin:** admin@test.com (role: admin, company: UC or your choice)
- **Employee:** emp2@test.com (role: employee, company: same as admin)

### Users to Delete:
- All other users in the database

---

## Notes:

- Company dropdown should show existing companies from users table
- If no companies exist, allow creating first company
- Role is completely automatic - no user input needed
- All forms should be simplified (remove role field)
- Clean database before testing to ensure clean state

---

## Testing Checklist:

- [ ] Superuser dashboard shows companies list
- [ ] Creating admin shows company dropdown
- [ ] Role is automatically set (no input needed)
- [ ] Only admin@test.com and emp2@test.com exist (plus superuser)
- [ ] All user creation forms work without role field
- [ ] Company dropdown populates correctly


