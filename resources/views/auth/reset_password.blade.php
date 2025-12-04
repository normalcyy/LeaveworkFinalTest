<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Reset Password | LeaveWork</title>
<link rel="icon" type="image/png" href="{{ asset('assets/leavework_logo.png') }}">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

<style>
:root {
  --primary: #19183B;
  --secondary: #708993;
  --accent: #A1C2BD;
  --light: #E7F2EF;
}

body {
  background: linear-gradient(135deg, var(--light) 0%, #d4e8e5 100%);
  display: flex;
  align-items: center;
  justify-content: center;
  min-height: 100vh;
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  padding: 1rem;
}

.login-card {
  width: 100%;
  max-width: 420px;
  border-radius: 20px;
  background: #ffffff;
  padding: 3rem 2.5rem;
  box-shadow: 0 10px 40px rgba(25, 24, 59, 0.1);
}

.brand-section {
  text-align: center;
  margin-bottom: 2rem;
}

.brand {
  font-weight: 700;
  font-size: 2rem;
  color: var(--primary);
  margin-bottom: 0.25rem;
  letter-spacing: -0.5px;
}

.brand-subtitle {
  color: var(--secondary);
  font-size: 0.875rem;
  font-weight: 500;
  text-transform: uppercase;
}

.form-label {
  color: var(--primary);
  font-weight: 600;
  font-size: 0.875rem;
  margin-bottom: 0.5rem;
}

.form-control {
  background-color: var(--light);
  color: var(--primary);
  border: 1px solid transparent;
  padding: 0.875rem 1rem;
  font-size: 0.95rem;
  border-radius: 10px;
  transition: all 0.3s ease;
}

.form-control:focus {
  background-color: #ffffff;
  border-color: var(--accent);
  box-shadow: 0 0 0 3px rgba(161, 194, 189, 0.15);
}

.btn-login {
  width: 100%;
  background-color: var(--primary);
  border: none;
  color: #fff;
  font-weight: 600;
  padding: 0.875rem;
  font-size: 1rem;
  border-radius: 10px;
  transition: all 0.3s ease;
  margin-top: 1rem;
}

.btn-login:hover {
  background-color: #0f0e2d;
  transform: translateY(-1px);
  box-shadow: 0 4px 12px rgba(25, 24, 59, 0.25);
}

.bottom-text {
  text-align: center;
  color: var(--secondary);
  font-size: 0.875rem;
  margin-top: 1.5rem;
}

.alert-danger {
  background-color: #fee;
  color: #c33;
  border: 1px solid #fcc;
  border-radius: 10px;
  font-size: 0.875rem;
  padding: 0.75rem 1rem;
  margin-bottom: 1.5rem;
}

.alert-success {
  background-color: #d4edda;
  color: #155724;
  border: 1px solid #c3e6cb;
  border-radius: 10px;
  font-size: 0.875rem;
  padding: 0.75rem 1rem;
  margin-bottom: 1.5rem;
}

/* Setup reminder message */
.setup-reminder {
  background: linear-gradient(135deg, #fff3cd 0%, #ffeaa7 100%);
  color: #856404;
  border: 1px solid #ffeaa7;
  border-radius: 10px;
  padding: 0.875rem 1rem;
  margin-bottom: 1.5rem;
  display: flex;
  align-items: center;
  gap: 0.75rem;
  font-size: 0.875rem;
  font-weight: 500;
  animation: slideIn 0.5s ease-out;
}

.setup-reminder .reminder-icon {
  font-size: 1.25rem;
  color: #f39c12;
}

.setup-reminder.fade-out {
  animation: fadeOut 0.5s ease-out forwards;
}

/* Password strength indicator */
.password-strength {
  margin-top: 0.5rem;
  font-size: 0.75rem;
}

.strength-bar {
  height: 4px;
  width: 100%;
  background-color: #e9ecef;
  border-radius: 2px;
  margin-top: 0.25rem;
  overflow: hidden;
}

.strength-fill {
  height: 100%;
  width: 0%;
  border-radius: 2px;
  transition: all 0.3s ease;
}

.strength-fill.weak {
  background-color: #e74c3c;
  width: 33%;
}

.strength-fill.moderate {
  background-color: #f39c12;
  width: 66%;
}

.strength-fill.strong {
  background-color: #27ae60;
  width: 100%;
}

/* Success Modal Styles */
#successModal .modal-content {
  border-radius: 20px;
  border: none;
  box-shadow: 0 10px 40px rgba(25, 24, 59, 0.15);
}

#successModal .modal-header {
  background: linear-gradient(135deg, #10b981 0%, #059669 100%);
  color: white;
  border-bottom: none;
  border-radius: 20px 20px 0 0;
  padding: 1.5rem 2rem;
}

#successModal .modal-title {
  font-weight: 700;
}

#successModal .modal-body {
  padding: 2rem;
  text-align: center;
}

#successModal .success-icon {
  font-size: 4rem;
  color: #10b981;
  margin-bottom: 1.5rem;
}

#successModal .success-message {
  font-size: 1.1rem;
  color: var(--primary);
  font-weight: 500;
}

#successModal .modal-footer {
  border-top: none;
  justify-content: center;
  padding: 0 2rem 2rem;
}

#successModal .btn-success {
  background: linear-gradient(135deg, #10b981 0%, #059669 100%);
  border: none;
  border-radius: 10px;
  padding: 0.75rem 2rem;
  font-weight: 600;
  transition: all 0.3s ease;
}

#successModal .btn-success:hover {
  transform: translateY(-2px);
  box-shadow: 0 5px 15px rgba(16, 185, 129, 0.3);
}

/* Animations */
@keyframes slideIn {
  from {
    opacity: 0;
    transform: translateY(-10px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

@keyframes fadeOut {
  from {
    opacity: 1;
    transform: translateY(0);
  }
  to {
    opacity: 0;
    transform: translateY(-10px);
    display: none;
  }
}

@keyframes pulse {
  0%, 100% {
    transform: scale(1);
  }
  50% {
    transform: scale(1.05);
  }
}

/* Pulsing effect for important elements */
.pulse-animation {
  animation: pulse 2s infinite;
}

@media (max-width: 576px) {
  .login-card {
    padding: 2rem 1.5rem;
  }

  .brand {
    font-size: 1.75rem;
  }

  .brand-subtitle {
    font-size: 0.8rem;
  }
}
</style>
</head>
<body>
<div class="login-card">
  <div class="brand-section">
    <div class="brand">LeaveWork</div>
    <div class="brand-subtitle">Reset Password</div>
  </div>

  {{-- Setup reminder message --}}
  @if (session('must_change_password'))
    <div class="setup-reminder pulse-animation" id="setupReminder">
      <div class="reminder-icon">
        <i class="bi bi-shield-lock"></i>
      </div>
      <div class="reminder-content">
        <strong>First-time Setup Required</strong>
        <div class="small">Please set up your secure password to continue using your account.</div>
      </div>
    </div>
  @else
    {{-- Show different message if not first-time setup --}}
    <div class="setup-reminder" id="setupReminder">
      <div class="reminder-icon">
        <i class="bi bi-key"></i>
      </div>
      <div class="reminder-content">
        <strong>First-time Setup Required</strong>
        <div class="small">Please set up your password to continue using your account.</div>
      </div>
    </div>
  @endif

  {{-- Laravel success message --}}
  @if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  {{-- Laravel error display --}}
  @if ($errors->any())
    <div class="alert alert-danger">
      @foreach ($errors->all() as $error)
        {{ $error }}<br>
      @endforeach
    </div>
  @endif

  <form method="POST" action="{{ route('password.reset') }}" id="resetPasswordForm">
    @csrf

    <div class="mb-3">
      <label for="password" class="form-label">New Password *</label>
      <input type="password" class="form-control" id="password" name="password" placeholder="Enter new password" required>
      <div id="passwordError" class="text-danger mt-1" style="display: none;"></div>
    
    </div>

    <div class="mb-3">
      <label for="password_confirmation" class="form-label">Confirm New Password *</label>
      <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Confirm password" required>
      <div id="passwordConfirmationError" class="text-danger mt-1" style="display: none;"></div>
      <div id="passwordMatch" class="text-success mt-1" style="display: none;">
        <i class="bi bi-check-circle"></i> Passwords match
      </div>
    </div>

    <button type="submit" class="btn btn-login" id="resetPasswordBtn">
      <span id="resetPasswordText">Reset Password</span>
      <span id="resetPasswordSpinner" class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
    </button>
  </form>

  <p class="bottom-text">
    Remembered your password? <a href="{{ route('login') }}">Sign In</a>
  </p>
</div>

<!-- Success Modal -->
<div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="successModalLabel">Success</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="success-icon">
          <i class="bi bi-check-circle-fill"></i>
        </div>
        <div class="success-message" id="successMessage">
          Your password has been reset successfully.
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success" id="redirectToLoginBtn">Go to Login</button>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
  const resetPasswordForm = $('#resetPasswordForm');
  const resetPasswordBtn = $('#resetPasswordBtn');
  const resetPasswordText = $('#resetPasswordText');
  const resetPasswordSpinner = $('#resetPasswordSpinner');
  const successModal = new bootstrap.Modal(document.getElementById('successModal'));
  const setupReminder = $('#setupReminder');
  
  // Store original button text
  const originalButtonText = resetPasswordText.text();

  // Auto-dismiss the setup reminder after 5 seconds
  if (setupReminder.length) {
    setTimeout(() => {
      setupReminder.addClass('fade-out');
      setTimeout(() => {
        setupReminder.remove();
      }, 500);
    }, 5000);
  }

  // Password strength checker
  $('#password').on('input', function() {
    const password = $(this).val();
    const strength = checkPasswordStrength(password);
    
    $('#strengthLevel').text(strength.level);
    $('#strengthFill')
      .removeClass('weak moderate strong')
      .addClass(strength.class)
      .css('width', strength.width);
    
    $('#strengthText').removeClass('text-danger text-warning text-success').addClass(strength.textColor);
  });

  // Password confirmation check
  $('#password_confirmation').on('input', function() {
    const password = $('#password').val();
    const confirmPassword = $(this).val();
    
    if (confirmPassword.length > 0) {
      if (password === confirmPassword) {
        $('#passwordMatch').show();
        $('#passwordConfirmationError').hide();
      } else {
        $('#passwordMatch').hide();
        $('#passwordConfirmationError').text('Passwords do not match').show();
      }
    } else {
      $('#passwordMatch').hide();
      $('#passwordConfirmationError').hide();
    }
  });

  // Handle form submission
  resetPasswordForm.on('submit', function(e) {
    e.preventDefault();

    // Show loading state
    resetPasswordText.text('Resetting...');
    resetPasswordSpinner.removeClass('d-none');
    resetPasswordBtn.prop('disabled', true);

    // Clear previous errors
    $('.text-danger').hide().text('');

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
        
        // Check if response contains success message
        if (response.success || response.message) {
          // Update success message if provided
          if (response.message) {
            $('#successMessage').text(response.message);
          }
          
          // Show success modal
          successModal.show();
        } else if (response.password_reset_success) {
          // Handle the case from your controller
          $('#successMessage').text(response.success_message || 'Your password has been reset successfully.');
          successModal.show();
        }
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
          $('#passwordError').text('An error occurred. Please try again.').show();
        }
      }
    });
  });

  // Password strength checker function
  function checkPasswordStrength(password) {
    let score = 0;
    
    // Length check
    if (password.length >= 8) score++;
    if (password.length >= 12) score++;
    
    // Complexity checks
    if (/[a-z]/.test(password)) score++;
    if (/[A-Z]/.test(password)) score++;
    if (/[0-9]/.test(password)) score++;
    if (/[^A-Za-z0-9]/.test(password)) score++;
    
    // Determine strength level
    if (password.length === 0) {
      return {
        level: 'None',
        class: '',
        width: '0%',
        textColor: 'text-muted'
      };
    } else if (score <= 2) {
      return {
        level: 'Weak',
        class: 'weak',
        width: '33%',
        textColor: 'text-danger'
      };
    } else if (score <= 4) {
      return {
        level: 'Moderate',
        class: 'moderate',
        width: '66%',
        textColor: 'text-warning'
      };
    } else {
      return {
        level: 'Strong',
        class: 'strong',
        width: '100%',
        textColor: 'text-success'
      };
    }
  }

  // Display validation errors
  function displayErrors(errors) {
    if (errors.password) {
      $('#passwordError').text(errors.password[0]).show();
    }
    if (errors.password_confirmation) {
      $('#passwordConfirmationError').text(errors.password_confirmation[0]).show();
    }
    if (errors.session) {
      // If session expired, redirect to login
      setTimeout(() => {
        window.location.href = "{{ route('login') }}";
      }, 1500);
    }
  }

  // Reset button to original state
  function resetButtonState() {
    resetPasswordText.text(originalButtonText);
    resetPasswordSpinner.addClass('d-none');
    resetPasswordBtn.prop('disabled', false);
  }

  // Handle success modal redirect
  $('#redirectToLoginBtn').on('click', function() {
    successModal.hide();
    window.location.href = "{{ route('login') }}";
  });

  // Optional: Auto-redirect after showing modal for a few seconds
  $('#successModal').on('shown.bs.modal', function() {
    setTimeout(function() {
      if ($('#successModal').hasClass('show')) {
        window.location.href = "{{ route('login') }}";
      }
    }, 3000); // Redirect after 3 seconds
  });
});
</script>
</body>
</html>