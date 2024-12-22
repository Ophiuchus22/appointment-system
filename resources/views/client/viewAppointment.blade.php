<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Appointments</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css">
</head>
<body class="bg-gray-100">
    <!-- Top Navigation Bar -->
    <div class="w-full bg-white border-b border-gray-100 px-4 py-3">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <!-- Left side - Logo or Title -->
            <div>
                <h1 class="text-xl font-semibold text-gray-800">My Appointments</h1>
            </div>

            <!-- Right side - Dropdown Menu -->
            <div class="relative">
                <button id="dropdownButton" class="flex items-center gap-2 bg-white px-4 py-2.5 rounded-lg border border-gray-200 hover:border-gray-300 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-100 active:bg-gray-100 transition-all duration-200 group">
                    <!-- User Avatar/Icon -->
                    <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center">
                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    
                    <span class="font-medium text-gray-700 group-hover:text-gray-900">Account</span>
                    <svg class="w-4 h-4 text-gray-500 group-hover:text-gray-700 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>

                <!-- Dropdown Content -->
                <div id="dropdownMenu" class="hidden absolute right-0 mt-2 w-56 rounded-xl shadow-lg bg-white ring-1 ring-black ring-opacity-5 border border-gray-100 transition-all duration-200 opacity-0 transform -translate-y-2 z-50">
                    <!-- User Info Section -->
                    <div class="px-4 py-3 border-b border-gray-100">
                        <p class="text-sm font-medium text-gray-900">{{ Auth::user()->name ?? 'Guest' }}</p>
                        <p class="text-sm text-gray-500 truncate">{{ Auth::user()->email ?? '' }}</p>
                    </div>
                    
                    <div class="py-1">
                        <!-- Create Appointment -->
                        <a href="{{ route('client.appointments.create') }}" 
                           class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                            Create Appointment
                        </a>
                        
                        <!-- Logout -->
                        <form action="{{ route('logout') }}" method="POST" class="block">
                            @csrf
                            <button type="submit" 
                                    class="flex items-center gap-3 w-full px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                </svg>
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- College Logo -->
    <div class="fixed bottom-4 right-4 opacity-50">
        @php
            $college = Auth::user()->college ?? 'default';
            $logos = [
                'COLLEGE OF TEACHER EDUCATION' => 'cte.png',
                'COLLEGE OF CRIMINAL JUSTICE' => 'ccj.png',
                'COLLEGE OF BUSINESS EDUCATION' => 'cbe.png',
                'COLLEGE OF ARTS AND SCIENCES' => 'cas.png',
            ];
            $logoFile = $logos[$college] ?? 'default.png';
            $logoPath = public_path('logo/' . $logoFile);
        @endphp
        
        @if(file_exists($logoPath))
            <img src="{{ asset('logo/' . $logoFile) }}" alt="College Logo" class="w-32 h-32">
        @endif
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
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
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
                                    <td class="px-6 py-4">
                                        <div class="flex space-x-2">
                                            @if($appointment->status === 'pending')
                                                <button type="button"
                                                        onclick='openEditModal(@json($appointment))'
                                                        class="text-blue-600 hover:text-blue-800 font-medium">
                                                    Edit
                                                </button>
                                            @endif
                                            
                                            @if(in_array($appointment->status, ['pending', 'approved']))
                                                <form action="{{ route('client.appointments.cancel', $appointment) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="text-yellow-600 hover:text-yellow-800" 
                                                            onclick="return confirm('Are you sure you want to cancel this appointment?')">
                                                        Cancel
                                                    </button>
                                                </form>
                                            @endif
                                            
                                            @if(in_array($appointment->status, ['cancelled', 'rejected']))
                                                <form action="{{ route('client.appointments.destroy', $appointment) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-800"
                                                            onclick="return confirm('Are you sure you want to delete this appointment? This action cannot be undone.')">
                                                        Delete
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
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

    @include('client.Modals.editModal')
</body>
</html>