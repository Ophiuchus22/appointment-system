<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointment Form</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css">
    <style>
        .tab-indicator {
            transition: transform 0.3s ease;
        }
    </style>
</head>
<body class="bg-gray-100">

<div class="flex justify-end p-4 pb-0"> 
    <form action="{{ route('logout') }}" method="POST" class="flex items-center">
        @csrf
        <button type="submit" class="text-gray-700 hover:text-red-600 focus:outline-none py-1 px-5 border border-gray-500 rounded-md transition-colors">
            <span class="text-l font-medium">Logout</span> 
        </button>
    </form>
</div>

<div id="toast" class="fixed right-0 top-4 transform translate-x-full transition-transform duration-300 ease-in-out z-50">
    <div class="bg-white rounded-lg shadow-lg p-4 max-w-sm w-full border-l-4 {{ session('success') ? 'border-green-500' : 'border-red-500' }}">
        <div class="flex items-center">
            @if(session('success'))
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-green-500" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-green-600">
                        {{ session('success') }}
                    </p>
                </div>
            @endif
            @if(session('error'))
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-red-500" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-red-600">
                        {{ session('error') }}
                    </p>
                </div>
            @endif
        </div>
    </div>
</div>

<div class="container py-6 mx-auto">
    <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded-lg shadow p-6">
            <!-- Tab Navigation -->
            <div class="relative mb-8">
                <!-- Updated tab navigation structure -->
                <div class="flex justify-center border-b">
                    <div class="relative flex space-x-0">
                        <button class="tab-btn text-xl font-medium px-4 py-2 text-blue-600" data-tab="details-section">
                            Details
                        </button>
                        <button class="tab-btn text-xl font-medium px-4 py-2 text-gray-400" data-tab="summary-section">
                            Summary
                        </button>
                        <!-- Indicator now positioned relative to the centered container -->
                        <div class="tab-indicator absolute bottom-0 w-16 h-0.5 bg-blue-600 opacity-100"></div>
                    </div>
                </div>
            </div>

            <form id="appointment-form" action="{{ route('client.appointments.store') }}" method="POST">
                @csrf
                <div class="section" id="details-section">
                    <div class="space-y-4">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">FIRST NAME</label>
                                <input type="text" name="first_name" class="w-full mt-1 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-blue-500" required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">LAST NAME</label>
                                <input type="text" name="last_name" class="w-full mt-1 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-blue-500" required>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">COLLEGE</label>
                            <select name="college" class="w-full mt-1 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-blue-500" required>
                                <option value="">Select College</option>
                                @foreach($colleges as $college)
                                    <option value="{{ $college }}">{{ $college }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">EMAIL</label>
                                <input type="email" name="email" class="w-full mt-1 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-blue-500" required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">PHONE NUMBER</label>
                                <input type="tel" name="phone_number" class="w-full mt-1 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-blue-500" required>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">DATE</label>
                                <input type="date" name="date" class="w-full mt-1 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-blue-500" required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">TIME</label>
                                <input type="time" name="time" class="w-full mt-1 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-blue-500" required>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">PURPOSE OF APPOINTMENT</label>
                            <textarea name="purpose" rows="3" class="w-full mt-1 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-blue-500" required></textarea>
                        </div>

                        <div class="space-y-2 mt-4 flex justify-end">
                            <button type="button" class="bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 transition-colors" onclick="showSection('summary-section')">
                                Next
                            </button>
                        </div>
                    </div>
                </div>

                <div class="section hidden" id="summary-section">
                    <div class="space-y-4">
                        <div>
                            <p class="text-sm text-gray-600">Name</p>
                            <p class="font-medium" id="summary-name"></p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">College</p>
                            <p class="font-medium" id="summary-college"></p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Email</p>
                            <p class="font-medium" id="summary-email"></p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Phone Number</p>
                            <p class="font-medium" id="summary-phone"></p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Date</p>
                            <p class="font-medium" id="summary-date"></p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Time</p>
                            <p class="font-medium" id="summary-time"></p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Purpose</p>
                            <p class="font-medium" id="summary-purpose"></p>
                        </div>

                        <div class="space-y-2 flex justify-between">
                            <button type="button" class="bg-gray-200 text-gray-700 py-2 px-4 rounded-md hover:bg-gray-300 transition-colors" onclick="showSection('details-section')">
                                Back
                            </button>
                            <button type="submit" class="bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 transition-colors">
                                Confirm Appointment
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const tabIndicator = document.querySelector('.tab-indicator');
    const tabButtons = document.querySelectorAll('.tab-btn');
    
    function updateTabIndicator(button) {
        const buttonLeft = button.offsetLeft;
        const buttonWidth = button.offsetWidth;
        tabIndicator.style.transform = `translateX(${buttonLeft}px)`;
        tabIndicator.style.width = `${buttonWidth}px`;
    }

    function showSection(sectionId) {
        // Update tab styles
        const targetButton = document.querySelector(`[data-tab="${sectionId}"]`);
        tabButtons.forEach(btn => {
            btn.classList.remove('text-blue-600');
            btn.classList.add('text-gray-600');
        });
        targetButton.classList.remove('text-gray-600');
        targetButton.classList.add('text-blue-600');
        updateTabIndicator(targetButton);

        // Show/hide sections
        document.querySelectorAll('.section').forEach(section => {
            section.classList.add('hidden');
        });
        document.getElementById(sectionId).classList.remove('hidden');

        // Update summary if showing summary section
        if (sectionId === 'summary-section') {
            const form = document.getElementById('appointment-form');
            document.getElementById('summary-name').textContent = 
                `${form.first_name.value} ${form.last_name.value}`;
            document.getElementById('summary-college').textContent = form.college.value;
            document.getElementById('summary-email').textContent = form.email.value;
            document.getElementById('summary-phone').textContent = form.phone_number.value;
            document.getElementById('summary-date').textContent = form.date.value;
            document.getElementById('summary-time').textContent = form.time.value;
            document.getElementById('summary-purpose').textContent = form.purpose.value;
        }
    }

    // Toast notification functionality
    function showToast() {
            const toast = document.getElementById('toast');
            if (toast && (toast.querySelector('.text-green-600') || toast.querySelector('.text-red-600'))) {
                // Show the toast
                setTimeout(() => {
                    toast.classList.remove('translate-x-full');
                    toast.classList.add('translate-x-0');
                }, 100);

                // Hide the toast after 5 seconds
                setTimeout(() => {
                    toast.classList.remove('translate-x-0');
                    toast.classList.add('translate-x-full');
                }, 5000);
            }
        }

    // Show toast if there's a message
    showToast();

    // Initialize tab indicator position
    updateTabIndicator(tabButtons[0]);

    // Add click handlers to tab buttons
    tabButtons.forEach(button => {
        button.addEventListener('click', () => {
            const targetSection = button.getAttribute('data-tab');
            showSection(targetSection);
        });
    });

    // Make showSection available globally
    window.showSection = showSection;
});
</script>
</body>
</html>