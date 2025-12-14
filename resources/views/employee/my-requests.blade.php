<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Employee | My Requests | LeaveWork</title>
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
  --radius: 14px;
  --shadow-light: 0 4px 15px rgba(25,24,59,0.06);
  --shadow-hover: 0 6px 20px rgba(25,24,59,0.12);
  --transition: 0.25s ease;
}

/* Body */
body {
  margin: 0;
  font-family: 'Inter', sans-serif;
  background-color: var(--light);
  color: var(--primary);
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

/* Page Header */
.dashboard-header {
  text-align: center;
  margin-bottom: 2.5rem;
}
.dashboard-header h2 { font-size: 2rem; font-weight: 700; }
.dashboard-header p { color: var(--secondary); }

/* Request Table Card */
.request-card {
  background: #fff;
  border-radius: var(--radius);
  box-shadow: var(--shadow-light);
  padding: 1.5rem;
  transition: var(--transition);
  margin-bottom: 1.5rem;
}
.request-card:hover { box-shadow: var(--shadow-hover); }

.request-table th, .request-table td {
  vertical-align: middle;
  text-align: center;
}
.status-badge {
  padding: 0.4rem 0.75rem;
  border-radius: var(--radius);
  font-size: 0.85rem;
  font-weight: 600;
  color: #fff;
}
.status-approved { background-color: var(--success); }
.status-pending { background-color: var(--warning); }
.status-rejected { background-color: var(--danger); }

/* Responsive */
@media(max-width: 992px) {
  #sidebar { transform: translateX(-100%); }
  .main-content { margin-left: 0; padding: 1rem; }
}
</style>
</head>

<body>

@include('layouts.sidebar')

<div class="main-content" id="mainContent">
  @include('layouts.topnav')

  <div class="content-wrapper">
    <div class="dashboard-header">
      <h2>My Requests</h2>
      <p>View and monitor all your submitted leave requests</p>
    </div>

    @if(session('success'))
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    @endif

    @if(isset($leaveRequests) && $leaveRequests->count() > 0)
      <div class="request-card">
        <table class="table request-table mb-0">
          <thead>
            <tr>
              <th>Leave Type</th>
              <th>Start Date</th>
              <th>End Date</th>
              <th>Days</th>
              <th>Status</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach($leaveRequests as $request)
            <tr>
              <td>
                @php
                  $typeIcons = [
                    'vacation' => '🌴',
                    'sick' => '🏥',
                    'personal' => '👤',
                    'emergency' => '🆘'
                  ];
                  $typeNames = [
                    'vacation' => 'Vacation Leave',
                    'sick' => 'Sick Leave',
                    'personal' => 'Personal Leave',
                    'emergency' => 'Emergency Leave'
                  ];
                @endphp
                {{ $typeIcons[$request->leave_type] ?? '' }} {{ $typeNames[$request->leave_type] ?? ucfirst($request->leave_type) }}
              </td>
              <td>{{ $request->start_date->format('M d, Y') }}</td>
              <td>{{ $request->end_date->format('M d, Y') }}</td>
              <td>{{ $request->start_date->diffInDays($request->end_date) + 1 }} day(s)</td>
              <td>
                @php
                  $statusClass = match($request->status){
                    'approved' => 'status-approved',
                    'pending' => 'status-pending',
                    'rejected' => 'status-rejected',
                    default => 'status-pending'
                  };
                @endphp
                <span class="status-badge {{ $statusClass }}">{{ ucfirst($request->status) }}</span>
              </td>
              <td>
                <button class="btn btn-sm btn-outline-primary" onclick="viewRequest({{ $request->id }})">View</button>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
        
        <!-- Pagination -->
        <div class="mt-3">
          {{ $leaveRequests->links() }}
        </div>
      </div>
    @else
      <div class="request-card text-center">
        <h5>No Requests Yet</h5>
        <p>Your leave requests will appear here once you submit them.</p>
        <a href="{{ route('employee.new_request') }}" class="btn btn-primary mt-3">Submit New Request</a>
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
</script>

</body>
</html>
