@component('mail::message')
# OFFICE OF THE ACADEMIC AFFAIRS

Dear {{ $appointment->appointment_type === 'Internal' ? $appointment->user->name : $appointment->first_name }},

This is to inform you that your appointment has been updated.

**CHANGES MADE:**

@if(isset($changes['old']['date']) && isset($changes['new']['date']))
Date: {{ \Carbon\Carbon::parse($changes['old']['date'])->format('M d, Y') }} → {{ \Carbon\Carbon::parse($changes['new']['date'])->format('M d, Y') }} <br>
@endif 
@if(isset($changes['old']['time']) && isset($changes['new']['time']))
Time: {{ \Carbon\Carbon::parse($changes['old']['time'])->format('h:i A') }} → {{ \Carbon\Carbon::parse($changes['new']['time'])->format('h:i A') }}
@endif

**UPDATED APPOINTMENT DETAILS:**

Purpose: {{ $appointment->purpose }} <br>
Description: {{ $appointment->description }}

For inquiries, you may contact us through:

Email: academic.affairs@example.com <br>
Contact No.: (123) 456-7890

Best regards,

Academic Affairs Office -
Ramon Magsaysay Memorial Colleges
@endcomponent 