<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Exception;
use Carbon\Carbon;

class AppointmentController extends Controller
{
    public function create()
    {
        return view('client.appointments.create');
    }

    public function viewAppointment()
    {
        $appointments = Appointment::where('user_id', Auth::id())
                                ->orderBy('date', 'desc')
                                ->orderBy('time', 'desc')
                                ->get();
        return view('client.appointments.viewAppointment', compact('appointments'));
    }

    public function store(Request $request)
    {
        try {
            // Validate the request
            $validated = $request->validate([
                'phone_number' => ['nullable', 'regex:/^[0-9]{11}$/', 'max:20'],
                'date' => 'required|date|after_or_equal:today',
                'time' => [
                    'required',
                    'date_format:H:i',
                    function ($attribute, $value, $fail) {
                        $time = \Carbon\Carbon::createFromFormat('H:i', $value);
                        $hour = (int) $time->format('H');
                        $minute = (int) $time->format('i');

                        // Morning shift: 9 AM to 12 PM
                        $isMorningShift = ($hour >= 9 && $hour < 12) || 
                                        ($hour == 12 && $minute == 0);

                        // Afternoon shift: 1 PM to 5 PM
                        $isAfternoonShift = $hour >= 13 && $hour < 17;

                        if (!$isMorningShift && !$isAfternoonShift) {
                            $fail('Appointments are only available from 9 AM - 12 PM and 1 PM - 5 PM.');
                        }
                    }
                ],
                'purpose' => 'required|string',
                'description' => 'required|string|max:1000'  // Adjust max length as needed
            ], [
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
            $appointment->phone_number = $validated['phone_number'] ?? null;
            $appointment->date = $validated['date'];
            $appointment->time = $validated['time'];
            $appointment->purpose = $validated['purpose'];
            $appointment->description = $validated['description'];
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

    public function update(Request $request, Appointment $appointment)
    {
        try {
            // Check if user owns this appointment
            if ($appointment->user_id !== Auth::id()) {
                return response()->json([
                    'error' => 'Unauthorized access.'
                ], 403);
            }

            // Check if appointment is still pending
            if ($appointment->status !== 'pending') {
                return response()->json([
                    'error' => 'Only pending appointments can be updated.'
                ], 400);
            }

            // Validate the request
            $validated = $request->validate([
                'phone_number' => ['nullable', 'regex:/^[0-9]{11}$/', 'max:20'],
                'date' => 'required|date|after_or_equal:today',
                'time' => [
                    'required',
                    'date_format:H:i',
                    function ($attribute, $value, $fail) {
                        $time = Carbon::createFromFormat('H:i', $value);
                        $hour = (int) $time->format('H');
                        $minute = (int) $time->format('i');

                        // Morning shift: 9 AM to 12 PM
                        $isMorningShift = ($hour >= 9 && $hour < 12) || 
                                        ($hour == 12 && $minute == 0);

                        // Afternoon shift: 1 PM to 5 PM
                        $isAfternoonShift = $hour >= 13 && $hour < 17;

                        if (!$isMorningShift && !$isAfternoonShift) {
                            $fail('Appointments are only available from 9 AM - 12 PM and 1 PM - 5 PM.');
                        }
                    }
                ],
                'purpose' => 'required|string',
                'description' => 'required|string|max:1000'
            ]);

            // Check for existing appointments on the same date and time (excluding current appointment)
            $existingAppointment = Appointment::where('date', $validated['date'])
                ->where('time', $validated['time'])
                ->where('id', '!=', $appointment->id)
                ->first();

            if ($existingAppointment) {
                return response()->json([
                    'error' => 'This time slot is already booked. Please select a different time.'
                ], 400);
            }

            // Format the time properly
            $timeString = $validated['time'];
            $time = Carbon::createFromFormat('H:i', $timeString)->format('H:i:s');

            // Update the appointment
            $appointment->update([
                'phone_number' => $validated['phone_number'],
                'date' => $validated['date'],
                'time' => $time,
                'purpose' => $validated['purpose'],
                'description' => $validated['description']
            ]);

            return response()->json([
                'success' => 'Appointment updated successfully!',
                'appointment' => $appointment->fresh()
            ]);

        } catch (Exception $e) {
            logger()->error('Appointment update failed: ' . $e->getMessage());

            if ($e instanceof \Illuminate\Validation\ValidationException) {
                return response()->json([
                    'error' => collect($e->validator->errors()->all())->first()
                ], 422);
            }

            return response()->json([
                'error' => 'Unable to update appointment. Please try again later.'
            ], 500);
        }
    }

    public function cancel(Appointment $appointment)
    {
        try {
            // Check if user owns this appointment
            if ($appointment->user_id !== Auth::id()) {
                return redirect()->route('client.appointments.viewAppointment')
                    ->with('error', 'Unauthorized access.');
            }

            // Check if appointment can be cancelled
            if (!in_array($appointment->status, ['pending', 'approved'])) {
                return redirect()->route('client.appointments.viewAppointment')
                    ->with('error', 'This appointment cannot be cancelled.');
            }

            // Cancel the appointment
            $appointment->status = 'cancelled';
            $appointment->save();

            return redirect()->route('client.appointments.viewAppointment')
                ->with('success', 'Appointment cancelled successfully.');

        } catch (Exception $e) {
            logger()->error('Appointment cancellation failed: ' . $e->getMessage());
            return redirect()->route('client.appointments.viewAppointment')
                ->with('error', 'Unable to cancel appointment. Please try again later.');
        }
    }

    public function destroy(Appointment $appointment)
    {
        try {
            // Check if user owns this appointment
            if ($appointment->user_id !== Auth::id()) {
                return redirect()->route('client.appointments.viewAppointment')
                    ->with('error', 'Unauthorized access.');
            }

            // Check if appointment can be deleted (only cancelled or rejected appointments)
            if (!in_array($appointment->status, ['cancelled', 'rejected'])) {
                return redirect()->route('client.appointments.viewAppointment')
                    ->with('error', 'Only cancelled or rejected appointments can be deleted.');
            }

            // Delete the appointment
            $appointment->delete();

            return redirect()->route('client.appointments.viewAppointment')
                ->with('success', 'Appointment deleted successfully.');

        } catch (Exception $e) {
            logger()->error('Appointment deletion failed: ' . $e->getMessage());
            return redirect()->route('client.appointments.viewAppointment')
                ->with('error', 'Unable to delete appointment. Please try again later.');
        }
    }
}