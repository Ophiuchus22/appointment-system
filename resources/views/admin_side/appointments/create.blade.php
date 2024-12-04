<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Appointment | Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto bg-white shadow-md rounded-lg p-6">
        <h1 class="text-3xl font-bold text-center text-gray-800 mb-6">Create New Appointment</h1>

        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <strong class="font-bold">Oops! There were some errors:</strong>
                <ul class="mt-2 list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.appointments.store') }}" method="POST" class="space-y-6">
            @csrf

            <div class="grid md:grid-cols-2 gap-4">
                <div>
                    <label for="first_name" class="block text-gray-700 font-medium mb-2">First Name</label>
                    <input type="text" 
                           name="first_name" 
                           id="first_name" 
                           value="{{ old('first_name') }}" 
                           required 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                           placeholder="Enter first name">
                </div>

                <div>
                    <label for="last_name" class="block text-gray-700 font-medium mb-2">Last Name</label>
                    <input type="text" 
                           name="last_name" 
                           id="last_name" 
                           value="{{ old('last_name') }}" 
                           required 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                           placeholder="Enter last name">
                </div>
            </div>

            <div class="grid md:grid-cols-2 gap-4">
                <div>
                    <label for="date" class="block text-gray-700 font-medium mb-2">Appointment Date</label>
                    <input type="date" 
                           name="date" 
                           id="date" 
                           value="{{ old('date') }}" 
                           required 
                           min="{{ now()->format('Y-m-d') }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <label for="time" class="block text-gray-700 font-medium mb-2">Appointment Time</label>
                    <input type="time" 
                           name="time" 
                           id="time" 
                           value="{{ old('time') }}" 
                           required 
                           min="09:00" 
                           max="17:00"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <small class="text-gray-600 text-sm mt-1">Available: 9 AM - 12 PM, 1 PM - 5 PM</small>
                </div>
            </div>

            <div>
                <label for="phone_number" class="block text-gray-700 font-medium mb-2">Phone Number (Optional)</label>
                <input type="tel" 
                       name="phone_number" 
                       id="phone_number" 
                       value="{{ old('phone_number') }}"
                       pattern="[0-9]{11}"
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                       placeholder="Enter 11-digit phone number">
            </div>

            <div>
                <label for="purpose" class="block text-gray-700 font-medium mb-2">Appointment Purpose</label>
                <select name="purpose" id="purpose" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="" disabled selected hidden>Select Purpose</option>
                    <option value="Academic Advising">Academic Advising</option>
                    <option value="Personal Concerns">Personal Concerns</option>
                    <option value="Event Planning">Event Planning</option>
                    <option value="Financial Aid">Financial Aid</option>
                    <option value="Graduation/Transcript Requests">Graduation/Transcript Requests</option>
                    <option value="Other">Other</option>
                </select>
            </div>

            <div>
                <label for="description" class="block text-gray-700 font-medium mb-2">Description</label>
                <textarea 
                    name="description" 
                    id="description" 
                    rows="4"
                    maxlength="1000"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Provide additional details (optional)">{{ old('description') }}</textarea>
                <small class="text-gray-600 text-sm">Maximum 1000 characters</small>
            </div>

            <div class="flex justify-between items-center">
                <button 
                    type="submit" 
                    class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded transition duration-300 ease-in-out"
                >
                    Schedule Appointment
                </button>
                <a 
                    href="{{ route('admin.appointments.index') }}" 
                    class="text-gray-600 hover:text-gray-800 font-medium"
                >
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const timeInput = document.getElementById('time');
    
    timeInput.addEventListener('change', function() {
        const selectedTime = this.value;
        const hour = parseInt(selectedTime.split(':')[0]);
        
        // Validate time is within allowed shifts
        const isMorningShift = (hour >= 9 && hour < 12);
        const isAfternoonShift = (hour >= 13 && hour < 17);
        
        if (!isMorningShift && !isAfternoonShift) {
            alert('Appointments are only available from 9 AM - 12 PM and 1 PM - 5 PM.');
            this.value = '';
        }
    });
});
</script>

</body>
</html>