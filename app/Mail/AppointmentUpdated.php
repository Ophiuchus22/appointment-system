<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Appointment;

class AppointmentUpdated extends Mailable
{
    use Queueable, SerializesModels;

    public $appointment;
    public $changes;

    public function __construct(Appointment $appointment, array $changes)
    {
        $this->appointment = $appointment;
        $this->changes = $changes;
    }

    public function build()
    {
        return $this->markdown('emails.appointments.updated')
                    ->subject('Your Appointment Has Been Updated');
    }
}
