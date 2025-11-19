<!-- resources/views/employee/emp_dashboard.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Employee Dashboard | LeaveWork</title>
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
  transition: transform 0.3s ease, width 0.3s ease;
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
  margin-left: 250px; /* shifted when sidebar is visible */
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

/* Cards */
.card {
  border: none;
  border-radius: 15px;
  background-color: #ffffff;
  box-shadow: 0 4px 15px rgba(25,24,59,0.08);
  transition: transform 0.2s ease;
}
.card:hover {
  transform: translateY(-2px);
  box-shadow: 0 6px 20px rgba(25,24,59,0.12);
}

.leave-card {
  text-align: center;
  padding: 1.5rem;
  border-radius: 12px;
  background-color: #ffffff;
  box-shadow: 0 3px 10px rgba(25,24,59,0.06);
  transition: transform 0.2s ease;
  border: 2px solid transparent;
}
.leave-card:hover {
  transform: translateY(-4px);
  border-color: var(--accent);
  box-shadow: 0 6px 15px rgba(25,24,59,0.1);
}
.leave-icon { font-size: 2rem; display: block; margin-bottom: 0.5rem; }
.leave-days { font-size: 2rem; font-weight: 700; color: var(--primary); margin: 0; }
.leave-type { font-weight: 500; color: var(--secondary); font-size: 0.9rem; }

.equal-card { height: 185px; display: flex; flex-direction: column; }
.scrollable-list { flex-grow: 1; overflow-y: auto; max-height: 220px; }
.scrollable-list::-webkit-scrollbar { width: 6px; }
.scrollable-list::-webkit-scrollbar-thumb { background-color: var(--secondary); border-radius: 10px; }
.scrollable-list::-webkit-scrollbar-thumb:hover { background-color: var(--primary); }

@media (max-width: 768px) {
  .main-content { margin-left: 0; padding: 1rem; }
  .equal-card { height: auto; }
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

  <h3 class="fw-bold mb-4">Welcome, John Doe!</h3>

  <div class="row g-4">
    <!-- Employee Information -->
    <div class="col-md-6">
      <div class="card p-3 equal-card">
        <h5 class="mb-2">Employee Information</h5>
        <div class="scrollable-list">
          <p><strong>Name:</strong> John Doe</p>
          <p><strong>Email:</strong> johndoe@example.com</p>
          <p><strong>Role:</strong> Employee</p>
        </div>
      </div>
    </div>

    <!-- Recent Activity -->
    <div class="col-md-6">
      <div class="card p-3 equal-card">
        <h5 class="mb-2">Recent Activity</h5>
        <ul class="list-group list-group-flush scrollable-list">
          <li class="list-group-item">No recent activity.</li>
        </ul>
      </div>
    </div>

    <!-- Leave Balances -->
    <div class="col-12">
      <div class="card p-4">
        <h5 class="mb-3">🧮 Leave Requests Balance</h5>
        <div class="row g-4 text-center">
          @php
            $leaveTypes = [
              'Vacation' => ['icon'=>'🌴','remaining'=>8,'submitted'=>0,'total'=>8],
              'Sick' => ['icon'=>'🏥','remaining'=>10,'submitted'=>0,'total'=>10],
              'Personal' => ['icon'=>'👤','remaining'=>5,'submitted'=>0,'total'=>5],
              'Emergency' => ['icon'=>'🆘','remaining'=>5,'submitted'=>0,'total'=>5]
            ];
          @endphp
          @foreach($leaveTypes as $label => $data)
          <div class="col-6 col-md-3">
            <div class="leave-card">
              <span class="leave-icon">{{ $data['icon'] }}</span>
              <p class="leave-days">{{ $data['remaining'] }}</p>
              <p class="leave-type">{{ $label }} Requests</p>
              <small class="text-muted">{{ $data['submitted'] }} submitted / {{ $data['total'] }} allowed</small>
            </div>
          </div>
          @endforeach
        </div>
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
