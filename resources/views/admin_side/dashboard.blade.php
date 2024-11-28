<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
</head>
<body class="bg-gray-50">
    <div class="flex">
        @include('admin_side.sidebar')

        <div class="flex-1 p-4">
            <h1 class="text-3xl font-bold mb-6 text-gray-800">Dashboard</h1>
            
            <div class="flex gap-2">
                <!-- Left Side - Calendar -->
                <div class="w-2/3">
                    <div class="bg-white rounded-xl shadow-lg">
                        <!-- Legend -->
                        <div class="p-3 border-b">
                            <div class="flex flex-wrap gap-3 text-s">
                                <div class="flex items-center gap-2">
                                    <div class="w-3 h-3 rounded-sm bg-amber-50 border border-amber-200"></div>
                                    <span class="text-amber-700">Pending</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <div class="w-3 h-3 rounded-sm bg-emerald-50 border border-emerald-200"></div>
                                    <span class="text-emerald-700">Confirmed</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <div class="w-3 h-3 rounded-sm bg-blue-50 border border-blue-200"></div>
                                    <span class="text-blue-700">Completed</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <div class="w-3 h-3 rounded-sm bg-red-50 border border-red-200"></div>
                                    <span class="text-red-700">Cancelled</span>
                                </div>
                            </div>
                        </div>

                        <!-- Month Navigation -->
                        <div class="flex justify-between items-center p-4 border-b">
                            <button onclick="changeMonth(-1)" class="p-2 hover:bg-gray-100 rounded-lg transition-colors">
                                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                                </svg>
                            </button>
                            <h2 id="currentMonth" class="text-lg font-semibold text-gray-800"></h2>
                            <button onclick="changeMonth(1)" class="p-2 hover:bg-gray-100 rounded-lg transition-colors">
                                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </button>
                        </div>

                        <!-- Calendar Header -->
                        <div class="grid grid-cols-7 gap-px bg-gray-50 border-b">
                            @foreach(['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'] as $day)
                                <div class="text-center py-2 text-sm font-medium text-gray-600">{{ $day }}</div>
                            @endforeach
                        </div>
                        
                        <!-- Calendar Body -->
                        <div class="grid grid-cols-7 gap-px bg-gray-100">
                            @foreach($calendar as $day)
                                <div class="min-h-[90px] max-h-[120px] overflow-y-auto bg-white p-2 relative group hover:bg-gray-50 transition-colors">
                                    <div class="flex justify-between items-center mb-1">
                                        <span class="text-sm font-medium {{ $day['date']->isToday() ? 'text-blue-600' : 'text-gray-700' }} 
                                            {{ in_array($day['date']->dayOfWeek, [0, 6]) ? 'text-gray-400' : '' }}">
                                            {{ $day['date']->format('j') }}
                                        </span>
                                        @if($day['date']->isToday())
                                            <span class="text-xs px-1.5 py-0.5 rounded-full bg-blue-100 text-blue-800">Today</span>
                                        @endif
                                    </div>
                                    
                                    <div class="space-y-1">
                                        @foreach($day['appointments'] as $appointment)
                                            <div class="rounded-md p-1.5 text-xs transition-all hover:transform hover:scale-102
                                                {{ $appointment->status === 'pending' ? 'bg-amber-50 text-amber-700 border border-amber-200' : '' }}
                                                {{ $appointment->status === 'confirmed' ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : '' }}
                                                {{ $appointment->status === 'completed' ? 'bg-blue-50 text-blue-700 border border-blue-200' : '' }}
                                                {{ $appointment->status === 'cancelled' ? 'bg-red-50 text-red-700 border border-red-200' : '' }}">
                                                <div class="font-medium">{{ Carbon\Carbon::parse($appointment->time)->format('h:i A') }}</div>
                                                <div class="truncate text-xs">{{ $appointment->purpose }}</div>
                                                <div class="text-xs opacity-75 capitalize">{{ $appointment->status }}</div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Right Side - Appointment Summaries -->
                <div class="w-1/3 space-y-4">
                    <!-- Upcoming Appointments -->
                    <div class="bg-white rounded-xl shadow-lg p-4">
                        <h3 class="text-lg font-semibold text-gray-800 mb-3">Upcoming Appointments</h3>
                        <div class="space-y-2">
                            @php
                                $upcomingAppointments = $appointment->where('date', '>=', today())
                                    ->where('status', 'pending')
                                    ->take(3);
                            @endphp
                            
                            @forelse($upcomingAppointments as $appointment)
                                <div class="p-3 rounded-lg bg-amber-50 border border-amber-200">
                                    <div class="font-medium text-sm">{{ $appointment->purpose }}</div>
                                    <div class="text-sm text-gray-600">
                                        {{ Carbon\Carbon::parse($appointment->date)->format('M j') }} at 
                                        {{ Carbon\Carbon::parse($appointment->time)->format('g:i A') }}
                                    </div>
                                </div>
                            @empty
                                <p class="text-sm text-gray-500 text-center py-2">No upcoming appointments</p>
                            @endforelse
                        </div>
                    </div>

                    <!-- Pending Appointments -->
                    <div class="bg-white rounded-xl shadow-lg p-4">
                        <h3 class="text-lg font-semibold text-gray-800 mb-3">Pending Appointments</h3>
                        <div class="space-y-2">
                            @php
                                $pendingAppointments = $appointment->where('status', 'pending')
                                    ->take(3);
                            @endphp
                            
                            @forelse($pendingAppointments as $appointment)
                                <div class="p-3 rounded-lg bg-amber-50 border border-amber-200">
                                    <div class="font-medium text-sm">{{ $appointment->purpose }}</div>
                                    <div class="text-sm text-gray-600">
                                        {{ Carbon\Carbon::parse($appointment->date)->format('M j') }} at 
                                        {{ Carbon\Carbon::parse($appointment->time)->format('g:i A') }}
                                    </div>
                                </div>
                            @empty
                                <p class="text-sm text-gray-500 text-center py-2">No pending appointments</p>
                            @endforelse
                        </div>
                    </div>

                    <!-- Completed Appointments -->
                    <div class="bg-white rounded-xl shadow-lg p-4">
                        <h3 class="text-lg font-semibold text-gray-800 mb-3">Completed Appointments</h3>
                        <div class="space-y-2">
                            @php
                                $completedAppointments = $appointment->where('status', 'completed')
                                    ->take(3);
                            @endphp
                            
                            @forelse($completedAppointments as $appointment)
                                <div class="p-3 rounded-lg bg-blue-50 border border-blue-200">
                                    <div class="font-medium text-sm">{{ $appointment->purpose }}</div>
                                    <div class="text-sm text-gray-600">
                                        {{ Carbon\Carbon::parse($appointment->date)->format('M j') }} at 
                                        {{ Carbon\Carbon::parse($appointment->time)->format('g:i A') }}
                                    </div>
                                </div>
                            @empty
                                <p class="text-sm text-gray-500 text-center py-2">No completed appointments</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        let currentDate = moment();

        function updateCalendar() {
            const year = currentDate.year();
            const month = currentDate.month() + 1;

            fetch(`/admin/dashboard?month=${month}&year=${year}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.text())
            .then(html => {
                const parser = new DOMParser();
                const newContent = parser.parseFromString(html, 'text/html')
                    .querySelector('.bg-white.rounded-xl.shadow-lg');
                
                if (newContent) {
                    document.querySelector('.bg-white.rounded-xl.shadow-lg').outerHTML = newContent.outerHTML;
                }
                
                document.getElementById('currentMonth').textContent = currentDate.format('MMMM YYYY');
            })
            .catch(error => console.error('Error updating calendar:', error));
        }

        function changeMonth(direction) {
            currentDate.add(direction, 'month');
            updateCalendar();
        }

        document.addEventListener('DOMContentLoaded', () => {
            document.getElementById('currentMonth').textContent = currentDate.format('MMMM YYYY');
        });

        updateCalendar();
    </script>
</body>
</html>