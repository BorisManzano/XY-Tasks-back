<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Tareas</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>Reporte de Tareas</h1>
    @if($tasks->isEmpty())
        <p>No se encontraron tareas completadas en el rango de fechas especificado.</p>
    @else
        <p>Se encontraron {{ $tasks->count() }} tareas completadas.</p>
        <table>
            <thead>
                <tr>
                    <th>Tarea</th>
                    <th>Estado</th>
                    <th>Tiempo de Completado</th>
                    <th>Empleado Asignado</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($tasks as $task)
                    <tr>
                        <td>{{ $task->task }}</td>
                        <td>{{ $task->status }}</td>
                        @if (!is_null($task->completed_at))
                            <td>
                                {{ \Carbon\Carbon::parse($task->created_at)->diffInMinutes(\Carbon\Carbon::parse($task->completed_at)) }} minutos
                            </td>
                        @else
                            <td>No completado</td>
                        @endif
                        <td>{{ $task->employee->name ?? 'No Asignado' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</body>
</html>