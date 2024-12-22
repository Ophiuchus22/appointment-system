@component('mail::message')
# Appointment Update Notification

Dear {{ $appointment->appointment_type === 'Internal' ? $appointment->user->name : $appointment->first_name }},

Your appointment has been updated. Here are the changes:

@if(isset($changes['date']))
- Date: {{ \Carbon\Carbon::parse($changes['old']['date'])->format('M d, Y') }} → {{ \Carbon\Carbon::parse($changes['new']['date'])->format('M d, Y') }}
@endif

@if(isset($changes['time']))
- Time: {{ \Carbon\Carbon::parse($changes['old']['time'])->format('h:i A') }} → {{ \Carbon\Carbon::parse($changes['new']['time'])->format('h:i A') }}
@endif

**Updated Appointment Details:**
- Purpose: {{ $appointment->purpose }}
- Description: {{ $appointment->description }}

@component('mail::button', ['url' => config('app.url')])
View Appointment
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent 