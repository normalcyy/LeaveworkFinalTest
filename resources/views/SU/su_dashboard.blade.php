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
body { background-color: var(--light); font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; color: var(--primary);}
.content { padding: 2.5rem 1.5rem; max-width: 1400px; margin: 0 auto; }
.dashboard-header { text-align: center; margin-bottom: 3rem; }
.dashboard-header h2 { font-size: 2rem; font-weight: 600; margin-bottom: 0.5rem; }
.dashboard-header p { color: var(--secondary); font-size: 1rem; }
.stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 1.5rem; margin-bottom: 3rem; }
.stat-card { background: #fff; border: 1px solid var(--accent); border-radius: 15px; padding: 2rem 1.5rem; text-align: center; transition: all 0.3s ease; }
.stat-card .stat-icon { font-size: 2.5rem; margin-bottom: 1rem; }
.stat-card .stat-number { font-size: 2.5rem; font-weight: 700; margin-bottom: 0.5rem; }
.stat-card .stat-label { font-size: 0.95rem; color: var(--secondary); }
.actions-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2rem; }
.action-card { background: #fff; border: 1px solid var(--accent); border-radius: 15px; padding: 2rem; text-align: center; transition: all 0.3s ease; }
.action-card h5 { font-size: 1.25rem; font-weight: 600; margin-bottom: 1rem; }
.action-card p { color: var(--secondary); font-size: 0.95rem; margin-bottom: 1.5rem; }
.action-card .btn { padding: 0.75rem 2.5rem; font-weight: 600; border-radius: 10px; border: none; background: var(--primary); color: #fff; transition: all 0.3s ease; text-decoration: none; }
.action-card .btn:hover { background-color: var(--secondary); transform: scale(1.05); box-shadow: 0 8px 20px rgba(25, 24, 59, 0.25); }
@media (max-width: 768px) { .content { padding: 1rem; } .stats-grid, .actions-grid { grid-template-columns: 1fr; } }
</style>
</head>
<body>

<div class="container-fluid">
  <div class="row">
    {{-- Sidebar --}}
    @include('layouts.sidebar')

    <div class="col-md-10">
      {{-- Topnav --}}
      @include('layouts.topnav')

      <div class="content">
        <!-- Dashboard Header -->
        <div class="dashboard-header">
          <h2>Welcome, Superuser!</h2>
          <p>Manage your admins and companies from here</p>
        </div>

        <!-- Stats Cards -->
        <div class="stats-grid">
          <div class="stat-card">
            <div class="stat-icon">👤</div>
            <div class="stat-number">5</div>
            <div class="stat-label">Admins Created</div>
          </div>
          <div class="stat-card">
            <div class="stat-icon">🏢</div>
            <div class="stat-number">3</div>
            <div class="stat-label">Companies Registered</div>
          </div>
        </div>

        <!-- Quick Actions -->
        <div class="actions-grid">
          <div class="action-card">
            <h5>Create Admin</h5>
            <p>Add a new admin for a company with the necessary credentials.</p>
            <a href="#" class="btn">Create Admin</a>
          </div>
          <div class="action-card">
            <h5>Create Company</h5>
            <p>Register a new company and assign admins to manage it.</p>
            <a href="#" class="btn">Create Company</a>
          </div>
        </div>

      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
