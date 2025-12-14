<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Create Admin | LeaveWork</title>
  <link rel="icon" type="image/png" href="{{ asset('assets/leavework_logo.png') }}">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
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

    /* Error messages */
    .invalid-feedback {
      display: block;
      color: #dc3545;
      font-size: 0.875rem;
      margin-top: 0.25rem;
    }
    .is-invalid {
      border-color: #dc3545 !important;
    }
    .alert {
      border-radius: 10px;
      padding: 1rem;
      margin-bottom: 1.5rem;
    }
    .alert-success {
      background-color: #d1fae5;
      border-color: #10b981;
      color: #065f46;
    }
    .alert-danger {
      background-color: #fee2e2;
      border-color: #ef4444;
      color: #7f1d1d;
    }

    /* Success Modal */
    .success-modal .modal-content {
      border-radius: 15px;
      border: none;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    }
    .success-modal .modal-header {
      border-bottom: none;
      padding: 2rem 2rem 0.5rem;
      justify-content: center;
    }
    .success-modal .modal-body {
      padding: 0 2rem 2rem;
      text-align: center;
    }
    .success-modal .modal-footer {
      border-top: none;
      padding: 0 2rem 2rem;
      justify-content: center;
    }
    .success-icon {
      width: 80px;
      height: 80px;
      background-color: #d1fae5;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 0 auto 1.5rem;
      color: #10b981;
      font-size: 2.5rem;
    }

    /* Form Status */
    #formStatus {
      display: none;
      margin-top: 1rem;
      padding: 0.75rem 1rem;
      border-radius: 10px;
      font-weight: 500;
    }
    #formStatus.success {
      display: block;
      background-color: #d1fae5;
      border: 1px solid #10b981;
      color: #065f46;
    }
    #formStatus.error {
      display: block;
      background-color: #fee2e2;
      border: 1px solid #ef4444;
      color: #7f1d1d;
    }

    /* Loading Spinner */
    .spinner-border {
      width: 1rem;
      height: 1rem;
      margin-right: 0.5rem;
    }

    @media (max-width: 992px) { 
      #sidebar { transform: translateX(-100%); }
      .main-content { margin-left: 0; }
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

    <div class="page-header">
      <h3>Create Admin</h3>
      <a href="{{ route('su.dashboard') }}" class="btn btn-primary">Cancel</a>
    </div>

    <!-- AJAX Form Status Message -->
    <div id="formStatus"></div>

    <!-- Display Success/Error Messages (for non-AJAX requests) -->
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

    <div class="card">
      <form action="{{ route('su.create_admin.post') }}" method="POST" id="createAdminForm">
        @csrf
        
        <div class="row mb-3">
          <div class="col-md-6">
            <label for="emp_id" class="form-label">Admin ID *</label>
            <input type="text" class="form-control @error('emp_id') is-invalid @enderror" 
                   id="emp_id" name="emp_id" 
                   value="{{ old('emp_id') }}" 
                   placeholder="ADM001" required>
            <div id="emp_id_error" class="invalid-feedback" style="display: none;"></div>
            @error('emp_id')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <small class="text-muted">Format: ADM000 (e.g., ADM001, ADM002)</small>
          </div>
          <div class="col-md-6">
            <label for="email" class="form-label">Email *</label>
            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                   id="email" name="email" 
                   value="{{ old('email') }}" 
                   placeholder="admin@company.com" required>
            <div id="email_error" class="invalid-feedback" style="display: none;"></div>
            @error('email')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
        </div>

        <div class="row mb-3">
          <div class="col-md-4">
            <label for="first_name" class="form-label">First Name *</label>
            <input type="text" class="form-control @error('first_name') is-invalid @enderror" 
                   id="first_name" name="first_name" 
                   value="{{ old('first_name') }}" 
                   placeholder="First Name" required>
            <div id="first_name_error" class="invalid-feedback" style="display: none;"></div>
            @error('first_name')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
          <div class="col-md-4">
            <label for="middle_name" class="form-label">Middle Name</label>
            <input type="text" class="form-control @error('middle_name') is-invalid @enderror" 
                   id="middle_name" name="middle_name" 
                   value="{{ old('middle_name') }}" 
                   placeholder="Middle Name">
            <div id="middle_name_error" class="invalid-feedback" style="display: none;"></div>
            @error('middle_name')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
          <div class="col-md-4">
            <label for="last_name" class="form-label">Last Name *</label>
            <input type="text" class="form-control @error('last_name') is-invalid @enderror" 
                   id="last_name" name="last_name" 
                   value="{{ old('last_name') }}" 
                   placeholder="Last Name" required>
            <div id="last_name_error" class="invalid-feedback" style="display: none;"></div>
            @error('last_name')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
        </div>

        <div class="row mb-3">
          <div class="col-md-12">
            <label for="department" class="form-label">Department *</label>
            <input type="text" class="form-control @error('department') is-invalid @enderror" 
                   id="department" name="department" 
                   value="{{ old('department') }}" 
                   placeholder="Department" required>
            <div id="department_error" class="invalid-feedback" style="display: none;"></div>
            @error('department')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
        </div>

        <div class="row mb-4">
          <div class="col-md-12">
            <label for="company" class="form-label">Company *</label>
            <select class="form-control @error('company') is-invalid @enderror" 
                   id="company" name="company" required>
              <option value="">Select Company</option>
              @if(isset($companies) && count($companies) > 0)
                @foreach($companies as $company)
                  <option value="{{ $company }}" {{ old('company') == $company ? 'selected' : '' }}>
                    {{ $company }}
                  </option>
                @endforeach
              @else
                <option value="" disabled>No companies available</option>
              @endif
            </select>
            <div id="company_error" class="invalid-feedback" style="display: none;"></div>
            @error('company')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            @if(!isset($companies) || count($companies) == 0)
              <small class="text-danger">No companies available. Please <a href="{{ route('su.create_company') }}">create a company first</a>.</small>
            @else
              <small class="text-muted">Select an existing company</small>
            @endif
          </div>
        </div>
        
        <input type="hidden" name="role" value="admin">

        <div class="alert alert-info">
          <strong>Note:</strong> The default password will be set to <strong>123456</strong>. 
          The admin should change this password upon first login.
        </div>

        <button type="submit" class="btn btn-primary w-100 py-2" id="submitBtn">
          <span id="submitText">Create Admin</span>
          <span id="submitSpinner" class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
        </button>
      </form>
    </div>

  </div>
</div>

<!-- Success Modal -->
<div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content success-modal">
      <div class="modal-header">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="success-icon">
          <i class="bi bi-check-circle-fill"></i>
        </div>
        <h4 class="mb-3" id="modalTitle">User Created Successfully!</h4>
        <p class="text-muted mb-4" id="modalMessage">
          The account has been created successfully. 
          The default password is <strong>123456</strong>.
        </p>
      </div>
      <div class="modal-footer">
        <a href="{{ route('su.dashboard') }}" class="btn btn-primary px-4">Return to Dashboard</a>
        <button type="button" class="btn btn-outline-primary px-4" onclick="resetForm()">Create Another Admin</button>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
  // Sidebar toggle
  const toggleBtn = document.getElementById('sidebarToggle');
  const sidebar = document.getElementById('sidebar');
  const mainContent = document.getElementById('mainContent');

  if (toggleBtn) {
    toggleBtn.addEventListener('click', () => {
      sidebar.classList.toggle('d-none');
      mainContent.style.marginLeft = sidebar.classList.contains('d-none') ? '0' : '250px';
    });
  }

  // Auto-hide alerts after 5 seconds
  document.addEventListener('DOMContentLoaded', function() {
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(function(alert) {
      setTimeout(function() {
        const bsAlert = new bootstrap.Alert(alert);
        bsAlert.close();
      }, 5000);
    });

    // Show success modal if admin was created via non-AJAX
    const successModal = document.getElementById('successModal');
    if (successModal && '{{ session("admin_created") }}') {
      const modal = new bootstrap.Modal(successModal);
      modal.show();
    }
  });


  // AJAX Form Submission
  $(document).ready(function() {
    const createAdminForm = $('#createAdminForm');
    const submitBtn = $('#submitBtn');
    const submitText = $('#submitText');
    const submitSpinner = $('#submitSpinner');
    const formStatus = $('#formStatus');
    const successModal = new bootstrap.Modal(document.getElementById('successModal'));

    // Store original button text
    const originalButtonText = submitText.text();

    // Handle form submission
    createAdminForm.on('submit', function(e) {
      e.preventDefault();

      // Show loading state
      submitText.text('Creating...');
      submitSpinner.removeClass('d-none');
      submitBtn.prop('disabled', true);

      // Clear previous errors and status
      clearErrors();
      formStatus.hide().removeClass('success error');
      
      // Get form data
      const formData = $(this).serialize();

      // Send AJAX request
      $.ajax({
        url: $(this).attr('action'),
        type: 'POST',
        data: formData,
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
          // Reset button state
          resetButtonState();
          
          // Show success modal
          if (response.success) {
            // Update modal content
            $('#modalTitle').text(response.title || 'User Created Successfully!');
            $('#modalMessage').html(response.message || 
              'The account has been created successfully. ' +
              'The default password is <strong>123456</strong>.');
            
            // Show success modal
            successModal.show();
            
            // Clear form
            createAdminForm[0].reset();
          }
        },
        error: function(xhr) {
          // Reset button state
          resetButtonState();

          // Handle validation errors
          if (xhr.status === 422) {
            const errors = xhr.responseJSON.errors;
            displayErrors(errors);
            
            // Show error status
            formStatus.text('Please fix the errors below.').addClass('error').show();
          } else {
            // Show general error
            formStatus.text('An error occurred. Please try again.').addClass('error').show();
          }
        }
      });
    });

    // Clear all error messages
    function clearErrors() {
      $('.form-control').removeClass('is-invalid');
      $('.invalid-feedback').hide().text('');
    }

    // Display validation errors
    function displayErrors(errors) {
      for (const field in errors) {
        const input = $(`[name="${field}"]`);
        const errorDiv = $(`#${field}_error`);
        
        if (input.length && errorDiv.length) {
          input.addClass('is-invalid');
          errorDiv.text(errors[field][0]).show();
        }
      }
    }

    // Reset button to original state
    function resetButtonState() {
      submitText.text(originalButtonText);
      submitSpinner.addClass('d-none');
      submitBtn.prop('disabled', false);
    }

    // Function to reset form and hide modal
    window.resetForm = function() {
      successModal.hide();
      createAdminForm[0].reset();
      clearErrors();
      formStatus.hide().removeClass('success error');
      
      // Focus on first input
      $('#emp_id').focus();
    };

    // Clear validation on input change
    $('.form-control').on('input', function() {
      $(this).removeClass('is-invalid');
      $(`#${this.name}_error`).hide();
    });
  });
</script>

</body>
</html>