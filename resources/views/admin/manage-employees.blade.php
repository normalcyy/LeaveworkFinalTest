<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Manage Employees | LeaveWork</title>
  <link rel="icon" type="image/png" href="{{ asset('assets/leavework_logo.png') }}">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
  <style>
    :root {
      --primary: #19183B;
      --secondary: #708993;
      --accent: #A1C2BD;
      --light: #E7F2EF;
    }

    body {
      font-family: 'Segoe UI', system-ui;
      background: var(--light);
      color: var(--primary);
      display: flex;
      min-height: 100vh;
    }

    #sidebar {
      width: 250px;
      background: #fff;
      border-end: 1px solid var(--accent);
      position: fixed;
      min-height: 100vh;
      z-index: 1000;
    }

    #sidebar.d-none {
      transform: translateX(-100%);
    }

    .main-content {
      flex: 1;
      margin-left: 250px;
      display: flex;
      flex-direction: column;
    }

    .content-area {
      padding: 2rem;
      flex: 1;
    }

    @media (max-width: 992px) {
      #sidebar {
        transform: translateX(-100%);
      }

      .main-content {
        margin-left: 0;
      }
    }

    .page-header {
      background: white;
      padding: 1.5rem 2rem;
      border-radius: 12px;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
      margin-bottom: 2rem;
      border-left: 4px solid var(--primary);
    }

    .table-container {
      background: white;
      border-radius: 12px;
      box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
      overflow: hidden;
    }

    .table-header {
      background: var(--primary);
      color: white;
      padding: 1rem 1.5rem;
    }

    .table th {
      font-weight: 600;
      text-transform: uppercase;
      font-size: 0.85rem;
      color: var(--primary);
      border-bottom: 2px solid var(--accent);
      padding: 1rem 1.5rem;
    }

    .table td {
      padding: 1rem 1.5rem;
      border-bottom: 1px solid #eee;
    }

    .table tr:hover {
      background: rgba(161, 194, 189, 0.05);
    }

    .badge-role {
      font-weight: 500;
      padding: 0.4rem 0.8rem;
      border-radius: 20px;
    }

    .badge-role.admin {
      background: #d1ecf1;
      color: #0c5460;
    }

    .badge-role.employee {
      background: #d4edda;
      color: #155724;
    }

    .badge-role.superuser {
      background: #f8d7da;
      color: #721c24;
    }

    .sortable {
      cursor: pointer;
      transition: color 0.2s;
      position: relative;
      user-select: none;
    }

    .sortable:hover {
      color: var(--secondary);
    }

    .sort-icon {
      font-size: 0.75rem;
      margin-left: 0.25rem;
      opacity: 0.7;
      transition: opacity 0.2s;
    }

    .sortable.active .sort-icon {
      opacity: 1;
    }

    .sortable.asc .sort-icon i::before {
      content: "\F128";
    }

    .sortable.desc .sort-icon i::before {
      content: "\F138";
    }

    .data-label {
      font-weight: 500;
      color: var(--secondary);
      font-size: 0.9rem;
    }

    .email-cell {
      font-size: 0.9rem;
      color: var(--secondary);
    }

    @media (max-width: 768px) {
      .content-area {
        padding: 1rem;
      }

      .table thead {
        display: none;
      }

      .table tr {
        display: block;
        margin-bottom: 1rem;
        border: 1px solid #dee2e6;
        border-radius: 8px;
      }

      .table td {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.75rem 1rem;
      }

      .table td:before {
        content: attr(data-label);
        font-weight: 600;
        color: var(--primary);
        min-width: 120px;
      }

      .email-cell {
        font-size: 0.85rem;
      }
    }
  </style>
</head>

<body>
  @include('layouts.sidebar')
  <div class="main-content" id="mainContent">
    @include('layouts.topnav')
    <div class="content-area">
      <div class="content-wrapper">
        <div class="page-header">
          <div class="d-flex justify-content-between align-items-center">
            <div>
              <h1 class="h3 mb-2" style="color: var(--primary);">Manage Employees</h1>
              <p class="text-muted mb-0">View all employees in your company</p>
            </div>
            <span class="badge bg-light text-dark p-2">
              <i class="bi bi-people-fill me-1"></i>
              <span id="userCount">{{ $users->total() }}</span> Employees
            </span>
          </div>
        </div>

        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-3" role="alert">
          {{ session('success') }}
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        @if($users->isEmpty())
        <div class="alert alert-info">
          No employees found in your company.
        </div>
        @else
        <div class="table-container">
          <div class="table-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Employee List</h5>
          </div>
          <div class="table-responsive">
            <table class="table table-hover mb-0" id="userTable">
              <thead>
                <tr>
                  <th class="sortable" data-sort="emp_id">Employee ID<span class="sort-icon"><i class="bi"></i></span></th>
                  <th class="sortable" data-sort="full_name">Full Name<span class="sort-icon"><i class="bi"></i></span></th>
                  <th>Email</th>
                  <th>Role</th>
                  <th class="sortable" data-sort="position">Position<span class="sort-icon"><i class="bi"></i></span></th>
                  <th class="sortable" data-sort="department">Department<span class="sort-icon"><i class="bi"></i></span></th>
                  <th class="sortable" data-sort="company">Company<span class="sort-icon"><i class="bi"></i></span></th>
                  <th class="sortable" data-sort="created_at">Joined At<span class="sort-icon"><i class="bi"></i></span></th>
                </tr>
              </thead>
              <tbody id="userTableBody">
                @foreach($users as $user)
                <tr>
                  <td data-label="Employee ID"><span class="data-label d-md-none">Employee ID: </span>{{ $user->emp_id }}</td>
                  <td data-label="Full Name">
                    <span class="data-label d-md-none">Full Name: </span>
                    {{ $user->last_name }}, {{ $user->first_name }}@if($user->middle_name) {{ strtoupper(substr($user->middle_name, 0, 1)) }}.@endif
                  </td>
                  <td data-label="Email" class="email-cell"><span class="data-label d-md-none">Email: </span>{{ $user->email }}</td>
                  <td data-label="Role"><span class="data-label d-md-none">Role: </span><span class="badge-role {{ $user->role }}">{{ ucfirst($user->role) }}</span></td>
                  <td data-label="Position"><span class="data-label d-md-none">Position: </span>{{ $user->position }}</td>
                  <td data-label="Department"><span class="data-label d-md-none">Department: </span>{{ $user->department }}</td>
                  <td data-label="Company"><span class="data-label d-md-none">Company: </span>{{ $user->company }}</td>
                  <td data-label="Joined At"><span class="data-label d-md-none">Joined At: </span>{{ $user->created_at->format('m/d/Y') }}</td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>

          @if($users->hasPages())
          <div class="p-3 border-top">
            <nav aria-label="User pagination">
              <ul class="pagination justify-content-center mb-0">
                @if($users->onFirstPage())
                <li class="page-item disabled"><span class="page-link">Previous</span></li>
                @else
                <li class="page-item"><a class="page-link" href="{{ $users->previousPageUrl() }}" rel="prev">Previous</a></li>
                @endif

                @php
                $currentPage = $users->currentPage();
                $lastPage = $users->lastPage();
                $start = max(1, $currentPage - 2);
                $end = min($lastPage, $currentPage + 2);
                if ($currentPage <= 3) $end=min(5, $lastPage);
                  if ($currentPage>= $lastPage - 2) $start = max(1, $lastPage - 4);
                  @endphp

                  @if($start > 1)
                  <li class="page-item"><a class="page-link" href="{{ $users->url(1) }}">1</a></li>
                  @if($start > 2)<li class="page-item disabled"><span class="page-link">...</span></li>@endif
                  @endif

                  @for ($page = $start; $page <= $end; $page++)
                    @if($page==$users->currentPage())
                    <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                    @else
                    <li class="page-item"><a class="page-link" href="{{ $users->url($page) }}">{{ $page }}</a></li>
                    @endif
                    @endfor

                    @if($end < $lastPage)
                      @if($end < $lastPage - 1)<li class="page-item disabled"><span class="page-link">...</span></li>@endif
                      <li class="page-item"><a class="page-link" href="{{ $users->url($lastPage) }}">{{ $lastPage }}</a></li>
                      @endif

                      @if($users->hasMorePages())
                      <li class="page-item"><a class="page-link" href="{{ $users->nextPageUrl() }}" rel="next">Next</a></li>
                      @else
                      <li class="page-item disabled"><span class="page-link">Next</span></li>
                      @endif
              </ul>
              <div class="text-center text-muted mt-2">
                Showing {{ $users->firstItem() }} to {{ $users->lastItem() }} of {{ $users->total() }} entries
                ({{ $users->perPage() }} per page)
              </div>
            </nav>
          </div>
          @endif
        </div>
        @endif
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', () => {
      // Sidebar toggle
      const sidebarToggle = document.getElementById('sidebarToggle');
      const sidebar = document.getElementById('sidebar');
      const mainContent = document.getElementById('mainContent');

      if (sidebarToggle && sidebar && mainContent) {
        sidebarToggle.addEventListener('click', () => {
          sidebar.classList.toggle('d-none');
          mainContent.style.marginLeft = sidebar.classList.contains('d-none') ? '0' : '250px';
        });
      }

      // Simple table sorting functionality
      class TableSorter {
        constructor() {
          this.currentSortColumn = null;
          this.currentSortDirection = 'asc';
          this.tableBody = document.getElementById('userTableBody');
          this.originalRows = Array.from(this.tableBody.querySelectorAll('tr'));
          this.sortableHeaders = document.querySelectorAll('.sortable[data-sort]');
          this.init();
        }

        init() {
          this.sortableHeaders.forEach(header => {
            header.addEventListener('click', (e) => {
              const sortColumn = header.getAttribute('data-sort');
              this.sortTable(sortColumn);
            });
          });
        }

        getCellValue(row, column) {
          const cells = row.querySelectorAll('td');
          const columnMap = {
            'emp_id': 0,
            'full_name': 1,
            'position': 4,
            'department': 5,
            'company': 6,
            'created_at': 7
          };

          const cellIndex = columnMap[column];
          if (cellIndex !== undefined && cells[cellIndex]) {
            return cells[cellIndex].textContent.trim().toLowerCase();
          }
          return '';
        }

        sortTable(column) {
          if (this.currentSortColumn === column) {
            this.currentSortDirection = this.currentSortDirection === 'asc' ? 'desc' : 'asc';
          } else {
            this.currentSortDirection = 'asc';
          }

          this.currentSortColumn = column;
          this.updateSortIndicators();

          const sortedRows = this.originalRows.slice().sort((a, b) => {
            const aValue = this.getCellValue(a, column);
            const bValue = this.getCellValue(b, column);
            let comparison = 0;

            comparison = aValue.localeCompare(bValue, undefined, {
              sensitivity: 'base',
              numeric: true
            });

            return this.currentSortDirection === 'asc' ? comparison : -comparison;
          });

          this.tableBody.innerHTML = '';
          sortedRows.forEach(row => this.tableBody.appendChild(row));
        }

        updateSortIndicators() {
          this.sortableHeaders.forEach(header => {
            header.classList.remove('active', 'asc', 'desc');
            const icon = header.querySelector('.sort-icon i');
            if (icon) icon.className = 'bi';
          });

          const currentHeader = Array.from(this.sortableHeaders).find(header =>
            header.getAttribute('data-sort') === this.currentSortColumn
          );

          if (currentHeader) {
            currentHeader.classList.add('active', this.currentSortDirection);
            const icon = currentHeader.querySelector('.sort-icon i');
            if (icon) {
              icon.className = `bi bi-arrow-${this.currentSortDirection === 'asc' ? 'up' : 'down'}`;
            }
          }
        }
      }

      // Initialize table sorter if table exists
      if (document.querySelector('#userTableBody tr')) {
        new TableSorter();
      }
    });
  </script>
</body>

</html>