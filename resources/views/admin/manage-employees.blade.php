<!-- resources/views/admin/manage-employees.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Admin | Manage Employees | LeaveWork</title>
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
  --info: #3b82f6;
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
.content-wrapper { max-width: 1400px; width: 100%; margin: 0 auto; }

/* Page Header */
.dashboard-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 2.5rem;
}
.dashboard-header h2 { font-size: 2rem; font-weight: 700; margin: 0; }
.dashboard-header p { color: var(--secondary); margin: 0.3rem 0 0 0; }

/* Stats Cards */
.stats-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
  gap: 1.5rem;
  margin-bottom: 2.5rem;
}

.stat-card {
  background: #fff;
  border-radius: var(--radius);
  padding: 1.5rem;
  box-shadow: var(--shadow-light);
  transition: var(--transition);
  border-left: 4px solid var(--accent);
}
.stat-card:hover {
  transform: translateY(-4px);
  box-shadow: var(--shadow-hover);
}
.stat-card.success { border-left-color: var(--success); }
.stat-card.warning { border-left-color: var(--warning); }
.stat-card.info { border-left-color: var(--info); }
.stat-card.danger { border-left-color: var(--danger); }

.stat-icon {
  font-size: 2rem;
  margin-bottom: 0.5rem;
  display: block;
}
.stat-number {
  font-size: 2rem;
  font-weight: 700;
  margin: 0;
  color: var(--primary);
}
.stat-label {
  font-weight: 500;
  color: var(--secondary);
  font-size: 0.95rem;
  margin-top: 0.3rem;
}

/* Action Bar */
.action-bar {
  background: #fff;
  padding: 1.5rem;
  border-radius: var(--radius);
  box-shadow: var(--shadow-light);
  margin-bottom: 2rem;
  display: flex;
  justify-content: space-between;
  align-items: center;
  flex-wrap: wrap;
  gap: 1rem;
}

.search-box {
  flex: 1;
  max-width: 400px;
  position: relative;
}
.search-box input {
  width: 100%;
  padding: 0.75rem 1rem 0.75rem 2.75rem;
  border: 2px solid var(--accent);
  border-radius: var(--radius);
  font-size: 0.95rem;
  transition: var(--transition);
}
.search-box input:focus {
  outline: none;
  border-color: var(--primary);
}
.search-icon {
  position: absolute;
  left: 1rem;
  top: 50%;
  transform: translateY(-50%);
  color: var(--secondary);
  font-size: 1.2rem;
}

.btn-primary-custom {
  background: var(--primary);
  color: #fff;
  padding: 0.75rem 1.5rem;
  border-radius: var(--radius);
  border: none;
  font-weight: 600;
  cursor: pointer;
  transition: var(--transition);
  display: inline-flex;
  align-items: center;
  gap: 0.5rem;
}
.btn-primary-custom:hover {
  background: var(--secondary);
  transform: translateY(-2px);
}

/* Employee Table */
.table-container {
  background: #fff;
  border-radius: var(--radius);
  box-shadow: var(--shadow-light);
  overflow: hidden;
}

.employee-table {
  width: 100%;
  margin: 0;
}
.employee-table thead {
  background: var(--primary);
  color: #fff;
}
.employee-table thead th {
  padding: 1rem 1.5rem;
  font-weight: 600;
  text-align: left;
  border: none;
}
.employee-table tbody tr {
  border-bottom: 1px solid var(--accent);
  transition: var(--transition);
}
.employee-table tbody tr:hover {
  background-color: var(--light);
}
.employee-table tbody td {
  padding: 1rem 1.5rem;
  vertical-align: middle;
}

.employee-avatar {
  width: 40px;
  height: 40px;
  border-radius: 50%;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  font-weight: 600;
  color: #fff;
  margin-right: 0.75rem;
}

.employee-info {
  display: inline-block;
  vertical-align: middle;
}
.employee-name {
  font-weight: 600;
  color: var(--primary);
  margin: 0;
}
.employee-email {
  font-size: 0.85rem;
  color: var(--secondary);
  margin: 0;
}

.badge {
  padding: 0.35rem 0.75rem;
  border-radius: 20px;
  font-size: 0.85rem;
  font-weight: 600;
}
.badge-success { background: #d1fae5; color: #065f46; }
.badge-warning { background: #fef3c7; color: #92400e; }
.badge-danger { background: #fee2e2; color: #991b1b; }

.action-buttons {
  display: flex;
  gap: 0.5rem;
}
.btn-icon {
  width: 36px;
  height: 36px;
  border-radius: 8px;
  border: none;
  cursor: pointer;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  transition: var(--transition);
  font-size: 1rem;
}
.btn-icon.edit {
  background: #dbeafe;
  color: #1e40af;
}
.btn-icon.edit:hover {
  background: #3b82f6;
  color: #fff;
}
.btn-icon.delete {
  background: #fee2e2;
  color: #991b1b;
}
.btn-icon.delete:hover {
  background: #ef4444;
  color: #fff;
}

/* Responsive */
@media(max-width: 992px) {
  #sidebar { transform: translateX(-100%); }
  .main-content { margin-left: 0; padding: 1rem; }
  .dashboard-header { flex-direction: column; align-items: flex-start; }
  .action-bar { flex-direction: column; }
  .search-box { max-width: 100%; }
  .table-container { overflow-x: auto; }
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
      <div>
        <h2>Manage Employees</h2>
        <p>View and manage all employees in the system</p>
      </div>
    </div>

    <!-- Stats Overview -->
    <div class="stats-grid">
      <div class="stat-card success">
        <span class="stat-icon">👥</span>
        <p class="stat-number">24</p>
        <p class="stat-label">Total Employees</p>
      </div>
      <div class="stat-card info">
        <span class="stat-icon">✅</span>
        <p class="stat-number">21</p>
        <p class="stat-label">Active</p>
      </div>
      <div class="stat-card warning">
        <span class="stat-icon">🏖️</span>
        <p class="stat-number">3</p>
        <p class="stat-label">On Leave</p>
      </div>
      <div class="stat-card danger">
        <span class="stat-icon">⏸️</span>
        <p class="stat-number">0</p>
        <p class="stat-label">Inactive</p>
      </div>
    </div>

    <!-- Action Bar -->
    <div class="action-bar">
      <div class="search-box">
        <span class="search-icon">🔍</span>
        <input type="text" placeholder="Search employees by name, email, or department...">
      </div>
      <button class="btn-primary-custom">
        <span>➕</span>
        Add New Employee
      </button>
    </div>

    <!-- Employee Table -->
    <div class="table-container">
      <table class="employee-table">
        <thead>
          <tr>
            <th>Employee</th>
            <th>Department</th>
            <th>Position</th>
            <th>Status</th>
            <th>Join Date</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          @php
            $employees = [
              ['name'=>'John Doe','email'=>'john.doe@company.com','dept'=>'Engineering','position'=>'Senior Developer','status'=>'Active','join'=>'Jan 15, 2023','color'=>'#3b82f6'],
              ['name'=>'Jane Smith','email'=>'jane.smith@company.com','dept'=>'Marketing','position'=>'Marketing Manager','status'=>'Active','join'=>'Mar 22, 2023','color'=>'#10b981'],
              ['name'=>'Mike Johnson','email'=>'mike.j@company.com','dept'=>'Sales','position'=>'Sales Representative','status'=>'On Leave','join'=>'Jun 10, 2022','color'=>'#f59e0b'],
              ['name'=>'Sarah Williams','email'=>'sarah.w@company.com','dept'=>'HR','position'=>'HR Specialist','status'=>'Active','join'=>'Feb 5, 2023','color'=>'#8b5cf6'],
              ['name'=>'David Brown','email'=>'david.b@company.com','dept'=>'Engineering','position'=>'DevOps Engineer','status'=>'Active','join'=>'Aug 18, 2022','color'=>'#ef4444'],
              ['name'=>'Emily Davis','email'=>'emily.d@company.com','dept'=>'Design','position'=>'UX Designer','status'=>'Active','join'=>'Apr 12, 2023','color'=>'#ec4899'],
            ];
          @endphp

          @foreach($employees as $emp)
          <tr>
            <td>
              <div class="employee-avatar" style="background-color: {{ $emp['color'] }}">
                {{ strtoupper(substr($emp['name'], 0, 1)) }}
              </div>
              <div class="employee-info">
                <p class="employee-name">{{ $emp['name'] }}</p>
                <p class="employee-email">{{ $emp['email'] }}</p>
              </div>
            </td>
            <td>{{ $emp['dept'] }}</td>
            <td>{{ $emp['position'] }}</td>
            <td>
              <span class="badge badge-{{ $emp['status'] === 'Active' ? 'success' : 'warning' }}">
                {{ $emp['status'] }}
              </span>
            </td>
            <td>{{ $emp['join'] }}</td>
            <td>
              <div class="action-buttons">
                <button class="btn-icon edit" title="Edit">✏️</button>
                <button class="btn-icon delete" title="Delete">🗑️</button>
              </div>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
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
  mainContent.style.marginLeft = sidebar.classList.contains('d-none') ? '0' : '240px';
});

// Search functionality
const searchInput = document.querySelector('.search-box input');
const tableRows = document.querySelectorAll('.employee-table tbody tr');

searchInput?.addEventListener('input', (e) => {
  const searchTerm = e.target.value.toLowerCase();
  
  tableRows.forEach(row => {
    const text = row.textContent.toLowerCase();
    row.style.display = text.includes(searchTerm) ? '' : 'none';
  });
});
</script>

</body>
</html>