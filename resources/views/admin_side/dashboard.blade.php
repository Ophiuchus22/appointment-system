<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="icon" type="image/png" href="{{ asset('logo/system-logo.png') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
</head>
<body class="bg-gray-50">
    <div class="flex">
        @include('layouts.sidebar')
        
        <div class="flex-1 p-4">
            <h1 class="text-3xl font-bold mb-4 text-gray-800">Dashboard</h1>
            
            <div class="flex gap-2">
                <!-- Left Side - Calendar -->
                <div class="w-2/3">
                    <div class="bg-white rounded-xl shadow-lg">
                        <!-- Legend and View Switcher -->
                        <div class="p-3 border-b flex justify-between items-center">
                            <!-- Left side - Legend -->
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
                            
                            <!-- Right side - View Switcher -->
                            <div class="relative">
                                <select id="viewType" class="pl-3 pr-8 py-1.5 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 appearance-none bg-white">
                                    <option value="month">Month View</option>
                                    <option value="week">Week View</option>
                                </select>
                                <div class="absolute right-2 top-1/2 -translate-y-1/2 pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>
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
                            @include('admin_side.Extensions.dashboard_calendar_grid', ['calendar' => $calendar])
                        </div>
                    </div>
                </div>

                <!-- Right Side - Combined Stats and Activity -->
                <div class="w-1/3 space-y-4">
                    <!-- Appointments Overview - Compact Version -->
                    <div class="bg-white rounded-xl shadow-lg p-4">
                        <h2 class="text-lg font-semibold text-gray-800 mb-3">Appointments Overview</h2>
                        
                        <div class="grid gap-3">
                            <!-- Upcoming -->
                            <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-lg p-3 border border-blue-200">
                                <div class="flex items-center gap-3">
                                    <div class="bg-blue-500/10 p-2 rounded-lg">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="text-sm font-medium text-blue-900">Upcoming</h3>
                                        <div class="flex items-baseline">
                                            <span class="text-2xl font-bold text-blue-600">{{ $upcomingCount }}</span>
                                            <span class="ml-1 text-xs text-blue-600/70">appointments</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Pending -->
                            <div class="bg-gradient-to-br from-amber-50 to-amber-100 rounded-lg p-3 border border-amber-200">
                                <div class="flex items-center gap-3">
                                    <div class="bg-amber-500/10 p-2 rounded-lg">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="text-sm font-medium text-amber-900">Pending</h3>
                                        <div class="flex items-baseline">
                                            <span class="text-2xl font-bold text-amber-600">{{ $pendingCount }}</span>
                                            <span class="ml-1 text-xs text-amber-600/70">appointments</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Completed -->
                            <div class="bg-gradient-to-br from-emerald-50 to-emerald-100 rounded-lg p-3 border border-emerald-200">
                                <div class="flex items-center gap-3">
                                    <div class="bg-emerald-500/10 p-2 rounded-lg">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="text-sm font-medium text-emerald-900">Completed</h3>
                                        <div class="flex items-baseline">
                                            <span class="text-2xl font-bold text-emerald-600">{{ $completedCount }}</span>
                                            <span class="ml-1 text-xs text-emerald-600/70">appointments</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Activity - Compact Version -->
                    <div class="bg-white rounded-xl shadow-lg p-4">
                        <div class="flex justify-between items-center mb-3">
                            <h2 class="text-lg font-semibold text-gray-800">Activity Logs</h2>
                            <button 
                                onclick="openViewAllActivitiesModal()" 
                                class="text-sm text-blue-600 hover:text-blue-700 hover:underline focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 rounded"
                            >
                                View All
                            </button>
                        </div>
                        
                        <div class="space-y-3">
                            @forelse($recentActivities->take(3) as $activity)
                                <div class="flex items-start space-x-3 pb-3 border-b border-gray-100 last:border-0 last:pb-0">
                                    <div class="mt-1">
                                        <div class="p-1.5 bg-blue-50 rounded-lg">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-blue-500" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 011 1v3h3a1 1 0 110 2H6a1 1 0 01-1-1V8a1 1 0 011-1z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm text-gray-800">{{ $activity['action'] }}</p>
                                        @if(isset($activity['details']))
                                            <p class="text-xs text-gray-500 mt-0.5">{{ $activity['details'] }}</p>
                                        @endif
                                        <p class="text-xs text-gray-500 mt-0.5">{{ $activity['time'] }}</p>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-4 text-gray-500 text-sm">
                                    No recent activity
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        let currentDate = moment();
        let currentView = 'month';

        function updateCalendar() {
            const view = document.getElementById('viewType').value;
            let params;

            if (view === 'week') {
                params = `week=${currentDate.format('YYYY-MM-DD')}&view=${view}`;
            } else {
                params = `month=${currentDate.month() + 1}&year=${currentDate.year()}&view=${view}`;
            }

            fetch(`/admin/dashboard?${params}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.text())
            .then(html => {
                document.querySelector('.grid.grid-cols-7.bg-gray-100').innerHTML = html;
                updateHeaderText();
            })
            .catch(error => console.error('Error updating calendar:', error));
        }

        function updateHeaderText() {
            const view = document.getElementById('viewType').value;
            if (view === 'week') {
                const weekStart = currentDate.clone().startOf('week').format('MMM D');
                const weekEnd = currentDate.clone().endOf('week').format('MMM D, YYYY');
                document.getElementById('currentMonth').textContent = `${weekStart} - ${weekEnd}`;
            } else {
                document.getElementById('currentMonth').textContent = currentDate.format('MMMM YYYY');
            }
        }

        function changeMonth(direction) {
            const view = document.getElementById('viewType').value;
            if (view === 'week') {
                currentDate.add(direction, 'weeks');
            } else {
                currentDate.add(direction, 'months');
            }
            updateCalendar();
        }

        document.getElementById('viewType').addEventListener('change', function() {
            currentView = this.value;
            // Reset to current week/month when switching views
            currentDate = moment();
            updateCalendar();
        });

        document.addEventListener('DOMContentLoaded', () => {
            updateHeaderText();
            updateCalendar();
        });
    </script>

    <!-- Include the modal at the bottom of your dashboard file -->
    @include('admin_side.Modals.view_all_activities_modal')
</body>
</html>