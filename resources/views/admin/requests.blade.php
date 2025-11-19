<!-- resources/views/admin/requests.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Admin | Requests | LeaveWork</title>
<link rel="icon" type="image/png" href="{{ asset('assets/leavework_logo.png') }}">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
:root {
  --primary: #19183B;
  --secondary: #708993;
  --accent: #A1C2BD;
  --light: #E7F2EF;
}

/* Body */
body {
  margin: 0;
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
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

/* Content Wrapper */
.content-wrapper { max-width: 1400px; width: 100%; margin: 0 auto; }

/* Page Header */
.dashboard-header { text-align: center; margin-bottom: 3rem; }
.dashboard-header h2 { font-size: 2rem; font-weight: 600; margin-bottom: 0.5rem; }
.dashboard-header p { color: var(--secondary); font-size: 1rem; }

/* Placeholder Text */
.placeholder-text {
  text-align: center;
  color: var(--secondary);
  margin-top: 5rem;
  font-size: 1rem;
}

/* Responsive */
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
    <!-- Page Header -->
    <div class="dashboard-header">
      <h2>Manage Requests</h2>
      <p>View and process all employee requests here</p>
    </div>

    <!-- Placeholder for future requests table -->
    <div class="placeholder-text">
      <p>This page will display all requests submitted by employees.</p>
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
  mainContent.style.marginLeft = sidebar.classList.contains('d-none') ? '0' : '250px';
});
</script>

</body>
</html>
