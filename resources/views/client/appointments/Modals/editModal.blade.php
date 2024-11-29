<!-- Edit Appointment Modal -->
<div id="editModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4">
        <!-- Overlay -->
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

        <!-- Modal Content -->
        <div class="relative bg-white rounded-lg shadow-xl max-w-lg w-full mx-auto z-10">
            <div class="px-6 py-4 border-b">
                <h3 class="text-lg font-semibold text-gray-900">Edit Appointment</h3>
                <button onclick="closeEditModal()" class="absolute top-4 right-4 text-gray-400 hover:text-gray-500">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <form id="editAppointmentForm" method="POST">
                @csrf
                @method('PUT')
                
                <div class="px-6 py-4 space-y-4">
                    <!-- Phone Number -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Phone Number (Optional)</label>
                        <input type="tel" name="phone_number" id="edit_phone_number" 
                               class="form-input w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                    </div>

                    <!-- Date and Time -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Date</label>
                            <input type="date" name="date" id="edit_date" required
                                   class="form-input w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Time</label>
                            <input type="time" name="time" id="edit_time" required
                                   class="form-input w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                        </div>
                    </div>

                    <!-- Purpose -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Purpose</label>
                        <select name="purpose" id="edit_purpose" required
                                class="form-select w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                            <option value="">Select Purpose</option>
                            <option value="Academic Advising">Academic Advising</option>
                            <option value="Personal Concerns">Personal Concerns</option>
                            <option value="Event Planning">Event Planning</option>
                            <option value="Financial Aid">Financial Aid</option>
                            <option value="Graduation/Transcript Requests">Graduation/Transcript Requests</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>

                    <!-- Description -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                        <textarea name="description" id="edit_description" rows="4" required
                                  class="form-textarea w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"></textarea>
                    </div>
                </div>

                <div class="px-6 py-4 bg-gray-50 rounded-b-lg flex justify-end space-x-3">
                    <button type="button" onclick="closeEditModal()" 
                            class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Cancel
                    </button>
                    <button type="submit" 
                            class="px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Update Appointment
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

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
}

function closeEditModal() {
    document.getElementById('editModal').classList.add('hidden');
}

// Handle form submission
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
            // Show error message
            alert(data.error);
        } else {
            // Show success message and refresh the page
            alert(data.success);
            window.location.reload();
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred while updating the appointment.');
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
</script> 