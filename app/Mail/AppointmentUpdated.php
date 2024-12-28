<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Appointment;

/**
 * Handles the generation of appointment update notification emails
 * 
 * This mailable class creates and formats emails sent when:
 * - Appointment date or time is changed
 * - Appointment details are modified
 * - Tracks changes between old and new values
 */
class AppointmentUpdated extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The appointment instance.
     *
     * @var Appointment
     */
    public $appointment;

    /**
     * The changes made to the appointment.
     *
     * @var array
     */
    public $changes;

    /**
     * Create a new message instance.
     *
     * @param Appointment $appointment The updated appointment
     * @param array $changes Array containing old and new values
     */
    public function __construct(Appointment $appointment, array $changes)
    {
        $this->appointment = $appointment;
        $this->changes = $changes;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.appointments.updated')
                    ->subject('Your Appointment Has Been Updated');
    }
}
