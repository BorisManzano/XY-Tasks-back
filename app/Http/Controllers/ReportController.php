<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Barryvdh\DomPDF\Facade\Pdf;
use Dompdf\Dompdf;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function generateReport(Request $request)
    {
        // Validar las fechas
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        // Obtener tareas completadas en el rango de fechas
        $tasks = Task::where('status', 'completed')
                     ->whereBetween('completed_at', [
                         $request->start_date,
                         $request->end_date
                     ])
                     ->with('employee')
                     ->get();

        // Generar contenido del PDF
        $pdfContent = view('task_report', compact('tasks'));

        // Crear instancia de Dompdf
        $pdf = new Dompdf();
        $pdf->loadHtml($pdfContent);

        // Opcional: Personalizar configuraciones de Dompdf (por ejemplo, tamaño de página, etc.)

        // Renderizar el PDF
        $pdf->render();

        // Descargar el PDF
        return $pdf->stream('task_report.pdf');
    }
}
