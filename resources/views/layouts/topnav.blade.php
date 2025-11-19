<nav class="navbar navbar-expand-lg bg-white shadow-sm py-3 px-4 fixed-top" style="z-index: 2000;">
  <div class="container-fluid d-flex align-items-center">

    <!-- HAMBURGER FOR SIDEBAR (ALWAYS ON TOP + ALWAYS VISIBLE ON MOBILE) -->
    <button id="sidebarToggle" 
            class="btn btn-outline-primary me-3" 
            style="z-index: 2100;">
      ☰
    </button>

    <!-- LEFT: BIG TITLE -->
    <a class="navbar-brand fw-bold fs-3 text-primary" href="#">LeaveWork</a>

    <!-- MOBILE TOGGLER FOR TOPNAV -->
    <button class="navbar-toggler ms-auto" type="button" data-bs-toggle="collapse" data-bs-target="#topNavMenu">
      <span class="navbar-toggler-icon"></span>
    </button>

    <!-- RIGHT MENU -->
    <div class="collapse navbar-collapse justify-content-end" id="topNavMenu">
      <ul class="navbar-nav align-items-center gap-3">

        <!-- NOTIFICATION DROPDOWN -->
        <li class="nav-item dropdown">
          <a class="nav-link position-relative" href="#" id="notifDropdown" role="button" data-bs-toggle="dropdown">
            <img src="{{ asset('images/notification-bell-svgrepo-com.svg') }}" 
                 width="24" height="24" alt="Notifications">
            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">3</span>
          </a>

          <ul class="dropdown-menu dropdown-menu-end shadow-sm p-2" style="width: 300px;">
            <li class="dropdown-header fw-bold">Notifications</li>
            <li><hr class="dropdown-divider"></li>
            <li class="p-2 small"><strong>Leave Request Approved</strong><br>Your leave request was approved.</li>
            <li><hr class="dropdown-divider"></li>
            <li class="p-2 small"><strong>New Announcement</strong><br>HR posted a new message.</li>
            <li><hr class="dropdown-divider"></li>
            <li class="p-2 small"><strong>Schedule Updated</strong><br>Your work schedule has changed.</li>
          </ul>
        </li>

        <!-- USER DROPDOWN -->
        <li class="nav-item dropdown">
          <a class="nav-link d-flex align-items-center gap-2" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
            <img src="https://cdn-icons-png.flaticon.com/512/3135/3135715.png" 
                 width="35" height="35" class="rounded-circle border">
          </a>

          <ul class="dropdown-menu dropdown-menu-end shadow-sm">
            <!-- Updated Profile Link -->
            <li><a class="dropdown-item" href="/profile">Profile</a></li>
            <li><a class="dropdown-item" href="#">Settings</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item text-danger" href="/logout">Logout</a></li>
          </ul>
        </li>

      </ul>
    </div>
  </div>
</nav>

<!-- Spacer to prevent topnav overlap -->
<div style="height: 90px;"></div>
