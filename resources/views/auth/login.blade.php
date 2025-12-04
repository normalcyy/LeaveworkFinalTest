<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Login | LeaveWork</title>
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

.form-control::placeholder {
  color: var(--secondary);
  opacity: 0.6;
}

.form-control.is-invalid {
  border-color: #dc3545;
}

.password-wrapper {
  position: relative;
}

.password-toggle {
  position: absolute;
  right: 1rem;
  top: 50%;
  transform: translateY(-50%);
  background: none;
  border: none;
  color: var(--secondary);
  cursor: pointer;
  font-size: 1.1rem;
}

.password-toggle:hover {
  color: var(--primary);
}

.forgot-link {
  color: var(--secondary);
  text-decoration: none;
  font-size: 0.875rem;
  font-weight: 500;
}

.forgot-link:hover {
  color: var(--primary);
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
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 0.5rem;
}

.btn-login:hover {
  background-color: #0f0e2d;
  transform: translateY(-1px);
  box-shadow: 0 4px 12px rgba(25, 24, 59, 0.25);
}

.btn-login:disabled {
  background-color: var(--secondary);
  cursor: not-allowed;
  transform: none;
  box-shadow: none;
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

.invalid-feedback {
  display: block;
  color: #dc3545;
  font-size: 0.875rem;
  margin-top: 0.25rem;
}

/* Loading spinner */
.spinner-border {
  width: 1rem;
  height: 1rem;
  border-width: 0.15em;
}

/* Welcome Modal */
.welcome-modal .modal-content {
  border-radius: 20px;
  border: none;
  box-shadow: 0 10px 40px rgba(25, 24, 59, 0.15);
}

.welcome-modal .modal-header {
  background: linear-gradient(135deg, var(--primary) 0%, #2a2860 100%);
  color: white;
  border-bottom: none;
  border-radius: 20px 20px 0 0;
  padding: 1.5rem 2rem;
}

.welcome-modal .modal-title {
  font-weight: 700;
  font-size: 1.5rem;
}

.welcome-modal .modal-body {
  padding: 2rem;
  text-align: center;
}

.welcome-icon {
  font-size: 4rem;
  color: var(--accent);
  margin-bottom: 1.5rem;
}

.welcome-message {
  font-size: 1.1rem;
  color: var(--primary);
  font-weight: 500;
  margin-bottom: 1.5rem;
}

.welcome-role {
  display: inline-block;
  background-color: var(--light);
  color: var(--primary);
  padding: 0.5rem 1rem;
  border-radius: 20px;
  font-weight: 600;
  margin: 0.5rem 0;
}

.welcome-modal .modal-footer {
  border-top: none;
  justify-content: center;
  padding: 0 2rem 2rem;
}

.welcome-modal .btn-primary {
  background: linear-gradient(135deg, var(--primary) 0%, #2a2860 100%);
  border: none;
  border-radius: 10px;
  padding: 0.75rem 2rem;
  font-weight: 600;
  transition: all 0.3s ease;
}

.welcome-modal .btn-primary:hover {
  transform: translateY(-2px);
  box-shadow: 0 5px 15px rgba(25, 24, 59, 0.3);
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
  
  .welcome-modal .modal-body {
    padding: 1.5rem;
  }
}
</style>
</head>
<body>
<div class="login-card">
  <div class="brand-section">
    <div class="brand">LeaveWork</div>
    <div class="brand-subtitle">Leave Management System</div>
  </div>

  {{-- Laravel error display for non-AJAX requests --}}
  @if ($errors->any())
    <div class="alert alert-danger">{{ $errors->first() }}</div>
  @endif
  
  {{-- AJAX error container --}}
  <div id="ajaxError" class="alert alert-danger" style="display: none;"></div>
  
  {{-- AJAX success message for password reset redirects --}}
  @if (session('password_reset_success'))
    <div class="alert alert-success">
      <i class="bi bi-check-circle me-2"></i>
      {{ session('success_message', 'Your password has been reset successfully. Please log in with your new password.') }}
    </div>
  @endif

  <form method="POST" action="{{ route('login.post') }}" id="loginForm">
    @csrf
    
    <div class="mb-3">
      <label for="email" class="form-label">Email Address *</label>
      <input type="email" class="form-control" id="email" name="email" 
             placeholder="you@example.com" required autofocus>
      <div id="email_error" class="invalid-feedback" style="display: none;"></div>
    </div>

    <div class="mb-3">
      <label for="password" class="form-label">Password *</label>
      <div class="password-wrapper">
        <input type="password" class="form-control" id="password" name="password" 
               placeholder="Enter your password" required>
        <button type="button" class="password-toggle" onclick="togglePassword()">
          <i id="eye-icon" class="bi bi-eye"></i>
        </button>
      </div>
      <div id="password_error" class="invalid-feedback" style="display: none;"></div>
    </div>

    <div class="mb-3 text-end">
      <a href="{{ route('password.forgot') }}" class="forgot-link">Forgot password?</a>
    </div>

    <button type="submit" class="btn btn-login" id="loginBtn">
      <span id="loginText">Sign In</span>
      <span id="loginSpinner" class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
    </button>
  </form>

  <p class="bottom-text">
    Don't have an account? <strong>Contact your administrator</strong>
  </p>
</div>

<!-- Welcome Modal -->
<div class="modal fade" id="welcomeModal" tabindex="-1" aria-labelledby="welcomeModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">  
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
// Password toggle function
function togglePassword() {
  const passInput = document.getElementById('password');
  const eyeIcon = document.getElementById('eye-icon');
  if (passInput.type === 'password') {
    passInput.type = 'text';
    eyeIcon.classList.remove('bi-eye');
    eyeIcon.classList.add('bi-eye-slash');
  } else {
    passInput.type = 'password';
    eyeIcon.classList.remove('bi-eye-slash');
    eyeIcon.classList.add('bi-eye');
  }
}

$(document).ready(function() {
  const loginForm = $('#loginForm');
  const loginBtn = $('#loginBtn');
  const loginText = $('#loginText');
  const loginSpinner = $('#loginSpinner');
  const ajaxError = $('#ajaxError');
  const welcomeModal = new bootstrap.Modal(document.getElementById('welcomeModal'));
  
  // Store original button text
  const originalButtonText = loginText.text();
  
  // Variables for redirect countdown
  let countdownInterval;
  let countdownSeconds = 3;
  let redirectUrl = '';

  // Handle form submission
  loginForm.on('submit', function(e) {
    e.preventDefault();

    // Show loading state
    loginText.text('Signing In...');
    loginSpinner.removeClass('d-none');
    loginBtn.prop('disabled', true);
    ajaxError.hide();

    // Clear previous errors
    $('.form-control').removeClass('is-invalid');
    $('.invalid-feedback').hide().text('');

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
        if (response.redirect) {
          // Store redirect URL
          redirectUrl = response.redirect;
          
          // Update modal with user role if provided
          if (response.role) {
            $('#userRole').text(response.role.charAt(0).toUpperCase() + response.role.slice(1));
          }
          
          // Show welcome modal
          welcomeModal.show();
          
          // Start countdown
          startCountdown();
        } else if (response.password_reset_required) {
          // Redirect to password reset page
          window.location.href = response.redirect;
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
          const errorMsg = xhr.responseJSON?.message || 'An error occurred. Please try again.';
          ajaxError.text(errorMsg).show();
        }
      }
    });
  });

  // Display validation errors
  function displayErrors(errors) {
    if (errors.email) {
      $('#email').addClass('is-invalid');
      $('#email_error').text(errors.email[0]).show();
    }
    if (errors.password) {
      $('#password').addClass('is-invalid');
      $('#password_error').text(errors.password[0]).show();
    }
    if (errors.general) {
      ajaxError.text(errors.general[0]).show();
    }
  }

  // Reset button to original state
  function resetButtonState() {
    loginText.text(originalButtonText);
    loginSpinner.addClass('d-none');
    loginBtn.prop('disabled', false);
  }

  // Start countdown for redirect
  function startCountdown() {
    countdownSeconds = 3;
    $('#countdown').text(countdownSeconds);
    $('#progressBar').css('width', '0%');
    
    clearInterval(countdownInterval);
    
    countdownInterval = setInterval(function() {
      countdownSeconds--;
      $('#countdown').text(countdownSeconds);
      
      // Update progress bar
      const progress = ((3 - countdownSeconds) / 3) * 100;
      $('#progressBar').css('width', progress + '%');
      
      if (countdownSeconds <= 0) {
        clearInterval(countdownInterval);
        window.location.href = redirectUrl;
      }
    }, 1000);
  }

  // Handle immediate redirect button
  $('#redirectNowBtn').on('click', function() {
    clearInterval(countdownInterval);
    window.location.href = redirectUrl;
  });

  // Clear validation errors on input
  $('.form-control').on('input', function() {
    $(this).removeClass('is-invalid');
    const fieldName = this.name;
    $(`#${fieldName}_error`).hide();
  });

  // Clear error message on input
  $('.form-control').on('input', function() {
    ajaxError.hide();
  });
});

// Auto-focus email field on page load
document.addEventListener('DOMContentLoaded', function() {
  const emailField = document.getElementById('email');
  if (emailField && !emailField.value) {
    emailField.focus();
  }
  
  // Auto-hide success message after 5 seconds
  const successAlert = document.querySelector('.alert-success');
  if (successAlert) {
    setTimeout(function() {
      successAlert.style.display = 'none';
    }, 5000);
  }
});
</script>
</body>
</html>