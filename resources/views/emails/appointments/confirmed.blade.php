@component('mail::message')
# ACADEMIC AFFAIRS OFFICE

Dear {{ $appointment->appointment_type === 'Internal' ? $appointment->user->name : $appointment->first_name }},

This is to inform you that your appointment has been confirmed.

**APPOINTMENT DETAILS:**

Date: {{ $appointment->date->format('M d, Y') }} <br>
Time: {{ $appointment->time->format('h:i A') }} <br>
Purpose: {{ $appointment->purpose }} <br>
Description: {{ $appointment->description }}

Please be reminded to arrive at least 15 minutes before your scheduled appointment.

For inquiries, you may contact us through:

Email: acad@rmmc.edu.ph <br>
Contact No.: 0963-835-4416

Best regards,

Academic Affairs Office -
Ramon Magsaysay Memorial Colleges
@endcomponent 