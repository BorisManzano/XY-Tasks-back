<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Report</title>
</head>
<body>
    <h1>Task Report</h1>
    <table>
        <thead>
            <tr>
                <th>Task</th>
                <th>Status</th>
                <th>Employee</th>
                <th>Completion Time</th>
            </tr>
        </thead>
        <tbody>
            @foreach($tasks as $task)
                <tr>
                    <td>{{ $task->title }}</td>
                    <td>{{ $task->status }}</td>
                    <td>{{ $task->employee->name }}</td>
                    <td>{{ Carbon\Carbon::parse($task->completed_at)->diffForHumans($task->created_at, true) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
