<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Appointments Management</title>
    <link rel="icon" type="image/png" href="{{ asset('logo/system-logo.png') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/shepherd.js@10.0.1/dist/css/shepherd.css"/>
    <script src="https://cdn.jsdelivr.net/npm/shepherd.js@10.0.1/dist/js/shepherd.min.js"></script>
</head>
<body class="bg-gray-100">
    <!-- Add this right after your body tag starts -->
    <div id="loadingOverlay" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white p-5 rounded-lg flex flex-col items-center">
            <div class="animate-spin rounded-full h-10 w-10 border-b-2 border-blue-600 mb-3"></div>
            <p class="text-gray-700">Processing your request...</p>
        </div>
    </div>

    <!-- Include the modal right at the start of body -->
    @include('admin_side.Modals.add_external_appointment_modal')
    @include('admin_side.Modals.view_appointment_details_modal')
    @include('admin_side.Modals.confirmation_modal')
    @include('admin_side.Modals.updateModal')

    <div class="flex">
        @include('layouts.sidebar')

        <!-- Main Content -->
        <div class="flex-1 p-8">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100">
                <!-- Header Section -->
                <div class="p-6 border-b border-gray-100">
                    <div class="flex justify-between items-center">
                        <div>
                            <h1 class="text-2xl font-bold text-gray-800">Appointments Management</h1>
                            <p class="text-sm text-gray-500 mt-1">View and manage all appointments</p>
                        </div>
                        <div class="flex space-x-3">
                            <button id="startTour" 
                                class="group relative inline-flex items-center px-4 py-2.5 text-sm font-medium bg-gradient-to-r from-blue-50 to-indigo-50 text-blue-600 border border-blue-200 rounded-lg hover:from-blue-100 hover:to-indigo-100 hover:border-blue-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200 shadow-sm">
                                <span class="absolute inset-0 bg-gradient-to-r from-blue-500/0 to-indigo-500/0 group-hover:from-blue-500/5 group-hover:to-indigo-500/5 rounded-lg transition-all duration-200"></span>
                                <svg class="w-5 h-5 mr-2 text-blue-500 group-hover:text-blue-600 transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3c-3.75 0-6.75 2.25-6.75 6.75 0 1.875.75 3.375 1.875 4.5L8.25 21h7.5l1.125-6.75c1.125-1.125 1.875-2.625 1.875-4.5C18.75 5.25 15.75 3 12 3z"/>
                                </svg>
                                <span class="relative">Help Guide</span>
                                <!-- Notification dot for first-time users -->
                                <span class="absolute -top-1 -right-1 h-3 w-3 bg-blue-500 rounded-full ring-2 ring-white animate-pulse" id="helpNotificationDot"></span>
                            </button>
                            <button onclick="openModal('addExternalAppointmentModal')" 
                                class="inline-flex items-center px-4 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all duration-200">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                </svg>
                                Add Appointment
                            </button>
                        </div>
                    </div>

                    <!-- Alert Messages -->
                    @if(session('success'))
                        <div id="success-message" class="mt-4 p-4 rounded-lg bg-green-50 border border-green-200 flex items-center">
                            <svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span class="text-green-700 text-sm">{{ session('success') }}</span>
                        </div>
                    @endif

                    @if(session('error'))
                        <div id="error-message" class="mt-4 p-4 rounded-lg bg-red-50 border border-red-200 flex items-center">
                            <svg class="w-5 h-5 text-red-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span class="text-red-700 text-sm">{{ session('error') }}</span>
                        </div>
                    @endif
                </div>

                <!-- Enhanced filter section -->
                <div class="p-6 border-b border-gray-100 bg-white">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6 items-end">
                        <!-- Status Filter -->
                        <div class="space-y-1.5">
                            <label for="status-filter" class="block text-sm font-medium text-gray-700">Status</label>
                            <select id="status-filter" class="w-full rounded-lg border-gray-300 bg-gray-50 shadow-sm focus:border-blue-500 focus:ring-blue-500 pl-3 pr-10 py-2.5 text-sm transition duration-150 ease-in-out">
                                <option value="">All Status</option>
                                <option value="pending">Pending</option>
                                <option value="confirmed">Confirmed</option>
                                <option value="completed">Completed</option>
                                <option value="cancelled">Cancelled</option>
                            </select>
                        </div>

                        <!-- Date Range Filter -->
                        <div class="space-y-1.5">
                            <label for="date-filter" class="block text-sm font-medium text-gray-700">Date Range</label>
                            <select id="date-filter" class="w-full rounded-lg border-gray-300 bg-gray-50 shadow-sm focus:border-blue-500 focus:ring-blue-500 pl-3 pr-10 py-2.5 text-sm transition duration-150 ease-in-out">
                                <option value="">All Dates</option>
                                <option value="today">Today</option>
                                <option value="tomorrow">Tomorrow</option>
                                <option value="this_week">This Week</option>
                                <option value="next_week">Next Week</option>
                                <option value="this_month">This Month</option>
                            </select>
                        </div>

                        <!-- Appointment Type Filter -->
                        <div class="space-y-1.5">
                            <label for="type-filter" class="block text-sm font-medium text-gray-700">Type</label>
                            <select id="type-filter" class="w-full rounded-lg border-gray-300 bg-gray-50 shadow-sm focus:border-blue-500 focus:ring-blue-500 pl-3 pr-10 py-2.5 text-sm transition duration-150 ease-in-out">
                                <option value="">All Types</option>
                                <option value="Internal">Internal</option>
                                <option value="External">External</option>
                            </select>
                        </div>

                        <!-- Search by Name -->
                        <div class="space-y-1.5">
                            <label for="search" class="block text-sm font-medium text-gray-700">Search</label>
                            <div class="relative">
                                <input type="text" id="search" placeholder="Search by name..." 
                                    class="w-full rounded-lg border-gray-300 bg-gray-50 shadow-sm focus:border-blue-500 focus:ring-blue-500 pl-10 pr-4 py-2.5 text-sm transition duration-150 ease-in-out">
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-gray-500">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <!-- Clear Filters Button - Adjusted positioning -->
                        <div class="flex justify-center ml-[-2rem]">
                            <button onclick="clearFilters()" 
                                class="inline-flex items-center justify-center px-4 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                                Clear Filters
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Table Section -->
                <div class="relative">
                    <table class="min-w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Type</th>
                                <th class="px-6 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Name</th>
                                <th class="px-6 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Date</th>
                                <th class="px-6 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Time</th>
                                <th class="px-6 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Purpose</th>
                                <th class="px-6 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($appointments as $appointment)
                            <tr class="hover:bg-gray-50 transition-colors duration-200">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2.5 py-1 text-xs font-medium rounded-full 
                                        {{ $appointment->appointment_type === 'Internal' ? 'bg-blue-100 text-blue-700' : 'bg-green-100 text-green-700' }}">
                                        {{ $appointment->appointment_type }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    @if($appointment->appointment_type === 'Internal')
                                        {{ $appointment->user->name }}
                                    @else
                                        {{ $appointment->first_name }} {{ $appointment->last_name }}
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $appointment->date->format('M d, Y') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $appointment->time->format('h:i A') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $appointment->purpose }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2.5 py-1 text-xs font-medium rounded-full 
                                        @switch($appointment->status)
                                            @case('pending')
                                                bg-yellow-100 text-yellow-700
                                                @break
                                            @case('confirmed')
                                                bg-green-100 text-green-700
                                                @break
                                            @case('completed')
                                                bg-blue-100 text-blue-700
                                                @break
                                            @case('cancelled')
                                                bg-red-100 text-red-700
                                                @break
                                            @default
                                                bg-gray-100 text-gray-700
                                        @endswitch">
                                        {{ ucfirst($appointment->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    <div class="relative" x-data="{ open: false }">
                                        <button @click="open = !open" @click.away="open = false" 
                                            class="inline-flex items-center px-2 py-1 text-sm text-gray-700 hover:bg-gray-50 rounded-md border border-gray-200">
                                            <span>Actions</span>
                                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                            </svg>
                                        </button>

                                        <!-- Dropdown menu -->
                                        <div x-show="open" 
                                            class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg z-[60] border border-gray-100"
                                            style="display: none;">
                                            <div class="py-1">
                                                <!-- View -->
                                                <button onclick="viewAppointmentDetails({{ $appointment->id }})" 
                                                    class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 flex items-center">
                                                    <svg class="w-4 h-4 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                    </svg>
                                                    View Details
                                                </button>

                                                <!-- Update -->
                                                <button type="button"
                                                        onclick='openUpdateModal(@json($appointment))' 
                                                        class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 flex items-center">
                                                    <svg class="w-4 h-4 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                    </svg>
                                                    Update
                                                </button>

                                                @if($appointment->status === 'pending')
                                                    <button onclick="confirmAppointment({{ $appointment->id }})" 
                                                        class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 flex items-center">
                                                        <svg class="w-4 h-4 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                                        </svg>
                                                        Confirm
                                                    </button>
                                                @endif

                                                @if($appointment->status === 'confirmed')
                                                    <button onclick="completeAppointment({{ $appointment->id }})"
                                                        class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 flex items-center">
                                                        <svg class="w-4 h-4 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                        </svg>
                                                        Complete
                                                    </button>
                                                @endif

                                                @if(!in_array($appointment->status, ['cancelled', 'completed']))
                                                    <button onclick="cancelAppointment({{ $appointment->id }})"
                                                        class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 flex items-center">
                                                        <svg class="w-4 h-4 mr-2 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                        </svg>
                                                        Cancel
                                                    </button>
                                                @endif

                                                @if(in_array($appointment->status, ['cancelled', 'completed']))
                                                    <button onclick="deleteAppointment({{ $appointment->id }})"
                                                        class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 flex items-center">
                                                        <svg class="w-4 h-4 mr-2 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                        </svg>
                                                        Delete
                                                    </button>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                                    No appointments found
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Handle success message
            const successMessage = document.getElementById('success-message');
            if (successMessage) {
                setTimeout(() => {
                    successMessage.classList.add('fade-out');
                    setTimeout(() => {
                        successMessage.style.display = 'none';
                    }, 500);
                }, 3000);
            }

            // Handle error message
            const errorMessage = document.getElementById('error-message');
            if (errorMessage) {
                setTimeout(() => {
                    errorMessage.classList.add('fade-out');
                    setTimeout(() => {
                        errorMessage.style.display = 'none';
                    }, 500);
                }, 7000);
            }
        });

        // Modal functions
        function openModal(modalId) {
            document.getElementById(modalId).classList.remove('hidden');
            document.body.style.overflow = 'hidden'; // Prevent background scrolling
        }

        function closeModal(modalId) {
            document.getElementById(modalId).classList.add('hidden');
            document.body.style.overflow = 'auto'; // Restore scrolling
        }

        // Close modal when clicking outside
        document.addEventListener('click', function(event) {
            const modals = document.querySelectorAll('.fixed.inset-0');
            modals.forEach(modal => {
                if (event.target === modal) {
                    closeModal(modal.id);
                }
            });
        });

        // Close modal on escape key
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                const modals = document.querySelectorAll('.fixed.inset-0');
                modals.forEach(modal => {
                    if (!modal.classList.contains('hidden')) {
                        closeModal(modal.id);
                    }
                });
            }
        });

        // Add this for debugging
        document.addEventListener('DOMContentLoaded', function() {
            const modal = document.getElementById('addExternalAppointmentModal');
            if (!modal) {
                console.error('Modal element not found in DOM');
            }
        });

        // Notification functions
        function showConfirmationModal(title, message, onConfirm) {
            const modal = document.getElementById('confirmationModal');
            const titleElement = document.getElementById('modal-title');
            const messageElement = document.getElementById('modal-message');
            const confirmButton = document.getElementById('confirmButton');
            const cancelButton = document.getElementById('cancelButton');

            titleElement.textContent = title;
            messageElement.textContent = message;

            // Show modal
            modal.classList.remove('hidden');

            // Handle confirm button
            const handleConfirm = () => {
                modal.classList.add('hidden');
                confirmButton.removeEventListener('click', handleConfirm);
                cancelButton.removeEventListener('click', handleCancel);
                onConfirm();
            };

            // Handle cancel button
            const handleCancel = () => {
                modal.classList.add('hidden');
                confirmButton.removeEventListener('click', handleConfirm);
                cancelButton.removeEventListener('click', handleCancel);
            };

            confirmButton.addEventListener('click', handleConfirm);
            cancelButton.addEventListener('click', handleCancel);
        }

        // Updated action functions
        function confirmAppointment(appointmentId) {
            showConfirmationModal(
                'Confirm Appointment',
                'Are you sure you want to confirm this appointment?',
                () => {
                    showLoading(); // Show loading before the request
                    fetch(`/admin/appointments/${appointmentId}/confirm`, {
                        method: 'PATCH',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json',
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        hideLoading(); // Hide loading after success
                        window.location.reload();
                    })
                    .catch(error => {
                        hideLoading(); // Hide loading on error
                        console.error('Error:', error);
                        window.location.reload();
                    });
                }
            );
        }

        function cancelAppointment(appointmentId) {
            showConfirmationModal(
                'Cancel Appointment',
                'Are you sure you want to cancel this appointment? This action cannot be undone.',
                () => {
                    showLoading(); // Show loading before the request
                    fetch(`/admin/appointments/${appointmentId}/cancel`, {
                        method: 'PATCH',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json',
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        hideLoading(); // Hide loading after success
                        window.location.reload();
                    })
                    .catch(error => {
                        hideLoading(); // Hide loading on error
                        console.error('Error:', error);
                        window.location.reload();
                    });
                }
            );
        }

        function completeAppointment(appointmentId) {
            showConfirmationModal(
                'Complete Appointment',
                'Are you sure you want to mark this appointment as completed?',
                () => {
                    fetch(`/admin/appointments/${appointmentId}/complete`, {
                        method: 'PATCH',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json',
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        window.location.reload();
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        window.location.reload();
                    });
                }
            );
        }

        function deleteAppointment(appointmentId) {
            showConfirmationModal(
                'Delete Appointment',
                'Are you sure you want to delete this appointment? This action cannot be undone.',
                () => {
                    fetch(`/admin/appointments/${appointmentId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json',
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        window.location.reload();
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        window.location.reload();
                    });
                }
            );
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Get all filter elements
            const statusFilter = document.getElementById('status-filter');
            const dateFilter = document.getElementById('date-filter');
            const typeFilter = document.getElementById('type-filter');
            const searchInput = document.getElementById('search');

            // Add event listeners to all filters
            [statusFilter, dateFilter, typeFilter].forEach(filter => {
                filter.addEventListener('change', applyFilters);
            });

            // Add debounced search
            let searchTimeout;
            searchInput.addEventListener('input', function() {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(applyFilters, 300);
            });
        });

        function applyFilters() {
            const status = document.getElementById('status-filter').value;
            const dateRange = document.getElementById('date-filter').value;
            const type = document.getElementById('type-filter').value;
            const search = document.getElementById('search').value.toLowerCase();

            // Get all rows except header
            const rows = document.querySelectorAll('tbody tr');

            rows.forEach(row => {
                let showRow = true;

                // Status filter - Updated to properly find and compare status
                if (status) {
                    const statusCell = row.querySelector('td:nth-child(6) span'); // Adjust if your status is in a different column
                    const rowStatus = statusCell ? statusCell.textContent.toLowerCase().trim() : '';
                    if (rowStatus !== status.toLowerCase()) {
                        showRow = false;
                    }
                }

                // Type filter
                if (type && row.querySelector('td:nth-child(1)').textContent.trim() !== type) {
                    showRow = false;
                }

                // Name search
                if (search) {
                    const name = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
                    if (!name.includes(search)) {
                        showRow = false;
                    }
                }

                // Date range filter
                if (dateRange) {
                    const appointmentDate = new Date(row.querySelector('td:nth-child(3)').textContent);
                    const today = new Date();
                    
                    switch(dateRange) {
                        case 'today':
                            showRow = isSameDay(appointmentDate, today);
                            break;
                        case 'tomorrow':
                            const tomorrow = new Date(today);
                            tomorrow.setDate(tomorrow.getDate() + 1);
                            showRow = isSameDay(appointmentDate, tomorrow);
                            break;
                        case 'this_week':
                            showRow = isThisWeek(appointmentDate);
                            break;
                        case 'next_week':
                            showRow = isNextWeek(appointmentDate);
                            break;
                        case 'this_month':
                            showRow = isSameMonth(appointmentDate, today);
                            break;
                    }
                }

                // Show/hide row
                row.classList.toggle('hidden', !showRow);
            });

            // Show "No results" message if all rows are hidden
            const visibleRows = document.querySelectorAll('tbody tr:not(.hidden)').length;
            const noResultsRow = document.querySelector('tbody tr.no-results');
            
            if (visibleRows === 0) {
                if (!noResultsRow) {
                    const tbody = document.querySelector('tbody');
                    const newRow = document.createElement('tr');
                    newRow.className = 'no-results';
                    newRow.innerHTML = `
                        <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                            No appointments found matching the selected filters
                        </td>
                    `;
                    tbody.appendChild(newRow);
                }
            } else if (noResultsRow) {
                noResultsRow.remove();
            }
        }

        function clearFilters() {
            // Reset all filters
            document.getElementById('status-filter').value = '';
            document.getElementById('date-filter').value = '';
            document.getElementById('type-filter').value = '';
            document.getElementById('search').value = '';

            // Show all rows
            const rows = document.querySelectorAll('tbody tr');
            rows.forEach(row => row.classList.remove('hidden'));

            // Remove "No results" row if it exists
            const noResultsRow = document.querySelector('tbody tr.no-results');
            if (noResultsRow) {
                noResultsRow.remove();
            }
        }

        // Helper functions for date filtering
        function isSameDay(date1, date2) {
            return date1.getDate() === date2.getDate() &&
                   date1.getMonth() === date2.getMonth() &&
                   date1.getFullYear() === date2.getFullYear();
        }

        function isSameMonth(date1, date2) {
            return date1.getMonth() === date2.getMonth() &&
                   date1.getFullYear() === date2.getFullYear();
        }

        function isThisWeek(date) {
            const today = new Date();
            const firstDay = new Date(today.setDate(today.getDate() - today.getDay()));
            const lastDay = new Date(today.setDate(today.getDate() - today.getDay() + 6));
            return date >= firstDay && date <= lastDay;
        }

        function isNextWeek(date) {
            const today = new Date();
            const firstDay = new Date(today.setDate(today.getDate() - today.getDay() + 7));
            const lastDay = new Date(today.setDate(today.getDate() - today.getDay() + 13));
            return date >= firstDay && date <= lastDay;
        }

        // Form submission handler
        document.getElementById('updateAppointmentForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            // First close the modal
            closeModal('updateModal');
            
            // Then show loading overlay
            showLoading();
            
            // Finally submit the form
            const form = e.target;
            form.submit();
        });

        // Add these utility functions
        function showLoading() {
            document.getElementById('loadingOverlay').classList.remove('hidden');
        }

        function hideLoading() {
            document.getElementById('loadingOverlay').classList.add('hidden');
        }

        document.addEventListener('DOMContentLoaded', function() {
            const tour = new Shepherd.Tour({
                useModalOverlay: true,
                defaultStepOptions: {
                    classes: 'shadow-xl bg-white rounded-xl border border-gray-100',
                    scrollTo: { behavior: 'smooth', block: 'center' },
                    cancelIcon: {
                        enabled: true
                    },
                    when: {
                        show() {
                            const currentStep = tour.getCurrentStep();
                            const target = currentStep.getTarget();
                            if (target) {
                                target.classList.add('shepherd-highlight');
                            }
                        },
                        hide() {
                            const currentStep = tour.getCurrentStep();
                            const target = currentStep.getTarget();
                            if (target) {
                                target.classList.remove('shepherd-highlight');
                            }
                        }
                    }
                }
            });

            // Enhanced welcome step with animation
            tour.addStep({
                id: 'welcome',
                text: `
                    <div class="text-gray-800 animate-fade-in">
                        <h3 class="text-xl font-semibold mb-3 text-blue-600">Welcome to AcadPoint! 👋</h3>
                        <p class="mb-4">Let's take a tour of your appointment management dashboard. We'll cover everything you need to know to get started.</p>
                        <div class="bg-blue-50 p-4 rounded-lg">
                            <p class="text-sm text-blue-600">💡 Tip: You can restart this tour anytime by clicking the Help Guide button.</p>
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
                        classes: 'shepherd-button-primary pulse-animation'
                    }
                ]
            });

            // 
            tour.addStep({
                id: 'add-appointment',
                attachTo: {
                    element: 'button[onclick="openModal(\'addExternalAppointmentModal\')"]',
                    on: 'bottom'
                },
                text: `
                    <div class="text-gray-800">
                        <h3 class="text-lg font-semibold mb-3 text-blue-600">Creating New Appointments</h3>
                        <div class="space-y-4">
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <h4 class="font-medium mb-2">Quick Guide:</h4>
                                <ul class="space-y-2 text-sm">
                                    <li class="flex items-center space-x-2">
                                        <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                        </svg>
                                        <span>Click "Add Appointment" to create a new appointment</span>
                                    </li>
                                    <li class="flex items-center space-x-2">
                                        <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                        </svg>
                                        <span>Fill in visitor's personal information</span>
                                    </li>
                                    <li class="flex items-center space-x-2">
                                        <svg class="w-5 h-5 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                        <span>Select available date and time slot</span>
                                    </li>
                                </ul>
                            </div>
                            <div class="bg-blue-50 p-4 rounded-lg">
                                <p class="text-sm text-blue-600">
                                    💡 Tip: The system will automatically check for scheduling conflicts and validate all information.
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

            // Enhanced filters step with interactive elements
            tour.addStep({
                id: 'filters',
                attachTo: {
                    element: '.grid.grid-cols-1.md\\:grid-cols-2.lg\\:grid-cols-5',
                    on: 'bottom'
                },
                text: `
                    <div class="text-gray-800">
                        <h3 class="text-lg font-semibold mb-3 text-blue-600">Smart Filtering System</h3>
                        <p class="mb-3">Quickly find appointments using our powerful filters:</p>
                        <div class="space-y-2 mb-4">
                            <div class="flex items-center space-x-2 filter-demo" onclick="demonstrateFilter('status')">
                                <span class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center">
                                    <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                                    </svg>
                                </span>
                                <span class="text-sm">Status Filter - Track appointment progress</span>
                            </div>
                            <div class="flex items-center space-x-2 filter-demo" onclick="demonstrateFilter('date')">
                                <span class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center">
                                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                </span>
                                <span class="text-sm">Date Range - Find appointments by time period</span>
                            </div>
                            <div class="flex items-center space-x-2 filter-demo" onclick="demonstrateFilter('search')">
                                <span class="w-8 h-8 rounded-full bg-purple-100 flex items-center justify-center">
                                    <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                    </svg>
                                </span>
                                <span class="text-sm">Quick Search - Find appointments by name or details</span>
                            </div>
                        </div>
                        <p class="text-sm text-gray-500">👆 Click any filter type to see it in action!</p>
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

            // New step for status management
            tour.addStep({
                id: 'status-management',
                attachTo: {
                    element: 'table thead tr th:nth-child(6)',
                    on: 'bottom'
                },
                text: `
                    <div class="text-gray-800">
                        <h3 class="text-lg font-semibold mb-3 text-blue-600">Appointment Status Management</h3>
                        <div class="space-y-3 mb-4">
                            <div class="flex items-center space-x-2">
                                <span class="px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-700">Pending</span>
                                <span class="text-sm">New appointments awaiting confirmation</span>
                            </div>
                            <div class="flex items-center space-x-2">
                                <span class="px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700">Confirmed</span>
                                <span class="text-sm">Approved and scheduled appointments</span>
                            </div>
                            <div class="flex items-center space-x-2">
                                <span class="px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-700">Completed</span>
                                <span class="text-sm">Successfully finished appointments</span>
                            </div>
                            <div class="flex items-center space-x-2">
                                <span class="px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-700">Cancelled</span>
                                <span class="text-sm">Cancelled or declined appointments</span>
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

            // New step for quick actions
            tour.addStep({
                id: 'quick-actions',
                attachTo: {
                    element: 'table tbody tr:first-child td:last-child',
                    on: 'left'
                },
                text: `
                    <div class="text-gray-800">
                        <h3 class="text-lg font-semibold mb-3 text-blue-600">Quick Actions</h3>
                        <div class="space-y-4">
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <h4 class="font-medium mb-2">Available Actions:</h4>
                                <ul class="space-y-2 text-sm">
                                    <li class="flex items-center space-x-2">
                                        <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                        <span>View full appointment details</span>
                                    </li>
                                    <li class="flex items-center space-x-2">
                                        <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                        <span>Update appointment details</span>
                                    </li>
                                    <li class="flex items-center space-x-2">
                                        <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                        <span>Cancel or delete appointments</span>
                                    </li>
                                </ul>
                            </div>
                            <div class="text-sm text-gray-600">
                                <p>💡 Tip: Hover over any action button to see what it does!</p>
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

            // New step for notifications and alerts
            tour.addStep({
                id: 'notifications',
                text: `
                    <div class="text-gray-800">
                        <h3 class="text-lg font-semibold mb-3 text-blue-600">Notifications & Alerts</h3>
                        <div class="space-y-4">
                            <p class="text-sm">Stay informed about appointment updates:</p>
                            <div class="space-y-2">
                                <div class="p-3 bg-green-50 text-green-700 rounded-lg text-sm">
                                    ✓ Success notifications appear here
                                </div>
                                <div class="p-3 bg-yellow-50 text-yellow-700 rounded-lg text-sm">
                                    ⚠ Warning alerts for important changes
                                </div>
                                <div class="p-3 bg-red-50 text-red-700 rounded-lg text-sm">
                                    ⚠ Error messages when something goes wrong
                                </div>
                            </div>
                            <p class="text-sm text-gray-600">
                                Notifications will automatically disappear after a few seconds.
                            </p>
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

            // Final step with helpful resources
            tour.addStep({
                id: 'completion',
                text: `
                    <div class="text-gray-800">
                        <h3 class="text-lg font-semibold mb-3 text-blue-600">You're All Set! 🎉</h3>
                        <div class="space-y-4">
                            <p>You now know the basics of managing appointments. Here are some helpful tips:</p>
                            <div class="bg-gray-50 p-4 rounded-lg space-y-2">
                                <p class="text-sm">📅 Regular check appointments daily</p>
                                <p class="text-sm">📧 Keep communication channels open</p>
                                <p class="text-sm">⚡ Use quick actions for efficiency</p>
                                <p class="text-sm">🔍 Utilize filters for better organization</p>
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
            if (!localStorage.getItem('appointmentTourShown')) {
                tour.start();
                localStorage.setItem('appointmentTourShown', 'true');
            }
        });

        // Function to demonstrate filters
        function demonstrateFilter(filterType) {
            const filterInputs = {
                'status': document.getElementById('status-filter'),
                'date': document.getElementById('date-filter'),
                'search': document.getElementById('search')
            };

            const input = filterInputs[filterType];
            if (input) {
                input.classList.add('ring-2', 'ring-blue-500', 'ring-offset-2');
                input.focus();
                setTimeout(() => {
                    input.classList.remove('ring-2', 'ring-blue-500', 'ring-offset-2');
                }, 2000);
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            const notificationDot = document.getElementById('helpNotificationDot');
            
            // Hide dot if tour has been shown before
            if (localStorage.getItem('appointmentTourShown')) {
                notificationDot.classList.add('hidden');
            }

            // Hide dot after starting tour
            document.getElementById('startTour').addEventListener('click', () => {
                notificationDot.classList.add('hidden');
            });
        });
    </script>

    <!-- Add these new styles -->
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

    .filter-demo {
        @apply p-2 rounded-lg transition-all duration-200 cursor-pointer hover:bg-gray-50;
    }

    /* Animations */
    .pulse-animation {
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0% {
            box-shadow: 0 0 0 0 rgba(59, 130, 246, 0.4);
        }
        70% {
            box-shadow: 0 0 0 10px rgba(59, 130, 246, 0);
        }
        100% {
            box-shadow: 0 0 0 0 rgba(59, 130, 246, 0);
        }
    }

    .animate-fade-in {
        animation: fadeIn 0.5s ease-in-out;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

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
    </style>
</body>
</html> 