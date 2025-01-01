<!-- Update Appointment Modal -->
<div id="updateModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <!-- Background overlay -->
        <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" aria-hidden="true"></div>

        <!-- Modal panel -->
        <div class="relative inline-block w-full max-w-lg p-4 my-8 overflow-hidden text-left align-middle transition-all transform bg-white shadow-xl sm:rounded-xl">
            <div class="absolute top-0 right-0 hidden pt-4 pr-4 sm:block">
                <button type="button" onclick="closeUpdateModal()" class="text-gray-400 bg-white rounded-md hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
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
                    <h3 class="text-lg font-medium leading-6 text-gray-900" id="modal-title">
                        Update Appointment Details
                    </h3>
                </div>
            </div>

            <form action="" method="POST" id="updateAppointmentForm" class="mt-6">
                @csrf
                @method('PUT')
                
                <div class="space-y-6">
                    <!-- Date and Time -->
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <div>
                            <label for="update_date" class="block text-sm font-medium text-gray-700">Date</label>
                            <div class="mt-1">
                                <input type="date" name="date" id="update_date" required
                                       class="block w-full px-4 py-3 rounded-lg border border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                            </div>
                        </div>
                        <div>
                            <label for="update_time" class="block text-sm font-medium text-gray-700">Time</label>
                            <div class="relative mt-1">
                                <select name="time" 
                                        id="update_time"
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
                            <div id="updateTimeLoadingIndicator" class="hidden mt-2">
                                <div class="flex items-center space-x-2">
                                    <div class="animate-spin rounded-full h-4 w-4 border-b-2 border-blue-500"></div>
                                    <span class="text-sm text-gray-500">Loading available times...</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Purpose -->
                    <div>
                        <label for="update_purpose" class="block text-sm font-medium text-gray-700">Purpose</label>
                        <div class="mt-1">
                            <select name="purpose" id="update_purpose" required
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
                        <label for="update_description" class="block text-sm font-medium text-gray-700">Description</label>
                        <div class="mt-1">
                            <textarea name="description" id="update_description" rows="4" required
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
                    <button type="button" onclick="closeUpdateModal()"
                            class="mt-3 inline-flex justify-center w-full px-4 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:w-auto sm:text-sm">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
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

<script>
document.getElementById('update_date').addEventListener('change', function() {
    const date = this.value;
    const timeSelect = document.getElementById('update_time');
    const loadingIndicator = document.getElementById('updateTimeLoadingIndicator');
    
    if (date) {
        timeSelect.disabled = true;
        loadingIndicator.classList.remove('hidden');

        const baseUrl = '{{ url("/") }}';
        const url = `${baseUrl}/admin/appointments/available-times?date=${date}&exclude_completed=true`;

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
                
                // Don't disable the current appointment's time slot
                const currentTime = timeSelect.getAttribute('data-current-time');
                const isCurrentTimeSlot = slot.value === currentTime;
                
                option.disabled = (isBooked && !isCurrentTimeSlot) || isPastTime;
                option.className = (option.disabled) ? 'text-gray-400' : 'text-gray-900';
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
    document.getElementById('update_date').setAttribute('min', todayString);
});

// Update the openUpdateModal function to store the current time
function openUpdateModal(appointment) {
    const modal = document.getElementById('updateModal');
    const form = document.getElementById('updateAppointmentForm');
    
    form.action = `/admin/appointments/${appointment.id}/update`;

    const date = appointment.date ? appointment.date.split(' ')[0] : '';
    let time = appointment.time;
    if (time && time.includes(' ')) {
        time = time.split(' ')[1];
    }
    if (time && time.includes(':')) {
        time = time.split(':').slice(0, 2).join(':');
    }

    document.getElementById('update_date').value = date;
    document.getElementById('update_time').value = time;
    document.getElementById('update_purpose').value = appointment.purpose;
    document.getElementById('update_description').value = appointment.description;

    document.getElementById('update_time').setAttribute('data-current-time', time);
    document.getElementById('update_date').dispatchEvent(new Event('change'));

    modal.classList.remove('hidden');
}

function closeUpdateModal() {
    document.getElementById('updateModal').classList.add('hidden');
}

// Close modal when clicking outside
document.addEventListener('click', function(event) {
    const modal = document.getElementById('updateModal');
    if (event.target === modal) {
        closeUpdateModal();
    }
});

// Close modal with Escape key
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        closeUpdateModal();
    }
});
</script>
  </rewritten_file>
  