@component('mail::message')
# OFFICE OF THE ACADEMIC AFFAIRS

Dear {{ $appointment->appointment_type === 'Internal' ? $appointment->user->name : $appointment->first_name }},

This is to inform you that your appointment has been cancelled.

**APPOINTMENT DETAILS:**

Date: {{ $appointment->date->format('M d, Y') }} <br>
Time: {{ $appointment->time->format('h:i A') }} <br>
Purpose: {{ $appointment->purpose }}

For inquiries, you may contact us through:

Email: academic.affairs@example.com <br>
Contact No.: (123) 456-7890

Best regards,

Academic Affairs Office -
Ramon Magsaysay Memorial Colleges
@endcomponent 