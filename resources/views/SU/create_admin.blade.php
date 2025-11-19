<!-- resources/views/su/create_admin.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Create Admin | LeaveWork</title>
  <link rel="icon" type="image/png" href="{{ asset('assets/leavework_logo.png') }}">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    :root {
      --primary: #19183B;
      --secondary: #708993;
      --accent: #A1C2BD;
      --light: #E7F2EF;
      --success: #10b981;
      --border-color: var(--accent);
      --hover-bg: #f1f5f9;
      --text-dark: var(--primary);
      --text-muted: var(--secondary);
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
      position: fixed;
      top: 0;
      left: 0;
      overflow-y: auto;
      transition: transform 0.3s ease;
      z-index: 1000;
    }
    #sidebar.d-none { transform: translateX(-100%); }

    /* Main Content */
    .main-content {
      flex: 1;
      margin-left: 250px;
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
    .topnav h4 { margin: 0; font-weight: 600; color: var(--primary); }
    .topnav .btn-toggle {
      background-color: var(--primary);
      color: #fff;
      border: none;
      padding: 0.5rem 1rem;
      border-radius: 8px;
      font-weight: 600;
      cursor: pointer;
    }
    .topnav .btn-toggle:hover { background-color: var(--secondary); }

    /* Content */
    .content-wrapper {
      max-width: 900px;
      margin: 0 auto;
      width: 100%;
    }

    .page-header {
      margin-bottom: 2rem;
      display: flex;
      justify-content: space-between;
      align-items: center;
      flex-wrap: wrap;
      gap: 1rem;
    }
    .page-header h3 {
      font-size: 1.75rem;
      font-weight: 600;
      color: var(--text-dark);
    }

    .btn-primary {
      padding: 0.75rem 1.75rem;
      font-weight: 500;
      font-size: 0.95rem;
      border-radius: 10px;
      border: none;
      background: var(--primary);
      color: white;
      transition: all 0.3s ease;
    }
    .btn-primary:hover {
      background: var(--secondary);
      transform: translateY(-2px);
      box-shadow: 0 8px 20px rgba(25, 24, 59, 0.25);
    }

    .card {
      border-radius: 15px;
      padding: 2rem;
      box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
      border: 1px solid var(--border-color);
    }

    .form-label { font-weight: 500; }
    .form-control, .form-select {
      border-radius: 10px;
      border: 1.5px solid var(--border-color);
      padding: 0.875rem 1.125rem;
      font-size: 1rem;
    }
    .form-control:focus, .form-select:focus {
      border-color: var(--primary);
      box-shadow: 0 0 0 4px rgba(25, 24, 59, 0.1);
      outline: none;
    }

    /* Modal */
    .modal-content { border-radius: 15px; }
    .modal-header { border-bottom: 1px solid var(--border-color); }
    .modal-body { padding: 2rem 1.5rem; }
    .modal-footer { border-top: 1px solid var(--border-color); }

    @media (max-width: 992px) { #sidebar { transform: translateX(-100%); } }
  </style>
</head>
<body>

<!-- Sidebar -->
@include('layouts.sidebar')

<!-- Main Content -->
<div class="main-content" id="mainContent">
  @include('layouts.topnav')

  <div class="content-wrapper">

    <div class="page-header">
      <h3>Create Admin</h3>
      <a href="{{ url('/superuser/dashboard') }}" class="btn btn-primary">Cancel</a>
    </div>

    <div class="card">
      <form id="createAdminForm">
        <div class="row mb-3">
          <div class="col-md-6">
            <label for="employee_id" class="form-label">Employee ID *</label>
            <input type="text" class="form-control" id="employee_id" placeholder="Employee ID" required>
          </div>
          <div class="col-md-6">
            <label for="email" class="form-label">Email *</label>
            <input type="email" class="form-control" id="email" placeholder="employee@company.com" required>
          </div>
        </div>

        <div class="row mb-3">
          <div class="col-md-4">
            <label for="first_name" class="form-label">First Name *</label>
            <input type="text" class="form-control" id="first_name" placeholder="First Name" required>
          </div>
          <div class="col-md-4">
            <label for="middle_name" class="form-label">Middle Name</label>
            <input type="text" class="form-control" id="middle_name" placeholder="Middle Name">
          </div>
          <div class="col-md-4">
            <label for="last_name" class="form-label">Last Name *</label>
            <input type="text" class="form-control" id="last_name" placeholder="Last Name" required>
          </div>
        </div>

        <div class="row mb-3">
          <div class="col-md-6">
            <label for="position" class="form-label">Position</label>
            <input type="text" class="form-control" id="position" placeholder="Position">
          </div>
          <div class="col-md-6">
            <label for="department" class="form-label">Department</label>
            <input type="text" class="form-control" id="department" placeholder="Department">
          </div>
        </div>

        <div class="mb-3">
          <label for="role" class="form-label">Role</label>
          <input type="text" class="form-control" id="role" value="admin" readonly>
        </div>

        <button type="submit" class="btn btn-primary w-100">Create Admin</button>
      </form>
    </div>

  </div>
</div>

<!-- Success Modal -->
<div class="modal fade" id="successModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-success text-white">
        <h5 class="modal-title">Success</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        Admin has been created successfully!
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary w-100" data-bs-dismiss="modal">OK</button>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
  document.getElementById('createAdminForm').addEventListener('submit', function(e){
    e.preventDefault();
    const successModal = new bootstrap.Modal(document.getElementById('successModal'));
    successModal.show();
    this.reset();
  });

  const toggleBtn = document.getElementById('sidebarToggle');
  const sidebar = document.getElementById('sidebar');
  const mainContent = document.getElementById('mainContent');

  toggleBtn?.addEventListener('click', () => {
    sidebar.classList.toggle('d-none');
    mainContent.style.marginLeft = sidebar.classList.contains('d-none') ? '0' : '250px';
  });
</script>

</body>
</html>
