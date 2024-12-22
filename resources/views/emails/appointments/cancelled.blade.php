@component('mail::message')
# Appointment Cancellation Notice

Dear {{ $appointment->appointment_type === 'Internal' ? $appointment->user->name : $appointment->first_name }},

Your appointment has been cancelled. Here are the details of the cancelled appointment:

**Appointment Details:**
- Date: {{ $appointment->date->format('M d, Y') }}
- Time: {{ $appointment->time->format('h:i A') }}
- Purpose: {{ $appointment->purpose }}

If you have any questions, please contact us.

Thanks,<br>
{{ config('app.name') }}
@endcomponent 