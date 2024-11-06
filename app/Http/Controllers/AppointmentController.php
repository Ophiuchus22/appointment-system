<?php
// app/Http/Controllers/AppointmentController.php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    public function index()
    {
        return redirect()->route('client.appointments.create');
    }

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
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'college' => 'required|string',
            'email' => 'required|email|max:255',
            'phone_number' => 'required|string|max:20',
            'purpose' => 'required|string',
            'date' => 'required|date|after_or_equal:today',
            'time' => 'required|date_format:H:i',
        ]);

        $appointment = new Appointment($request->all());
        $appointment->user_id = Auth::id();
        $appointment->save();

        return redirect()->route('client.appointments.summary', $appointment->id)
            ->with('success', 'Appointment created successfully.');
    }

    public function summary($id)
    {
        $appointment = Appointment::where('user_id', Auth::id())
            ->findOrFail($id);
        return view('client.appointments.summary', compact('appointment'));
    }

    public function showDetails($id)
    {
        $appointment = Appointment::where('user_id', Auth::id())
            ->findOrFail($id);
        return view('client.appointments.details', compact('appointment'));
    }
}
