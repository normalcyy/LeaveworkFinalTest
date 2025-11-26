<!-- resources/views/admin/requests.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Admin | Manage Requests | LeaveWork</title>
<link rel="icon" type="image/png" href="{{ asset('assets/leavework_logo.png') }}">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

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

* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

body {
  font-family: 'Inter', sans-serif;
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
  border-right: 1px solid var(--accent);
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
  margin-left: 250px;
  padding: 2rem;
  transition: margin-left 0.3s ease;
  display: flex;
  flex-direction: column;
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

/* Content Wrapper */
.content-wrapper { 
  max-width: 1600px; 
  width: 100%; 
  margin: 0 auto; 
}

/* Header */
.dashboard-header {
  margin-bottom: 2.5rem;
}

.dashboard-header h2 { 
  font-size: 2rem; 
  font-weight: 700;
  margin: 0;
}

.dashboard-header p { 
  color: var(--secondary); 
  margin: 0.5rem 0 0 0;
}

/* Stats Cards */
.stats-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
  gap: 1.5rem;
  margin-bottom: 2rem;
}

.stat-card {
  background: #fff;
  border-radius: var(--radius);
  padding: 1.5rem;
  box-shadow: var(--shadow-light);
  transition: var(--transition);
  cursor: pointer;
  text-align: center;
}

.stat-card:hover {
  transform: translateY(-4px);
  box-shadow: var(--shadow-hover);
}

.stat-card.active {
  background: var(--primary);
  color: white;
}

.stat-card.active .stat-label,
.stat-card.active .stat-number {
  color: white;
}

.stat-icon {
  font-size: 2.2rem;
  margin-bottom: 0.5rem;
  display: block;
}

.stat-number {
  font-size: 1.8rem;
  font-weight: 700;
  margin: 0.5rem 0;
  color: var(--primary);
}

.stat-card.active .stat-number {
  color: white;
}

.stat-label {
  font-size: 0.95rem;
  font-weight: 500;
  color: var(--secondary);
}

.stat-card.active .stat-label {
  color: white;
}

/* Filter Bar */
.filter-bar {
  display: flex;
  gap: 1rem;
  margin-bottom: 1.5rem;
  flex-wrap: wrap;
  padding: 1rem;
  background: #fff;
  border-radius: var(--radius);
  box-shadow: var(--shadow-light);
}

.search-box {
  flex: 1;
  min-width: 250px;
  position: relative;
}

.search-icon {
  position: absolute;
  left: 1rem;
  top: 50%;
  transform: translateY(-50%);
  font-size: 1rem;
}

.search-box input {
  width: 100%;
  padding: 0.75rem 0.75rem 0.75rem 2.5rem;
  border: 1px solid var(--accent);
  border-radius: var(--radius);
  font-size: 0.95rem;
  transition: var(--transition);
  background: white;
}

.search-box input:focus {
  outline: none;
  border-color: var(--primary);
}

.filter-select {
  padding: 0.75rem 1rem;
  border: 1px solid var(--accent);
  border-radius: var(--radius);
  font-size: 0.95rem;
  font-weight: 500;
  cursor: pointer;
  transition: var(--transition);
  background: white;
  min-width: 160px;
}

.filter-select:focus {
  outline: none;
  border-color: var(--primary);
}

/* Table */
.table-container {
  background: #fff;
  border-radius: var(--radius);
  box-shadow: var(--shadow-light);
  overflow: hidden;
}

.requests-table {
  width: 100%;
  border-collapse: collapse;
}

.requests-table thead {
  background: var(--primary);
  color: white;
}

.requests-table th {
  padding: 1rem 1rem;
  text-align: left;
  font-weight: 600;
  font-size: 0.9rem;
}

.requests-table tbody tr {
  border-bottom: 1px solid var(--accent);
  transition: var(--transition);
}

.requests-table tbody tr:hover {
  background: var(--light);
}

.requests-table td {
  padding: 1rem 1rem;
  vertical-align: middle;
}

/* Employee Info */
.employee-info-cell {
  display: flex;
  align-items: center;
  gap: 0.75rem;
}

.employee-avatar {
  width: 40px;
  height: 40px;
  border-radius: 10px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-weight: 600;
  font-size: 1rem;
  color: white;
  background: var(--primary);
}

.employee-details {
  display: flex;
  flex-direction: column;
}

.employee-name {
  font-weight: 600;
  font-size: 0.95rem;
  margin: 0;
  color: var(--primary);
}

.employee-dept {
  font-size: 0.85rem;
  color: var(--secondary);
  margin: 0.2rem 0 0 0;
}

/* Leave Type Badge */
.leave-type-badge {
  display: inline-flex;
  align-items: center;
  gap: 0.4rem;
  padding: 0.4rem 0.8rem;
  border-radius: 8px;
  font-weight: 500;
  font-size: 0.85rem;
}

.leave-type-badge.vacation {
  background: #dbeafe;
  color: #1e40af;
}

.leave-type-badge.sick {
  background: #fce7f3;
  color: #be185d;
}

.leave-type-badge.personal {
  background: #fef3c7;
  color: #92400e;
}

.leave-type-badge.emergency {
  background: #fee2e2;
  color: #991b1b;
}

/* Date Info */
.date-info {
  display: flex;
  flex-direction: column;
  gap: 0.2rem;
}

.date-range {
  font-weight: 500;
  color: var(--primary);
  font-size: 0.9rem;
}

.date-duration {
  font-size: 0.85rem;
  color: var(--secondary);
}

/* Status Badge */
.status-badge {
  display: inline-block;
  padding: 0.4rem 0.8rem;
  border-radius: 8px;
  font-weight: 600;
  font-size: 0.85rem;
  text-transform: capitalize;
}

.status-badge.pending {
  background: #fef3c7;
  color: #92400e;
}

.status-badge.approved {
  background: #d1fae5;
  color: #065f46;
}

.status-badge.rejected {
  background: #fee2e2;
  color: #991b1b;
}

/* Action Buttons */
.action-buttons {
  display: flex;
  gap: 0.5rem;
  flex-wrap: wrap;
}

.btn-action {
  padding: 0.4rem 0.8rem;
  border: none;
  border-radius: 8px;
  font-weight: 500;
  font-size: 0.85rem;
  cursor: pointer;
  transition: var(--transition);
  display: inline-flex;
  align-items: center;
  gap: 0.3rem;
}

.btn-action.view {
  background: #dbeafe;
  color: #1e40af;
}

.btn-action.view:hover {
  background: #3b82f6;
  color: white;
}

.btn-action.approve {
  background: #d1fae5;
  color: #065f46;
}

.btn-action.approve:hover {
  background: #10b981;
  color: white;
}

.btn-action.reject {
  background: #fee2e2;
  color: #991b1b;
}

.btn-action.reject:hover {
  background: #ef4444;
  color: white;
}

/* Modal */
.modal-overlay {
  display: none;
  position: fixed;
  inset: 0;
  background: rgba(0,0,0,0.5);
  z-index: 2000;
  align-items: center;
  justify-content: center;
  animation: fadeIn 0.3s ease;
}

.modal-overlay.active { 
  display: flex; 
}

@keyframes fadeIn {
  from { opacity: 0; }
  to { opacity: 1; }
}

.modal-content {
  background: white;
  border-radius: var(--radius);
  padding: 0;
  max-width: 600px;
  width: 90%;
  max-height: 90vh;
  overflow-y: auto;
  box-shadow: 0 20px 40px rgba(0,0,0,0.3);
  animation: slideUp 0.3s ease;
}

@keyframes slideUp {
  from { 
    opacity: 0;
    transform: translateY(30px);
  }
  to { 
    opacity: 1;
    transform: translateY(0);
  }
}

.modal-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 1.5rem;
  background: var(--primary);
  color: white;
}

.modal-header h3 {
  margin: 0;
  font-size: 1.3rem;
  font-weight: 600;
}

.modal-close {
  background: rgba(255,255,255,0.2);
  border: none;
  color: white;
  font-size: 1.5rem;
  width: 35px;
  height: 35px;
  border-radius: 8px;
  cursor: pointer;
  transition: var(--transition);
  display: flex;
  align-items: center;
  justify-content: center;
  line-height: 1;
}

.modal-close:hover {
  background: rgba(255,255,255,0.3);
}

.modal-body {
  padding: 1.5rem;
}

.modal-actions {
  display: flex;
  gap: 1rem;
  padding: 1.5rem;
  border-top: 1px solid var(--accent);
}

.modal-btn {
  flex: 1;
  padding: 0.75rem 1.5rem;
  border: none;
  border-radius: var(--radius);
  font-weight: 600;
  font-size: 0.95rem;
  cursor: pointer;
  transition: var(--transition);
}

.modal-btn.approve {
  background: var(--success);
  color: white;
}

.modal-btn.approve:hover {
  background: #059669;
}

.modal-btn.reject {
  background: var(--danger);
  color: white;
}

.modal-btn.reject:hover {
  background: #dc2626;
}

/* Responsive */
@media(max-width: 992px) {
  #sidebar { 
    transform: translateX(-100%); 
  }
  
  .main-content { 
    margin-left: 0; 
    padding: 1rem; 
  }
  
  .dashboard-header h2 {
    font-size: 1.6rem;
  }
  
  .stats-grid {
    grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
    gap: 1rem;
  }
  
  .filter-bar {
    flex-direction: column;
  }
  
  .search-box {
    min-width: 100%;
  }
  
  .action-buttons {
    flex-direction: column;
  }
  
  .btn-action {
    width: 100%;
  }
}
</style>

</head>
<body>

@include('layouts.sidebar')

<div class="main-content" id="mainContent">
  @include('layouts.topnav')

  <div class="content-wrapper">

    <div class="dashboard-header">
      <h2>Manage Requests</h2>
      <p>Review and process employee leave requests</p>
    </div>

    <div class="stats-grid">
      <div class="stat-card all active" data-filter="all">
        <span class="stat-icon">📋</span>
        <p class="stat-number">12</p>
        <p class="stat-label">Total Requests</p>
      </div>
      <div class="stat-card pending" data-filter="pending">
        <span class="stat-icon">⏳</span>
        <p class="stat-number">5</p>
        <p class="stat-label">Pending</p>
      </div>
      <div class="stat-card approved" data-filter="approved">
        <span class="stat-icon">✅</span>
        <p class="stat-number">6</p>
        <p class="stat-label">Approved</p>
      </div>
      <div class="stat-card rejected" data-filter="rejected">
        <span class="stat-icon">❌</span>
        <p class="stat-number">1</p>
        <p class="stat-label">Rejected</p>
      </div>
    </div>

    <!-- Filters -->
    <div class="filter-bar">
      <div class="search-box">
        <span class="search-icon">🔍</span>
        <input type="text" id="searchInput" placeholder="Search by employee name or department...">
      </div>
      <select class="filter-select" id="leaveTypeFilter">
        <option value="all">All Leave Types</option>
        <option value="vacation">Vacation</option>
        <option value="sick">Sick Leave</option>
        <option value="personal">Personal</option>
        <option value="emergency">Emergency</option>
      </select>
      <select class="filter-select" id="dateFilter">
        <option value="all">All Dates</option>
        <option value="today">Today</option>
        <option value="week">This Week</option>
        <option value="month">This Month</option>
      </select>
    </div>

    <!-- Table -->
    <div class="table-container">
      <table class="requests-table">
        <thead>
          <tr>
            <th>Employee</th>
            <th>Leave Type</th>
            <th>Dates</th>
            <th>Reason</th>
            <th>Status</th>
            <th>Actions</th>
          </tr>
        </thead>

        <tbody id="requestsTableBody">
        @php
          $requests = [
            ['id'=>1,'name'=>'John Doe','dept'=>'Engineering','email'=>'john.doe@company.com','type'=>'vacation','icon'=>'🌴','start'=>'Dec 1, 2024','end'=>'Dec 5, 2024','days'=>5,'reason'=>'Family vacation','status'=>'pending'],
            ['id'=>2,'name'=>'Jane Smith','dept'=>'Marketing','email'=>'jane.smith@company.com','type'=>'sick','icon'=>'🏥','start'=>'Nov 28, 2024','end'=>'Nov 29, 2024','days'=>2,'reason'=>'Medical appointment','status'=>'approved'],
            ['id'=>3,'name'=>'Mike Johnson','dept'=>'Sales','email'=>'mike.j@company.com','type'=>'personal','icon'=>'👤','start'=>'Dec 10, 2024','end'=>'Dec 12, 2024','days'=>3,'reason'=>'Personal matters','status'=>'pending'],
            ['id'=>4,'name'=>'Sarah Williams','dept'=>'HR','email'=>'sarah.w@company.com','type'=>'vacation','icon'=>'🌴','start'=>'Nov 20, 2024','end'=>'Nov 27, 2024','days'=>8,'reason'=>'Annual leave','status'=>'approved'],
            ['id'=>5,'name'=>'David Brown','dept'=>'Engineering','email'=>'david.b@company.com','type'=>'sick','icon'=>'🏥','start'=>'Nov 25, 2024','end'=>'Nov 25, 2024','days'=>1,'reason'=>'Flu symptoms','status'=>'approved'],
            ['id'=>6,'name'=>'Emily Davis','dept'=>'Design','email'=>'emily.d@company.com','type'=>'emergency','icon'=>'🆘','start'=>'Nov 29, 2024','end'=>'Nov 30, 2024','days'=>2,'reason'=>'Family emergency','status'=>'pending'],
            ['id'=>7,'name'=>'Robert Taylor','dept'=>'Finance','email'=>'robert.t@company.com','type'=>'vacation','icon'=>'🌴','start'=>'Dec 15, 2024','end'=>'Dec 22, 2024','days'=>8,'reason'=>'Holiday trip','status'=>'pending'],
            ['id'=>8,'name'=>'Lisa Anderson','dept'=>'Operations','email'=>'lisa.a@company.com','type'=>'personal','icon'=>'👤','start'=>'Nov 26, 2024','end'=>'Nov 26, 2024','days'=>1,'reason'=>'Personal appointment','status'=>'approved'],
            ['id'=>9,'name'=>'James Wilson','dept'=>'Engineering','email'=>'james.w@company.com','type'=>'sick','icon'=>'🏥','start'=>'Nov 30, 2024','end'=>'Dec 1, 2024','days'=>2,'reason'=>'Doctor consultation','status'=>'rejected'],
            ['id'=>10,'name'=>'Maria Garcia','dept'=>'Marketing','email'=>'maria.g@company.com','type'=>'vacation','icon'=>'🌴','start'=>'Dec 3, 2024','end'=>'Dec 7, 2024','days'=>5,'reason'=>'Beach vacation','status'=>'pending'],
            ['id'=>11,'name'=>'Daniel Lee','dept'=>'Sales','email'=>'daniel.l@company.com','type'=>'personal','icon'=>'👤','start'=>'Nov 27, 2024','end'=>'Nov 28, 2024','days'=>2,'reason'=>'Moving house','status'=>'approved'],
            ['id'=>12,'name'=>'Jennifer Martinez','dept'=>'HR','email'=>'jennifer.m@company.com','type'=>'emergency','icon'=>'🆘','start'=>'Dec 2, 2024','end'=>'Dec 2, 2024','days'=>1,'reason'=>'Urgent family matter','status'=>'pending'],
          ];
        @endphp

        @foreach($requests as $req)
          <tr data-status="{{ $req['status'] }}" data-type="{{ $req['type'] }}">
            <td>
              <div class="employee-info-cell">
                <div class="employee-avatar">
                  {{ strtoupper(substr($req['name'], 0, 1)) }}
                </div>
                <div class="employee-details">
                  <p class="employee-name">{{ $req['name'] }}</p>
                  <p class="employee-dept">{{ $req['dept'] }}</p>
                </div>
              </div>
            </td>

            <td>
              <span class="leave-type-badge {{ $req['type'] }}">
                {{ $req['icon'] }} {{ ucfirst($req['type']) }}
              </span>
            </td>

            <td>
              <div class="date-info">
                <span class="date-range">{{ $req['start'] }} → {{ $req['end'] }}</span>
                <span class="date-duration">{{ $req['days'] }} day(s)</span>
              </div>
            </td>

            <td>{{ $req['reason'] }}</td>

            <td>
              <span class="status-badge {{ $req['status'] }}">
                {{ ucfirst($req['status']) }}
              </span>
            </td>

            <td>
              <div class="action-buttons">
                <button class="btn-action view">👁 View</button>
                <button class="btn-action approve">✔ Approve</button>
                <button class="btn-action reject">✖ Reject</button>
              </div>
            </td>

          </tr>
        @endforeach

        </tbody>
      </table>
    </div>

  </div>
</div>

<!-- Modal -->
<div class="modal-overlay" id="modalOverlay">
  <div class="modal-content">
    <div class="modal-header">
      <h3>Request Details</h3>
      <button class="modal-close" onclick="toggleModal()">×</button>
    </div>
    <div class="modal-body" id="modalBody"></div>

    <div class="modal-actions">
      <button class="modal-btn approve">Approve Request</button>
      <button class="modal-btn reject">Reject Request</button>
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

function toggleModal(content = null) {
  const modal = document.getElementById("modalOverlay");
  const body = document.getElementById("modalBody");

  if (content) body.innerHTML = content;
  modal.classList.toggle("active");
}
</script>

</body>
</html>