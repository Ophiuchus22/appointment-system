<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class AdminReportController extends Controller
{
    public function index()
    {
        return view('admin_side.report.index');
    }

    public function generate(Request $request)
    {
        $reportTypes = $request->input('report_types', []);
        $data = [
            'generated_at' => now()->format('F j, Y g:i A'),
            'reportTypes' => $reportTypes
        ];

        // Only get appointment stats if selected
        if (in_array('appointment_overview', $reportTypes)) {
            $data['appointmentStats'] = Appointment::select('status', DB::raw('count(*) as count'))
                ->groupBy('status')
                ->get()
                ->pluck('count', 'status')
                ->toArray();

            $data['collegeStats'] = User::join('appointments', 'users.id', '=', 'appointments.user_id')
                ->select('college_office', DB::raw('count(*) as count'))
                ->groupBy('college_office')
                ->get();

            $data['dailyStats'] = Appointment::where('created_at', '>=', Carbon::now()->subDays(30))
                ->select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as count'))
                ->groupBy(DB::raw('DATE(created_at)'))
                ->orderBy('date')
                ->get();
        }

        // Only get user activity if selected
        if (in_array('user_activity', $reportTypes)) {
            $data['frequentUsers'] = User::join('appointments', 'users.id', '=', 'appointments.user_id')
                ->select('users.name', 'users.college_office', DB::raw('count(*) as appointment_count'))
                ->groupBy('users.id', 'users.name', 'users.college_office')
                ->orderBy('appointment_count', 'desc')
                ->limit(5)
                ->get();
        }

        // Only get purpose analysis if selected
        if (in_array('purpose_analysis', $reportTypes)) {
            $data['commonPurposes'] = Appointment::select('purpose', DB::raw('count(*) as count'))
                ->groupBy('purpose')
                ->orderBy('count', 'desc')
                ->limit(5)
                ->get();
        }

        $pdf = PDF::loadView('admin_side.report.admin_pdf', $data);
        return $pdf->download('admin-report.pdf');
    }
} 