<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Exception;

class AppointmentController extends Controller
{
    public function create()
    {
        $colleges = [
            'COLLEGE OF ARTS AND SCIENCES',
            'COLLEGE OF BUSINESS EDUCATION',
            'COLLEGE OF CRIMINAL JUSTICE',
            'COLLEGE OF ENGINEERING AND TECHNOLOGY',
            'COLLEGE OF TEACHER EDUCATION'
        ];

        return view('client.appointments.create', compact('colleges'));
    }

    public function store(Request $request)
    {
        try {
            // Validate the request
            $validated = $request->validate([
                'first_name' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z\s\'-]*$/', 'min:2'],
                'last_name' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z\s\'-]*$/', 'min:2'],
                'college' => 'required|string',
                'email' => ['nullable', 'max:255'],
                'phone_number' => ['required', 'regex:/^[0-9]{11}$/', 'max:20'],
                'date' => 'required|date|after_or_equal:today',
                'time' => 'required|date_format:H:i',
                'purpose' => 'required|string'
            ], [
                'first_name.regex' => 'The first name must contain only letters, spaces, hyphens, and apostrophes.',
                'first_name.min' => 'The first name must be at least 2 characters.',
                'last_name.regex' => 'The last name must contain only letters, spaces, hyphens, and apostrophes.',
                'last_name.min' => 'The last name must be at least 2 characters.',
                // 'email.email' => 'Please enter a valid email address.',
                'email.email:rfc,dns' => 'Please enter a valid email address with a valid domain.',
                'phone_number.regex' => 'Invalid phone number',
                'date.after_or_equal' => 'The appointment date must be today or a future date.',
                'time.date_format' => 'Please provide a valid time in 24-hour format (HH:MM).'
            ]);
            
            // Check for existing appointments on the same date and time
            $existingAppointment = Appointment::where('date', $validated['date'])
                ->where('time', $validated['time'])
                ->first();

            if ($existingAppointment) {
                return redirect()->route('client.appointments.create')
                    ->with('error', 'This time slot is already booked. Please select a different time.')
                    ->withInput();
            }

            // Create the appointment
            $appointment = new Appointment();
            $appointment->user_id = Auth::id();
            $appointment->first_name = $validated['first_name'];
            $appointment->last_name = $validated['last_name'];
            $appointment->college = $validated['college'];
            $appointment->email = $validated['email'] ?? null;
            $appointment->phone_number = $validated['phone_number'];
            $appointment->date = $validated['date'];
            $appointment->time = $validated['time'];
            $appointment->purpose = $validated['purpose'];
            $appointment->save();

            return redirect()->route('client.appointments.create')
                ->with('success', 'Your appointment has been successfully scheduled!');

        } catch (Exception $e) {
            // Log the error for debugging
            logger()->error('Appointment creation failed: ' . $e->getMessage());

            // Handle validation errors
            if ($e instanceof \Illuminate\Validation\ValidationException) {
                $firstError = collect($e->validator->errors()->all())->first();
                return redirect()->route('client.appointments.create')
                    ->withErrors($e->validator)
                    ->withInput()
                    ->with('error', $firstError);
            }

            // Handle other unexpected errors
            return redirect()->route('client.appointments.create')
                ->with('error', 'Unable to schedule appointment. Please try again later.')
                ->withInput();
        }
    }
}