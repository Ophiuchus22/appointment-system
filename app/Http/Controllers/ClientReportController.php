<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Appointment;
use Carbon\Carbon;
use App\Traits\LogsActivity;

/**
 * Handles the generation of client-specific appointment reports
 * 
 * This controller manages the creation of PDF reports for client users,
 * allowing them to download their appointment history and details.
 * The reports include:
 * - List of all appointments
 * - Appointment dates and times
 * - Current status of each appointment
 */
class ClientReportController extends Controller
{
    use LogsActivity;

    /**
     * Generate a PDF report of the authenticated user's appointments
     * 
     * This method creates a downloadable PDF containing:
     * - All appointments for the current user
     * - Formatted dates and times
     * - Generation timestamp
     * 
     * @return \Illuminate\Http\Response Returns the downloaded PDF report
     */
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

        // Fix timezone for generation timestamp
        $generated_at = now()->setTimezone('Asia/Manila')->format('F j, Y g:i A');

        // Generate PDF
        $pdf = PDF::loadView('client.report.client_pdf', [
            'appointments' => $appointments,
            'user' => auth()->user(),
            'generated_at' => $generated_at
        ]);

        // Log the report generation
        $this->logActivity('generate_report');

        // Download the PDF
        return $pdf->download('appointments-report.pdf');
    }
} 