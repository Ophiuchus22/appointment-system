<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Check if user is admin
        if (auth()->user()->role !== 'admin') {
            return redirect('/appointments/create');
        }

        // Get requested month/year or use current date
        $date = Carbon::now();
        if ($request->has('month') && $request->has('year')) {
            $date = Carbon::createFromDate($request->year, $request->month, 1);
        }

        $startOfMonth = $date->copy()->startOfMonth()->startOfWeek(Carbon::SUNDAY);
        $endOfMonth = $date->copy()->endOfMonth()->endOfWeek(Carbon::SATURDAY);
        
        // Get all appointments for the displayed date range
        $appointments = Appointment::whereBetween('date', [$startOfMonth, $endOfMonth])
            ->orderBy('date')
            ->orderBy('time')
            ->get()
            ->groupBy(function($appointment) {
                return Carbon::parse($appointment->date)->format('Y-m-d');
            });
        
        // Generate calendar data
        $calendar = [];
        $currentDate = $startOfMonth->copy();
        
        while ($currentDate <= $endOfMonth) {
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
            return view('admin_side.dashboard_calendar_grid', compact('calendar'))->render();
        }
        
        // Return full dashboard view
        return view('admin_side.dashboard', compact(
            'calendar',
            'upcomingCount',
            'pendingCount',
            'completedCount',
            'recentActivities'
        ));
    }

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
                    'user' => $appointment->user->name,
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