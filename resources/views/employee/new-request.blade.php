<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Employee | New Request | LeaveWork</title>
<link rel="icon" type="image/png" href="{{ asset('assets/leavework_logo.png') }}">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
:root {
  --primary: #19183B;
  --secondary: #708993;
  --accent: #A1C2BD;
  --light: #E7F2EF;
  --radius: 14px;
  --shadow-light: 0 4px 15px rgba(25,24,59,0.06);
  --shadow-hover: 0 6px 20px rgba(25,24,59,0.12);
  --transition: 0.25s ease;
}

/* Body */
body {
  margin: 0;
  font-family: 'Inter', sans-serif;
  background-color: var(--light);
  color: var(--primary);
  display: flex;
  min-height: 100vh;
}

/* Sidebar */
#sidebar {
  width: 240px;
  background: #fff;
  border-right: 1px solid var(--accent);
  position: fixed;
  top: 0;
  left: 0;
  height: 100vh;
  padding: 2rem 1.5rem;
  overflow-y: auto;
  transition: transform 0.3s ease;
  z-index: 1000;
}
#sidebar.d-none { transform: translateX(-100%); }

/* Main Content */
.main-content {
  flex: 1;
  margin-left: 240px;
  padding: 2rem;
  transition: margin-left 0.3s ease;
}

/* Topnav */
.topnav {
  display: flex;
  justify-content: space-between;
  align-items: center;
  background: #fff;
  padding: 1rem 1.5rem;
  border-radius: var(--radius);
  box-shadow: var(--shadow-light);
  margin-bottom: 2rem;
}
.topnav h4 { margin: 0; font-weight: 600; font-size: 1.3rem; }
.btn-toggle {
  background: var(--primary);
  color: #fff;
  padding: 0.5rem 1rem;
  border-radius: var(--radius);
  border: none;
  font-weight: 600;
  cursor: pointer;
  transition: var(--transition);
}
.btn-toggle:hover { background: var(--secondary); }

/* Page Header */
.page-header {
  text-align: center;
  margin-bottom: 2.5rem;
}
.page-header h2 { font-size: 2rem; font-weight: 600; }
.page-header p { color: var(--secondary); margin-top: 0.3rem; }

/* Form Card */
.form-card {
  background: #fff;
  padding: 2rem;
  border-radius: var(--radius);
  box-shadow: var(--shadow-light);
  max-width: 700px;
  margin: 0 auto;
  transition: var(--transition);
}
.form-card:hover { box-shadow: var(--shadow-hover); }

/* Labels & Inputs */
.form-label { font-weight: 600; color: var(--primary); }
.form-control, .form-select, input[type="file"], textarea {
  border-radius: var(--radius);
  border: 1px solid var(--accent);
  padding: 0.75rem 1rem;
  transition: var(--transition);
}
.form-control:focus, .form-select:focus, textarea:focus {
  outline: none;
  border-color: var(--accent);
  box-shadow: 0 0 6px rgba(161,194,189,0.4);
}
input[type="file"] {
  border: 2px dashed var(--accent);
  background: var(--light);
}

/* Buttons */
.btn-submit {
  background: var(--accent);
  color: #fff;
  padding: 0.75rem 1.8rem;
  border-radius: var(--radius);
  border: none;
  font-weight: 600;
  transition: var(--transition);
}
.btn-submit:hover { opacity: 0.85; }

.btn-cancel {
  background: #f0f0f0;
  color: var(--primary);
  padding: 0.75rem 1.8rem;
  border-radius: var(--radius);
  border: none;
  font-weight: 600;
  transition: var(--transition);
}
.btn-cancel:hover { background: #e0e0e0; }

/* Responsive */
@media (max-width: 992px) {
  #sidebar { transform: translateX(-100%); }
  .main-content { margin-left: 0; padding: 1rem; }
}
</style>
</head>
<body>

@include('layouts.sidebar')

<div class="main-content" id="mainContent">

  @include('layouts.topnav')

  <div class="page-header">
    <h2>New Leave Request</h2>
    <p>Fill out the form below to submit your leave request</p>
  </div>

  <div class="form-card">
    <form action="#" method="POST" enctype="multipart/form-data">
      @csrf

      <!-- Leave Type -->
      <div class="mb-4">
        <label class="form-label">Leave Type</label>
        <select class="form-select" required>
          <option value="" disabled selected>Select leave type</option>
          <option value="Vacation Leave">🌴 Vacation Leave</option>
          <option value="Sick Leave">🏥 Sick Leave</option>
          <option value="Personal Leave">👤 Personal Leave</option>
          <option value="Emergency Leave">🆘 Emergency Leave</option>
        </select>
      </div>

      <!-- Dates -->
      <div class="row g-4 mb-4">
        <div class="col-md-6">
          <label class="form-label">Start Date</label>
          <input type="date" class="form-control" required>
        </div>
        <div class="col-md-6">
          <label class="form-label">End Date</label>
          <input type="date" class="form-control" required>
        </div>
      </div>

      <!-- Reason -->
      <div class="mb-4">
        <label class="form-label">Reason</label>
        <textarea class="form-control" rows="4" placeholder="Describe your reason for leave..." required></textarea>
      </div>

      <!-- Attachment -->
      <div class="mb-4">
        <label class="form-label">Attachment (Optional)</label>
        <input type="file" class="form-control">
        <small class="text-muted">Upload medical certificates or proof if necessary</small>
      </div>

      <!-- Buttons -->
      <div class="d-flex justify-content-end gap-3">
        <button type="button" class="btn-cancel">Cancel</button>
        <button type="submit" class="btn-submit">Submit Request</button>
      </div>

    </form>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
const toggleBtn = document.getElementById('sidebarToggle');
const sidebar = document.getElementById('sidebar');
const mainContent = document.getElementById('mainContent');

toggleBtn?.addEventListener('click', () => {
  sidebar.classList.toggle('d-none');
  mainContent.style.marginLeft = sidebar.classList.contains('d-none') ? '0' : '240px';
});
</script>

</body>
</html>
