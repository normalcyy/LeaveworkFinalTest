<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Edit Admin | LeaveWork</title>
    <link rel="icon" type="image/png" href="{{ asset('assets/leavework_logo.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --primary: #19183B;
            --secondary: #708993;
            --accent: #A1C2BD;
            --light: #E7F2EF;
        }
        body {
            background-color: var(--light);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .card {
            padding: 2.5rem;
            border-radius: 15px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            border: 1px solid var(--accent);
            background-color: #fff;
        }
        .form-label {
            font-weight: 500;
            font-size: 0.875rem;
            margin-bottom: 0.4rem;
            color: var(--primary);
        }
        .form-control, .form-select {
            border: 1px solid var(--accent);
            border-radius: 8px;
            padding: 0.65rem 0.9rem;
            font-size: 0.95rem;
            background-color: #fff;
        }
        .form-control:focus, .form-select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(25, 24, 59, 0.1);
            outline: none;
        }
        .btn-primary {
            background-color: var(--primary);
            color: #fff;
            border-radius: 8px;
            padding: 0.65rem 1.5rem;
            font-weight: 500;
            font-size: 0.95rem;
            border: none;
        }
        .btn-primary:hover {
            background-color: var(--secondary);
        }
        .btn-secondary {
            background-color: var(--accent);
            color: var(--primary);
            border-radius: 8px;
            padding: 0.65rem 1.5rem;
            font-weight: 500;
            font-size: 0.95rem;
            border: none;
        }
        .btn-secondary:hover {
            background-color: var(--secondary);
            color: #fff;
        }
    </style>
</head>
<body>
@include('layouts.sidebar')

<div class="main-content" style="margin-left: 240px; padding: 2rem;">
    @include('layouts.topnav')
    
    <div class="container" style="max-width: 600px;">
        <div class="card">
            <h3 style="font-size: 1.5rem; font-weight: 600; margin-bottom: 0.3rem; color: var(--primary);">Edit Admin</h3>
            <p style="color: var(--secondary); font-size: 0.875rem; margin-bottom: 1.5rem;">Update admin information</p>

            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if(isset($admin))
                <form method="POST" action="{{ route('su.manage_admins.update', $admin->id) }}" id="editAdminForm">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label">Admin ID <span class="text-danger">*</span></label>
                        <input type="text" name="emp_id" class="form-control @error('emp_id') is-invalid @enderror" 
                               value="{{ old('emp_id', $admin->emp_id) }}" required>
                        <small class="text-muted">Format: ADM000 (e.g., ADM001, ADM002)</small>
                        @error('emp_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">First Name <span class="text-danger">*</span></label>
                        <input type="text" name="first_name" class="form-control @error('first_name') is-invalid @enderror" 
                               value="{{ old('first_name', $admin->first_name) }}" required>
                        @error('first_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Middle Name</label>
                        <input type="text" name="middle_name" class="form-control @error('middle_name') is-invalid @enderror" 
                               value="{{ old('middle_name', $admin->middle_name) }}">
                        @error('middle_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Last Name <span class="text-danger">*</span></label>
                        <input type="text" name="last_name" class="form-control @error('last_name') is-invalid @enderror" 
                               value="{{ old('last_name', $admin->last_name) }}" required>
                        @error('last_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email <span class="text-danger">*</span></label>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" 
                               value="{{ old('email', $admin->email) }}" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Department <span class="text-danger">*</span></label>
                        <input type="text" name="department" class="form-control @error('department') is-invalid @enderror" 
                               value="{{ old('department', $admin->department) }}" required>
                        @error('department')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Company <span class="text-danger">*</span></label>
                        <select name="company" class="form-select @error('company') is-invalid @enderror" required>
                            <option value="">Select Company</option>
                            @if(isset($companies) && count($companies) > 0)
                                @foreach($companies as $company)
                                    <option value="{{ $company }}" {{ old('company', $admin->company) == $company ? 'selected' : '' }}>
                                        {{ $company }}
                                    </option>
                                @endforeach
                            @endif
                        </select>
                        @error('company')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="alert alert-info">
                        <strong>Note:</strong> Position is automatically set to "Administrator" for all admins.
                    </div>

                    <div class="d-flex justify-content-between flex-wrap mt-3">
                        <a href="{{ route('su.manage_admins') }}" class="btn btn-secondary">Cancel</a>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
            @else
                <div class="alert alert-danger">
                    Admin not found.
                </div>
                <a href="{{ route('su.manage_admins') }}" class="btn btn-secondary">Back to Admins</a>
            @endif
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
const toggleBtn = document.getElementById('sidebarToggle');
const sidebar = document.getElementById('sidebar');
const mainContent = document.querySelector('.main-content');

toggleBtn?.addEventListener('click', () => {
    sidebar.classList.toggle('d-none');
    mainContent.style.marginLeft = sidebar.classList.contains('d-none') ? '0' : '240px';
});
</script>
</body>
</html>

