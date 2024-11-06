@extends('layouts.app')

@section('content')
<div class="container py-6">
    <div class="max-w-4xl mx-auto">
        <div class="flex">
            <div class="w-1/4 pr-6">
                <!-- Sidebar with Summary highlighted -->
            </div>
            <div class="w-3/4">
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-2xl font-semibold mb-6">Appointment Summary</h2>
                    <div class="space-y-4">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm text-gray-500">Name</p>
                                <p class="font-medium">{{ $appointment->first_name }} {{ $appointment->last_name }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">College</p>
                                <p class="font-medium">{{ $appointment->college }}</p>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm text-gray-500">Email</p>
                                <p class="font-medium">{{ $appointment->email }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Phone Number</p>
                                <p class="font-medium">{{ $appointment->phone_number }}</p>
                            </div>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Purpose of Appointment</p>
                            <p class="font-medium">{{ $appointment->purpose }}</p>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm text-gray-500">Date</p>
                                <p class="font-medium">{{ $appointment->date->format('F j, Y') }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Time</p>
                                <p class="font-medium">{{ $appointment->time->format('g:i A') }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="mt-6 flex justify-end space-x-4">
                        <a href="{{ route('client.appointments.edit', $appointment->id) }}" class="bg-gray-100 text-gray-700 px-6 py-2 rounded-md hover:bg-gray-200">
                            Edit
                        </a>
                        <form action="{{ route('client.appointments.confirm', $appointment->id) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700">
                                Confirm Appointment
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection