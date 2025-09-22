<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Teacher Salaries</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        h2 { text-align: center; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #333; padding: 8px; text-align: left; }
        th { background: #6b21a8; color: #fff; }
        tr:nth-child(even) { background: #f3e8ff; }
    </style>
</head>
<body>
    <h2>{{ $school }} - Active Teacher Salaries</h2>
    <p>Date: {{ $date }}</p>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Last Name</th>
                <th>First Name</th>
                <th>Middle Name</th>
                <th>Sex</th>
                <th>Salary (₦)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($teachers as $index => $teacher)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $teacher->last_name }}</td>
                    <td>{{ $teacher->first_name }}</td>
                    <td>{{ $teacher->middle_name }}</td>
                    <td>{{ $teacher->sex }}</td>
                    <td>{{ number_format($teacher->activeSalary->amount, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
