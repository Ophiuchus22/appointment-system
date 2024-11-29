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

<!-- Top Navigation Bar -->
<div class="w-full bg-white border-b border-gray-100 px-4 py-3">
    <div class="max-w-7xl mx-auto flex justify-between items-center">
        <!-- Left side - Logo or Title -->
        <div>
            <h1 class="text-xl font-semibold text-gray-800">Appointment System</h1>
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
<div class="fixed bottom-4 right-4 opacity-60">
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
                    <div class="space-y-6">
                        <!-- Phone Number - Single Column -->
                        <div class="max-w-md">
                            <label class="block text-sm font-medium text-gray-600">Phone Number</label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <input type="tel" 
                                    name="phone_number" 
                                    placeholder="(Optional)"
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200">
                            </div>
                        </div>

                        <!-- Date and Time - Two Columns -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-600">Date</label>
                                <div class="mt-1 relative rounded-md shadow-sm">
                                    <input type="date" 
                                        name="date" 
                                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200" 
                                        required>
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-600">Time</label>
                                <div class="mt-1 relative rounded-md shadow-sm">
                                    <input type="time" 
                                        name="time" 
                                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200" 
                                        required>
                                </div>
                            </div>
                        </div>

                        <!-- Purpose - Single Column -->
                        <div>
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
                        <div class="bg-gray-50 rounded-lg p-6 space-y-4 border border-gray-100">
                            <!-- Phone Number -->
                            <div class="grid grid-cols-3 gap-4 items-baseline">
                                <p class="text-sm font-medium text-gray-500">Phone Number</p>
                                <p class="col-span-2 text-base text-gray-900" id="summary-phone">
                                    <span class="text-gray-400 italic text-sm">Not provided</span>
                                </p>
                            </div>

                            <!-- Date & Time -->
                            <div class="grid grid-cols-3 gap-4 items-baseline">
                                <p class="text-sm font-medium text-gray-500">Schedule</p>
                                <div class="col-span-2 flex gap-2 text-base text-gray-900">
                                    <span id="summary-date"></span>
                                    <span class="text-gray-400">|</span>
                                    <span id="summary-time"></span>
                                </div>
                            </div>

                            <!-- Purpose -->
                            <div class="grid grid-cols-3 gap-4 items-baseline">
                                <p class="text-sm font-medium text-gray-500">Purpose</p>
                                <p class="col-span-2 text-base text-gray-900" id="summary-purpose"></p>
                            </div>

                            <!-- Description -->
                            <div class="grid grid-cols-3 gap-4 items-baseline">
                                <p class="text-sm font-medium text-gray-500">Description</p>
                                <p class="col-span-2 text-base text-gray-900 whitespace-pre-line" id="summary-description"></p>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex justify-between items-center pt-4">
                            <button type="button" 
                                class="px-6 py-2.5 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-200 focus:ring-offset-2 transition-all duration-200 font-medium" 
                                onclick="showSection('details-section')">
                                Back to Details
                            </button>
                            <button type="submit" 
                                class="bg-blue-600 text-white px-6 py-2.5 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all duration-200 font-medium">
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
</script>
</body>
</html>