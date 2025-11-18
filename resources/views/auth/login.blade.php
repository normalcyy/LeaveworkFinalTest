<!-- resources/views/auth/login.blade.php -->
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
    <div class="brand-subtitle">Leave Management System</div>
  </div>

  {{-- Laravel error display --}}
  @if ($errors->any())
    <div class="alert alert-danger">{{ $errors->first() }}</div>
  @endif

  <form method="POST" action="{{ route('login') }}">
    @csrf
    <div class="mb-3">
      <label for="email" class="form-label">Email Address *</label>
      <input type="email" class="form-control" id="email" name="email" placeholder="you@example.com" required autofocus>
    </div>

    <div class="mb-3">
      <label for="password" class="form-label">Password *</label>
      <div class="password-wrapper">
        <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
        <button type="button" class="password-toggle" onclick="togglePassword()">
          <i id="eye-icon" class="bi bi-eye"></i>
        </button>
      </div>
    </div>

    <div class="mb-3 text-end">
  <a href="{{ route('password.forgot') }}" class="forgot-link">Forgot password?</a>
</div>


    <button type="submit" class="btn btn-login">Sign In</button>
  </form>

  <p class="bottom-text">
    Don't have an account? <strong>Contact your administrator</strong>
  </p>
</div>

<script>
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
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
