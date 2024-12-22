<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ExternalAppointmentController extends Controller
{
    public function index()
    {
        $appointments = Appointment::with('user')
                                ->orderBy('date', 'desc')
                                ->orderBy('time', 'desc')
                                ->get();

        return view('admin_side.appointments', compact('appointments'));
    }

    public function store(Request $request)
    {
        try {
            // Validate the request
            $validated = $request->validate([
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'company_name' => 'required|string|max:255',
                'phone_number' => ['required', 'regex:/^[0-9]{11}$/', 'max:20'],
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
                'purpose' => 'required|string|max:255',
                'description' => 'required|string|max:1000',
                'address' => 'required|string|max:1000',
            ]);

            // Check for existing appointments
            $existingAppointment = Appointment::where('date', $validated['date'])
                ->where('time', $validated['time'])
                ->first();

            if ($existingAppointment) {
                return redirect()->back()
                    ->with('error', 'This time slot is already booked. Please select a different time.')
                    ->withInput();
            }

            // For debugging, let's log the data before creating
            \Log::info('Attempting to create appointment with data:', $validated);

            // Create the appointment
            $appointment = Appointment::create([
                'first_name' => $validated['first_name'],
                'last_name' => $validated['last_name'],
                'email' => $validated['email'],
                'company_name' => $validated['company_name'],
                'phone_number' => $validated['phone_number'],
                'date' => $validated['date'],
                'time' => $validated['time'],
                'purpose' => $validated['purpose'],
                'description' => $validated['description'],
                'address' => $validated['address'],
                'appointment_type' => 'External',
                'status' => 'pending'
            ]);

            return redirect()->route('admin.appointments.index')
                ->with('success', 'External appointment has been successfully created.');

        } catch (\Exception $e) {
            // Log the actual error
            \Log::error('Error creating appointment: ' . $e->getMessage());
            
            return redirect()->back()
                ->with('error', 'An error occurred: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function show($id)
    {
        $appointment = Appointment::with('user')->findOrFail($id);
        return response()->json($appointment);
    }

    public function confirm(Appointment $appointment)
    {
        try {
            if ($appointment->status !== 'pending') {
                return response()->json([
                    'success' => false,
                    'message' => 'Only pending appointments can be confirmed'
                ], 400);
            }

            $appointment->update(['status' => 'confirmed']);

            return response()->json([
                'success' => true,
                'message' => 'Appointment has been confirmed successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while confirming the appointment'
            ], 500);
        }
    }

    public function cancel(Appointment $appointment)
    {
        try {
            if (in_array($appointment->status, ['cancelled', 'completed'])) {
                return response()->json([
                    'success' => false,
                    'message' => 'This appointment cannot be cancelled'
                ], 400);
            }

            $appointment->update(['status' => 'cancelled']);

            return response()->json([
                'success' => true,
                'message' => 'Appointment has been cancelled successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while cancelling the appointment'
            ], 500);
        }
    }

    public function complete(Appointment $appointment)
    {
        try {
            if ($appointment->status !== 'confirmed') {
                return response()->json([
                    'success' => false,
                    'message' => 'Only confirmed appointments can be marked as completed'
                ], 400);
            }

            $appointment->update(['status' => 'completed']);

            return response()->json([
                'success' => true,
                'message' => 'Appointment has been marked as completed'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while completing the appointment'
            ], 500);
        }
    }

    public function destroy(Appointment $appointment)
    {
        try {
            if (!in_array($appointment->status, ['cancelled', 'completed'])) {
                return response()->json([
                    'success' => false,
                    'message' => 'Only cancelled or completed appointments can be deleted'
                ], 400);
            }

            $appointment->delete();

            return response()->json([
                'success' => true,
                'message' => 'Appointment has been deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while deleting the appointment'
            ], 500);
        }
    }
} 