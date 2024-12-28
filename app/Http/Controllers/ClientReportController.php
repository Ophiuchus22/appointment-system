<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Appointment;
use Carbon\Carbon;

class ClientReportController extends Controller
{
    public function generate()
    {
        // Get authenticated user's appointments
        $appointments = Appointment::where('user_id', auth()->id())
            ->orderBy('date', 'desc')
            ->orderBy('time', 'desc')
            ->get();

        // Transform the data for better display
        $appointments->transform(function ($appointment) {
            $appointment->formatted_date = Carbon::parse($appointment->date)->format('F j, Y');
            $appointment->formatted_time = Carbon::parse($appointment->time)->format('g:i A');
            return $appointment;
        });

        // Generate PDF
        $pdf = PDF::loadView('client.report.client_pdf', [
            'appointments' => $appointments,
            'user' => auth()->user(),
            'generated_at' => now()->format('F j, Y g:i A')
        ]);

        // Download the PDF
        return $pdf->download('appointments-report.pdf');
    }
} 