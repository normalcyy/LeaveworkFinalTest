<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Edit Employee</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f5f7fa;
        }
        .card {
            padding: 2.5rem;
            border-radius: 15px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            border: 1px solid #A1C2BD;
            background-color: #fff;
        }
        .form-label {
            font-weight: 500;
            font-size: 0.875rem;
            margin-bottom: 0.4rem;
        }
        .form-control {
            border: 1px solid #A1C2BD;
            border-radius: 8px;
            padding: 0.65rem 0.9rem;
            font-size: 0.95rem;
            background-color: #fff;
        }
        .btn-primary {
            background-color: #19183B;
            color: #fff;
            border-radius: 8px;
            padding: 0.65rem 1.5rem;
            font-weight: 500;
            font-size: 0.95rem;
        }
        .btn-secondary {
            background-color: #A1C2BD;
            color: #19183B;
            border-radius: 8px;
            padding: 0.65rem 1.5rem;
            font-weight: 500;
            font-size: 0.95rem;
        }
    </style>
</head>
<body>
<div class="container" style="max-width: 550px; padding: 2rem;">
    <div class="card">
        <h3 style="font-size: 1.5rem; font-weight: 600; margin-bottom: 0.3rem; color: #19183B;">Edit Employee</h3>
        <p style="color: #708993; font-size: 0.875rem; margin-bottom: 1.5rem;">Update employee information</p>

        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if(isset($user))
            <form method="POST" action="{{ route('admin.employees.update', $user->id) }}" id="editEmployeeForm">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Employee ID <span class="text-danger">*</span></label>
                    <input type="text" name="emp_id" class="form-control @error('emp_id') is-invalid @enderror" 
                           value="{{ old('emp_id', $user->emp_id) }}" required>
                    @error('emp_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">First Name <span class="text-danger">*</span></label>
                    <input type="text" name="first_name" class="form-control @error('first_name') is-invalid @enderror" 
                           value="{{ old('first_name', $user->first_name) }}" required>
                    @error('first_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Middle Name</label>
                    <input type="text" name="middle_name" class="form-control @error('middle_name') is-invalid @enderror" 
                           value="{{ old('middle_name', $user->middle_name) }}">
                    @error('middle_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Last Name <span class="text-danger">*</span></label>
                    <input type="text" name="last_name" class="form-control @error('last_name') is-invalid @enderror" 
                           value="{{ old('last_name', $user->last_name) }}" required>
                    @error('last_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Email <span class="text-danger">*</span></label>
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" 
                           value="{{ old('email', $user->email) }}" required>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Position <span class="text-danger">*</span></label>
                    <input type="text" name="position" class="form-control @error('position') is-invalid @enderror" 
                           value="{{ old('position', $user->position) }}" required>
                    @error('position')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Department <span class="text-danger">*</span></label>
                    <input type="text" name="department" class="form-control @error('department') is-invalid @enderror" 
                           value="{{ old('department', $user->department) }}" required>
                    @error('department')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-between flex-wrap mt-3">
                    <a href="{{ route('admin.manage_employees') }}" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        @else
            <div class="alert alert-danger">
                Employee not found.
            </div>
            <a href="{{ route('admin.manage_employees') }}" class="btn btn-secondary">Back to Employees</a>
        @endif
    </div>
</div>
</body>
</html>
