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
                                    <select name="time" id="time" required
                                        class="w-full rounded-lg border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                        <option value="">Select time</option>
                                        <optgroup label="Morning (9 AM - 12 PM)">
                                            <option value="09:00">9:00 AM</option>
                                            <option value="09:30">9:30 AM</option>
                                            <option value="10:00">10:00 AM</option>
                                            <option value="10:30">10:30 AM</option>
                                            <option value="11:00">11:00 AM</option>
                                            <option value="11:30">11:30 AM</option>
                                            <option value="12:00">12:00 PM</option>
                                        </optgroup>
                                        <optgroup label="Afternoon (1 PM - 5 PM)">
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

<script>
document.getElementById('date').addEventListener('change', function() {
    const date = this.value;
    const timeSelect = document.getElementById('time');
    
    if (date) {
        timeSelect.disabled = true;
        timeSelect.innerHTML = '<option value="">Loading available times...</option>';

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
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            timeSelect.innerHTML = '<option value="">Select time</option>';
            
            const morningGroup = document.createElement('optgroup');
            morningGroup.label = 'Morning (9 AM - 12 PM)';
            
            const afternoonGroup = document.createElement('optgroup');
            afternoonGroup.label = 'Afternoon (1 PM - 5 PM)';

            const morningSlots = [
                { value: '09:00', label: '9:00 AM' },
                { value: '09:30', label: '9:30 AM' },
                { value: '10:00', label: '10:00 AM' },
                { value: '10:30', label: '10:30 AM' },
                { value: '11:00', label: '11:00 AM' },
                { value: '11:30', label: '11:30 AM' },
                { value: '12:00', label: '12:00 PM' }
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
                const option = document.createElement('option');
                option.value = slot.value;
                option.textContent = slot.label;
                option.disabled = data.bookedTimes.includes(slot.value);
                morningGroup.appendChild(option);
            });

            afternoonSlots.forEach(slot => {
                const option = document.createElement('option');
                option.value = slot.value;
                option.textContent = slot.label;
                option.disabled = data.bookedTimes.includes(slot.value);
                afternoonGroup.appendChild(option);
            });

            timeSelect.appendChild(morningGroup);
            timeSelect.appendChild(afternoonGroup);
            timeSelect.disabled = false;
        })
        .catch(error => {
            timeSelect.innerHTML = '<option value="">Error loading times</option>';
            timeSelect.disabled = true;
        });
    }
});
</script> 