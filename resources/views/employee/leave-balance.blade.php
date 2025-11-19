<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Employee | Leave Balance | LeaveWork</title>
<link rel="icon" type="image/png" href="{{ asset('assets/leavework_logo.png') }}">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

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
.dashboard-header {
  text-align: center;
  margin-bottom: 2.5rem;
}
.dashboard-header h2 { font-size: 2rem; font-weight: 700; }
.dashboard-header p { color: var(--secondary); }

/* Leave Cards */
.leave-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
  gap: 1.5rem;
}

.leave-card {
  background: #fff;
  border-radius: var(--radius);
  padding: 1.5rem;
  text-align: center;
  box-shadow: var(--shadow-light);
  transition: var(--transition);
}
.leave-card:hover {
  transform: translateY(-4px);
  box-shadow: var(--shadow-hover);
}
.leave-icon { font-size: 2.2rem; margin-bottom: 0.5rem; display: block; }
.leave-days { font-size: 1.8rem; font-weight: 700; margin: 0; color: var(--primary); }
.leave-type { font-weight: 500; color: var(--secondary); font-size: 0.95rem; }
.leave-submitted { font-size: 0.85rem; color: var(--secondary); margin-top: 0.3rem; }

/* Responsive */
@media(max-width: 992px) {
  #sidebar { transform: translateX(-100%); }
  .main-content { margin-left: 0; padding: 1rem; }
}
</style>
</head>

<body>

@include('layouts.sidebar')

<div class="main-content" id="mainContent">
  @include('layouts.topnav')

  <div class="content-wrapper">

    <div class="dashboard-header">
      <h2>Leave Balance</h2>
      <p>Check your remaining leave entitlements</p>
    </div>

    @php
      $leaveTypes = [
        'Vacation' => ['icon'=>'🌴','remaining'=>8,'submitted'=>0,'total'=>8],
        'Sick' => ['icon'=>'🏥','remaining'=>10,'submitted'=>2,'total'=>10],
        'Personal' => ['icon'=>'👤','remaining'=>5,'submitted'=>1,'total'=>5],
        'Emergency' => ['icon'=>'🆘','remaining'=>5,'submitted'=>0,'total'=>5]
      ];
    @endphp

    <div class="leave-grid">
      @foreach($leaveTypes as $label => $data)
      <div class="leave-card">
        <span class="leave-icon">{{ $data['icon'] }}</span>
        <p class="leave-days">{{ $data['remaining'] }}</p>
        <p class="leave-type">{{ $label }} Leave</p>
        <small class="leave-submitted">{{ $data['submitted'] }} submitted / {{ $data['total'] }} allowed</small>
      </div>
      @endforeach
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
  mainContent.style.marginLeft = sidebar.classList.contains('d-none') ? '0' : '240px';
});
</script>

</body>
</html>
