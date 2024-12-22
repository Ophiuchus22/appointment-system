@component('mail::message')
# Appointment Confirmation

Dear {{ $appointment->appointment_type === 'Internal' ? $appointment->user->name : $appointment->first_name }},

Your appointment has been confirmed. Here are the details:

**Appointment Details:**
- Date: {{ $appointment->date->format('M d, Y') }}
- Time: {{ $appointment->time->format('h:i A') }}
- Purpose: {{ $appointment->purpose }}
- Description: {{ $appointment->description }}

@component('mail::button', ['url' => config('app.url')])
View Appointment
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent 