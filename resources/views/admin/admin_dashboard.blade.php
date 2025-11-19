<!-- resources/views/admin/admin_dashboard.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Admin Dashboard | LeaveWork</title>
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
  --pending: #8b5cf6;
  --text-dark: var(--primary);
  --text-muted: var(--secondary);
  --card-bg: #ffffff;
  --border-color: var(--accent);
}

body {
  margin: 0;
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  color: var(--text-dark);
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
  transition: transform 0.3s ease;
  position: fixed;
  left: 0;
  top: 0;
  overflow-y: auto;
  z-index: 1000;
}

#sidebar.d-none {
  transform: translateX(-100%);
}

/* Main Content */
.main-content {
  flex: 1;
  margin-left: 250px; /* content stays in place when sidebar visible */
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

.topnav h4 {
  margin: 0;
  font-weight: 600;
  color: var(--primary);
}

.topnav .btn-toggle {
  background-color: var(--primary);
  color: #fff;
  border: none;
  padding: 0.5rem 1rem;
  border-radius: 8px;
  font-weight: 600;
  cursor: pointer;
}
.topnav .btn-toggle:hover {
  background-color: var(--secondary);
}

/* Stats Grid */
.stats-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
  gap: 1.5rem;
  margin-bottom: 3rem;
}

.stat-card {
  background: var(--card-bg);
  border: 1px solid var(--accent);
  border-radius: 15px;
  padding: 2rem 1.5rem;
  text-align: center;
  transition: all 0.3s ease;
}

.stat-card .stat-icon { font-size: 2.5rem; margin-bottom: 1rem; display: inline-block; }
.stat-card .stat-number { font-size: 2.5rem; font-weight: 700; margin-bottom: 0.5rem; }
.stat-card .stat-label { font-size: 0.95rem; font-weight: 500; color: var(--secondary); }

.stat-card.employees .stat-number { color: var(--primary); }
.stat-card.pending .stat-number { color: var(--pending); }
.stat-card.approved .stat-number { color: var(--success); }
.stat-card.rejected .stat-number { color: var(--danger); }

/* Quick Actions */
.actions-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
  gap: 2rem;
}

.action-card {
  background: var(--card-bg);
  border: 1px solid var(--accent);
  border-radius: 15px;
  padding: 2rem 1.5rem;
  text-align: center;
}

.action-card h5 { font-size: 1.25rem; font-weight: 600; color: var(--primary); margin-bottom: 0.75rem; }
.action-card p { color: var(--secondary); font-size: 0.95rem; margin-bottom: 1rem; }
.action-card .btn {
  padding: 0.75rem 2.5rem;
  font-weight: 600;
  border-radius: 10px;
  border: none;
  background: var(--primary);
  color: #fff;
  transition: all 0.3s ease;
  text-decoration: none;
}
.action-card .btn:hover {
  background-color: var(--secondary);
  transform: scale(1.05);
  box-shadow: 0 8px 20px rgba(25, 24, 59, 0.25);
}

/* Responsive */
@media (max-width: 768px) {
  .stats-grid { grid-template-columns: repeat(auto-fit, minmax(160px, 1fr)); gap: 1rem; }
  .actions-grid { grid-template-columns: 1fr; gap: 1.5rem; }
  .main-content { margin-left: 0; padding: 1rem; }
  #sidebar { transform: translateX(-100%); }
}
</style>
</head>
<body>

<!-- Sidebar -->
@include('layouts.sidebar')

<!-- Main Content -->
<div class="main-content" id="mainContent">
  @include('layouts.topnav')

  <!-- Dashboard Header -->
  <div class="dashboard-header">
    <h2>Welcome back, {{ $adminName ?? 'Admin' }}</h2>
    <p>Here's your department overview</p>
  </div>

  <!-- Stats -->
  <div class="stats-grid">
    <div class="stat-card employees">
      <div class="stat-icon">👥</div>
      <div class="stat-number">12</div>
      <div class="stat-label">Total Employees</div>
    </div>
    <div class="stat-card pending">
      <div class="stat-icon">⏳</div>
      <div class="stat-number">3</div>
      <div class="stat-label">Pending Requests</div>
    </div>
    <div class="stat-card approved">
      <div class="stat-icon">✅</div>
      <div class="stat-number">7</div>
      <div class="stat-label">Approved Requests</div>
    </div>
    <div class="stat-card rejected">
      <div class="stat-icon">❌</div>
      <div class="stat-number">2</div>
      <div class="stat-label">Rejected Requests</div>
    </div>
  </div>

  <!-- Quick Actions -->
  <div class="actions-grid">
    <div class="action-card">
      <h5>Manage Employees</h5>
      <p>Add, edit, or remove employee accounts and view profiles</p>
      <a href="#" class="btn">Manage</a>
    </div>
    <div class="action-card">
      <h5>Review Requests</h5>
      <p>Approve or reject leave requests from your team</p>
      <a href="#" class="btn">Review</a>
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
