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
            <!-- Header with title and new appointment button -->
            <div class="flex justify-between items-center p-6 border-b">
                <h1 class="text-2xl font-bold text-gray-800">Appointments Management</h1>
                
                <div class="relative">
                    <button id="newAppointmentBtn" 
                            class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded inline-flex items-center">
                        New Appointment
                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div id="newAppointmentDropdown" 
                         class="hidden absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg z-50">
                        <a href="{{route('admin.clients.create')}}" 
                           class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            Add New Client
                        </a>
                        <a href="{{ route('admin.appointments.create') }}" 
                           class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            Add Appointment
                        </a>
                    </div>
                </div>
            </div>

            <!-- Filters section -->
            <div class="p-6">
                <form action="{{ route('admin.appointments.index') }}" method="GET">
                    <div class="flex flex-wrap items-end gap-4">
                        <!-- Search Name -->
                        <div class="flex-1 min-w-[200px]">
                            <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Search Name</label>
                            <input type="text" 
                                   name="search" 
                                   id="search" 
                                   placeholder="Search by name..."
                                   value="{{ request('search') }}"
                                   class="w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        </div>

                        <!-- Status -->
                        <div class="flex-1 min-w-[150px]">
                            <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                            <select name="status" id="status" 
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                <option value="">All Status</option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                                <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                        </div>

                        <!-- Year -->
                        <div class="flex-1 min-w-[150px]">
                            <label for="year" class="block text-sm font-medium text-gray-700 mb-1">Year</label>
                            <select name="year" id="year" 
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                <option value="">All Years</option>
                                @for ($i = date('Y'); $i >= date('Y') - 5; $i--)
                                    <option value="{{ $i }}" {{ request('year') == $i ? 'selected' : '' }}>{{ $i }}</option>
                                @endfor
                            </select>
                        </div>

                        <!-- Sort -->
                        <div class="flex-1 min-w-[150px]">
                            <label for="sort" class="block text-sm font-medium text-gray-700 mb-1">Sort By</label>
                            <select name="sort" id="sort" 
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                <option value="latest" {{ request('sort', 'latest') == 'latest' ? 'selected' : '' }}>Latest First</option>
                                <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Oldest First</option>
                            </select>
                        </div>

                        <!-- Buttons -->
                        <div class="flex gap-2">
                            <button type="reset" 
                                    onclick="window.location='{{ route('admin.appointments.index') }}'"
                                    class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-md text-sm font-medium transition-colors">
                                Reset
                            </button>
                            <button type="submit" 
                                    class="px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-md text-sm font-medium transition-colors">
                                Apply Filters
                            </button>
                        </div>
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


    <script>
        // Toggle dropdown menu
        const newAppointmentBtn = document.getElementById('newAppointmentBtn');
        const newAppointmentDropdown = document.getElementById('newAppointmentDropdown');

        newAppointmentBtn.addEventListener('click', () => {
            newAppointmentDropdown.classList.toggle('hidden');
        });

        // Close dropdown when clicking outside
        document.addEventListener('click', (e) => {
            if (!newAppointmentBtn.contains(e.target)) {
                newAppointmentDropdown.classList.add('hidden');
            }
        });
    </script>

    
</body>
</html>