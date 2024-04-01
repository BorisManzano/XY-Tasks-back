<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;
use PDF;

class ReportController extends Controller
{
    public function downloadPDF(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $tasks = Task::where('status', 'Completado')
             ->whereBetween('completed_at', [
                 $request->start_date . ' 00:00:00', 
                 $request->end_date . ' 23:59:59'
             ])
             ->with('employee')
             ->get();

        $pdf = PDF::loadView('pdf.report', compact('tasks'))
                  ->setPaper('a4', 'portrait');

        return $pdf->stream('tasks-details.pdf');
    }
}