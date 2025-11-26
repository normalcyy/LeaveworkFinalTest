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

/* Body */
body {
  margin: 0;
  font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
  color: var(--primary);
  background-color: var(--light);
  display: flex;
  min-height: 100vh;
}

/* Sidebar */
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

/* Main Content */
.main-content {
  flex: 1;
  margin-left: 240px;
  padding: 2rem;
  transition: margin-left 0.3s ease;
}

/* Topnav */
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

/* Content Wrapper */
.content-wrapper { 
  max-width: 900px; 
  width: 100%; 
  margin: 0 auto; 
}

/* Page Header */
.dashboard-header {
  text-align: center;
  margin-bottom: 2.5rem;
}
.dashboard-header h2 { 
  font-size: 2rem; 
  font-weight: 700; 
  margin: 0;
}
.dashboard-header p { 
  color: var(--secondary); 
  margin: 0.5rem 0 0 0;
}

/* Form Card */
.form-card {
  background: #fff;
  border-radius: var(--radius);
  padding: 2.5rem;
  box-shadow: var(--shadow-light);
}

/* Section Headers */
.section-header {
  display: flex;
  align-items: center;
  gap: 0.75rem;
  margin-bottom: 1.5rem;
  padding-bottom: 0.75rem;
  border-bottom: 2px solid var(--light);
}
.section-icon {
  font-size: 1.5rem;
}
.section-title {
  font-size: 1.1rem;
  font-weight: 600;
  color: var(--primary);
  margin: 0;
}

/* Form Groups */
.form-group {
  margin-bottom: 1.5rem;
}

.form-label {
  display: block;
  font-weight: 600;
  color: var(--primary);
  margin-bottom: 0.5rem;
  font-size: 0.95rem;
}

.form-label .required {
  color: var(--danger);
  margin-left: 0.25rem;
}

.form-control, .form-select {
  width: 100%;
  padding: 0.875rem 1rem;
  border: 2px solid var(--accent);
  border-radius: var(--radius);
  font-size: 0.95rem;
  transition: var(--transition);
  background: #fff;
  color: var(--primary);
}

.form-control:focus, .form-select:focus {
  outline: none;
  border-color: var(--primary);
  box-shadow: 0 0 0 3px rgba(25, 24, 59, 0.1);
}

.form-control::placeholder {
  color: var(--secondary);
  opacity: 0.6;
}

/* Two Column Grid */
.form-row {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 1.5rem;
}

/* Radio Group */
.radio-group {
  display: flex;
  gap: 1.5rem;
  margin-top: 0.5rem;
}

.radio-option {
  display: flex;
  align-items: center;
  gap: 0.5rem;
}

.radio-option input[type="radio"] {
  width: 18px;
  height: 18px;
  cursor: pointer;
  accent-color: var(--primary);
}

.radio-option label {
  cursor: pointer;
  font-weight: 500;
  color: var(--primary);
}

/* Profile Picture Upload */
.profile-upload {
  display: flex;
  align-items: center;
  gap: 1.5rem;
}

.profile-preview {
  width: 100px;
  height: 100px;
  border-radius: 50%;
  background: var(--light);
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 2.5rem;
  color: var(--secondary);
  border: 3px solid var(--accent);
}

.upload-btn {
  background: var(--accent);
  color: var(--primary);
  padding: 0.75rem 1.5rem;
  border-radius: var(--radius);
  border: none;
  font-weight: 600;
  cursor: pointer;
  transition: var(--transition);
}

.upload-btn:hover {
  background: var(--primary);
  color: #fff;
  transform: translateY(-2px);
}

.upload-info {
  font-size: 0.85rem;
  color: var(--secondary);
  margin-top: 0.5rem;
}

/* Action Buttons */
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

/* Helper Text */
.helper-text {
  font-size: 0.85rem;
  color: var(--secondary);
  margin-top: 0.4rem;
}

/* Success Message */
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

/* Responsive */
@media(max-width: 992px) {
  #sidebar { transform: translateX(-100%); }
  .main-content { margin-left: 0; padding: 1rem; }
}

@media(max-width: 768px) {
  .form-row {
    grid-template-columns: 1fr;
  }
  .form-card {
    padding: 1.5rem;
  }
  .form-actions {
    flex-direction: column;
  }
  .profile-upload {
    flex-direction: column;
    text-align: center;
  }
}
</style>
</head>
<body>

<!-- Sidebar -->
@include('layouts.sidebar')

<!-- Main Content -->
<div class="main-content" id="mainContent">
  @include('layouts.topnav')

  <div class="content-wrapper">
    
    <!-- Page Header -->
    <div class="dashboard-header">
      <h2>Add New User</h2>
      <p>Create a new employee account in the system</p>
    </div>

    <!-- Success Message -->
    <div class="success-message" id="successMessage">
      <span>✅</span>
      <span>User added successfully!</span>
    </div>

    <!-- Form Card -->
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
            <label class="form-label">Last Name<span class="required">*</span></label>
            <input type="text" name="last_name" class="form-control" placeholder="Enter last name" required>
          </div>
        </div>

        <div class="form-group">
          <label class="form-label">Email Address<span class="required">*</span></label>
          <input type="email" name="email" class="form-control" placeholder="employee@company.com" required>
          <p class="helper-text">This will be used for login and communication</p>
        </div>

        <div class="form-row">
          <div class="form-group">
            <label class="form-label">Phone Number</label>
            <input type="tel" name="phone" class="form-control" placeholder="+63 912 345 6789">
          </div>
          <div class="form-group">
            <label class="form-label">Date of Birth</label>
            <input type="date" name="date_of_birth" class="form-control">
          </div>
        </div>

        <div class="form-group">
          <label class="form-label">Gender</label>
          <div class="radio-group">
            <div class="radio-option">
              <input type="radio" id="male" name="gender" value="male">
              <label for="male">Male</label>
            </div>
            <div class="radio-option">
              <input type="radio" id="female" name="gender" value="female">
              <label for="female">Female</label>
            </div>
            <div class="radio-option">
              <input type="radio" id="other" name="gender" value="other">
              <label for="other">Other</label>
            </div>
          </div>
        </div>

        <!-- Employment Information Section -->
        <div class="section-header" style="margin-top: 2.5rem;">
          <span class="section-icon">💼</span>
          <h3 class="section-title">Employment Information</h3>
        </div>

        <div class="form-row">
          <div class="form-group">
            <label class="form-label">Department<span class="required">*</span></label>
            <select name="department" class="form-select" required>
              <option value="">Select Department</option>
              <option value="engineering">Engineering</option>
              <option value="marketing">Marketing</option>
              <option value="sales">Sales</option>
              <option value="hr">Human Resources</option>
              <option value="finance">Finance</option>
              <option value="design">Design</option>
              <option value="operations">Operations</option>
            </select>
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
          <div class="form-group">
            <label class="form-label">Join Date<span class="required">*</span></label>
            <input type="date" name="join_date" class="form-control" required>
          </div>
        </div>

        <div class="form-row">
          <div class="form-group">
            <label class="form-label">Employment Type<span class="required">*</span></label>
            <select name="employment_type" class="form-select" required>
              <option value="">Select Type</option>
              <option value="full-time">Full-Time</option>
              <option value="part-time">Part-Time</option>
              <option value="contract">Contract</option>
              <option value="intern">Intern</option>
            </select>
          </div>
          <div class="form-group">
            <label class="form-label">Role<span class="required">*</span></label>
            <select name="role" class="form-select" required>
              <option value="">Select Role</option>
              <option value="employee">Employee</option>
              <option value="manager">Manager</option>
              <option value="admin">Admin</option>
            </select>
          </div>
        </div>

        <!-- Account Settings Section -->
        <div class="section-header" style="margin-top: 2.5rem;">
          <span class="section-icon">🔐</span>
          <h3 class="section-title">Account Settings</h3>
        </div>

        <div class="form-row">
          <div class="form-group">
            <label class="form-label">Password<span class="required">*</span></label>
            <input type="password" name="password" class="form-control" placeholder="Enter password" required>
            <p class="helper-text">Minimum 8 characters</p>
          </div>
          <div class="form-group">
            <label class="form-label">Confirm Password<span class="required">*</span></label>
            <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm password" required>
          </div>
        </div>

        <!-- Profile Picture Section -->
        <div class="section-header" style="margin-top: 2.5rem;">
          <span class="section-icon">📸</span>
          <h3 class="section-title">Profile Picture</h3>
        </div>

        <div class="form-group">
          <div class="profile-upload">
            <div class="profile-preview" id="profilePreview">
              👤
            </div>
            <div>
              <input type="file" name="profile_picture" id="profilePicture" accept="image/*" style="display: none;">
              <button type="button" class="upload-btn" onclick="document.getElementById('profilePicture').click()">
                Choose Photo
              </button>
              <p class="upload-info">JPG, PNG or GIF (Max 2MB)</p>
            </div>
          </div>
        </div>

        <!-- Form Actions -->
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

// Profile Picture Preview
document.getElementById('profilePicture')?.addEventListener('change', function(e) {
  const file = e.target.files[0];
  if (file) {
    const reader = new FileReader();
    reader.onload = function(event) {
      const preview = document.getElementById('profilePreview');
      preview.style.backgroundImage = `url(${event.target.result})`;
      preview.style.backgroundSize = 'cover';
      preview.style.backgroundPosition = 'center';
      preview.textContent = '';
    };
    reader.readAsDataURL(file);
  }
});

// Form Validation
document.getElementById('addUserForm')?.addEventListener('submit', function(e) {
  e.preventDefault();
  
  // Password matching validation
  const password = document.querySelector('input[name="password"]').value;
  const confirmPassword = document.querySelector('input[name="password_confirmation"]').value;
  
  if (password !== confirmPassword) {
    alert('Passwords do not match!');
    return;
  }
  
  if (password.length < 8) {
    alert('Password must be at least 8 characters long!');
    return;
  }
  
  // Show success message (in production, this would be after server response)
  const successMessage = document.getElementById('successMessage');
  successMessage.style.display = 'flex';
  
  // Scroll to top
  window.scrollTo({ top: 0, behavior: 'smooth' });
  
  // Reset form after 2 seconds
  setTimeout(() => {
    this.reset();
    document.getElementById('profilePreview').style.backgroundImage = '';
    document.getElementById('profilePreview').textContent = '👤';
    successMessage.style.display = 'none';
  }, 2000);
  
  // In production, uncomment this to actually submit:
  // this.submit();
});

// Auto-hide success message after 5 seconds
setTimeout(() => {
  const successMessage = document.getElementById('successMessage');
  if (successMessage.style.display === 'flex') {
    successMessage.style.display = 'none';
  }
}, 5000);
</script>

</body>
</html>