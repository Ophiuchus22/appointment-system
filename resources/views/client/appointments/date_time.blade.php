@extends('layouts.app')

@section('content')
<div class="container py-6">
    <div class="max-w-4xl mx-auto">
        <!-- Similar layout structure as create.blade.php -->
        <div class="flex">
            <div class="w-1/4 pr-6">
                <!-- Sidebar with Date & Time highlighted -->
            </div>
            <div class="w-3/4">
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-2xl font-semibold mb-6">Select Date & Time</h2>
                    <form action="{{ route('client.appointments.update-datetime', $appointment->id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <div class="grid grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">DATE</label>
                                <input type="date" name="date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">TIME</label>
                                <input type="time" name="time" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                            </div>
                        </div>
                        <div class="mt-6 flex justify-end">
                            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700">
                                Next
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection