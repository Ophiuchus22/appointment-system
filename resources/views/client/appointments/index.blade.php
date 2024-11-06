@extends('layouts.app')

@section('content')
<div class="container py-6">
    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-semibold">My Appointments</h2>
                <a href="{{ route('client.appointments.create') }}" 
                   class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700">
                    New Appointment
                </a>
            </div>

            @if($appointments->isEmpty())
                <div class="text-center py-8">
                    <p class="text-gray-500">No appointments found.</p>
                    <p class="mt-2">
                        <a href="{{ route('client.appointments.create') }}" 
                           class="text-blue-600 hover:text-blue-800">
                            Schedule your first appointment
                        </a>
                    </p>
                </div>
            @else
                <div class="space-y-4">
                    @foreach($appointments as $appointment)
                        <div class="border rounded-lg p-4">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h3 class="font-medium">
                                        {{ $appointment->first_name }} {{ $appointment->last_name }}
                                    </h3>
                                    <p class="text-sm text-gray-500">
                                        {{ $appointment->date->format('F j, Y') }} at 
                                        {{ $appointment->time->format('g:i A') }}
                                    </p>
                                </div>
                                <a href="{{ route('client.appointments.details', $appointment->id) }}" 
                                   class="text-blue-600 hover:text-blue-800">
                                    View Details
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
@endsection