<!-- resources/views/superuser/profile.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Superuser Profile | LeaveWork</title>
<link rel="icon" type="image/png" href="{{ asset('assets/leavework_logo.png') }}">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
:root {
  --primary: #19183B;
  --secondary: #708993;
  --accent: #A1C2BD;
  --light: #E7F2EF;
  --success: #10b981;
  --danger: #ef4444;
  --card-bg: #fff;
  --text-dark: var(--primary);
  --text-muted: var(--secondary);
  --border-color: var(--accent);
  --hover-bg: #f1f5f9;
  --shadow: 0 4px 20px rgba(25, 24, 59, 0.08);
  --shadow-hover: 0 8px 30px rgba(25, 24, 59, 0.12);
}

/* Body */
body {
  margin: 0;
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  color: var(--text-dark);
  background: linear-gradient(135deg, var(--light) 0%, #f0f7f5 100%);
  display: flex;
  min-height: 100vh;
}

/* Sidebar */
#sidebar {
  width: 250px;
  min-height: 100vh;
  background-color: #fff;
  border-end: 1px solid var(--accent);
  padding: 1.5rem;
  position: fixed;
  top: 0;
  left: 0;
  overflow-y: auto;
  transition: transform 0.3s ease;
  z-index: 1000;
  box-shadow: var(--shadow);
}
#sidebar.d-none { transform: translateX(-100%); }

/* Main Content */
.main-content {
  flex: 1;
  margin-left: 250px;
  transition: margin-left 0.3s ease;
  display: flex;
  flex-direction: column;
  padding: 2rem;
}

/* Topnav */
.topnav {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 2rem;
  background-color: #fff;
  padding: 1rem 1.5rem;
  border-radius: 16px;
  box-shadow: var(--shadow);
}
.topnav h4 { 
  margin: 0; 
  font-weight: 700; 
  color: var(--primary);
  font-size: 1.5rem;
}
.topnav .btn-toggle {
  background: linear-gradient(135deg, var(--primary) 0%, #2a2860 100%);
  color: #fff;
  border: none;
  padding: 0.75rem 1.25rem;
  border-radius: 12px;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.3s ease;
  display: flex;
  align-items: center;
  gap: 0.5rem;
  box-shadow: 0 4px 12px rgba(25, 24, 59, 0.2);
}
.topnav .btn-toggle:hover { 
  transform: translateY(-2px);
  box-shadow: 0 6px 16px rgba(25, 24, 59, 0.3);
}

/* Content Wrapper */
.content-wrapper { 
  max-width: 1400px; 
  width: 100%; 
  margin: 0 auto; 
}

/* Profile Header */
.profile-header-card {
  background: linear-gradient(135deg, var(--primary) 0%, #2a2860 100%);
  color: white;
  border-radius: 20px;
  padding: 2.5rem;
  display: flex;
  gap: 2rem;
  align-items: center;
  margin-bottom: 2.5rem;
  box-shadow: var(--shadow);
  position: relative;
  overflow: hidden;
}
.profile-header-card::before {
  content: '';
  position: absolute;
  top: 0;
  right: 0;
  width: 150px;
  height: 150px;
  background: rgba(255, 255, 255, 0.05);
  border-radius: 50%;
  transform: translate(30%, -30%);
}
.profile-avatar {
  width: 120px;
  height: 120px;
  border-radius: 50%;
  background: var(--card-bg);
  display: flex;
  justify-content: center;
  align-items: center;
  font-size: 2.5rem;
  color: var(--primary);
  font-weight: 700;
  box-shadow: 0 8px 25px rgba(0,0,0,0.15);
  z-index: 1;
  transition: transform 0.3s ease;
}
.profile-avatar:hover {
  transform: scale(1.05);
}
.profile-info .profile-name { 
  font-size: 2rem; 
  font-weight: 800; 
  margin-bottom: 0.5rem;
}
.profile-role { 
  display: flex; 
  align-items: center; 
  gap: 0.75rem;
  font-size: 1.1rem;
}
.role-badge {
  background: var(--accent);
  padding: 0.4rem 1rem;
  border-radius: 20px;
  font-size: 0.9rem;
  font-weight: 600;
  color: var(--primary);
  box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

/* Details Grid */
.details-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
  gap: 2rem;
}

/* Detail Card */
.detail-card {
  background: var(--card-bg);
  border-radius: 20px;
  padding: 2rem;
  border: 1px solid rgba(161, 194, 189, 0.3);
  transition: all 0.3s ease;
  position: relative;
  box-shadow: var(--shadow);
}
.detail-card:hover {
  transform: translateY(-5px);
  box-shadow: var(--shadow-hover);
  border-color: var(--accent);
}
.detail-card-header { 
  display: flex; 
  align-items: center; 
  gap: 0.75rem; 
  margin-bottom: 1.5rem; 
  padding-bottom: 1rem;
  border-bottom: 1px solid rgba(161, 194, 189, 0.3);
}
.detail-icon { 
  font-size: 1.5rem; 
  width: 40px;
  height: 40px;
  display: flex;
  align-items: center;
  justify-content: center;
  background: rgba(161, 194, 189, 0.2);
  border-radius: 10px;
}
.detail-card-title { 
  font-weight: 700; 
  font-size: 1.3rem;
  color: var(--primary);
}

/* Edit Button */
.edit-btn {
  position: absolute;
  top: 1.5rem;
  right: 1.5rem;
  background: linear-gradient(135deg, var(--primary) 0%, #2a2860 100%);
  color: #fff;
  border: none;
  border-radius: 10px;
  padding: 0.5rem 1rem;
  font-size: 0.9rem;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.3s ease;
  display: flex;
  align-items: center;
  gap: 0.5rem;
  box-shadow: 0 3px 10px rgba(25, 24, 59, 0.2);
}
.edit-btn:hover {
  transform: translateY(-2px);
  box-shadow: 0 5px 15px rgba(25, 24, 59, 0.3);
}

/* Detail Item */
.detail-item {
  display: flex;
  justify-content: space-between;
  padding: 1rem 0;
  border-bottom: 1px solid rgba(161, 194, 189, 0.3);
  transition: background-color 0.2s ease;
}
.detail-item:hover {
  background-color: rgba(161, 194, 189, 0.05);
  border-radius: 8px;
  padding-left: 0.5rem;
  padding-right: 0.5rem;
}
.detail-item:last-child { border-bottom: none; }
.detail-label { 
  color: var(--text-muted); 
  font-weight: 600; 
  font-size: 0.95rem;
}
.detail-value { 
  font-weight: 500; 
  text-align: right;
  color: var(--text-dark);
}

/* Modal Styles */
.modal-content {
  border-radius: 20px;
  border: none;
  box-shadow: var(--shadow-hover);
  overflow: hidden;
}
.modal-header {
  background: linear-gradient(135deg, var(--primary) 0%, #2a2860 100%);
  color: white;
  padding: 1.5rem 2rem;
  border-bottom: none;
}
.modal-title {
  font-weight: 700;
  font-size: 1.5rem;
}
.modal-body {
  padding: 2rem;
}
.modal-footer {
  padding: 1.5rem 2rem;
  border-top: 1px solid rgba(161, 194, 189, 0.3);
}
.btn-primary {
  background: linear-gradient(135deg, var(--primary) 0%, #2a2860 100%);
  border: none;
  border-radius: 10px;
  padding: 0.75rem 1.5rem;
  font-weight: 600;
  transition: all 0.3s ease;
}
.btn-primary:hover {
  transform: translateY(-2px);
  box-shadow: 0 5px 15px rgba(25, 24, 59, 0.3);
}
.btn-secondary {
  background: #f8f9fa;
  border: 1px solid #dee2e6;
  color: var(--text-dark);
  border-radius: 10px;
  padding: 0.75rem 1.5rem;
  font-weight: 600;
  transition: all 0.3s ease;
}
.btn-secondary:hover {
  background: #e9ecef;
  transform: translateY(-2px);
}
.form-label {
  font-weight: 600;
  color: var(--text-dark);
  margin-bottom: 0.5rem;
}
.form-control {
  border: 1px solid rgba(161, 194, 189, 0.5);
  border-radius: 10px;
  padding: 0.75rem 1rem;
  transition: all 0.3s ease;
}
.form-control:focus {
  border-color: var(--accent);
  box-shadow: 0 0 0 0.25rem rgba(161, 194, 189, 0.25);
}

/* Responsive */
@media(max-width: 992px){
  .details-grid { grid-template-columns: 1fr; }
}
@media(max-width:768px){
  .profile-header-card { 
    flex-direction: column; 
    text-align: center; 
    gap: 1.5rem; 
    padding: 2rem;
  }
  .profile-avatar { 
    width: 100px; 
    height: 100px; 
    font-size: 2rem; 
  }
  .profile-info .profile-name { font-size: 1.75rem; }
  .detail-item { flex-direction: column; gap: 0.5rem; }
  .detail-value { text-align: left; }
  .edit-btn { top: 1rem; right: 1rem; }
  .main-content { padding: 1rem; }
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

    <!-- Profile Header -->
    <div class="profile-header-card">
      <div class="profile-avatar">
        {{ strtoupper(substr(session('first_name', ''),0,1) . substr(session('last_name',''),0,1)) }}
      </div>
      <div class="profile-info">
        <div class="profile-name">
          {{ session('first_name') }} {{ session('middle_name') ? session('middle_name').' ' : '' }}{{ session('last_name') }}
        </div>
        <div class="profile-role">
          <span>{{ session('position') ?? 'Administrator' }}</span>
          <span class="role-badge">{{ ucfirst(session('role')) }}</span>
        </div>
      </div>
    </div>

    <!-- Details Grid -->
    <div class="details-grid">

      <!-- Personal Info Card -->
      <div class="detail-card">
        <button class="edit-btn" data-bs-toggle="modal" data-bs-target="#editPersonalModal">
          <i class="fas fa-edit"></i> Edit
        </button>
        <div class="detail-card-header">
          <div class="detail-icon">👤</div>
          <h4 class="detail-card-title">Personal Information</h4>
        </div>
        <div class="detail-item">
          <span class="detail-label">Employee ID</span>
          <span class="detail-value">{{ session('id') }}</span>
        </div>
        <div class="detail-item">
          <span class="detail-label">First Name</span>
          <span class="detail-value">{{ session('first_name') }}</span>
        </div>
        <div class="detail-item">
          <span class="detail-label">Middle Name</span>
          <span class="detail-value">{{ session('middle_name') ?? '-' }}</span>
        </div>
        <div class="detail-item">
          <span class="detail-label">Last Name</span>
          <span class="detail-value">{{ session('last_name') }}</span>
        </div>
      </div>

      <!-- Contact Info Card -->
      <div class="detail-card">
        <div class="detail-card-header">
          <div class="detail-icon">📧</div>
          <h4 class="detail-card-title">Contact Information</h4>
        </div>
        <div class="detail-item">
          <span class="detail-label">Email</span>
          <span class="detail-value">{{ session('user') }}</span>
        </div>
      </div>

      <!-- Work Info Card -->
      <div class="detail-card">
        <div class="detail-card-header">
          <div class="detail-icon">💼</div>
          <h4 class="detail-card-title">Work Information</h4>
        </div>
        <div class="detail-item">
          <span class="detail-label">Role</span>
          <span class="detail-value">{{ ucfirst(session('role')) }}</span>
        </div>
        <div class="detail-item">
          <span class="detail-label">Position</span>
          <span class="detail-value">{{ session('position') ?? '-' }}</span>
        </div>
        <div class="detail-item">
          <span class="detail-label">Department</span>
          <span class="detail-value">{{ session('department') ?? '-' }}</span>
        </div>
        <div class="detail-item">
          <span class="detail-label">Company</span>
          <span class="detail-value">{{ session('company') ?? '-' }}</span>
        </div>
      </div>

    </div>
  </div>
</div>

<!-- Edit Personal Information Modal -->
<div class="modal fade" id="editPersonalModal" tabindex="-1" aria-labelledby="editPersonalModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editPersonalModalLabel">Edit Personal Information</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="personalInfoForm">
          <div class="mb-3">
            <label for="firstName" class="form-label">First Name</label>
            <input type="text" class="form-control" id="firstName" value="{{ session('first_name') }}">
          </div>
          <div class="mb-3">
            <label for="middleName" class="form-label">Middle Name</label>
            <input type="text" class="form-control" id="middleName" value="{{ session('middle_name') ?? '' }}">
          </div>
          <div class="mb-3">
            <label for="lastName" class="form-label">Last Name</label>
            <input type="text" class="form-control" id="lastName" value="{{ session('last_name') }}">
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary">Save Changes</button>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
const toggleBtn = document.getElementById('sidebarToggle');
const sidebar = document.getElementById('sidebar');
const mainContent = document.getElementById('mainContent');

toggleBtn?.addEventListener('click', () => {
  sidebar.classList.toggle('d-none');
  mainContent.style.marginLeft = sidebar.classList.contains('d-none') ? '0' : '250px';
});

// Handle form submission for personal info
document.querySelector('.btn-primary').addEventListener('click', function() {
  // Here you would typically send the data to your backend
  const firstName = document.getElementById('firstName').value;
  const middleName = document.getElementById('middleName').value;
  const lastName = document.getElementById('lastName').value;
  
  // Update the displayed values
  document.querySelectorAll('.detail-item')[1].querySelector('.detail-value').textContent = firstName;
  document.querySelectorAll('.detail-item')[2].querySelector('.detail-value').textContent = middleName || '-';
  document.querySelectorAll('.detail-item')[3].querySelector('.detail-value').textContent = lastName;
  
  // Update profile header
  document.querySelector('.profile-name').textContent = `${firstName} ${middleName ? middleName + ' ' : ''}${lastName}`;
  document.querySelector('.profile-avatar').textContent = 
    `${firstName.charAt(0).toUpperCase()}${lastName.charAt(0).toUpperCase()}`;
  
  // Close modal
  const modal = bootstrap.Modal.getInstance(document.getElementById('editPersonalModal'));
  modal.hide();
  
  // Show success message (you can replace this with a toast notification)
  alert('Personal information updated successfully!');
});
</script>
</body>
</html>