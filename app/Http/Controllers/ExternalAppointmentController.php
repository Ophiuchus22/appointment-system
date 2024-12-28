<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Mail\AppointmentUpdated;
use App\Mail\AppointmentConfirmed;
use App\Mail\AppointmentCancelled;
use Illuminate\Support\Facades\Mail;

/**
 * Handles external appointment management
 * 
 * This controller manages appointments for external clients/visitors including:
 * - Listing all appointments
 * - Creating new appointments
 * - Updating appointment status (confirm, cancel, complete)
 * - Managing appointment schedules
 * - Sending email notifications
 */
class ExternalAppointmentController extends Controller
{
    /**
     * Display a listing of appointments
     * 
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $appointments = Appointment::with('user')
                                ->orderBy('date', 'desc')
                                ->orderBy('time', 'desc')
                                ->get();

        return view('admin_side.appointments', compact('appointments'));
    }

    /**
     * Store a new external appointment
     * 
     * Validates and stores appointment details including:
     * - Personal information
     * - Schedule details
     * - Purpose and description
     * 
     * @param Request $request Contains appointment details
     * @return \Illuminate\Http\RedirectResponse
     */
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

    /**
     * Display appointment details
     * 
     * @param int $id Appointment ID
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $appointment = Appointment::with('user')->findOrFail($id);
        return response()->json($appointment);
    }

    /**
     * Confirm an appointment and send email notification
     * 
     * @param Appointment $appointment
     * @return \Illuminate\Http\RedirectResponse
     */
    public function confirm(Appointment $appointment)
    {
        try {
            if ($appointment->status !== 'pending') {
                return back()->with('error', 'Only pending appointments can be confirmed');
            }

            $appointment->update(['status' => 'confirmed']);

            // Send confirmation email
            $email = $appointment->appointment_type === 'Internal' 
                ? $appointment->user->email 
                : $appointment->email;

            Mail::to($email)->send(new AppointmentConfirmed($appointment));

            return back()->with('success', 'Appointment has been confirmed successfully');
        } catch (\Exception $e) {
            return back()->with('error', 'An error occurred while confirming the appointment');
        }
    }

    /**
     * Cancel an appointment and send email notification
     * 
     * @param Appointment $appointment
     * @return \Illuminate\Http\RedirectResponse
     */
    public function cancel(Appointment $appointment)
    {
        try {
            if (in_array($appointment->status, ['cancelled', 'completed'])) {
                return back()->with('error', 'This appointment cannot be cancelled');
            }

            $appointment->update(['status' => 'cancelled']);

            // Send cancellation email
            $email = $appointment->appointment_type === 'Internal' 
                ? $appointment->user->email 
                : $appointment->email;

            Mail::to($email)->send(new AppointmentCancelled($appointment));

            return back()->with('success', 'Appointment has been cancelled successfully');
        } catch (\Exception $e) {
            return back()->with('error', 'An error occurred while cancelling the appointment');
        }
    }

    /**
     * Mark an appointment as completed
     * 
     * @param Appointment $appointment
     * @return \Illuminate\Http\RedirectResponse
     */
    public function complete(Appointment $appointment)
    {
        try {
            if ($appointment->status !== 'confirmed') {
                return back()->with('error', 'Only confirmed appointments can be marked as completed');
            }

            $appointment->update(['status' => 'completed']);
            return back()->with('success', 'Appointment has been marked as completed');
        } catch (\Exception $e) {
            return back()->with('error', 'An error occurred while completing the appointment');
        }
    }

    /**
     * Delete an appointment
     * 
     * @param Appointment $appointment
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Appointment $appointment)
    {
        try {
            if (!in_array($appointment->status, ['cancelled', 'completed'])) {
                return back()->with('error', 'Only cancelled or completed appointments can be deleted');
            }

            $appointment->delete();
            return back()->with('success', 'Appointment has been deleted successfully');
        } catch (\Exception $e) {
            return back()->with('error', 'An error occurred while deleting the appointment');
        }
    }

    /**
     * Update appointment details and send notification if schedule changes
     * 
     * @param Request $request
     * @param Appointment $appointment
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Appointment $appointment)
    {
        try {
            $validated = $request->validate([
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
            ]);

            $existingAppointment = Appointment::where('id', '!=', $appointment->id)
                ->where('date', $validated['date'])
                ->where('time', $validated['time'])
                ->first();

            if ($existingAppointment) {
                return back()->with('error', 'This time slot is already booked. Please select a different time.');
            }

            // Store old values
            $oldValues = [
                'date' => $appointment->date,
                'time' => $appointment->time
            ];

            // Update appointment
            $appointment->update($validated);

            // Create changes array only if date or time changed
            $changes = [];
            if ($oldValues['date'] != $validated['date']) {
                $changes['date'] = [
                    'old' => $oldValues['date'],
                    'new' => $validated['date']
                ];
            }
            if ($oldValues['time'] != $validated['time']) {
                $changes['time'] = [
                    'old' => $oldValues['time'],
                    'new' => $validated['time']
                ];
            }

            // Only send email if there are changes
            if (!empty($changes)) {
                $email = $appointment->appointment_type === 'Internal' 
                    ? $appointment->user->email 
                    : $appointment->email;

                Mail::to($email)->send(new AppointmentUpdated($appointment, [
                    'old' => $oldValues,
                    'new' => [
                        'date' => $validated['date'],
                        'time' => $validated['time']
                    ]
                ]));
            }

            return redirect('/admin/appointments')->with('success', 'Appointment updated successfully');

        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Get available time slots for a specific date
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAvailableTimes(Request $request)
    {
        try {
            $date = $request->get('date');
            $bookedTimes = Appointment::where('date', $date)
                ->pluck('time')
                ->map(function($time) {
                    return $time->format('H:i');
                })
                ->toArray();

            return response()->json([
                'success' => true,
                'bookedTimes' => $bookedTimes
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching available times'
            ], 500);
        }
    }
} 