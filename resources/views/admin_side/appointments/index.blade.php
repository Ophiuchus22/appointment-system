<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
</head>
<body class="bg-gray-100">
    @include('layouts.sidebar')
    <div class="container mx-auto px-4 py-8">
        <div class="bg-white shadow-md rounded-lg">
            <div class="flex justify-between items-center p-6 border-b">
                <h1 class="text-2xl font-bold text-gray-800">Appointments Management</h1>
                <a href="{{ route('admin.appointments.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
                    Create New Appointment
                </a>
            </div>

            <div class="p-6">
                <form action="{{ route('admin.appointments.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                        <div class="mt-1 flex space-x-2">
                            <button type="submit" name="status" value="pending" class="px-4 py-2 rounded-md {{ $filters['status'] == 'pending' ? 'bg-blue-500 text-white' : 'bg-gray-200 text-gray-700' }}">
                                Pending
                            </button>
                            <button type="submit" name="status" value="confirmed" class="px-4 py-2 rounded-md {{ $filters['status'] == 'confirmed' ? 'bg-blue-500 text-white' : 'bg-gray-200 text-gray-700' }}">
                                Confirmed
                            </button>
                            <button type="submit" name="status" value="completed" class="px-4 py-2 rounded-md {{ $filters['status'] == 'completed' ? 'bg-blue-500 text-white' : 'bg-gray-200 text-gray-700' }}">
                                Completed
                            </button>
                            <button type="submit" name="status" value="cancelled" class="px-4 py-2 rounded-md {{ $filters['status'] == 'cancelled' ? 'bg-blue-500 text-white' : 'bg-gray-200 text-gray-700' }}">
                                Cancelled
                            </button>
                        </div>
                    </div>
                    <div class="flex justify-end items-center space-x-2">
                        <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
                            Apply Filters
                        </button>
                        <a href="{{ route('admin.appointments.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                            Reset
                        </a>
                    </div>
                </form>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-100 border-b">
                        <tr>
                            <th class="p-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                            <th class="p-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                            <th class="p-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                            <th class="p-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Time</th>
                            <th class="p-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Purpose</th>
                            <th class="p-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="p-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($appointments as $appointment)
                            <tr>
                                <td class="p-3 whitespace-nowrap">{{ $appointment->id }}</td>
                                <td class="p-3 whitespace-nowrap">
                                    {{ $appointment->first_name }} {{ $appointment->last_name }}
                                </td>
                                <td class="p-3 whitespace-nowrap">{{ $appointment->formatted_date }}</td>
                                <td class="p-3 whitespace-nowrap">{{ $appointment->formatted_time }}</td>
                                <td class="p-3 whitespace-nowrap">{{ $appointment->purpose }}</td>
                                <td class="p-3 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        @if($appointment->status == 'pending') bg-yellow-100 text-yellow-800
                                        @elseif($appointment->status == 'confirmed') bg-green-100 text-green-800
                                        @elseif($appointment->status == 'completed') bg-blue-100 text-blue-800
                                        @elseif($appointment->status == 'cancelled') bg-red-100 text-red-800
                                        @endif">
                                        {{ ucfirst($appointment->status) }}
                                    </span>
                                </td>
                                <td class="p-3 whitespace-nowrap">
                                    <div class="flex space-x-2">
                                        <a href="{{ route('admin.appointments.edit', $appointment) }}" 
                                        class="text-blue-600 hover:text-blue-900">
                                            Edit
                                        </a>
                                        <form action="{{ route('admin.appointments.destroy', $appointment) }}" method="POST" 
                                              onsubmit="return confirm('Are you sure you want to delete this appointment?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="p-3 text-center text-gray-500">
                                    No appointments found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="p-6">
                {{ $appointments->appends(request()->input())->links() }}
            </div>
        </div>
    </div>
</body>
</html>