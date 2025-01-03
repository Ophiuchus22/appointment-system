<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAppointmentController extends Controller
{
    public function index(Request $request)
    {
        // Start with base query
        $query = Appointment::query();

        // Search by name if provided
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%");
            });
        }

        // Filter by status if provided
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by year if provided
        if ($request->filled('year')) {
            $query->whereYear('date', $request->year);
        }

        // Apply sorting
        if ($request->sort === 'oldest') {
            $query->oldest('date')->oldest('time');
        } else {
            $query->latest('date')->latest('time');
        }

        // Get paginated results
        $appointments = $query->paginate(10);

        // Preserve filter inputs for repopulating the form
        $filters = [
            'status' => $request->status,
            'search' => $request->search,
            'year' => $request->year,
            'sort' => $request->sort ?? 'latest'
        ];

        return view('admin_side.appointments.index', compact('appointments', 'filters'));
    }


    public function create()
    {
        return view('admin_side.appointments.create');
    }
    
    public function store(Request $request)
    {
        try {
            // Validate the request
            $validated = $request->validate([
                'first_name' => 'required|string',
                'last_name' => 'required|string',
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
            $appointment->first_name = $validated['first_name'];
            $appointment->last_name = $validated['last_name'];
            $appointment->phone_number = $validated['phone_number'] ?? null;
            $appointment->date = $validated['date'];
            $appointment->time = $validated['time'];
            $appointment->purpose = $validated['purpose'];
            $appointment->description = $validated['description'];
            $appointment->save();

            return redirect()->route('admin.appointments.index')
                ->with('success', 'Your appointment has been successfully scheduled!');

        } catch (Exception $e) {
            // Log the error for debugging
            logger()->error('Appointment creation failed: ' . $e->getMessage());

            // Handle validation errors
            if ($e instanceof \Illuminate\Validation\ValidationException) {
                $firstError = collect($e->validator->errors()->all())->first();
                return redirect()->route('admin.appointments.create')
                    ->withErrors($e->validator)
                    ->withInput()
                    ->with('error', $firstError);
            }

            // Handle other unexpected errors
            return redirect()->route('admin.appointments.create')
                ->with('error', 'Unable to schedule appointment. Please try again later.')
                ->withInput();
        }
    }

    public function update(Request $request, Appointment $appointment)
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
                'description' => 'required|string|max:1000',
                'status' => 'required|in:pending,approved,cancelled,completed'
            ], [
                'phone_number.regex' => 'Invalid phone number',
                'date.after_or_equal' => 'The appointment date must be today or a future date.',
                'time.date_format' => 'Please provide a valid time in 24-hour format (HH:MM).'
            ]);
            
            // Check for existing appointments on the same date and time
            // Skip this check if the time hasn't changed
            if ($appointment->date != $validated['date'] || $appointment->time != $validated['time']) {
                $existingAppointment = Appointment::where('date', $validated['date'])
                    ->where('time', $validated['time'])
                    ->where('id', '!=', $appointment->id)
                    ->first();

                if ($existingAppointment) {
                    return redirect()->route('admin.appointments.edit', $appointment->id)
                        ->with('error', 'This time slot is already booked. Please select a different time.')
                        ->withInput();
                }
            }

            // Update the appointment
            $appointment->phone_number = $validated['phone_number'] ?? null;
            $appointment->date = $validated['date'];
            $appointment->time = $validated['time'];
            $appointment->purpose = $validated['purpose'];
            $appointment->description = $validated['description'];
            $appointment->status = $validated['status'];
            $appointment->save();

            return redirect()->route('admin.appointments.index')
                ->with('success', 'Appointment updated successfully!');

        } catch (Exception $e) {
            // Log the error for debugging
            logger()->error('Appointment update failed: ' . $e->getMessage());

            // Handle validation errors
            if ($e instanceof \Illuminate\Validation\ValidationException) {
                $firstError = collect($e->validator->errors()->all())->first();
                return redirect()->route('admin.appointments.edit', $appointment->id)
                    ->withErrors($e->validator)
                    ->withInput()
                    ->with('error', $firstError);
            }

            // Handle other unexpected errors
            return redirect()->route('admin.appointments.edit', $appointment->id)
                ->with('error', 'Unable to update appointment. Please try again later.')
                ->withInput();
        }
    }

    public function edit(Appointment $appointment)
    {
        return view('admin_side.appointments.edit', compact('appointment'));
    }


    public function destroy(Appointment $appointment)
    {
        // Delete the appointment
        $appointment->delete();

        return redirect()->route('admin.appointments.index')->with('success', 'Appointment deleted successfully.');
    }
}
