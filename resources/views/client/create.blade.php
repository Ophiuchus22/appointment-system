<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointment Form</title>
    <link rel="icon" type="image/png" href="{{ asset('logo/system-logo.png') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/shepherd.js@10.0.1/dist/css/shepherd.css"/>
    <style>
        .tab-indicator {
            transition: transform 0.3s ease;
        }
        /* Custom styles for the select element */
        select option:disabled {
            color: #9CA3AF;
            background-color: #F3F4F6;
        }

        select optgroup {
            font-weight: 600;
            color: #374151;
            background-color: #F9FAFB;
            padding: 8px 0;
        }

        select option {
            padding: 8px 12px;
            transition: background-color 0.2s;
        }

        select option:not(:disabled):hover {
            background-color: #EFF6FF;
        }

        /* Loading state styles */
        .animate-spin {
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            from {
                transform: rotate(0deg);
            }
            to {
                transform: rotate(360deg);
            }
        }
    </style>
</head>
<body class="bg-gray-100">

<!-- Top Navigation Bar -->
<div class="w-full bg-white border-b border-gray-100 px-4 py-3">
    <div class="max-w-7xl mx-auto flex justify-between items-center">
        <!-- Left side - Logo or Title -->
        <div class="flex items-center gap-2">
            <img src="{{ asset('logo/system-logo-client.png') }}" alt="AppointEase Logo" class="h-10 w-10">
            <h1 class="text-2xl font-bold tracking-tight">
                <span class="bg-gradient-to-r from-blue-500 via-blue-600 to-indigo-600 bg-clip-text text-transparent drop-shadow-sm">Appoint</span><span class="text-gray-800">Ease</span>
            </h1>
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
                    <!-- View Appointments -->
                    <a href="{{ route('client.appointments.viewAppointment') }}" 
                       class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                        <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        View Appointments
                    </a>

                    <!-- Generate Report -->
                    <a href="{{ route('client.report.generate') }}" 
                       class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                        <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        Generate Report
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

<div class="container py-5 mx-auto">
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
                    <div class="space-y-6">
                        <!-- Phone Number - Single Column -->
                        <div class="max-w-md" id="contact-section">
                            <label class="block text-sm font-medium text-gray-600">Phone Number</label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <input type="tel" 
                                    name="phone_number" 
                                    placeholder="(Optional)"
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200">
                            </div>
                        </div>

                        <!-- Date and Time - Two Columns -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6" id="datetime-section">
                            <div>
                                <label for="date" class="block text-sm font-medium text-gray-600">Date</label>
                                <div class="mt-1 relative rounded-md shadow-sm">
                                    <input type="date" 
                                        name="date" 
                                        id="date" 
                                        required
                                        min="{{ date('Y-m-d') }}"
                                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200">
                                </div>
                            </div>
                            <div>
                                <label for="time" class="block text-sm font-medium text-gray-600">Time</label>
                                <div class="mt-1 relative">
                                    <select name="time" 
                                            id="time"
                                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 bg-white appearance-none cursor-pointer disabled:bg-gray-50 disabled:text-gray-500" 
                                            required>
                                        <option value="">Select available time</option>
                                        <optgroup label="Morning (9 AM - 12 PM)" class="text-gray-900 font-medium">
                                            <option value="09:00">9:00 AM</option>
                                            <option value="09:30">9:30 AM</option>
                                            <option value="10:00">10:00 AM</option>
                                            <option value="10:30">10:30 AM</option>
                                            <option value="11:00">11:00 AM</option>
                                            <option value="11:30">11:30 AM</option>
                                        </optgroup>
                                        <optgroup label="Afternoon (1 PM - 5 PM)" class="text-gray-900 font-medium">
                                            <option value="13:00">1:00 PM</option>
                                            <option value="13:30">1:30 PM</option>
                                            <option value="14:00">2:00 PM</option>
                                            <option value="14:30">2:30 PM</option>
                                            <option value="15:00">3:00 PM</option>
                                            <option value="15:30">3:30 PM</option>
                                            <option value="16:00">4:00 PM</option>
                                            <option value="16:30">4:30 PM</option>
                                            <option value="17:00">5:00 PM</option>
                                        </optgroup>
                                    </select>
                                    <!-- Custom Select Arrow -->
                                    <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </div>
                                <!-- Loading State Indicator -->
                                <div id="timeLoadingIndicator" class="hidden mt-2">
                                    <div class="flex items-center space-x-2">
                                        <div class="animate-spin rounded-full h-4 w-4 border-b-2 border-blue-500"></div>
                                        <span class="text-sm text-gray-500">Loading available times...</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Purpose - Single Column -->
                        <div id="purpose-section">
                            <label class="block text-sm font-medium text-gray-600">Purpose</label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <select name="purpose" 
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 bg-white" 
                                    required>
                                    <option value="">Select purpose</option>
                                    <option value="Academic Advising">Academic Advising</option>
                                    <option value="Personal Concerns">Personal Concerns</option>
                                    <option value="Event Planning">Event Planning</option>
                                    <option value="Financial Aid">Financial Aid</option>
                                    <option value="Graduation/Transcript Requests">Documents Request</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                        </div>

                        <!-- Description - Single Column -->
                        <div>
                            <label class="block text-sm font-medium text-gray-600">Description</label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <textarea name="description" 
                                    rows="3" 
                                    placeholder="Please provide details about your appointment..."
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 resize-none" 
                                    required></textarea>
                            </div>
                        </div>

                        <!-- Next Button -->
                        <div class="flex justify-end pt-4">
                            <button type="button" 
                                class="bg-blue-600 text-white px-6 py-2.5 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all duration-200 font-medium" 
                                onclick="showSection('summary-section')">
                                Next
                            </button>
                        </div>
                    </div>
                </div>

                <div class="section hidden" id="summary-section">
                    <div class="space-y-6">
                        <!-- Summary Card -->
                        <div class="bg-gray-50 rounded-lg p-4 sm:p-6 space-y-4 border border-gray-100">
                            <!-- Phone Number -->
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-2 sm:gap-4 items-baseline">
                                <p class="text-sm font-medium text-gray-500">Phone Number</p>
                                <p class="sm:col-span-2 text-base text-gray-900" id="summary-phone">
                                    <span class="text-gray-400 italic text-sm">Not provided</span>
                                </p>
                            </div>

                            <!-- Date & Time -->
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-2 sm:gap-4 items-baseline">
                                <p class="text-sm font-medium text-gray-500">Schedule</p>
                                <div class="sm:col-span-2 flex flex-wrap gap-2 text-base text-gray-900">
                                    <span id="summary-date"></span>
                                    <span class="text-gray-400 hidden sm:inline">|</span>
                                    <span id="summary-time"></span>
                                </div>
                            </div>

                            <!-- Purpose -->
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-2 sm:gap-4 items-baseline">
                                <p class="text-sm font-medium text-gray-500">Purpose</p>
                                <p class="sm:col-span-2 text-base text-gray-900" id="summary-purpose"></p>
                            </div>

                            <!-- Description -->
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-2 sm:gap-4 items-baseline">
                                <p class="text-sm font-medium text-gray-500">Description</p>
                                <p class="sm:col-span-2 text-base text-gray-900 whitespace-pre-line" id="summary-description"></p>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex flex-col sm:flex-row gap-3 sm:gap-0 sm:justify-between items-stretch sm:items-center pt-4">
                            <button type="button" 
                                class="order-2 sm:order-1 w-full sm:w-auto px-6 py-2.5 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-200 focus:ring-offset-2 transition-all duration-200 font-medium" 
                                onclick="showSection('details-section')">
                                Back to Details
                            </button>
                            <button type="submit" 
                                class="order-1 sm:order-2 w-full sm:w-auto bg-blue-600 text-white px-6 py-2.5 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all duration-200 font-medium">
                                Confirm Appointment
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<button id="startTour" 
    class="fixed bottom-6 right-6 group inline-flex items-center px-5 py-3 text-sm font-medium 
    bg-gradient-to-r from-blue-50 via-indigo-50 to-purple-50 
    text-blue-600 
    border border-blue-100/80 
    rounded-xl
    hover:from-blue-100 hover:via-indigo-100 hover:to-purple-100
    hover:border-blue-200 
    hover:shadow-lg hover:shadow-blue-500/10
    focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 
    transform hover:-translate-y-0.5 active:translate-y-0
    transition-all duration-200 
    backdrop-blur-sm 
    z-50">
    <!-- Gradient overlay for hover effect -->
    <span class="absolute inset-0 bg-gradient-to-r from-blue-500/0 via-indigo-500/0 to-purple-500/0 
        group-hover:from-blue-500/5 group-hover:via-indigo-500/5 group-hover:to-purple-500/5 
        rounded-xl transition-all duration-200">
    </span>
    
    <!-- Light effect -->
    <span class="absolute inset-0 rounded-xl bg-gradient-to-tr from-white/20 via-white/0 to-white/0"></span>
    
    <!-- Glow effect -->
    <span class="absolute inset-0 rounded-xl ring-1 ring-inset ring-black/5"></span>
    
    <!-- Icon with enhanced styling -->
    <svg class="w-5 h-5 mr-2.5 text-blue-500 group-hover:text-blue-600 transition-colors duration-200 
        filter drop-shadow-sm" 
        fill="none" 
        stroke="currentColor" 
        viewBox="0 0 24 24">
        <path stroke-linecap="round" 
            stroke-linejoin="round" 
            stroke-width="2" 
            d="M9.663 17h4.673M12 3c-3.75 0-6.75 2.25-6.75 6.75 0 1.875.75 3.375 1.875 4.5L8.25 21h7.5l1.125-6.75c1.125-1.125 1.875-2.625 1.875-4.5C18.75 5.25 15.75 3 12 3z"/>
    </svg>
    
    <!-- Text with enhanced styling -->
    <span class="relative font-semibold tracking-wide">Help Guide</span>
    
    <!-- Enhanced notification dot -->
    <span class="absolute -top-1.5 -right-1.5 h-3.5 w-3.5 
        bg-gradient-to-r from-blue-500 to-indigo-500 
        rounded-full ring-2 ring-white 
        animate-pulse 
        shadow-lg shadow-blue-500/50" 
        id="helpNotificationDot">
        <!-- Inner glow -->
        <span class="absolute inset-0 rounded-full bg-white/40"></span>
    </span>
</button>

<script src="https://cdn.jsdelivr.net/npm/shepherd.js@10.0.1/dist/js/shepherd.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const tabIndicator = document.querySelector('.tab-indicator');
    const tabButtons = document.querySelectorAll('.tab-btn');
    // Dropdown functionality
    const dropdownButton = document.getElementById('dropdownButton');
    const dropdownMenu = document.getElementById('dropdownMenu');
    const dropdownArrow = dropdownButton.querySelector('svg');

    dropdownButton.addEventListener('click', () => {
        const isHidden = dropdownMenu.classList.contains('hidden');
        
        if (isHidden) {
            // Show menu
            dropdownMenu.classList.remove('hidden');
            setTimeout(() => {
                dropdownMenu.classList.remove('opacity-0', '-translate-y-2');
                dropdownArrow.classList.add('rotate-180');
            }, 20);
        } else {
            // Hide menu
            dropdownMenu.classList.add('opacity-0', '-translate-y-2');
            dropdownArrow.classList.remove('rotate-180');
            setTimeout(() => {
                dropdownMenu.classList.add('hidden');
            }, 200);
        }
    });

    // Close dropdown when clicking outside
    document.addEventListener('click', (e) => {
        if (!dropdownButton.contains(e.target) && !dropdownMenu.contains(e.target)) {
            dropdownMenu.classList.add('opacity-0', '-translate-y-2');
            dropdownArrow.classList.remove('rotate-180');
            setTimeout(() => {
                dropdownMenu.classList.add('hidden');
            }, 200);
        }
    });
    
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
            document.getElementById('summary-phone').textContent = form.phone_number.value;
            document.getElementById('summary-date').textContent = form.date.value;
            document.getElementById('summary-time').textContent = form.time.value;
            document.getElementById('summary-purpose').textContent = form.purpose.value;
            document.getElementById('summary-description').textContent = form.description.value;
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

document.addEventListener('DOMContentLoaded', function() {
    const dateInput = document.getElementById('date');
    const timeSelect = document.getElementById('time');
    const loadingIndicator = document.getElementById('timeLoadingIndicator');

    if (!dateInput || !timeSelect) return;

    dateInput.addEventListener('change', function() {
        const date = this.value;
        
        if (date) {
            timeSelect.disabled = true;
            loadingIndicator.classList.remove('hidden');
            
            const url = '{{ route("client.appointments.available-times") }}?date=' + date + '&exclude_completed=true';

            fetch(url, {
                method: 'GET',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
                credentials: 'same-origin'
            })
            .then(response => {
                if (!response.ok) throw new Error('Network response was not ok');
                return response.json();
            })
            .then(data => {
                timeSelect.innerHTML = '<option value="">Select available time</option>';
                
                const morningGroup = document.createElement('optgroup');
                morningGroup.label = 'Morning (9 AM - 11:30 AM)';
                morningGroup.className = 'text-gray-900 font-medium';
                
                const afternoonGroup = document.createElement('optgroup');
                afternoonGroup.label = 'Afternoon (1 PM - 5 PM)';
                afternoonGroup.className = 'text-gray-900 font-medium';

                const now = new Date();
                const selectedDate = new Date(date);

                const createTimeOption = (slot, isBooked) => {
                    const option = document.createElement('option');
                    option.value = slot.value;
                    option.textContent = slot.label;
                    
                    // Check if the selected datetime is in the past
                    const [hours, minutes] = slot.value.split(':');
                    const slotDateTime = new Date(selectedDate);
                    slotDateTime.setHours(parseInt(hours), parseInt(minutes), 0);
                    const isPastTime = slotDateTime <= now;
                    
                    option.disabled = isBooked || isPastTime;
                    option.className = (isBooked || isPastTime) ? 'text-gray-400' : 'text-gray-900';
                    
                    // Add a title attribute to show why the slot is disabled
                    if (isPastTime) {
                        option.title = "This time slot has already passed";
                    } else if (isBooked) {
                        option.title = "This time slot is already booked";
                    }
                    
                    return option;
                };

                const morningSlots = [
                    { value: '09:00', label: '9:00 AM' },
                    { value: '09:30', label: '9:30 AM' },
                    { value: '10:00', label: '10:00 AM' },
                    { value: '10:30', label: '10:30 AM' },
                    { value: '11:00', label: '11:00 AM' },
                    { value: '11:30', label: '11:30 AM' }
                ];

                const afternoonSlots = [
                    { value: '13:00', label: '1:00 PM' },
                    { value: '13:30', label: '1:30 PM' },
                    { value: '14:00', label: '2:00 PM' },
                    { value: '14:30', label: '2:30 PM' },
                    { value: '15:00', label: '3:00 PM' },
                    { value: '15:30', label: '3:30 PM' },
                    { value: '16:00', label: '4:00 PM' },
                    { value: '16:30', label: '4:30 PM' },
                    { value: '17:00', label: '5:00 PM' }
                ];

                morningSlots.forEach(slot => {
                    morningGroup.appendChild(
                        createTimeOption(slot, data.bookedTimes.includes(slot.value))
                    );
                });

                afternoonSlots.forEach(slot => {
                    afternoonGroup.appendChild(
                        createTimeOption(slot, data.bookedTimes.includes(slot.value))
                    );
                });

                timeSelect.appendChild(morningGroup);
                timeSelect.appendChild(afternoonGroup);
            })
            .catch(() => {
                timeSelect.innerHTML = '<option value="">Error loading times</option>';
            })
            .finally(() => {
                timeSelect.disabled = false;
                loadingIndicator.classList.add('hidden');
            });
        }
    });

    // Set minimum date to today
    const today = new Date();
    const dd = String(today.getDate()).padStart(2, '0');
    const mm = String(today.getMonth() + 1).padStart(2, '0');
    const yyyy = today.getFullYear();

    const todayString = yyyy + '-' + mm + '-' + dd;
    dateInput.setAttribute('min', todayString);

    // Trigger change event if date is already selected
    if (dateInput.value) {
        dateInput.dispatchEvent(new Event('change'));
    }
});

document.addEventListener('DOMContentLoaded', function() {
    const tour = new Shepherd.Tour({
        useModalOverlay: true,
        defaultStepOptions: {
            classes: 'shadow-xl bg-white rounded-xl border border-gray-100',
            scrollTo: { behavior: 'smooth', block: 'center' },
            cancelIcon: {
                enabled: true
            }
        }
    });

    // Welcome step
    tour.addStep({
        id: 'welcome',
        text: `
            <div class="text-gray-800">
                <h3 class="text-xl font-semibold mb-3 text-blue-600">Welcome to Appointment Creation! 👋</h3>
                <p class="mb-4">This guide will help you understand how to schedule your appointment properly.</p>
                <div class="bg-blue-50 p-4 rounded-lg">
                    <p class="text-sm text-blue-600">💡 Tip: Follow each step carefully to ensure your appointment is scheduled successfully.</p>
                </div>
            </div>
        `,
        buttons: [
            {
                text: 'Skip Tour',
                action: tour.complete,
                classes: 'shepherd-button-secondary'
            },
            {
                text: 'Start Tour',
                action: tour.next,
                classes: 'shepherd-button-primary'
            }
        ]
    });

    // Contact Information step
    tour.addStep({
        id: 'contact-info',
        attachTo: {
            element: '#contact-section',
            on: 'bottom'
        },
        text: `
            <div class="text-gray-800">
                <h3 class="text-lg font-semibold mb-3 text-blue-600">Contact Information</h3>
                <div class="space-y-4">
                    <p class="text-sm">Provide your contact details:</p>
                    <ul class="space-y-2 text-sm">
                        <li class="flex items-center space-x-2">
                            <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                            </svg>
                            <span>Phone number should be 11 digits</span>
                        </li>
                    </ul>
                </div>
            </div>
        `,
        buttons: [
            {
                text: 'Back',
                action: tour.back,
                classes: 'shepherd-button-secondary'
            },
            {
                text: 'Next',
                action: tour.next,
                classes: 'shepherd-button-primary'
            }
        ]
    });

    // Date and Time Selection step
    tour.addStep({
        id: 'datetime',
        attachTo: {
            element: '#datetime-section',
            on: 'bottom'
        },
        text: `
            <div class="text-gray-800">
                <h3 class="text-lg font-semibold mb-3 text-blue-600">Schedule Your Appointment</h3>
                <div class="space-y-4">
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h4 class="font-medium mb-2">Available Hours:</h4>
                        <ul class="space-y-2 text-sm">
                            <li class="flex items-center space-x-2">
                                <svg class="w-4 h-4 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
                                </svg>
                                <span>Morning: 9:00 AM - 12:00 PM</span>
                            </li>
                            <li class="flex items-center space-x-2">
                                <svg class="w-4 h-4 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                                </svg>
                                <span>Afternoon: 1:00 PM - 5:00 PM</span>
                            </li>
                        </ul>
                    </div>
                    <div class="bg-blue-50 p-4 rounded-lg">
                        <p class="text-sm text-blue-600">
                            💡 Tip: The system will automatically check for scheduling conflicts.
                        </p>
                    </div>
                </div>
            </div>
        `,
        buttons: [
            {
                text: 'Back',
                action: tour.back,
                classes: 'shepherd-button-secondary'
            },
            {
                text: 'Next',
                action: tour.next,
                classes: 'shepherd-button-primary'
            }
        ]
    });

    // Purpose and Description step
    tour.addStep({
        id: 'purpose',
        attachTo: {
            element: '#purpose-section',
            on: 'bottom'
        },
        text: `
            <div class="text-gray-800">
                <h3 class="text-lg font-semibold mb-3 text-blue-600">Appointment Details</h3>
                <div class="space-y-4">
                    <p class="text-sm">Provide clear and concise information:</p>
                    <ul class="space-y-2 text-sm">
                        <li class="flex items-center space-x-2">
                            <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                            <span>State your main purpose clearly</span>
                        </li>
                        <li class="flex items-center space-x-2">
                            <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"/>
                            </svg>
                            <span>Add relevant details in the description</span>
                        </li>
                    </ul>
                </div>
            </div>
        `,
        buttons: [
            {
                text: 'Back',
                action: tour.back,
                classes: 'shepherd-button-secondary'
            },
            {
                text: 'Next',
                action: tour.next,
                classes: 'shepherd-button-primary'
            }
        ]
    });

    // Final step
    tour.addStep({
        id: 'completion',
        text: `
            <div class="text-gray-800">
                <h3 class="text-lg font-semibold mb-3 text-blue-600">Ready to Schedule! 🎉</h3>
                <div class="space-y-4">
                    <p>Before submitting, make sure:</p>
                    <div class="bg-gray-50 p-4 rounded-lg space-y-2">
                        <p class="text-sm">📱 Your contact information is correct</p>
                        <p class="text-sm">📅 You've selected an available time slot</p>
                        <p class="text-sm">📝 Your purpose is clearly stated</p>
                        <p class="text-sm">📋 All required fields are filled</p>
                    </div>
                    <div class="mt-4 text-sm text-gray-600">
                        Need help? Click the Help Guide button anytime to restart this tour.
                    </div>
                </div>
            </div>
        `,
        buttons: [
            {
                text: 'Finish Tour',
                action: tour.complete,
                classes: 'shepherd-button-primary'
            }
        ]
    });

    // Start tour button handler
    document.getElementById('startTour').addEventListener('click', () => {
        tour.start();
    });

    // Show tour on first visit
    if (!localStorage.getItem('createAppointmentTourShown')) {
        tour.start();
        localStorage.setItem('createAppointmentTourShown', 'true');
    }

    // Handle notification dot visibility
    const notificationDot = document.getElementById('helpNotificationDot');
    if (localStorage.getItem('createAppointmentTourShown')) {
        notificationDot.classList.add('hidden');
    }

    // Hide dot after starting tour
    document.getElementById('startTour').addEventListener('click', () => {
        notificationDot.classList.add('hidden');
    });
});
</script>

<!-- Add the tour styles -->
<style>
/* Tour Styles */
.shepherd-highlight {
    box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.5) !important;
    transition: box-shadow 0.2s ease-in-out;
}

.shepherd-button {
    @apply px-4 py-2 text-sm font-medium rounded-lg transition-all duration-200;
}

.shepherd-button-primary {
    @apply bg-blue-600 text-white hover:bg-blue-700;
}

.shepherd-button-secondary {
    @apply bg-gray-500 text-white hover:bg-gray-600;
}

.shepherd-text {
    @apply p-4;
}

.shepherd-footer {
    @apply p-4 flex justify-end space-x-2 border-t border-gray-100;
}

.shepherd-cancel-icon {
    @apply text-gray-400 hover:text-gray-600 transition-colors duration-200;
}

/* Help button animation */
@keyframes gradient-shift {
    0% {
        background-position: 0% 50%;
    }
    50% {
        background-position: 100% 50%;
    }
    100% {
        background-position: 0% 50%;
    }
}

#startTour {
    background-size: 200% 200%;
    animation: gradient-shift 4s ease infinite;
}

#startTour:hover {
    transform: translateY(-1px);
}

#startTour:active {
    transform: translateY(0px);
}

/* Additional animations for the help guide button */
@keyframes gentle-pulse {
    0%, 100% {
        transform: scale(1);
        opacity: 1;
    }
    50% {
        transform: scale(1.05);
        opacity: 0.9;
    }
}

@keyframes float {
    0%, 100% {
        transform: translateY(0);
    }
    50% {
        transform: translateY(-4px);
    }
}

#startTour {
    animation: float 6s ease-in-out infinite;
}

#helpNotificationDot {
    animation: gentle-pulse 2s infinite;
}

/* Glass effect for modern browsers */
@@supports (backdrop-filter: blur(12px)) {
    #startTour {
        backdrop-filter: blur(12px);
        background: linear-gradient(135deg, rgba(255,255,255,0.9), rgba(255,255,255,0.6));
    }
}

/* Improved hover state */
#startTour:hover {
    box-shadow: 0 8px 24px -4px rgba(59, 130, 246, 0.1),
                0 4px 12px -2px rgba(59, 130, 246, 0.08);
}

/* Active state enhancement */
#startTour:active {
    transform: translateY(0);
    box-shadow: 0 4px 12px -2px rgba(59, 130, 246, 0.06);
}
</style>
</body>
</html>