<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Forgot Password | LeaveWork</title>
<link rel="icon" type="image/png" href="{{ asset('assets/leavework_logo.png') }}">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
<!-- SweetAlert2 for better alerts -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<meta name="csrf-token" content="{{ csrf_token() }}">

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
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 0.5rem;
}

.btn-login:hover:not(:disabled) {
  background-color: #0f0e2d;
  transform: translateY(-1px);
  box-shadow: 0 4px 12px rgba(25, 24, 59, 0.25);
}

.btn-login:disabled {
  opacity: 0.7;
  cursor: not-allowed;
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

/* Loading spinner */
.spinner-border {
  width: 1rem;
  height: 1rem;
  border-width: 0.15em;
}

.success-message {
  background-color: #e7f7ef;
  color: #0a7c42;
  border: 1px solid #a3e9c4;
  border-radius: 10px;
  font-size: 0.875rem;
  padding: 0.75rem 1rem;
  margin-bottom: 1.5rem;
  display: none;
}

.error-message {
  background-color: #fee;
  color: #c33;
  border: 1px solid #fcc;
  border-radius: 10px;
  font-size: 0.875rem;
  padding: 0.75rem 1rem;
  margin-bottom: 1.5rem;
  display: none;
}

.instruction-box {
  background-color: #f8f9fa;
  border-left: 4px solid var(--accent);
  padding: 1rem;
  margin-bottom: 1.5rem;
  border-radius: 8px;
  font-size: 0.875rem;
  color: var(--secondary);
}

.instruction-box h6 {
  color: var(--primary);
  margin-bottom: 0.5rem;
  font-weight: 600;
}

.instruction-box ul {
  margin-bottom: 0;
  padding-left: 1rem;
}

.instruction-box li {
  margin-bottom: 0.25rem;
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
    <div class="brand-subtitle">Forgot Password</div>
  </div>

  {{-- Success message container --}}
  <div class="success-message" id="successMessage"></div>
  
  {{-- Error message container --}}
  <div class="error-message" id="errorMessage"></div>

  {{-- Laravel error display --}}
  @if ($errors->any())
    <div class="alert alert-danger">{{ $errors->first() }}</div>
  @endif



  <form id="forgotPasswordForm" method="POST">
    @csrf

    <div class="mb-3">
      <label for="email" class="form-label">Email Address *</label>
      <input type="email" class="form-control" id="email" name="email" placeholder="you@example.com" required>
      <div class="form-text">Enter the email address associated with your account</div>
    </div>

    <button type="submit" class="btn btn-login" id="submitBtn">
      <span id="btnText">Reset Password</span>
      <span class="spinner-border spinner-border-sm d-none" id="loadingSpinner" role="status"></span>
    </button>
  </form>

  <div class="bottom-text">
    <div class="mb-2">
      <a href="{{ route('login') }}" class="text-decoration-none">
        <i class="bi bi-arrow-left me-1"></i> Back to Login
      </a>
    </div>
    <div class="text-muted small">
      Need help? Contact your system administrator
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('forgotPasswordForm');
    const submitBtn = document.getElementById('submitBtn');
    const btnText = document.getElementById('btnText');
    const loadingSpinner = document.getElementById('loadingSpinner');
    const successMessage = document.getElementById('successMessage');
    const errorMessage = document.getElementById('errorMessage');
    const emailInput = document.getElementById('email');
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    // Simple email validation function
    function isValidEmail(email) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }

    form.addEventListener('submit', async function(e) {
        e.preventDefault();
        
        // Reset messages
        successMessage.style.display = 'none';
        errorMessage.style.display = 'none';
        
        // Get email value
        const email = emailInput.value.trim();
        
        // Frontend validation
        if (!email) {
            showError('Email address is required.');
            return;
        }
        
        if (!isValidEmail(email)) {
            showError('Please enter a valid email address.');
            return;
        }
        
        // Show loading state
        btnText.textContent = 'Resetting...';
        loadingSpinner.classList.remove('d-none');
        submitBtn.disabled = true;
        emailInput.disabled = true;

        try {
            // Make AJAX request to backend
            const response = await fetch("{{ route('password.reset.post') }}", {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({email: email})
            });

            const data = await response.json();

            if (response.ok && data.success) {
                // Success - show SweetAlert
                Swal.fire({
                    icon: 'success',
                    title: 'Password Reset Successful!',
                    html: `
                        <div class="text-start">
                            <p><strong>Password has been reset successfully!</strong></p>
                            <p>Your new temporary password is:</p>
                            <div class="text-center my-3">
                                <div style="
                                    background: #f8f9fa;
                                    border: 2px dashed #19183B;
                                    padding: 1rem;
                                    border-radius: 8px;
                                    font-size: 1.5rem;
                                    font-weight: bold;
                                    letter-spacing: 2px;
                                    color: #19183B;
                                ">
                                    12345678
                                </div>
                            </div>
                            <p class="small text-muted mt-2">
                                <i class="bi bi-exclamation-triangle-fill text-warning me-1"></i>
                                <strong>Important:</strong> Login immediately with this temporary password and change it in your profile settings.
                            </p>
                            <p class="small text-muted">
                                <i class="bi bi-shield-check me-1"></i>
                                For security reasons, please do not share this password.
                            </p>
                        </div>
                    `,
                    confirmButtonColor: '#19183B',
                    confirmButtonText: 'Go to Login',
                    allowOutsideClick: false,
                    allowEscapeKey: false
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = "{{ route('login') }}";
                    }
                });

                // Clear form
                form.reset();
            } else {
                // Error - show error message
                showError(data.message || 'An error occurred. Please try again.');
                
                // Show SweetAlert error
                Swal.fire({
                    icon: 'error',
                    title: 'Reset Failed',
                    text: data.message || 'Unable to reset password. Please try again.',
                    confirmButtonColor: '#19183B'
                });
            }
        } catch (error) {
            // Network error
            showError('Network error. Please check your connection and try again.');
            Swal.fire({
                icon: 'error',
                title: 'Network Error',
                text: 'Unable to connect to server. Please try again.',
                confirmButtonColor: '#19183B'
            });
        } finally {
            // Reset button state
            btnText.textContent = 'Reset Password';
            loadingSpinner.classList.add('d-none');
            submitBtn.disabled = false;
            emailInput.disabled = false;
        }
    });

    // Helper functions
    function showError(message) {
        errorMessage.textContent = message;
        errorMessage.style.display = 'block';
        form.classList.add('shake');
        setTimeout(() => {
            form.classList.remove('shake');
        }, 500);
        
        // Focus on email input
        emailInput.focus();
    }

    function showSuccess(message) {
        successMessage.textContent = message;
        successMessage.style.display = 'block';
    }

    // Add shake animation CSS
    const style = document.createElement('style');
    style.textContent = `
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            10%, 30%, 50%, 70%, 90% { transform: translateX(-5px); }
            20%, 40%, 60%, 80% { transform: translateX(5px); }
        }
        .shake {
            animation: shake 0.5s ease-in-out;
        }
        
        /* Optional: Add fade-in animation for messages */
        .success-message, .error-message {
            animation: fadeIn 0.3s ease-in;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    `;
    document.head.appendChild(style);
});
</script>
</body>
</html>