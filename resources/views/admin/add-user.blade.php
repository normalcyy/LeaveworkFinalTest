<!-- resources/views/admin/add_user.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Admin | Add User | LeaveWork</title>
<link rel="icon" type="image/png" href="{{ asset('assets/leavework_logo.png') }}">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
:root {
  --primary: #19183B;
  --secondary: #708993;
  --accent: #A1C2BD;
  --light: #E7F2EF;
  --success: #10b981;
  --danger: #ef4444;
  --radius: 14px;
  --shadow-light: 0 4px 15px rgba(25,24,59,0.06);
  --shadow-hover: 0 6px 20px rgba(25,24,59,0.12);
  --transition: 0.25s ease;
}

body {
  margin: 0;
  font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
  color: var(--primary);
  background-color: var(--light);
  display: flex;
  min-height: 100vh;
}

#sidebar {
  width: 240px;
  background: #fff;
  border-right: 1px solid var(--accent);
  position: fixed;
  top: 0;
  left: 0;
  height: 100vh;
  padding: 2rem 1.5rem;
  overflow-y: auto;
  transition: transform 0.3s ease;
  z-index: 1000;
}
#sidebar.d-none { transform: translateX(-100%); }

.main-content {
  flex: 1;
  margin-left: 240px;
  padding: 2rem;
  transition: margin-left 0.3s ease;
}

.topnav {
  display: flex;
  justify-content: space-between;
  align-items: center;
  background: #fff;
  padding: 1rem 1.5rem;
  border-radius: var(--radius);
  box-shadow: var(--shadow-light);
  margin-bottom: 2rem;
}
.topnav h4 { margin: 0; font-weight: 600; font-size: 1.3rem; }
.btn-toggle {
  background: var(--primary);
  color: #fff;
  padding: 0.5rem 1rem;
  border-radius: var(--radius);
  border: none;
  font-weight: 600;
  cursor: pointer;
  transition: var(--transition);
}
.btn-toggle:hover { background: var(--secondary); }

.content-wrapper { 
  max-width: 900px; 
  width: 100%; 
  margin: 0 auto; 
}

.dashboard-header {
  text-align: center;
  margin-bottom: 2.5rem;
}
.dashboard-header h2 { font-size: 2rem; font-weight: 700; margin: 0; }
.dashboard-header p { color: var(--secondary); margin: 0.5rem 0 0 0; }

.form-card {
  background: #fff;
  border-radius: var(--radius);
  padding: 2.5rem;
  box-shadow: var(--shadow-light);
}

.section-header {
  display: flex;
  align-items: center;
  gap: 0.75rem;
  margin-bottom: 1.5rem;
  padding-bottom: 0.75rem;
  border-bottom: 2px solid var(--light);
}
.section-icon { font-size: 1.5rem; }
.section-title { font-size: 1.1rem; font-weight: 600; color: var(--primary); margin: 0; }

.form-group { margin-bottom: 1.5rem; }

.form-label {
  display: block;
  font-weight: 600;
  color: var(--primary);
  margin-bottom: 0.5rem;
  font-size: 0.95rem;
}

.form-label .required { color: var(--danger); margin-left: 0.25rem; }

.form-control { 
  width: 100%; 
  padding: 0.875rem 1rem; 
  border: 2px solid var(--accent); 
  border-radius: var(--radius); 
  font-size: 0.95rem; 
  transition: var(--transition); 
  background: #fff; 
  color: var(--primary);
}

.form-control:focus {
  outline: none;
  border-color: var(--primary);
  box-shadow: 0 0 0 3px rgba(25, 24, 59, 0.1);
}

.form-control::placeholder { color: var(--secondary); opacity: 0.6; }

.form-row {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 1.5rem;
}

.form-actions {
  display: flex;
  gap: 1rem;
  margin-top: 2.5rem;
  padding-top: 1.5rem;
  border-top: 2px solid var(--light);
}

.btn-submit {
  flex: 1;
  background: var(--primary);
  color: #fff;
  padding: 1rem 2rem;
  border-radius: var(--radius);
  border: none;
  font-weight: 600;
  font-size: 1rem;
  cursor: pointer;
  transition: var(--transition);
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 0.5rem;
}
.btn-submit:hover {
  background: var(--secondary);
  transform: translateY(-2px);
  box-shadow: var(--shadow-hover);
}

.btn-cancel {
  flex: 1;
  background: #fff;
  color: var(--primary);
  padding: 1rem 2rem;
  border-radius: var(--radius);
  border: 2px solid var(--accent);
  font-weight: 600;
  font-size: 1rem;
  cursor: pointer;
  transition: var(--transition);
}
.btn-cancel:hover {
  background: var(--light);
  border-color: var(--primary);
}

.helper-text {
  font-size: 0.85rem;
  color: var(--secondary);
  margin-top: 0.4rem;
}

.success-message {
  background: #d1fae5;
  color: #065f46;
  padding: 1rem 1.5rem;
  border-radius: var(--radius);
  margin-bottom: 1.5rem;
  display: none;
  align-items: center;
  gap: 0.75rem;
  font-weight: 500;
}

@media(max-width: 992px) {
  #sidebar { transform: translateX(-100%); }
  .main-content { margin-left: 0; padding: 1rem; }
}

@media(max-width: 768px) {
  .form-row { grid-template-columns: 1fr; }
  .form-card { padding: 1.5rem; }
  .form-actions { flex-direction: column; }
}
</style>
</head>
<body>

@include('layouts.sidebar')

<div class="main-content" id="mainContent">
  @include('layouts.topnav')

  <div class="content-wrapper">

    <div class="dashboard-header">
      <h2>Add New User</h2>
      <p>Create a new employee account in the system</p>
    </div>

    <div class="success-message" id="successMessage">
      <span>✅</span>
      <span>User added successfully!</span>
    </div>

    <div class="form-card">
      <form id="addUserForm" action="{{ route('admin.store-user') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- Personal Information Section -->
        <div class="section-header">
          <span class="section-icon">👤</span>
          <h3 class="section-title">Personal Information</h3>
        </div>

        <div class="form-row">
          <div class="form-group">
            <label class="form-label">First Name<span class="required">*</span></label>
            <input type="text" name="first_name" class="form-control" placeholder="Enter first name" required>
          </div>
          <div class="form-group">
            <label class="form-label">Middle Name (Optional)</label>
            <input type="text" name="middle_name" class="form-control" placeholder="Enter middle name">
          </div>
        </div>

        <div class="form-row">
          <div class="form-group">
            <label class="form-label">Last Name<span class="required">*</span></label>
            <input type="text" name="last_name" class="form-control" placeholder="Enter last name" required>
          </div>
          <div class="form-group">
            <label class="form-label">Email Address<span class="required">*</span></label>
            <input type="email" name="email" class="form-control" placeholder="employee@company.com" required>
            <p class="helper-text">This will be used for login and communication</p>
          </div>
        </div>

        <div class="form-group">
          <label class="form-label">Phone Number</label>
          <input type="tel" name="phone" class="form-control" placeholder="+63 912 345 6789">
        </div>

        <!-- Employee Information Section -->
        <div class="section-header" style="margin-top: 2.5rem;">
          <span class="section-icon">💼</span>
          <h3 class="section-title">Employee Information</h3>
        </div>

        <div class="form-row">
          <div class="form-group">
            <label class="form-label">Department<span class="required">*</span></label>
            <input type="text" name="department" class="form-control" placeholder="Enter department" required>
          </div>
          <div class="form-group">
            <label class="form-label">Position<span class="required">*</span></label>
            <input type="text" name="position" class="form-control" placeholder="e.g., Senior Developer" required>
          </div>
        </div>

        <div class="form-row">
          <div class="form-group">
            <label class="form-label">Employee ID</label>
            <input type="text" name="employee_id" class="form-control" placeholder="Auto-generated if empty">
            <p class="helper-text">Leave blank to auto-generate</p>
          </div>
        </div>

        <div class="form-actions">
          <button type="button" class="btn-cancel" onclick="window.history.back()">
            Cancel
          </button>
          <button type="submit" class="btn-submit">
            <span>➕</span>
            <span>Add User</span>
          </button>
        </div>

      </form>
    </div>

  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
// Sidebar Toggle
const toggleBtn = document.getElementById('sidebarToggle');
const sidebar = document.getElementById('sidebar');
const mainContent = document.getElementById('mainContent');

toggleBtn?.addEventListener('click', () => {
  sidebar.classList.toggle('d-none');
  mainContent.style.marginLeft = sidebar.classList.contains('d-none') ? '0' : '240px';
});

// Form Validation
document.getElementById('addUserForm')?.addEventListener('submit', function(e) {
  e.preventDefault();

  const successMessage = document.getElementById('successMessage');
  successMessage.style.display = 'flex';
  window.scrollTo({ top: 0, behavior: 'smooth' });

  setTimeout(() => {
    this.reset();
    successMessage.style.display = 'none';
  }, 2000);

  // Uncomment for production
  // this.submit();
});

setTimeout(() => {
  const successMessage = document.getElementById('successMessage');
  if (successMessage.style.display === 'flex') {
    successMessage.style.display = 'none';
  }
}, 5000);
</script>

</body>
</html>
