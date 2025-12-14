<!-- resources/views/superuser/su_dashboard.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Superuser Dashboard | LeaveWork</title>
<link rel="icon" type="image/png" href="{{ asset('assets/leavework_logo.png') }}">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
:root {
  --primary: #19183B;
  --secondary: #708993;
  --accent: #A1C2BD;
  --light: #E7F2EF;
  --success: #10b981;
  --warning: #f59e0b;
  --danger: #ef4444;
}

/* Body */
body {
  margin: 0;
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  color: var(--primary);
  background-color: var(--light);
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
  padding: 0.75rem 1.5rem;
  border-radius: 10px;
  box-shadow: 0 2px 10px rgba(25,24,59,0.08);
}
.topnav h4 { margin: 0; font-weight: 600; color: var(--primary); }
.topnav .btn-toggle {
  background-color: var(--primary);
  color: #fff;
  border: none;
  padding: 0.5rem 1rem;
  border-radius: 8px;
  font-weight: 600;
  cursor: pointer;
}
.topnav .btn-toggle:hover { background-color: var(--secondary); }

/* Content Wrapper */
.content-wrapper { max-width: 1400px; width: 100%; margin: 0 auto; }

/* Dashboard Header */
.dashboard-header { text-align: center; margin-bottom: 3rem; }
.dashboard-header h2 { font-size: 2rem; font-weight: 600; margin-bottom: 0.5rem; }
.dashboard-header p { color: var(--secondary); font-size: 1rem; }

/* User Welcome Badge */
.welcome-badge {
  display: inline-block;
  background: linear-gradient(135deg, var(--primary) 0%, #2a2860 100%);
  color: white;
  padding: 0.5rem 1.5rem;
  border-radius: 20px;
  font-weight: 600;
  margin-top: 0.5rem;
}

/* Stats Grid */
.stats-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
  gap: 1.5rem;
  margin-bottom: 3rem;
}
.stat-card {
  background: #fff;
  border: 1px solid var(--accent);
  border-radius: 15px;
  padding: 2rem 1.5rem;
  text-align: center;
  transition: all 0.3s ease;
}
.stat-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 10px 25px rgba(25, 24, 59, 0.1);
}
.stat-card .stat-icon { font-size: 2.5rem; margin-bottom: 1rem; }
.stat-card .stat-number { 
  font-size: 2.5rem; 
  font-weight: 700; 
  margin-bottom: 0.5rem; 
  color: var(--primary);
}
.stat-card .stat-label { 
  font-size: 0.95rem; 
  color: var(--secondary);
  font-weight: 500;
}

/* Actions Grid */
.actions-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
  gap: 2rem;
}
.action-card {
  background: #fff;
  border: 1px solid var(--accent);
  border-radius: 15px;
  padding: 2rem;
  text-align: center;
  transition: all 0.3s ease;
}
.action-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 10px 25px rgba(25, 24, 59, 0.1);
}
.action-card h5 { font-size: 1.25rem; font-weight: 600; margin-bottom: 1rem; }
.action-card p { color: var(--secondary); font-size: 0.95rem; margin-bottom: 1.5rem; }
.action-card .btn {
  padding: 0.75rem 2.5rem;
  font-weight: 600;
  border-radius: 10px;
  border: none;
  background: var(--primary);
  color: #fff;
  text-decoration: none;
  transition: all 0.3s ease;
  display: inline-flex;
  align-items: center;
  justify-content: center;
}
.action-card .btn:hover {
  background-color: var(--secondary);
  transform: scale(1.05);
  box-shadow: 0 8px 20px rgba(25, 24, 59, 0.25);
}

/* Companies Table */
.companies-table {
  background: #fff;
  border-radius: 15px;
  overflow: hidden;
  box-shadow: 0 2px 10px rgba(25,24,59,0.08);
  margin-bottom: 2rem;
}
.companies-table table {
  margin: 0;
}
.companies-table thead {
  background: var(--primary);
  color: #fff;
}
.companies-table thead th {
  padding: 1rem 1.5rem;
  font-weight: 600;
  border: none;
}
.companies-table tbody tr {
  border-bottom: 1px solid var(--accent);
  transition: var(--transition);
}
.companies-table tbody tr:hover {
  background-color: var(--light);
}
.companies-table tbody td {
  padding: 1rem 1.5rem;
  vertical-align: middle;
}

/* Responsive */
@media (max-width: 992px) { 
  #sidebar { transform: translateX(-100%); }
  .main-content { margin-left: 0; }
  .dashboard-header h2 { font-size: 1.75rem; }
}

@media (max-width: 768px) {
  .stats-grid { grid-template-columns: 1fr; }
  .actions-grid { grid-template-columns: 1fr; }
  .dashboard-header h2 { font-size: 1.5rem; }
  .companies-table { overflow-x: auto; }
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

    <!-- Dashboard Header -->
    <div class="dashboard-header">
      <h2>Welcome, {{ session('first_name', 'Superuser') }}!</h2>
      <p>Manage your admins and companies from here</p>
    </div>

    <!-- Stats Cards -->
    <div class="stats-grid">
      <div class="stat-card">
        <div class="stat-icon">👤</div>
        <div class="stat-number">{{ $adminCount ?? 0 }}</div>
        <div class="stat-label">Admins Created</div>
      </div>
      <div class="stat-card">
        <div class="stat-icon">🏢</div>
        <div class="stat-number">{{ $companyCount ?? 0 }}</div>
        <div class="stat-label">Companies Registered</div>
      </div>
    </div>

    <!-- Companies List -->
    <div class="mt-4">
      <h3 class="mb-3">Registered Companies</h3>
      @if(isset($companies) && count($companies) > 0)
        <div class="companies-table">
          <table class="table table-hover mb-0">
            <thead>
              <tr>
                <th>Company Name</th>
                <th>Admins</th>
                <th>Employees</th>
                <th>Total Users</th>
              </tr>
            </thead>
            <tbody>
              @foreach($companies as $company)
                <tr>
                  <td><strong>{{ $company['name'] }}</strong></td>
                  <td><span class="badge bg-info">{{ $company['admin_count'] }}</span></td>
                  <td><span class="badge bg-success">{{ $company['employee_count'] }}</span></td>
                  <td><strong>{{ $company['total_users'] }}</strong></td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      @else
        <div class="alert alert-info">
          <p class="mb-0">No companies registered yet. Create an admin to register the first company.</p>
        </div>
      @endif
    </div>

    <!-- Quick Actions -->
    <div class="actions-grid mt-4">
      <div class="action-card">
        <h5>Create Admin</h5>
        <p>Add a new admin for a company with the necessary credentials.</p>
        <a href="{{ route('su.create_admin') }}" class="btn d-flex align-items-center justify-content-center">
          Create Admin
        </a>
      </div>
      <div class="action-card">
        <h5>View Admins</h5>
        <p>View and manage all registered admins in the system.</p>
        <a href="{{ route('su.admin.list') }}" class="btn d-flex align-items-center justify-content-center">
          View Admins
        </a>
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
  if(sidebar.classList.contains('d-none')){
    mainContent.style.marginLeft = '0';
  } else {
    mainContent.style.marginLeft = '250px';
  }
});
</script>

</body>
</html>