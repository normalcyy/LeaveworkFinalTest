<!-- resources/views/admin/requests.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">
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
        <p class="stat-number">{{ $totalCount ?? 0 }}</p>
        <p class="stat-label">Total Requests</p>
      </div>
      <div class="stat-card pending" data-filter="pending">
        <span class="stat-icon">⏳</span>
        <p class="stat-number">{{ $pendingCount ?? 0 }}</p>
        <p class="stat-label">Pending</p>
      </div>
      <div class="stat-card approved" data-filter="approved">
        <span class="stat-icon">✅</span>
        <p class="stat-number">{{ $approvedCount ?? 0 }}</p>
        <p class="stat-label">Approved</p>
      </div>
      <div class="stat-card rejected" data-filter="rejected">
        <span class="stat-icon">❌</span>
        <p class="stat-number">{{ $rejectedCount ?? 0 }}</p>
        <p class="stat-label">Rejected</p>
      </div>
    </div>

    <!-- Filters -->
    <form method="GET" action="{{ route('admin.requests') }}" id="filterForm">
      <div class="filter-bar">
        <div class="search-box">
          <span class="search-icon">🔍</span>
          <input type="text" name="search" id="searchInput" placeholder="Search by employee name or department..." 
                 value="{{ request('search') }}">
        </div>
        <select class="filter-select" name="leave_type" id="leaveTypeFilter">
          <option value="">All Leave Types</option>
          <option value="vacation" {{ request('leave_type') == 'vacation' ? 'selected' : '' }}>Vacation</option>
          <option value="sick" {{ request('leave_type') == 'sick' ? 'selected' : '' }}>Sick Leave</option>
          <option value="personal" {{ request('leave_type') == 'personal' ? 'selected' : '' }}>Personal</option>
          <option value="emergency" {{ request('leave_type') == 'emergency' ? 'selected' : '' }}>Emergency</option>
        </select>
        <select class="filter-select" name="status" id="statusFilter">
          <option value="">All Status</option>
          <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
          <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
          <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
        </select>
        <select class="filter-select" name="date_filter" id="dateFilter">
          <option value="">All Dates</option>
          <option value="today" {{ request('date_filter') == 'today' ? 'selected' : '' }}>Today</option>
          <option value="week" {{ request('date_filter') == 'week' ? 'selected' : '' }}>This Week</option>
          <option value="month" {{ request('date_filter') == 'month' ? 'selected' : '' }}>This Month</option>
        </select>
        <button type="submit" class="btn-action view">Apply Filters</button>
      </div>
    </form>

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
        @if(isset($leaveRequests) && $leaveRequests->count() > 0)
          @foreach($leaveRequests as $request)
            @php
              $typeIcons = [
                'vacation' => '🌴',
                'sick' => '🏥',
                'personal' => '👤',
                'emergency' => '🆘'
              ];
              $days = $request->start_date->diffInDays($request->end_date) + 1;
            @endphp
            <tr data-status="{{ $request->status }}" data-type="{{ $request->leave_type }}">
              <td>
                <div class="employee-info-cell">
                  <div class="employee-avatar">
                    {{ strtoupper(substr($request->user->first_name, 0, 1)) }}
                  </div>
                  <div class="employee-details">
                    <p class="employee-name">{{ $request->user->first_name }} {{ $request->user->last_name }}</p>
                    <p class="employee-dept">{{ $request->user->department }}</p>
                  </div>
                </div>
              </td>

              <td>
                <span class="leave-type-badge {{ $request->leave_type }}">
                  {{ $typeIcons[$request->leave_type] ?? '' }} {{ ucfirst($request->leave_type) }}
                </span>
              </td>

              <td>
                <div class="date-info">
                  <span class="date-range">{{ $request->start_date->format('M d, Y') }} → {{ $request->end_date->format('M d, Y') }}</span>
                  <span class="date-duration">{{ $days }} day(s)</span>
                </div>
              </td>

              <td>{{ \Illuminate\Support\Str::limit($request->reason, 50) }}</td>

              <td>
                <span class="status-badge {{ $request->status }}">
                  {{ ucfirst($request->status) }}
                </span>
              </td>

              <td>
                <div class="action-buttons">
                  <button class="btn-action view" onclick="viewRequest({{ $request->id }})">👁 View</button>
                  @if($request->status == 'pending')
                    <button class="btn-action approve" onclick="approveRequest({{ $request->id }})">✔ Approve</button>
                    <button class="btn-action reject" onclick="rejectRequest({{ $request->id }})">✖ Reject</button>
                  @else
                    <span class="text-muted">Processed</span>
                  @endif
                </div>
              </td>

            </tr>
          @endforeach
        @else
          <tr>
            <td colspan="6" class="text-center py-4">
              <p>No leave requests found.</p>
            </td>
          </tr>
        @endif

        </tbody>
      </table>
    </div>

    <!-- Pagination -->
    @if(isset($leaveRequests) && $leaveRequests->hasPages())
      <div class="mt-4">
        {{ $leaveRequests->links() }}
      </div>
    @endif

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

let currentRequestId = null;

function toggleModal(content = null) {
  const modal = document.getElementById("modalOverlay");
  const body = document.getElementById("modalBody");

  if (content) body.innerHTML = content;
  modal.classList.toggle("active");
}

function viewRequest(id) {
  currentRequestId = id;
  fetch(`/admin/requests/${id}`)
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        const request = data.request;
        const user = data.user;
        const days = data.days;
        
        const content = `
          <div class="request-details">
            <h4>Employee Information</h4>
            <p><strong>Name:</strong> ${user.first_name} ${user.last_name}</p>
            <p><strong>Email:</strong> ${user.email}</p>
            <p><strong>Department:</strong> ${user.department}</p>
            <p><strong>Position:</strong> ${user.position}</p>
            
            <h4 class="mt-3">Leave Request Details</h4>
            <p><strong>Leave Type:</strong> ${request.leave_type.charAt(0).toUpperCase() + request.leave_type.slice(1)}</p>
            <p><strong>Priority:</strong> ${request.priority.charAt(0).toUpperCase() + request.priority.slice(1)}</p>
            <p><strong>Start Date:</strong> ${new Date(request.start_date).toLocaleDateString()}</p>
            <p><strong>End Date:</strong> ${new Date(request.end_date).toLocaleDateString()}</p>
            <p><strong>Duration:</strong> ${days} day(s)</p>
            <p><strong>Reason:</strong> ${request.reason}</p>
            ${request.message ? `<p><strong>Additional Message:</strong> ${request.message}</p>` : ''}
            ${request.emergency_contact ? `<p><strong>Emergency Contact:</strong> ${request.emergency_contact}</p>` : ''}
            ${request.handover_to ? `<p><strong>Handover To:</strong> ${request.handover_to}</p>` : ''}
            <p><strong>Status:</strong> <span class="status-badge ${request.status}">${request.status.charAt(0).toUpperCase() + request.status.slice(1)}</span></p>
            <p><strong>Submitted:</strong> ${new Date(request.created_at).toLocaleString()}</p>
          </div>
        `;
        toggleModal(content);
        
        // Update modal action buttons
        const approveBtn = document.querySelector('.modal-btn.approve');
        const rejectBtn = document.querySelector('.modal-btn.reject');
        
        if (request.status === 'pending') {
          approveBtn.style.display = 'inline-block';
          rejectBtn.style.display = 'inline-block';
          approveBtn.onclick = () => approveRequest(id);
          rejectBtn.onclick = () => rejectRequest(id);
        } else {
          approveBtn.style.display = 'none';
          rejectBtn.style.display = 'none';
        }
      }
    })
    .catch(error => {
      console.error('Error:', error);
      alert('Failed to load request details');
    });
}

function approveRequest(id) {
  if (!confirm('Are you sure you want to approve this leave request?')) {
    return;
  }
  
  fetch(`/admin/requests/${id}/approve`, {
    method: 'POST',
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
        alert(data.error || 'Failed to approve request');
      }
    })
    .catch(error => {
      console.error('Error:', error);
      alert('Failed to approve request');
    });
}

function rejectRequest(id) {
  if (!confirm('Are you sure you want to reject this leave request?')) {
    return;
  }
  
  fetch(`/admin/requests/${id}/reject`, {
    method: 'POST',
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
        alert(data.error || 'Failed to reject request');
      }
    })
    .catch(error => {
      console.error('Error:', error);
      alert('Failed to reject request');
    });
}
</script>

</body>
</html>