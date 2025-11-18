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
}
body { 
  background-color: var(--light); 
  color: var(--primary); 
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
}
.content { 
  padding: 2rem; 
  min-height: 100vh; 
  width: 100%;
}
.card { 
  border: none;
  border-radius: 15px; 
  background-color: #ffffff; 
  box-shadow: 0 4px 15px rgba(25, 24, 59, 0.08); 
  transition: transform 0.2s ease;
}
.card:hover {
  transform: translateY(-2px);
  box-shadow: 0 6px 20px rgba(25, 24, 59, 0.12);
}
.leave-card { 
  text-align: center; 
  padding: 1.5rem; 
  border-radius: 12px; 
  background-color: #ffffff; 
  box-shadow: 0 3px 10px rgba(25, 24, 59, 0.06); 
  transition: transform 0.2s ease;
  border: 2px solid transparent;
}
.leave-card:hover { 
  transform: translateY(-4px); 
  border-color: var(--accent);
  box-shadow: 0 6px 15px rgba(25, 24, 59, 0.1);
}
.leave-icon { 
  font-size: 2rem; 
  display: block; 
  margin-bottom: 0.5rem; 
}
.leave-days { 
  font-size: 2rem; 
  font-weight: 700; 
  color: var(--primary); 
  margin: 0; 
}
.leave-type { 
  font-weight: 500; 
  color: var(--secondary); 
  font-size: 0.9rem;
}
.notification-unread { 
  font-weight: 600; 
  background-color: var(--light);
}
.list-group-item {
  border-color: var(--light);
}
h3, h5 {
  color: var(--primary);
}
p strong {
  color: var(--primary);
}
.equal-card {
  height: 185px;
  display: flex;
  flex-direction: column;
}
.scrollable-list {
  flex-grow: 1;
  overflow-y: auto;
  max-height: 220px;
}
.scrollable-list::-webkit-scrollbar {
  width: 6px;
}
.scrollable-list::-webkit-scrollbar-thumb {
  background-color: var(--secondary);
  border-radius: 10px;
}
.scrollable-list::-webkit-scrollbar-thumb:hover {
  background-color: var(--primary);
}
@media (max-width: 768px) {
  .content { padding: 1rem; }
  .equal-card { height: auto; }
}
</style>
</head>
<body>

<div class="container-fluid">
  <div class="row">
    {{-- Sidebar placeholder --}}
    <div class="col-md-2 bg-white p-3" style="min-height:100vh;">
      <h5>Sidebar</h5>
      <ul class="nav flex-column">
        <li class="nav-item"><a class="nav-link" href="#">Dashboard</a></li>
        <li class="nav-item"><a class="nav-link" href="#">My Leaves</a></li>
        <li class="nav-item"><a class="nav-link" href="#">Profile</a></li>
      </ul>
    </div>

    <div class="col-md-10 content">
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
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
