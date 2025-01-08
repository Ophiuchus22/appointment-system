<!DOCTYPE html>
<html>
<head>
    <title>Generate Reports</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">
    @include('layouts.sidebar')
    
    <div class="ml-64 min-h-screen">
        <div class="py-6 px-8">
            <!-- Header Section -->
            <div class="mb-8">
                <h1 class="text-2xl font-bold text-gray-800">Report Generation</h1>
                <p class="text-gray-600 mt-1">Select the types of reports you want to generate</p>
            </div>

            <!-- Main Content -->
            <div class="max-w-3xl">
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8">
                    <form action="{{ route('admin.reports.generate') }}" method="POST">
                        @csrf
                        <div class="space-y-8">
                            <!-- Report Types Section -->
                            <div>
                                <h2 class="text-lg font-semibold text-gray-800 mb-4">Available Report Types</h2>
                                
                                <div class="space-y-4">
                                    <!-- Appointment Overview -->
                                    <div class="bg-gray-50 p-4 rounded-lg border border-gray-100 hover:border-blue-200 transition-colors">
                                        <label class="flex items-start space-x-3 cursor-pointer">
                                            <input type="checkbox" name="report_types[]" value="appointment_overview" 
                                                   class="mt-1 rounded text-blue-600 focus:ring-blue-500" checked>
                                            <div>
                                                <span class="block font-medium text-gray-800">Appointment Overview Report</span>
                                                <span class="text-sm text-gray-500">Status distribution, daily counts, and college breakdown</span>
                                            </div>
                                        </label>
                                    </div>

                                    <!-- User Activity -->
                                    <div class="bg-gray-50 p-4 rounded-lg border border-gray-100 hover:border-blue-200 transition-colors">
                                        <label class="flex items-start space-x-3 cursor-pointer">
                                            <input type="checkbox" name="report_types[]" value="user_activity" 
                                                   class="mt-1 rounded text-blue-600 focus:ring-blue-500" checked>
                                            <div>
                                                <span class="block font-medium text-gray-800">User Activity Report</span>
                                                <span class="text-sm text-gray-500">Most frequent users and appointment patterns</span>
                                            </div>
                                        </label>
                                    </div>

                                    <!-- Purpose Analysis -->
                                    <div class="bg-gray-50 p-4 rounded-lg border border-gray-100 hover:border-blue-200 transition-colors">
                                        <label class="flex items-start space-x-3 cursor-pointer">
                                            <input type="checkbox" name="report_types[]" value="purpose_analysis" 
                                                   class="mt-1 rounded text-blue-600 focus:ring-blue-500" checked>
                                            <div>
                                                <span class="block font-medium text-gray-800">Purpose Analysis</span>
                                                <span class="text-sm text-gray-500">Common appointment purposes and trends</span>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <!-- Date Range Selector -->
                            <div class="space-y-6">
                                <div>
                                    <h2 class="text-lg font-semibold text-gray-800 mb-4">Select Date Range</h2>
                                    
                                    <div class="relative">
                                        <select name="date_range" id="date_range" 
                                                class="block w-full rounded-lg border border-gray-200 bg-white py-3 px-4 pr-10 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 appearance-none">
                                            <option value="all">All Time</option>
                                            <option value="today">Today</option>
                                            <option value="week">This Week</option>
                                            <option value="month">This Month</option>
                                            <option value="year">This Year</option>
                                            <option value="custom">Custom Date Range</option>
                                        </select>
                                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3">
                                            <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                            </svg>
                                        </div>
                                    </div>
                                </div>

                                <!-- Custom Date Range Inputs -->
                                <div id="custom-range" class="space-y-4 hidden">
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <!-- Start Date -->
                                        <div class="space-y-2">
                                            <label for="start_date" class="block text-sm font-medium text-gray-700">Start Date</label>
                                            <div class="relative">
                                                <input type="date" name="start_date" id="start_date"
                                                       class="block w-full rounded-lg border border-gray-200 bg-white py-3 px-4 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                                            </div>
                                        </div>

                                        <!-- End Date -->
                                        <div class="space-y-2">
                                            <label for="end_date" class="block text-sm font-medium text-gray-700">End Date</label>
                                            <div class="relative">
                                                <input type="date" name="end_date" id="end_date"
                                                       class="block w-full rounded-lg border border-gray-200 bg-white py-3 px-4 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                const dateRange = document.getElementById('date_range');
                                const customRange = document.getElementById('custom-range');
                                
                                dateRange.addEventListener('change', function() {
                                    if (this.value === 'custom') {
                                        customRange.classList.remove('hidden');
                                        customRange.style.opacity = '0';
                                        setTimeout(() => {
                                            customRange.style.transition = 'opacity 0.3s ease-in-out';
                                            customRange.style.opacity = '1';
                                        }, 10);
                                    } else {
                                        customRange.style.opacity = '0';
                                        setTimeout(() => {
                                            customRange.classList.add('hidden');
                                        }, 300);
                                    }
                                });
                            });
                            </script>

                            <!-- Action Buttons -->
                            <div class="flex justify-end pt-4 border-t border-gray-100">
                                <button type="submit" 
                                        class="inline-flex items-center px-6 py-3 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                              d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                    Generate Report
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html> 