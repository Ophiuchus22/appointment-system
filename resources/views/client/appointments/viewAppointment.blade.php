<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Appointments</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css">
</head>
<body class="bg-gray-100">
    <!-- Dropdown Menu (same as in create.blade.php) -->
    <div class="relative p-4 pb-0">
        <div class="relative inline-block text-left">
            <button id="dropdownButton" class="flex items-center text-gray-700 hover:text-gray-900 focus:outline-none py-2 px-4 border border-gray-300 rounded-md transition-colors">
                <span class="mr-2">Menu</span>
                <svg class="w-4 h-4 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </button>

            <div id="dropdownMenu" class="hidden absolute left-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 transition-all duration-200 opacity-0 transform -translate-y-2">
                <div class="py-1">
                    <a href="{{ route('client.appointments.create') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors">
                        Create Appointment
                    </a>
                    <form action="{{ route('logout') }}" method="POST" class="block">
                        @csrf
                        <button type="submit" class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="container mx-auto py-6 px-4">
        <div class="max-w-6xl mx-auto">
            <h1 class="text-2xl font-bold text-gray-900 mb-6">My Appointments</h1>
            
            @if($appointments->isEmpty())
                <div class="bg-white rounded-lg shadow p-6 text-center">
                    <p class="text-gray-500">You don't have any appointments yet.</p>
                    <a href="{{ route('client.appointments.create') }}" class="inline-block mt-4 px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors">
                        Schedule an Appointment
                    </a>
                </div>
            @else
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date & Time</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Purpose</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Contact</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($appointments as $appointment)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">
                                            {{ \Carbon\Carbon::parse($appointment->date)->format('M d, Y') }}
                                        </div>
                                        <div class="text-sm text-gray-500">
                                            {{ \Carbon\Carbon::parse($appointment->time)->format('h:i A') }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-900">{{ $appointment->purpose }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-900 max-w-xs overflow-hidden overflow-ellipsis">
                                            {{ $appointment->description }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            @if($appointment->status === 'pending')
                                                bg-yellow-100 text-yellow-800
                                            @elseif($appointment->status === 'approved')
                                                bg-green-100 text-green-800
                                            @elseif($appointment->status === 'rejected')
                                                bg-red-100 text-red-800
                                            @elseif($appointment->status === 'completed')
                                                bg-blue-100 text-blue-800
                                            @endif
                                        ">
                                            {{ ucfirst($appointment->status ?? 'Pending') }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500">
                                        {{ $appointment->phone_number ?? 'Not provided' }}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <script>
        // Dropdown functionality (same as in create.blade.php)
        document.addEventListener('DOMContentLoaded', function() {
            const dropdownButton = document.getElementById('dropdownButton');
            const dropdownMenu = document.getElementById('dropdownMenu');
            const dropdownArrow = dropdownButton.querySelector('svg');

            dropdownButton.addEventListener('click', () => {
                const isHidden = dropdownMenu.classList.contains('hidden');
                
                if (isHidden) {
                    dropdownMenu.classList.remove('hidden');
                    setTimeout(() => {
                        dropdownMenu.classList.remove('opacity-0', '-translate-y-2');
                        dropdownArrow.classList.add('rotate-180');
                    }, 20);
                } else {
                    dropdownMenu.classList.add('opacity-0', '-translate-y-2');
                    dropdownArrow.classList.remove('rotate-180');
                    setTimeout(() => {
                        dropdownMenu.classList.add('hidden');
                    }, 200);
                }
            });

            document.addEventListener('click', (e) => {
                if (!dropdownButton.contains(e.target) && !dropdownMenu.contains(e.target)) {
                    dropdownMenu.classList.add('opacity-0', '-translate-y-2');
                    dropdownArrow.classList.remove('rotate-180');
                    setTimeout(() => {
                        dropdownMenu.classList.add('hidden');
                    }, 200);
                }
            });
        });
    </script>
</body>
</html>