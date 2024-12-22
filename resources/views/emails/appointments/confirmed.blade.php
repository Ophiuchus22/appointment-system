@component('mail::message')
# OFFICE OF THE ACADEMIC AFFAIRS

Dear {{ $appointment->appointment_type === 'Internal' ? $appointment->user->name : $appointment->first_name }},

This is to inform you that your appointment has been confirmed.

**APPOINTMENT DETAILS:**

Date: {{ $appointment->date->format('M d, Y') }}
Time: {{ $appointment->time->format('h:i A') }}
Purpose: {{ $appointment->purpose }}
Description: {{ $appointment->description }}

Please be reminded to arrive at least 15 minutes before your scheduled appointment.

For inquiries, you may contact us through:
Email: academic.affairs@example.com
Contact No.: (123) 456-7890

Best regards,

Academic Affairs OFFICE
Ramon Magsaysay Memorial Colleges - GSC
@endcomponent 