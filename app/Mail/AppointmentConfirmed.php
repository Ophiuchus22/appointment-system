<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Appointment;

/**
 * Handles the generation of appointment confirmation emails
 * 
 * This mailable class creates and formats emails sent when:
 * - An appointment is confirmed by admin
 * - An appointment is automatically confirmed
 * - A rescheduled appointment is confirmed
 */
class AppointmentConfirmed extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The appointment instance.
     *
     * @var Appointment
     */
    public $appointment;

    /**
     * Create a new message instance.
     *
     * @param Appointment $appointment The appointment that was confirmed
     */
    public function __construct(Appointment $appointment)
    {
        $this->appointment = $appointment;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.appointments.confirmed')
                    ->subject('Your Appointment Has Been Confirmed');
    }
}
