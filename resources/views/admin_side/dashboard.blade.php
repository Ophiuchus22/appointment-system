<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <!-- Include Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
    <div class="flex">
        <!-- Include Sidebar -->
        @include('admin_side.sidebar')

        <!-- Main Content -->
        <div class="flex-1 p-8">
            <h1 class="text-3xl font-bold mb-6">Dashboard</h1>
            
            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="bg-blue-500 text-white p-6 rounded-lg shadow">
                    <h3 class="text-xl font-semibold mb-2">Total Users</h3>
                    <p class="text-3xl font-bold">1,234</p>
                </div>
                <div class="bg-green-500 text-white p-6 rounded-lg shadow">
                    <h3 class="text-xl font-semibold mb-2">Active Appointments</h3>
                    <p class="text-3xl font-bold">42</p>
                </div>
                <div class="bg-yellow-500 text-white p-6 rounded-lg shadow">
                    <h3 class="text-xl font-semibold mb-2">Pending Reports</h3>
                    <p class="text-3xl font-bold">7</p>
                </div>
                <div class="bg-purple-500 text-white p-6 rounded-lg shadow">
                    <h3 class="text-xl font-semibold mb-2">Total Revenue</h3>
                    <p class="text-3xl font-bold">$9,876</p>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-semibold mb-4">Recent Activity</h2>
                <div class="space-y-4">
                    <div class="border-b pb-4">
                        <p class="text-gray-600">New user registration: John Doe</p>
                        <p class="text-sm text-gray-400">2 hours ago</p>
                    </div>
                    <div class="border-b pb-4">
                        <p class="text-gray-600">Appointment scheduled: Dr. Smith with Patient #123</p>
                        <p class="text-sm text-gray-400">4 hours ago</p>
                    </div>
                    <div class="border-b pb-4">
                        <p class="text-gray-600">Report generated: Monthly Statistics</p>
                        <p class="text-sm text-gray-400">6 hours ago</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>