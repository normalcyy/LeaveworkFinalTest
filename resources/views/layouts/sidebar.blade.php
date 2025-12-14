<div id="sidebar" class="col-md-2 bg-white p-3 border-end" style="min-height:100vh; transition: all .3s; margin-top: 40px;">
  <h5 class="mb-3">Menu</h5>

  <ul class="nav flex-column">

    @php $role = session('role'); @endphp

    @if($role === 'employee')
    <li class="nav-item mb-2 mt-2">
      <a class="nav-link d-flex align-items-center {{ request()->is('employee/dashboard') ? 'fw-bold text-primary' : '' }}"
        href="{{ url('/employee/dashboard') }}">
        <span class="me-2">🏠</span> Dashboard
      </a>
    </li>
    <li class="nav-item mb-2 mt-2">
      <a class="nav-link d-flex align-items-center {{ request()->is('employee/new-request') ? 'fw-bold text-primary' : '' }}"
        href="{{ url('/employee/new-request') }}">
        <span class="me-2">🆕</span> New Request
      </a>
    </li>
    <li class="nav-item mb-2 mt-2">
      <a class="nav-link d-flex align-items-center {{ request()->is('employee/my-requests') ? 'fw-bold text-primary' : '' }}"
        href="{{ url('/employee/my-requests') }}">
        <span class="me-2">📋</span> My Requests
      </a>
    </li>
    <li class="nav-item mb-2 mt-2">
      <a class="nav-link d-flex align-items-center {{ request()->is('employee/leave-balance') ? 'fw-bold text-primary' : '' }}"
        href="{{ url('/employee/leave-balance') }}">
        <span class="me-2">🧮</span> Leave Balance
      </a>
    </li>

    @elseif($role === 'admin')
    <li class="nav-item mb-2 mt-2">
      <a class="nav-link d-flex align-items-center {{ request()->is('admin/dashboard') ? 'fw-bold text-primary' : '' }}"
        href="{{ url('/admin/dashboard') }}">
        <span class="me-2">🏠</span> Dashboard
      </a>
    </li>
    <li class="nav-item mb-2 mt-2">
      <a class="nav-link d-flex align-items-center {{ request()->is('admin/manage-employees') ? 'fw-bold text-primary' : '' }}"
        href="{{ url('/admin/manage-employees') }}">
        <span class="me-2">👥</span> Manage Employees
      </a>
    </li>
    <li class="nav-item mb-2 mt-2">
      <a class="nav-link d-flex align-items-center {{ request()->is('admin/add-user') ? 'fw-bold text-primary' : '' }}"
        href="{{ url('/admin/add-user') }}">
        <span class="me-2">➕</span> Add User
      </a>
    </li>
    <li class="nav-item mb-2 mt-2">
      <a class="nav-link d-flex align-items-center {{ request()->is('admin/requests') ? 'fw-bold text-primary' : '' }}"
        href="{{ url('/admin/requests') }}">
        <span class="me-2">📄</span> Requests
      </a>
    </li>

    @elseif($role === 'superuser')
    <li class="nav-item mb-2 mt-2">
      <a class="nav-link d-flex align-items-center {{ request()->is('superuser/dashboard') ? 'fw-bold text-primary' : '' }}"
        href="{{ url('/superuser/dashboard') }}">
        <span class="me-2">🏠</span> Dashboard
      </a>
    </li>
    <li class="nav-item mb-2 mt-2">
      <a class="nav-link d-flex align-items-center {{ request()->is('superuser/create-admin') ? 'fw-bold text-primary' : '' }}"
        href="{{ url('/superuser/create-admin') }}">
        <span class="me-2">🛠️</span> Create Admin
      </a>
    </li>
    <li class="nav-item mb-2 mt-2">
      <a class="nav-link d-flex align-items-center {{ request()->is('superuser/admin-list') ? 'fw-bold text-primary' : '' }}"
        href="{{ url('/superuser/admin-list') }}">
        <span class="me-2">📋</span> Admins List
      </a>
    </li>

    @endif

  </ul>
</div>