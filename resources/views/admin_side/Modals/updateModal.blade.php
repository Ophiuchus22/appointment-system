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
                            <div class="mt-1">
                                <input type="time" name="time" id="update_time" required
                                       class="block w-full px-4 py-3 rounded-lg border border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
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

<script>
function openUpdateModal(appointment) {
    const modal = document.getElementById('updateModal');
    const form = document.getElementById('updateAppointmentForm');
    
    // Set form action URL
    form.action = `/admin/appointments/${appointment.id}/update`;

    // Format date (assuming it comes in YYYY-MM-DD format)
    const date = appointment.date ? appointment.date.split(' ')[0] : '';
    
    // Format time (assuming it comes in HH:MM:SS format)
    let time = appointment.time;
    if (time && time.includes(' ')) {
        time = time.split(' ')[1];
    }
    if (time && time.includes(':')) {
        time = time.split(':').slice(0, 2).join(':');
    }

    // Set form values
    document.getElementById('update_date').value = date;
    document.getElementById('update_time').value = time;
    document.getElementById('update_purpose').value = appointment.purpose;
    document.getElementById('update_description').value = appointment.description;

    // Show modal
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
  