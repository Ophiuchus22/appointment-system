<!-- Edit Appointment Modal -->
<div id="editModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <!-- Background overlay -->
        <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" aria-hidden="true"></div>

        <!-- Modal panel -->
        <div class="relative inline-block w-full max-w-lg p-4 my-8 overflow-hidden text-left align-middle transition-all transform bg-white shadow-xl sm:rounded-xl">
            <div class="absolute top-0 right-0 hidden pt-4 pr-4 sm:block">
                <button type="button" onclick="closeEditModal()" class="text-gray-400 bg-white rounded-md hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <span class="sr-only">Close</span>
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <div class="sm:flex sm:items-start">
                <div class="flex items-center justify-center flex-shrink-0 w-12 h-12 mx-auto bg-blue-100 rounded-full sm:mx-0 sm:h-10 sm:w-10">
                    <svg class="w-6 h-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                </div>
                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                    <!-- <h3 class="text-lg font-medium leading-6 text-gray-900" id="modal-title">
                        
                    </h3> -->
                </div>
            </div>

            <form id="editAppointmentForm" method="POST" class="mt-6">
                @csrf
                @method('PUT')
                
                <div class="space-y-6">
                    <!-- Phone Number -->
                    <div>
                        <label for="edit_phone_number" class="block text-sm font-medium text-gray-700">
                            Phone Number <span class="text-gray-400">(Optional)</span>
                        </label>
                        <div class="mt-1">
                            <input type="tel" name="phone_number" id="edit_phone_number" 
                                   class="block w-full px-4 py-3 rounded-lg border border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                   placeholder="Enter your phone number">
                        </div>
                    </div>

                    <!-- Date and Time -->
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <div>
                            <label for="edit_date" class="block text-sm font-medium text-gray-700">Date</label>
                            <div class="mt-1">
                                <input type="date" name="date" id="edit_date" required
                                       class="block w-full px-4 py-3 rounded-lg border border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                            </div>
                        </div>
                        <div>
                            <label for="edit_time" class="block text-sm font-medium text-gray-700">Time</label>
                            <div class="relative mt-1">
                                <select name="time" 
                                        id="edit_time"
                                        class="block w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 bg-white appearance-none cursor-pointer disabled:bg-gray-50 disabled:text-gray-500" 
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
                            <div id="editTimeLoadingIndicator" class="hidden mt-2">
                                <div class="flex items-center space-x-2">
                                    <div class="animate-spin rounded-full h-4 w-4 border-b-2 border-blue-500"></div>
                                    <span class="text-sm text-gray-500">Loading available times...</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Purpose -->
                    <div>
                        <label for="edit_purpose" class="block text-sm font-medium text-gray-700">Purpose</label>
                        <div class="mt-1">
                            <select name="purpose" id="edit_purpose" required
                                    class="block w-full px-4 py-3 rounded-lg border border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                <option value="">Select Purpose</option>
                                <option value="Academic Advising">Academic Advising</option>
                                <option value="Personal Concerns">Personal Concerns</option>
                                <option value="Event Planning">Event Planning</option>
                                <option value="Financial Aid">Financial Aid</option>
                                <option value="Graduation/Transcript Requests">Graduation/Transcript Requests</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                    </div>

                    <!-- Description -->
                    <div>
                        <label for="edit_description" class="block text-sm font-medium text-gray-700">Description</label>
                        <div class="mt-1">
                            <textarea name="description" id="edit_description" rows="4" required
                                      class="block w-full px-4 py-3 rounded-lg border border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                      placeholder="Provide additional details about your appointment"></textarea>
                        </div>
                    </div>
                </div>

                <div class="mt-6 sm:mt-8 sm:flex sm:flex-row-reverse gap-3">
                    <button type="submit" 
                            class="inline-flex justify-center w-full px-4 py-2.5 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-lg shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:w-auto sm:text-sm">
                        Update Appointment
                    </button>
                    <button type="button" onclick="closeEditModal()"
                            class="mt-3 inline-flex justify-center w-full px-4 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:w-auto sm:text-sm">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Add this HTML at the bottom of your modal, before the script -->
<div id="toast" class="fixed right-0 top-4 transform translate-x-full transition-transform duration-300 ease-in-out z-50"></div>

<script>
function openEditModal(appointment) {
    // Set form action URL
    const form = document.getElementById('editAppointmentForm');
    form.action = `/appointments/${appointment.id}`;

    // Format date (assuming it comes in YYYY-MM-DD format)
    const date = appointment.date ? appointment.date.split(' ')[0] : '';
    
    // Format time (assuming it comes in HH:MM:SS format)
    let time = appointment.time;
    if (time && time.includes(' ')) {
        // If time includes date, extract only the time part
        time = time.split(' ')[1];
    }
    if (time && time.includes(':')) {
        // Extract HH:MM from HH:MM:SS
        time = time.split(':').slice(0, 2).join(':');
    }

    // Populate form fields
    document.getElementById('edit_phone_number').value = appointment.phone_number || '';
    document.getElementById('edit_date').value = date;
    document.getElementById('edit_time').value = time;
    document.getElementById('edit_purpose').value = appointment.purpose || '';
    document.getElementById('edit_description').value = appointment.description || '';

    // Show modal
    document.getElementById('editModal').classList.remove('hidden');

    // Debug log to check values
    console.log('Appointment Data:', {
        original: appointment,
        formatted: {
            date,
            time,
            phone: appointment.phone_number,
            purpose: appointment.purpose,
            description: appointment.description
        }
    });

    // Store the current time as a data attribute
    document.getElementById('edit_time').setAttribute('data-current-time', time);
    
    // Trigger the date change event to load available times
    document.getElementById('edit_date').dispatchEvent(new Event('change'));
}

function closeEditModal() {
    document.getElementById('editModal').classList.add('hidden');
}

function showNotification(type, message) {
    const toast = document.getElementById('toast');
    
    // Create the notification content
    const notificationHTML = `
        <div class="bg-white rounded-lg shadow-lg p-4 max-w-sm w-full border-l-4 ${type === 'success' ? 'border-green-500' : 'border-red-500'}">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    ${type === 'success' 
                        ? `<svg class="h-5 w-5 text-green-500" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                           </svg>`
                        : `<svg class="h-5 w-5 text-red-500" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                           </svg>`
                    }
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium ${type === 'success' ? 'text-green-600' : 'text-red-600'}">
                        ${message}
                    </p>
                </div>
            </div>
        </div>
    `;

    // Set the HTML content
    toast.innerHTML = notificationHTML;

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

// Update the form submission handler
document.getElementById('editAppointmentForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const form = e.target;
    const formData = new FormData(form);
    const url = form.action;

    // Add CSRF token
    formData.append('_token', '{{ csrf_token() }}');
    formData.append('_method', 'PUT');

    // Send AJAX request
    fetch(url, {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.error) {
            // Show error notification
            showNotification('error', data.error);
        } else {
            // Show success notification and close modal
            closeEditModal();
            showNotification('success', data.success || 'Appointment updated successfully');
            // Reload the page after a short delay
            setTimeout(() => {
                window.location.reload();
            }, 1500);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('error', 'An error occurred while updating the appointment.');
    });
});

// Close modal when clicking outside
document.addEventListener('click', function(event) {
    const modal = document.getElementById('editModal');
    const modalContent = modal.querySelector('.relative');
    
    if (event.target === modal) {
        closeEditModal();
    }
});

// Close modal with Escape key
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        closeEditModal();
    }
});

// Add this new function to handle date changes
document.getElementById('edit_date').addEventListener('change', function() {
    const date = this.value;
    const timeSelect = document.getElementById('edit_time');
    const loadingIndicator = document.getElementById('editTimeLoadingIndicator');
    
    if (date) {
        timeSelect.disabled = true;
        loadingIndicator.classList.remove('hidden');

        // Update URL to include exclude_completed parameter
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
        .then(response => response.json())
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
                
                // Don't disable the current appointment's time slot
                const currentTime = timeSelect.getAttribute('data-current-time');
                const isCurrentTimeSlot = slot.value === currentTime;
                
                option.disabled = (isBooked && !isCurrentTimeSlot) || isPastTime;
                option.className = (option.disabled) ? 'text-gray-400' : 'text-gray-900';
                
                // Add a title attribute to show why the slot is disabled
                if (isPastTime) {
                    option.title = "This time slot has already passed";
                } else if (isBooked && !isCurrentTimeSlot) {
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

            // Restore the current time if editing
            const currentTime = timeSelect.getAttribute('data-current-time');
            if (currentTime) {
                timeSelect.value = currentTime;
            }
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

// Add date input restriction
document.addEventListener('DOMContentLoaded', function() {
    const today = new Date();
    const dd = String(today.getDate()).padStart(2, '0');
    const mm = String(today.getMonth() + 1).padStart(2, '0');
    const yyyy = today.getFullYear();

    const todayString = yyyy + '-' + mm + '-' + dd;
    document.getElementById('edit_date').setAttribute('min', todayString);
});
</script>

<style>
#toast {
    transition: transform 0.3s ease-in-out;
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