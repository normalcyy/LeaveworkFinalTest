<!-- resources/views/superuser/profile.blade.php -->
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Superuser Profile | LeaveWork</title>
  <link rel="icon" type="image/png" href="{{ asset('assets/leavework_logo.png') }}">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <style>
    :root {
      --primary: #19183B;
      --secondary: #708993;
      --accent: #A1C2BD;
      --light: #E7F2EF;
      --success: #10b981;
      --danger: #ef4444;
      --card-bg: #fff;
      --text-dark: var(--primary);
      --text-muted: var(--secondary);
      --border-color: var(--accent);
      --hover-bg: #f1f5f9;
      --shadow: 0 4px 20px rgba(25, 24, 59, 0.08);
      --shadow-hover: 0 8px 30px rgba(25, 24, 59, 0.12);
    }

    /* Body */
    body {
      margin: 0;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      color: var(--text-dark);
      background: linear-gradient(135deg, var(--light) 0%, #f0f7f5 100%);
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
      box-shadow: var(--shadow);
    }

    #sidebar.d-none {
      transform: translateX(-100%);
    }

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
      padding: 1rem 1.5rem;
      border-radius: 16px;
      box-shadow: var(--shadow);
    }

    .topnav h4 {
      margin: 0;
      font-weight: 700;
      color: var(--primary);
      font-size: 1.5rem;
    }

    .topnav .btn-toggle {
      background: linear-gradient(135deg, var(--primary) 0%, #2a2860 100%);
      color: #fff;
      border: none;
      padding: 0.75rem 1.25rem;
      border-radius: 12px;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.3s ease;
      display: flex;
      align-items: center;
      gap: 0.5rem;
      box-shadow: 0 4px 12px rgba(25, 24, 59, 0.2);
    }

    .topnav .btn-toggle:hover {
      transform: translateY(-2px);
      box-shadow: 0 6px 16px rgba(25, 24, 59, 0.3);
    }

    /* Content Wrapper */
    .content-wrapper {
      max-width: 1400px;
      width: 100%;
      margin: 0 auto;
    }

    /* Profile Header */
    .profile-header-card {
      background: linear-gradient(135deg, var(--primary) 0%, #2a2860 100%);
      color: white;
      border-radius: 20px;
      padding: 2.5rem;
      display: flex;
      gap: 2rem;
      align-items: center;
      margin-bottom: 2.5rem;
      box-shadow: var(--shadow);
      position: relative;
      overflow: hidden;
    }

    .profile-header-card::before {
      content: '';
      position: absolute;
      top: 0;
      right: 0;
      width: 150px;
      height: 150px;
      background: rgba(255, 255, 255, 0.05);
      border-radius: 50%;
      transform: translate(30%, -30%);
    }

    .profile-avatar {
      width: 120px;
      height: 120px;
      border-radius: 50%;
      background: var(--card-bg);
      display: flex;
      justify-content: center;
      align-items: center;
      font-size: 2.5rem;
      color: var(--primary);
      font-weight: 700;
      box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
      z-index: 1;
      transition: transform 0.3s ease;
    }

    .profile-avatar:hover {
      transform: scale(1.05);
    }

    .profile-info .profile-name {
      font-size: 2rem;
      font-weight: 800;
      margin-bottom: 0.5rem;
    }

    .profile-role {
      display: flex;
      align-items: center;
      gap: 0.75rem;
      font-size: 1.1rem;
    }

    .role-badge {
      background: var(--accent);
      padding: 0.4rem 1rem;
      border-radius: 20px;
      font-size: 0.9rem;
      font-weight: 600;
      color: var(--primary);
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    /* Details Grid */
    .details-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
      gap: 2rem;
    }

    /* Detail Card */
    .detail-card {
      background: var(--card-bg);
      border-radius: 20px;
      padding: 2rem;
      border: 1px solid rgba(161, 194, 189, 0.3);
      transition: all 0.3s ease;
      position: relative;
      box-shadow: var(--shadow);
    }

    .detail-card:hover {
      transform: translateY(-5px);
      box-shadow: var(--shadow-hover);
      border-color: var(--accent);
    }

    .detail-card-header {
      display: flex;
      align-items: center;
      gap: 0.75rem;
      margin-bottom: 1.5rem;
      padding-bottom: 1rem;
      border-bottom: 1px solid rgba(161, 194, 189, 0.3);
    }

    .detail-icon {
      font-size: 1.5rem;
      width: 40px;
      height: 40px;
      display: flex;
      align-items: center;
      justify-content: center;
      background: rgba(161, 194, 189, 0.2);
      border-radius: 10px;
    }

    .detail-card-title {
      font-weight: 700;
      font-size: 1.3rem;
      color: var(--primary);
    }

    /* Edit Button */
    .edit-btn {
      position: absolute;
      top: 1.5rem;
      right: 1.5rem;
      background: linear-gradient(135deg, var(--primary) 0%, #2a2860 100%);
      color: #fff;
      border: none;
      border-radius: 10px;
      padding: 0.5rem 1rem;
      font-size: 0.9rem;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.3s ease;
      display: flex;
      align-items: center;
      gap: 0.5rem;
      box-shadow: 0 3px 10px rgba(25, 24, 59, 0.2);
    }

    .edit-btn:hover {
      transform: translateY(-2px);
      box-shadow: 0 5px 15px rgba(25, 24, 59, 0.3);
    }

    /* Detail Item */
    .detail-item {
      display: flex;
      justify-content: space-between;
      padding: 1rem 0;
      border-bottom: 1px solid rgba(161, 194, 189, 0.3);
      transition: background-color 0.2s ease;
    }

    .detail-item:hover {
      background-color: rgba(161, 194, 189, 0.05);
      border-radius: 8px;
      padding-left: 0.5rem;
      padding-right: 0.5rem;
    }

    .detail-item:last-child {
      border-bottom: none;
    }

    .detail-label {
      color: var(--text-muted);
      font-weight: 600;
      font-size: 0.95rem;
    }

    .detail-value {
      font-weight: 500;
      text-align: right;
      color: var(--text-dark);
    }

    /* Modal Styles */
    .modal-content {
      border-radius: 20px;
      border: none;
      box-shadow: var(--shadow-hover);
      overflow: hidden;
    }

    .modal-header {
      background: linear-gradient(135deg, var(--primary) 0%, #2a2860 100%);
      color: white;
      padding: 1.5rem 2rem;
      border-bottom: none;
    }

    .modal-title {
      font-weight: 700;
      font-size: 1.5rem;
    }

    .modal-body {
      padding: 2rem;
    }

    .modal-footer {
      padding: 1.5rem 2rem;
      border-top: 1px solid rgba(161, 194, 189, 0.3);
    }

    .btn-primary {
      background: linear-gradient(135deg, var(--primary) 0%, #2a2860 100%);
      border: none;
      border-radius: 10px;
      padding: 0.75rem 1.5rem;
      font-weight: 600;
      transition: all 0.3s ease;
    }

    .btn-primary:hover {
      transform: translateY(-2px);
      box-shadow: 0 5px 15px rgba(25, 24, 59, 0.3);
    }

    .btn-secondary {
      background: #f8f9fa;
      border: 1px solid #dee2e6;
      color: var(--text-dark);
      border-radius: 10px;
      padding: 0.75rem 1.5rem;
      font-weight: 600;
      transition: all 0.3s ease;
    }

    .btn-secondary:hover {
      background: #e9ecef;
      transform: translateY(-2px);
    }

    .form-label {
      font-weight: 600;
      color: var(--text-dark);
      margin-bottom: 0.5rem;
    }

    .form-control {
      border: 1px solid rgba(161, 194, 189, 0.5);
      border-radius: 10px;
      padding: 0.75rem 1rem;
      transition: all 0.3s ease;
    }

    .form-control:focus {
      border-color: var(--accent);
      box-shadow: 0 0 0 0.25rem rgba(161, 194, 189, 0.25);
    }

    /* Responsive */
    @media(max-width: 992px) {
      .details-grid {
        grid-template-columns: 1fr;
      }
    }

    @media(max-width:768px) {
      .profile-header-card {
        flex-direction: column;
        text-align: center;
        gap: 1.5rem;
        padding: 2rem;
      }

      .profile-avatar {
        width: 100px;
        height: 100px;
        font-size: 2rem;
      }

      .profile-info .profile-name {
        font-size: 1.75rem;
      }

      .detail-item {
        flex-direction: column;
        gap: 0.5rem;
      }

      .detail-value {
        text-align: left;
      }

      .edit-btn {
        top: 1rem;
        right: 1rem;
      }

      .main-content {
        padding: 1rem;
      }
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

      <!-- Profile Header -->
      <div class="profile-header-card">
        <div class="profile-avatar">
          {{ strtoupper(substr($user->first_name,0,1) . substr($user->last_name,0,1)) }}
        </div>
        <div class="profile-info">
          <div class="profile-name">
            {{ $user->first_name }} {{ $user->middle_name ? $user->middle_name.' ' : '' }}{{ $user->last_name }}
          </div>
          <div class="profile-role">
            <span>{{ $user->position ?? 'Administrator' }}</span>
            <span class="role-badge">{{ ucfirst($user->role) }}</span>
          </div>

          <!-- Change Password Button -->
          <button class="btn btn-warning mt-3" data-bs-toggle="modal" data-bs-target="#changePasswordModal">
            <i class="fas fa-key"></i> Change Password
          </button>
        </div>
      </div>

      <!-- Details Grid -->
      <div class="details-grid">

        <!-- Personal Info Card -->
        <div class="detail-card">
          <button class="edit-btn" data-bs-toggle="modal" data-bs-target="#editPersonalModal">
            <i class="fas fa-edit"></i> Edit
          </button>
          <div class="detail-card-header">
            <div class="detail-icon">👤</div>
            <h4 class="detail-card-title">Personal Information</h4>
          </div>
          <div class="detail-item">
            <span class="detail-label">Employee ID</span>
            <span class="detail-value">{{ $user->emp_id }}</span>
          </div>
          <div class="detail-item">
            <span class="detail-label">First Name</span>
            <span class="detail-value">{{ $user->first_name }}</span>
          </div>
          <div class="detail-item">
            <span class="detail-label">Middle Name</span>
            <span class="detail-value">{{ $user->middle_name ?? '-' }}</span>
          </div>
          <div class="detail-item">
            <span class="detail-label">Last Name</span>
            <span class="detail-value">{{ $user->last_name }}</span>
          </div>
        </div>

        <!-- Contact Info Card -->
        <div class="detail-card">
          <div class="detail-card-header">
            <div class="detail-icon">📧</div>
            <h4 class="detail-card-title">Contact Information</h4>
          </div>
          <div class="detail-item">
            <span class="detail-label">Email</span>
            <span class="detail-value">{{ $user->email }}</span>
          </div>
        </div>

        <!-- Work Info Card -->
        <div class="detail-card">
          <div class="detail-card-header">
            <div class="detail-icon">💼</div>
            <h4 class="detail-card-title">Work Information</h4>
          </div>
          <div class="detail-item">
            <span class="detail-label">Role</span>
            <span class="detail-value">{{ ucfirst($user->role) }}</span>
          </div>
          <div class="detail-item">
            <span class="detail-label">Position</span>
            <span class="detail-value">{{ $user->position ?? '-' }}</span>
          </div>
          <div class="detail-item">
            <span class="detail-label">Department</span>
            <span class="detail-value">{{ $user->department ?? '-' }}</span>
          </div>
          <div class="detail-item">
            <span class="detail-label">Company</span>
            <span class="detail-value">{{ $user->company ?? '-' }}</span>
          </div>
        </div>

      </div>
    </div>
  </div>

  <!-- Edit Personal Information Modal -->
  <div class="modal fade" id="editPersonalModal" tabindex="-1" aria-labelledby="editPersonalModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editPersonalModalLabel">Edit Personal Information</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form method="POST" action="{{ route('profile.update.info') }}">
            @csrf
            <div class="mb-3">
              <label for="firstName" class="form-label">First Name</label>
              <input type="text" class="form-control" id="firstName" name="first_name" value="{{ $user->first_name }}" required>
              @error('first_name')
              <div class="text-danger mt-1">{{ $message }}</div>
              @enderror
            </div>
            <div class="mb-3">
              <label for="middleName" class="form-label">Middle Name</label>
              <input type="text" class="form-control" id="middleName" name="middle_name" value="{{ $user->middle_name }}">
              @error('middle_name')
              <div class="text-danger mt-1">{{ $message }}</div>
              @enderror
            </div>
            <div class="mb-3">
              <label for="lastName" class="form-label">Last Name</label>
              <input type="text" class="form-control" id="lastName" name="last_name" value="{{ $user->last_name }}" required>
              @error('last_name')
              <div class="text-danger mt-1">{{ $message }}</div>
              @enderror
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
              <button type="submit" class="btn btn-primary">Save Changes</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>


  <!-- Change Password Modal -->
  <div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="changePasswordModalLabel">Change Password</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form id="changePasswordForm" method="POST" action="{{ route('profile.update.password') }}">
            @csrf
            <div class="mb-3">
              <label for="currentPassword" class="form-label">Current Password</label>
              <input type="password" class="form-control" id="currentPassword" name="current_password" required>
              <div id="currentPasswordError" class="text-danger mt-1" style="display: none;"></div>
            </div>
            <div class="mb-3">
              <label for="newPassword" class="form-label">New Password</label>
              <input type="password" class="form-control" id="newPassword" name="password" required>
              <div id="passwordError" class="text-danger mt-1" style="display: none;"></div>
            </div>
            <div class="mb-3">
              <label for="confirmPassword" class="form-label">Confirm New Password</label>
              <input type="password" class="form-control" id="confirmPassword" name="password_confirmation" required>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
              <button type="submit" class="btn btn-primary" id="updatePasswordBtn">
                <span id="updatePasswordText">Update Password</span>
                <span id="updatePasswordSpinner" class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
              </button>
            </div>
          </form>

          <!-- Success Message (initially hidden) -->
          <div id="passwordSuccessAlert" class="alert alert-success mt-3" style="display: none;">
            <i class="fas fa-check-circle me-2"></i>
            <span id="successMessage">Password updated successfully!</span>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Success Alert -->
  @if(session('success'))
  <script>
    window.addEventListener('DOMContentLoaded', () => {
      const successModal = new bootstrap.Modal(document.getElementById('successModal'));
      successModal.show();
    });
  </script>
  <div class="modal fade" id="successModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header bg-success text-white">
          <h5 class="modal-title">Success</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          {{ session('success') }}
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-success" data-bs-dismiss="modal">OK</button>
        </div>
      </div>
    </div>
  </div>
  @endif

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    const toggleBtn = document.getElementById('sidebarToggle');
    const sidebar = document.getElementById('sidebar');
    const mainContent = document.getElementById('mainContent');

    toggleBtn?.addEventListener('click', () => {
      sidebar.classList.toggle('d-none');
      mainContent.style.marginLeft = sidebar.classList.contains('d-none') ? '0' : '250px';
    });
  </script>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>
    $(document).ready(function() {
      const changePasswordForm = $('#changePasswordForm');
      const updatePasswordBtn = $('#updatePasswordBtn');
      const updatePasswordText = $('#updatePasswordText');
      const updatePasswordSpinner = $('#updatePasswordSpinner');
      const passwordSuccessAlert = $('#passwordSuccessAlert');
      const changePasswordModal = document.getElementById('changePasswordModal');
      const modalInstance = bootstrap.Modal.getInstance(changePasswordModal) || new bootstrap.Modal(changePasswordModal);

      // Clear errors when modal is shown
      $('#changePasswordModal').on('show.bs.modal', function() {
        clearErrors();
        passwordSuccessAlert.hide();
        changePasswordForm.show();
      });

      // Handle form submission
      changePasswordForm.on('submit', function(e) {
        e.preventDefault();

        // Show loading state
        updatePasswordText.text('Updating...');
        updatePasswordSpinner.removeClass('d-none');
        updatePasswordBtn.prop('disabled', true);

        // Clear previous errors
        clearErrors();
        passwordSuccessAlert.hide();

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
            // Show success message
            passwordSuccessAlert.show();
            changePasswordForm.hide();

            // Reset button state
            resetButtonState();

            // Close modal after 2 seconds
            setTimeout(function() {
              modalInstance.hide();
              // Reload page to reflect changes if needed
              window.location.reload();
            }, 2000);
          },
          error: function(xhr) {
            // Reset button state
            resetButtonState();

            // Handle validation errors
            if (xhr.status === 422) {
              const errors = xhr.responseJSON.errors;
              displayErrors(errors);
            } else {
              // Show general error
              $('#currentPasswordError').text('An error occurred. Please try again.').show();
            }
          }
        });
      });

      // Clear error messages
      function clearErrors() {
        $('.text-danger').hide().text('');
      }

      // Display validation errors
      function displayErrors(errors) {
        if (errors.current_password) {
          $('#currentPasswordError').text(errors.current_password[0]).show();
        }
        if (errors.password) {
          $('#passwordError').text(errors.password[0]).show();
        }
      }

      // Reset button to original state
      function resetButtonState() {
        updatePasswordText.text('Update Password');
        updatePasswordSpinner.addClass('d-none');
        updatePasswordBtn.prop('disabled', false);
      }

      // Also update the Personal Info Modal to work similarly
      $('#editPersonalModal form').on('submit', function(e) {
        e.preventDefault();

        const form = $(this);
        const submitBtn = form.find('button[type="submit"]');
        const originalText = submitBtn.text();

        // Show loading
        submitBtn.text('Saving...').prop('disabled', true);

        $.ajax({
          url: form.attr('action'),
          type: 'POST',
          data: form.serialize(),
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          success: function(response) {
            submitBtn.text('Saved!');

            // Close modal after 1.5 seconds
            setTimeout(function() {
              bootstrap.Modal.getInstance(document.getElementById('editPersonalModal')).hide();
              window.location.reload();
            }, 1500);
          },
          error: function(xhr) {
            submitBtn.text(originalText).prop('disabled', false);

            // Handle errors - you can add error display similar to password form
            if (xhr.status === 422) {
              alert('Please check your inputs and try again.');
            }
          }
        });
      });
    });
  </script>


</body>

</html>