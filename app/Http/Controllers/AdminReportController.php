<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\User;
use App\Traits\LogsActivity;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

/**
 * Handles the generation and management of administrative reports
 * 
 * This controller manages the creation of detailed PDF reports for administrative purposes.
 * It can generate different types of reports including:
 * - Appointment Overview: Shows appointment statistics, college-wise distribution, and daily trends
 * - User Activity: Displays the most active users and their appointment frequencies
 * - Purpose Analysis: Analyzes common purposes for appointments
 * 
 * The reports can be generated individually or combined based on user selection.
 */
class AdminReportController extends Controller
{
    use LogsActivity;

    /**
     * Display the report generation page
     * 
     * This method shows the interface where administrators can select
     * which types of reports they want to generate.
     * 
     * @return \Illuminate\View\View Returns the report selection page view
     */
    public function index()
    {
        return view('admin_side.report.index');
    }

    /**
     * Generate a PDF report based on selected report types
     * 
     * This method processes the selected report types and generates a comprehensive PDF report.
     * It can include:
     * - Appointment Statistics: Total counts by status
     * - College-wise Distribution: Appointment counts per college office
     * - Daily Trends: Last 30 days appointment creation pattern
     * - Top 5 Most Active Users: Users with most appointments
     * - Top 5 Common Purposes: Most frequent appointment purposes
     * 
     * @param Request $request Contains the selected report types in 'report_types' array
     * @return \Illuminate\Http\Response Returns the downloaded PDF
     */
    public function generate(Request $request)
    {
        $reportTypes = $request->input('report_types', []);
        $dateRange = $request->input('date_range', 'all');
        $customStartDate = $request->input('start_date');
        $customEndDate = $request->input('end_date');

        // Calculate date range
        $startDate = null;
        $endDate = now();

        switch ($dateRange) {
            case 'today':
                $startDate = now()->startOfDay();
                break;
            case 'week':
                $startDate = now()->startOfWeek();
                break;
            case 'month':
                $startDate = now()->startOfMonth();
                break;
            case 'year':
                $startDate = now()->startOfYear();
                break;
            case 'custom':
                $startDate = Carbon::parse($customStartDate)->startOfDay();
                $endDate = Carbon::parse($customEndDate)->endOfDay();
                break;
        }

        $data = [
            'generated_at' => now()->setTimezone('Asia/Manila')->format('F j, Y g:i A'),
            'reportTypes' => $reportTypes,
            'date_range' => [
                'start' => $startDate ? $startDate->format('F j, Y') : 'All time',
                'end' => $endDate->format('F j, Y')
            ]
        ];

        // Only get appointment stats if selected
        if (in_array('appointment_overview', $reportTypes)) {
            $query = Appointment::query();
            if ($startDate) {
                $query->whereBetween('created_at', [$startDate, $endDate]);
            }
            
            $data['appointmentStats'] = $query->select('status', DB::raw('count(*) as count'))
                ->groupBy('status')
                ->get()
                ->pluck('count', 'status')
                ->toArray();

            $collegeQuery = User::join('appointments', 'users.id', '=', 'appointments.user_id');
            if ($startDate) {
                $collegeQuery->whereBetween('appointments.created_at', [$startDate, $endDate]);
            }
            $data['collegeStats'] = $collegeQuery->select('college_office', DB::raw('count(*) as count'))
                ->groupBy('college_office')
                ->get();
        }

        // Only get user activity if selected
        if (in_array('user_activity', $reportTypes)) {
            $userQuery = User::join('appointments', 'users.id', '=', 'appointments.user_id');
            if ($startDate) {
                $userQuery->whereBetween('appointments.created_at', [$startDate, $endDate]);
            }
            $data['frequentUsers'] = $userQuery->select('users.name', 'users.college_office', DB::raw('count(*) as appointment_count'))
                ->groupBy('users.id', 'users.name', 'users.college_office')
                ->orderBy('appointment_count', 'desc')
                ->limit(5)
                ->get();
        }

        // Only get purpose analysis if selected
        if (in_array('purpose_analysis', $reportTypes)) {
            $purposeQuery = Appointment::query();
            if ($startDate) {
                $purposeQuery->whereBetween('created_at', [$startDate, $endDate]);
            }
            $data['commonPurposes'] = $purposeQuery->select('purpose', DB::raw('count(*) as count'))
                ->groupBy('purpose')
                ->orderBy('count', 'desc')
                ->limit(5)
                ->get();
        }

        // Log the report generation
        $this->logActivity(
            'generate_admin_report',
            auth()->user()->name . ' (' . ucfirst(auth()->user()->role) . ') generated an administrative report',
            null,
            'report'
        );

        $pdf = PDF::loadView('admin_side.report.admin_pdf', $data);
        return $pdf->download('admin-report.pdf');
    }
} 