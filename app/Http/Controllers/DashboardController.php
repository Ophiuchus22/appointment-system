<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

/**
 * Handles the admin dashboard functionality and calendar view
 * 
 * This controller manages the admin dashboard which includes:
 * - Calendar view (monthly/weekly) of appointments
 * - Appointment statistics (upcoming, pending, completed)
 * - Recent activity tracking
 * - AJAX-based calendar updates
 */
class DashboardController extends Controller
{
    /**
     * Display the admin dashboard with calendar and statistics
     * 
     * This method handles:
     * - User role verification
     * - Calendar view type (month/week)
     * - Date range calculations
     * - Appointment fetching and grouping
     * - Statistics compilation
     * - AJAX requests for calendar updates
     * 
     * @param Request $request Contains view type and date parameters
     * @return \Illuminate\View\View|\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse|string Returns dashboard view or calendar grid for AJAX
     */
    public function index(Request $request)
    {
        // Check if user is admin
        if (auth()->user()->role !== 'admin') {
            return redirect('/appointments/create');
        }

        $viewType = $request->input('view', 'month');
        $date = Carbon::now();
        
        if ($viewType === 'week' && $request->has('week')) {
            // Parse the specific week date
            $date = Carbon::parse($request->week);
        } elseif ($request->has('month') && $request->has('year')) {
            // Parse the specific month
            $date = Carbon::createFromDate($request->year, $request->month, 1);
        }

        if ($viewType === 'week') {
            $startDate = $date->copy()->startOfWeek(Carbon::SUNDAY);
            $endDate = $date->copy()->endOfWeek(Carbon::SATURDAY);
        } else {
            $startDate = $date->copy()->startOfMonth()->startOfWeek(Carbon::SUNDAY);
            $endDate = $date->copy()->endOfMonth()->endOfWeek(Carbon::SATURDAY);
        }

        $appointments = Appointment::whereBetween('date', [$startDate, $endDate])
            ->orderBy('date')
            ->orderBy('time')
            ->get()
            ->groupBy(function($appointment) {
                return Carbon::parse($appointment->date)->format('Y-m-d');
            });

        $calendar = [];
        $currentDate = $startDate->copy();
        
        while ($currentDate <= $endDate) {
            $dateKey = $currentDate->format('Y-m-d');
            $calendar[] = [
                'date' => $currentDate->copy(),
                'appointments' => $appointments->get($dateKey, collect([]))
            ];
            $currentDate->addDay();
        }

        // Get counts for each category
        $now = Carbon::now();
        
        $upcomingCount = Appointment::where('date', '>=', $now->toDateString())
            ->whereIn('status', ['confirmed', 'pending'])
            ->count();
        
        $pendingCount = Appointment::where('status', 'pending')->count();
        $completedCount = Appointment::where('status', 'completed')->count();

        // Get recent activities
        $recentActivities = $this->getRecentActivities();
        
        // Check if it's an AJAX request
        if ($request->ajax()) {
            // Return only the calendar grid HTML
            return view('admin_side.Extensions.dashboard_calendar_grid', 
                compact('calendar', 'viewType')
            )->render();
        }
        
        // Return full dashboard view
        return view('admin_side.dashboard', compact(
            'calendar',
            'upcomingCount',
            'pendingCount',
            'completedCount',
            'recentActivities',
            'viewType'
        ));
    }

    /**
     * Get recent appointment activities
     * 
     * Retrieves and formats the 10 most recent appointment activities including:
     * - New appointments
     * - Status updates
     * - Appointment modifications
     * 
     * @return \Illuminate\Support\Collection Collection of formatted activity data
     */
    private function getRecentActivities()
    {
        // Get appointments with their associated users, ordered by latest first
        $activities = Appointment::with('user')
            ->orderBy('created_at', 'desc')
            ->orWhere('updated_at', '>', 'created_at')  // Include updated appointments
            ->limit(10)  // Limit to 10 most recent activities
            ->get()
            ->map(function ($appointment) {
                $activity = [
                    'type' => 'appointment',
                    // Use first_name and last_name for external appointments, user name for internal
                    'user' => $appointment->appointment_type === 'External' 
                        ? $appointment->first_name . ' ' . $appointment->last_name
                        : ($appointment->user ? $appointment->user->name : 'Unknown User'),
                    'time' => Carbon::parse(
                        max($appointment->created_at, $appointment->updated_at)
                    )->diffForHumans()
                ];

                // Determine the action based on timestamps and status
                if ($appointment->created_at->eq($appointment->updated_at)) {
                    $activity['action'] = 'created an appointment for ' . Carbon::parse($appointment->date)->format('M d, Y');
                } else {
                    switch ($appointment->status) {
                        case 'confirmed':
                            $activity['action'] = 'confirmed their appointment for ' . Carbon::parse($appointment->date)->format('M d, Y');
                            break;
                        case 'completed':
                            $activity['action'] = 'completed their appointment';
                            break;
                        case 'cancelled':
                            $activity['action'] = 'cancelled their appointment for ' . Carbon::parse($appointment->date)->format('M d, Y');
                            break;
                        default:
                            $activity['action'] = 'updated their appointment for ' . Carbon::parse($appointment->date)->format('M d, Y');
                    }
                }

                return $activity;
            });

        return $activities;
    }
}