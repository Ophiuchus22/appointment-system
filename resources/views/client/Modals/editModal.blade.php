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
                    <h3 class="text-lg font-medium leading-6 text-gray-900" id="modal-title">
                        Edit Appointment
                    </h3>
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
                            <div class="mt-1">
                                <input type="time" name="time" id="edit_time" required
                                       class="block w-full px-4 py-3 rounded-lg border border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
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
</script>

<style>
#toast {
    transition: transform 0.3s ease-in-out;
}
</style> 