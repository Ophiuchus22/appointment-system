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