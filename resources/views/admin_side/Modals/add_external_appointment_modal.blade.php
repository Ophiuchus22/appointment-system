<div id="addExternalAppointmentModal" class="fixed inset-0 bg-black bg-opacity-60 backdrop-blur-sm hidden z-[100]">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-xl shadow-lg max-w-3xl w-full max-h-[90vh] overflow-y-auto">
            <!-- Modal Header (Keep outside of scrollable area) -->
            <div class="p-6 border-b border-gray-100 sticky top-0 bg-white z-10">
                <div class="flex justify-between items-center">
                    <h3 class="text-xl font-semibold text-gray-800">Add External Appointment</h3>
                    <button onclick="closeModal('addExternalAppointmentModal')" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Form Content (Scrollable) -->
            <form action="{{ route('admin.appointments.store') }}" method="POST" class="p-6">
                @csrf
                <div class="grid grid-cols-2 gap-6">
                    <!-- Personal Information Section -->
                    <div class="col-span-2">
                        <h4 class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-4">Personal Information</h4>
                        <div class="grid grid-cols-2 gap-4">
                            <!-- First Name -->
                            <div>
                                <label for="first_name" class="block text-sm font-medium text-gray-700 mb-1">First Name</label>
                                <input type="text" name="first_name" id="first_name" required
                                    class="w-full rounded-lg border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            </div>

                            <!-- Last Name -->
                            <div>
                                <label for="last_name" class="block text-sm font-medium text-gray-700 mb-1">Last Name</label>
                                <input type="text" name="last_name" id="last_name" required
                                    class="w-full rounded-lg border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            </div>
                        </div>
                    </div>

                    <!-- Contact Information Section -->
                    <div class="col-span-2">
                        <h4 class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-4">Contact Information</h4>
                        <div class="grid grid-cols-2 gap-4">
                            <!-- Email -->
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                                <input type="email" name="email" id="email" required
                                    class="w-full rounded-lg border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            </div>

                            <!-- Phone Number -->
                            <div>
                                <label for="phone_number" class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                                <input type="tel" name="phone_number" id="phone_number" required
                                    class="w-full rounded-lg border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                    pattern="[0-9]{11}" placeholder="09123456789">
                            </div>

                            <!-- Company Name -->
                            <div class="col-span-2">
                                <label for="company_name" class="block text-sm font-medium text-gray-700 mb-1">Company Name</label>
                                <input type="text" name="company_name" id="company_name" required
                                    class="w-full rounded-lg border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            </div>

                            <!-- Address -->
                            <div class="col-span-2">
                                <label for="address" class="block text-sm font-medium text-gray-700 mb-1">Address</label>
                                <textarea name="address" id="address" rows="2"
                                    class="w-full rounded-lg border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                    placeholder="Enter address"></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Appointment Details Section -->
                    <div class="col-span-2">
                        <h4 class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-4">Appointment Details</h4>
                        <div class="grid grid-cols-2 gap-4">
                            <!-- Date -->
                            <div>
                                <label for="date" class="block text-sm font-medium text-gray-700 mb-1">Date</label>
                                <input type="date" name="date" id="date" required
                                    class="w-full rounded-lg border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            </div>

                            <!-- Time -->
                            <div>
                                <label for="time" class="block text-sm font-medium text-gray-700 mb-1">Time</label>
                                <div class="relative">
                                    <select name="time" 
                                            id="time"
                                            class="w-full rounded-lg border border-gray-300 px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 bg-white appearance-none cursor-pointer disabled:bg-gray-50 disabled:text-gray-500" 
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

                            <!-- Purpose -->
                            <div class="col-span-2">
                                <label for="purpose" class="block text-sm font-medium text-gray-700 mb-1">Purpose</label>
                                <select name="purpose" id="purpose" required
                                    class="w-full rounded-lg border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                    <option value="">Select purpose</option>
                                    <option value="Academic Advising">Academic Advising</option>
                                    <option value="Personal Concerns">Personal Concerns</option>
                                    <option value="Event Planning">Event Planning</option>
                                    <option value="Financial Aid">Financial Aid</option>
                                    <option value="Graduation/Transcript Requests">Documents Request</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>

                            <!-- Description -->
                            <div class="col-span-2">
                                <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                                <textarea name="description" id="description" rows="3" required
                                    class="w-full rounded-lg border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal Footer (Keep outside of scrollable area) -->
                <div class="mt-6 flex justify-end space-x-3 sticky bottom-0 bg-white py-4">
                    <button type="button" onclick="closeModal('addExternalAppointmentModal')"
                        class="px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 rounded-lg">
                        Cancel
                    </button>
                    <button type="submit"
                        class="px-4 py-2 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 rounded-lg">
                        Create Appointment
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

            const baseUrl = '{{ url("/") }}';
            const url = `${baseUrl}/admin/appointments/available-times?date=${date}`;

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

                const createTimeOption = (slot, isBooked) => {
                    const option = document.createElement('option');
                    option.value = slot.value;
                    option.textContent = slot.label;
                    option.disabled = isBooked;
                    option.className = isBooked ? 'text-gray-400' : 'text-gray-900';
                    return option;
                };

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

    if (dateInput.value) {
        dateInput.dispatchEvent(new Event('change'));
    }
});
</script> 