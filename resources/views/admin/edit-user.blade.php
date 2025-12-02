<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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

        <form method="POST" action="#">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Employee ID</label>
                <input type="text" name="emp_id" class="form-control" value="EMP001" required>
            </div>

            <div class="mb-3">
                <label class="form-label">First Name</label>
                <input type="text" name="first_name" class="form-control" value="John" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Middle Name</label>
                <input type="text" name="middle_name" class="form-control" value="A.">
            </div>

            <div class="mb-3">
                <label class="form-label">Last Name</label>
                <input type="text" name="last_name" class="form-control" value="Doe" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Position</label>
                <input type="text" name="position" class="form-control" value="Software Engineer">
            </div>

            <div class="d-flex justify-content-between flex-wrap mt-3">
                <a href="#" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">Save Changes</button>
            </div>
        </form>
    </div>
</div>
</body>
</html>
