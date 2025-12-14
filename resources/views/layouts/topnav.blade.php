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
          <a class="nav-link position-relative" href="#" id="notifDropdown" role="button" data-bs-toggle="dropdown" onclick="loadNotifications()">
            <img src="{{ asset('images/notification-bell-svgrepo-com.svg') }}" 
                 width="24" height="24" alt="Notifications">
            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" id="notificationBadge" style="display: none;">0</span>
          </a>

          <ul class="dropdown-menu dropdown-menu-end shadow-sm p-2" style="width: 350px; max-height: 400px; overflow-y: auto;" id="notificationDropdown">
            <li class="dropdown-header d-flex justify-content-between align-items-center">
              <span class="fw-bold">Notifications</span>
              <button class="btn btn-sm btn-link p-0" onclick="markAllAsRead(event)" style="font-size: 0.75rem;">Mark all as read</button>
            </li>
            <li><hr class="dropdown-divider"></li>
            <li id="notificationList">
              <div class="text-center p-3 text-muted">
                <small>Loading notifications...</small>
              </div>
            </li>
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

<script>
// Load unread notification count on page load
document.addEventListener('DOMContentLoaded', function() {
    loadUnreadCount();
    // Refresh count every 30 seconds
    setInterval(loadUnreadCount, 30000);
});

function loadUnreadCount() {
    fetch('{{ route("notifications.unread_count") }}')
        .then(response => response.json())
        .then(data => {
            const badge = document.getElementById('notificationBadge');
            if (data.count > 0) {
                badge.textContent = data.count > 99 ? '99+' : data.count;
                badge.style.display = 'block';
            } else {
                badge.style.display = 'none';
            }
        })
        .catch(error => console.error('Error loading notification count:', error));
}

function loadNotifications() {
    const notificationList = document.getElementById('notificationList');
    notificationList.innerHTML = '<div class="text-center p-3 text-muted"><small>Loading...</small></div>';
    
    fetch('{{ route("notifications.index") }}')
        .then(response => response.json())
        .then(data => {
            if (data.success && data.notifications.data.length > 0) {
                let html = '';
                data.notifications.data.forEach(notif => {
                    const isRead = notif.is_read ? '' : 'bg-light';
                    const readBadge = notif.is_read ? '' : '<span class="badge bg-primary rounded-pill ms-2">New</span>';
                    html += `
                        <li class="p-2 ${isRead}" onclick="markAsRead(${notif.id}, event)">
                            <div class="d-flex justify-content-between align-items-start">
                                <div class="flex-grow-1">
                                    <strong class="small">${notif.message}</strong>${readBadge}
                                    <br>
                                    <small class="text-muted">${new Date(notif.created_at).toLocaleString()}</small>
                                </div>
                            </div>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                    `;
                });
                notificationList.innerHTML = html;
            } else {
                notificationList.innerHTML = '<div class="text-center p-3 text-muted"><small>No notifications</small></div>';
            }
        })
        .catch(error => {
            console.error('Error loading notifications:', error);
            notificationList.innerHTML = '<div class="text-center p-3 text-danger"><small>Error loading notifications</small></div>';
        });
}

function markAsRead(id, event) {
    if (event) {
        event.stopPropagation();
    }
    
    fetch(`/notifications/${id}/read`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
        }
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                loadNotifications();
                loadUnreadCount();
            }
        })
        .catch(error => console.error('Error marking notification as read:', error));
}

function markAllAsRead(event) {
    if (event) {
        event.stopPropagation();
    }
    
    fetch('{{ route("notifications.mark_all_read") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
        }
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                loadNotifications();
                loadUnreadCount();
            }
        })
        .catch(error => console.error('Error marking all as read:', error));
}
</script>
