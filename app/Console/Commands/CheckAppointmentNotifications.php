<?php

namespace App\Console\Commands;

use App\Models\Appointment;
use App\Models\Notification;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CheckAppointmentNotifications extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'appointments:check-notifications';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check and create appointment notifications';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Check unconfirmed appointments (after 1 hour)
        $this->checkUnconfirmedAppointments();

        // Check upcoming appointments (1 week, 24 hours, 1 hour before)
        $this->checkUpcomingAppointments();

        $this->info('Notifications check completed!');
    }

    private function checkUnconfirmedAppointments()
    {
        Appointment::where('status', 'pending')
            ->where('created_at', '<=', now()->subHour())
            ->whereDoesntHave('notifications', function ($query) {
                $query->where('type', 'unconfirmed');
            })
            ->each(function ($appointment) {
                Notification::create([
                    'appointment_id' => $appointment->id,
                    'type' => 'unconfirmed',
                    'title' => 'Unconfirmed Appointment',
                    'message' => "Appointment scheduled for " . Carbon::parse($appointment->date)->format('M d, Y') . " at " . Carbon::parse($appointment->time)->format('h:i A') . " has been unconfirmed for over an hour."
                ]);
            });
    }

    private function checkUpcomingAppointments()
    {
        Appointment::where('status', 'confirmed')
            ->where('date', '>', now())
            ->each(function ($appointment) {
                $scheduledDate = Carbon::parse($appointment->date . ' ' . $appointment->time);
                $now = Carbon::now();

                // 1 week notification
                if ($now->diffInDays($scheduledDate) === 7) {
                    $this->createUpcomingNotification($appointment, 'upcoming_week', '1 Week');
                }

                // 24 hours notification
                if ($now->diffInHours($scheduledDate) === 24) {
                    $this->createUpcomingNotification($appointment, 'upcoming_day', '24 Hours');
                }

                // 1 hour notification
                if ($now->diffInHours($scheduledDate) === 1) {
                    $this->createUpcomingNotification($appointment, 'upcoming_hour', '1 Hour');
                }
            });
    }

    private function createUpcomingNotification($appointment, $type, $timeframe)
    {
        // Check if notification already exists
        if (!$appointment->notifications()->where('type', $type)->exists()) {
            Notification::create([
                'appointment_id' => $appointment->id,
                'type' => $type,
                'title' => "Upcoming Appointment - {$timeframe}",
                'message' => "Reminder: Your appointment is scheduled for " . Carbon::parse($appointment->date)->format('M d, Y') . " at " . Carbon::parse($appointment->time)->format('h:i A')
            ]);
        }
    }
}
