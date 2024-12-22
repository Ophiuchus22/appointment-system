<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Appointments Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
</head>
<body class="bg-gray-100">
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
                        <div>
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
                        window.location.reload();
                    })
                    .catch(error => {
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
                        window.location.reload();
                    })
                    .catch(error => {
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
            
            const form = e.target;
            const formData = new FormData(form);

            fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                // Simply reload the page - the session flash message will be shown
                window.location.reload();
            })
            .catch(error => {
                console.error('Error:', error);
                window.location.reload();
            });
        });
    </script>
</body>
</html> 