<?php

namespace App\Console\Commands;

use App\Models\Appointment;
use App\Models\Notification;
use Carbon\Carbon;
use Illuminate\Console\Command;

/**
 * Checks and creates appointment notifications
 * 
 * This command handles automated notification generation for:
 * - Unconfirmed appointments (after 1 hour)
 * - Upcoming appointments at different intervals:
 *   - 1 week before
 *   - 24 hours before
 *   - 1 hour before
 */
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
     * 
     * Runs notification checks for both unconfirmed and upcoming appointments
     */
    public function handle()
    {
        // Check upcoming appointments (1 week, 24 hours, 1 hour before)
        $this->checkUpcomingAppointments();

        $this->info('Notifications check completed!');
    }

    /**
     * Check and create notifications for upcoming appointments
     * 
     * Creates notifications at different time intervals:
     * - 1 week before appointment
     * - 24 hours before appointment
     * - 1 hour before appointment
     */
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

    /**
     * Create a notification for an upcoming appointment
     * 
     * @param Appointment $appointment The appointment to create notification for
     * @param string $type Notification type (upcoming_week/upcoming_day/upcoming_hour)
     * @param string $timeframe Human-readable time frame (1 Week/24 Hours/1 Hour)
     */
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
