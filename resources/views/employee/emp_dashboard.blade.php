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

  <h3 class="fw-bold mb-4">Welcome, {{ session('first_name') }} {{ session('last_name') }}!</h3>

  @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      {{ session('success') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  @endif

  <div class="row g-4 mb-4">
    <!-- Statistics Cards -->
    <div class="col-md-3">
      <div class="card p-3 text-center">
        <h6 class="text-muted mb-2">Pending</h6>
        <h3 class="mb-0 text-warning">{{ $pendingCount ?? 0 }}</h3>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card p-3 text-center">
        <h6 class="text-muted mb-2">Approved</h6>
        <h3 class="mb-0 text-success">{{ $approvedCount ?? 0 }}</h3>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card p-3 text-center">
        <h6 class="text-muted mb-2">Rejected</h6>
        <h3 class="mb-0 text-danger">{{ $rejectedCount ?? 0 }}</h3>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card p-3 text-center">
        <h6 class="text-muted mb-2">Notifications</h6>
        <h3 class="mb-0 text-primary">{{ $unreadNotificationsCount ?? 0 }}</h3>
      </div>
    </div>
  </div>

  <div class="row g-4">
    <!-- Employee Information -->
    <div class="col-md-6">
      <div class="card p-3 equal-card">
        <h5 class="mb-2">Employee Information</h5>
        <div class="scrollable-list">
          <p><strong>Name:</strong> {{ session('first_name') }} {{ session('middle_name') }} {{ session('last_name') }}</p>
          <p><strong>Email:</strong> {{ session('email') }}</p>
          <p><strong>Employee ID:</strong> {{ session('emp_id') }}</p>
          <p><strong>Position:</strong> {{ session('position') }}</p>
          <p><strong>Department:</strong> {{ session('department') }}</p>
          <p><strong>Company:</strong> {{ session('company') }}</p>
        </div>
      </div>
    </div>

    <!-- Recent Requests -->
    <div class="col-md-6">
      <div class="card p-3 equal-card">
        <h5 class="mb-2">Recent Requests</h5>
        <ul class="list-group list-group-flush scrollable-list">
          @if(isset($recentRequests) && $recentRequests->count() > 0)
            @foreach($recentRequests as $request)
              <li class="list-group-item">
                <div class="d-flex justify-content-between align-items-center">
                  <div>
                    <strong>{{ ucfirst($request->leave_type) }}</strong>
                    <br>
                    <small class="text-muted">{{ $request->start_date->format('M d') }} - {{ $request->end_date->format('M d, Y') }}</small>
                  </div>
                  <span class="badge bg-{{ $request->status == 'approved' ? 'success' : ($request->status == 'rejected' ? 'danger' : 'warning') }}">
                    {{ ucfirst($request->status) }}
                  </span>
                </div>
              </li>
            @endforeach
          @else
            <li class="list-group-item">No recent requests.</li>
          @endif
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
              'vacation' => ['icon'=>'🌴','label'=>'Vacation'],
              'sick' => ['icon'=>'🏥','label'=>'Sick'],
              'personal' => ['icon'=>'👤','label'=>'Personal'],
              'emergency' => ['icon'=>'🆘','label'=>'Emergency']
            ];
          @endphp
          @foreach($leaveTypes as $type => $info)
            @php
              $balance = $leaveBalance[$type] ?? ['total' => 0, 'remaining' => 0];
            @endphp
            <div class="col-6 col-md-3">
              <div class="leave-card">
                <span class="leave-icon">{{ $info['icon'] }}</span>
                <p class="leave-days">{{ $balance['remaining'] ?? 0 }}</p>
                <p class="leave-type">{{ $info['label'] }} Requests</p>
                <small class="text-muted">{{ $balance['total'] ?? 0 }} total</small>
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
