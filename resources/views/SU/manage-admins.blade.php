<!-- resources/views/su/manage-admins.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>Superuser | Manage Admins | LeaveWork</title>
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
  text-decoration: none;
}
.btn-primary-custom:hover {
  background: var(--secondary);
  transform: translateY(-2px);
  color: #fff;
}

/* Admin Table */
.table-container {
  background: #fff;
  border-radius: var(--radius);
  box-shadow: var(--shadow-light);
  overflow: hidden;
}

.admin-table {
  width: 100%;
  margin: 0;
}
.admin-table thead {
  background: var(--primary);
  color: #fff;
}
.admin-table thead th {
  padding: 1rem 1.5rem;
  font-weight: 600;
  text-align: left;
  border: none;
}
.admin-table tbody tr {
  border-bottom: 1px solid var(--accent);
  transition: var(--transition);
}
.admin-table tbody tr:hover {
  background-color: var(--light);
}
.admin-table tbody td {
  padding: 1rem 1.5rem;
  vertical-align: middle;
}

.admin-avatar {
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

.admin-info {
  display: inline-block;
  vertical-align: middle;
}
.admin-name {
  font-weight: 600;
  color: var(--primary);
  margin: 0;
}
.admin-email {
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

@include('layouts.sidebar')

<div class="main-content" id="mainContent">
  @include('layouts.topnav')

  <div class="content-wrapper">
    <div class="dashboard-header">
      <div>
        <h2>Manage Admins</h2>
        <p>View and manage all administrators in the system</p>
      </div>
    </div>

    @if(session('success'))
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    @endif

    @if(session('error'))
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    @endif

    <div class="stats-grid">
      <div class="stat-card success">
        <span class="stat-icon">👥</span>
        <p class="stat-number">{{ $totalAdmins ?? 0 }}</p>
        <p class="stat-label">Total Admins</p>
      </div>
      <div class="stat-card info">
        <span class="stat-icon">🏢</span>
        <p class="stat-number">{{ $totalCompanies ?? 0 }}</p>
        <p class="stat-label">Companies</p>
      </div>
    </div>

    <div class="action-bar">
      <form method="GET" action="{{ route('su.manage_admins') }}" class="search-box" style="display: flex; flex: 1; max-width: 400px;">
        <span class="search-icon">🔍</span>
        <input type="text" name="search" placeholder="Search admins by name, email, or company..." 
               value="{{ request('search') }}" style="flex: 1;">
        @if(request('search'))
          <a href="{{ route('su.manage_admins') }}" class="btn btn-sm btn-secondary ms-2">Clear</a>
        @endif
      </form>
      <a href="{{ route('su.create_admin') }}" class="btn-primary-custom">
        <span>➕</span>
        Create New Admin
      </a>
    </div>

    <div class="table-container">
      <table class="admin-table">
        <thead>
          <tr>
            <th>Admin</th>
            <th>Company</th>
            <th>Department</th>
            <th>Join Date</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          @if(isset($admins) && $admins->count() > 0)
            @foreach($admins as $admin)
              @php
                // Generate color based on admin ID for consistent avatar colors
                $colors = ['#3b82f6', '#10b981', '#f59e0b', '#8b5cf6', '#ef4444', '#ec4899', '#06b6d4', '#f97316'];
                $colorIndex = $admin->id % count($colors);
                $avatarColor = $colors[$colorIndex];
              @endphp
              <tr>
                <td>
                  <div class="admin-avatar" style="background-color: {{ $avatarColor }};">
                    {{ strtoupper(substr($admin->first_name, 0, 1)) }}
                  </div>
                  <div class="admin-info">
                    <p class="admin-name">{{ $admin->first_name }} {{ $admin->middle_name }} {{ $admin->last_name }}</p>
                    <p class="admin-email">{{ $admin->email }}</p>
                    <small class="text-muted">ID: {{ $admin->emp_id }}</small>
                  </div>
                </td>
                <td>{{ $admin->company ?? 'N/A' }}</td>
                <td>{{ $admin->department ?? 'N/A' }}</td>
                <td>{{ $admin->created_at->format('M d, Y') }}</td>
                <td>
                  <div class="action-buttons">
                    <a href="{{ route('su.manage_admins.edit', $admin->id) }}" class="btn-icon edit" title="Edit">✏️</a>
                    <button class="btn-icon delete" title="Delete" onclick="deleteAdmin({{ $admin->id }}, '{{ $admin->first_name }} {{ $admin->last_name }}')">🗑️</button>
                  </div>
                </td>
              </tr>
            @endforeach
          @else
            <tr>
              <td colspan="5" class="text-center py-4">
                <p>No admins found.</p>
                <a href="{{ route('su.create_admin') }}" class="btn-primary-custom" style="display: inline-flex; margin-top: 1rem;">
                  <span>➕</span>
                  Create Your First Admin
                </a>
              </td>
            </tr>
          @endif
        </tbody>
      </table>
    </div>

    <!-- Pagination -->
    @if(isset($admins) && $admins->hasPages())
      <div class="mt-4">
        {{ $admins->links() }}
      </div>
    @endif

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

// Delete admin function
function deleteAdmin(id, name) {
  if (!confirm(`Are you sure you want to delete admin "${name}"?\n\nThis action cannot be undone.`)) {
    return;
  }

  fetch(`/superuser/manage-admins/${id}`, {
    method: 'DELETE',
    headers: {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
    }
  })
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        alert(data.message);
        location.reload();
      } else {
        alert(data.error || 'Failed to delete admin');
      }
    })
    .catch(error => {
      console.error('Error:', error);
      alert('Failed to delete admin. Please try again.');
    });
}
</script>

</body>
</html>

