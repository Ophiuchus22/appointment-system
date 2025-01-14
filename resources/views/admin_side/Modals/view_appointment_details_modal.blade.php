<div id="viewAppointmentModal" class="fixed inset-0 bg-black bg-opacity-60 backdrop-blur-sm hidden z-[100]">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-xl shadow-lg max-w-3xl w-full max-h-[90vh] overflow-y-auto">
            <!-- Modal Header -->
            <div class="p-6 border-b border-gray-100 sticky top-0 bg-white z-10">
                <div class="flex justify-between items-center">
                    <h3 class="text-xl font-semibold text-gray-800">Appointment Details</h3>
                    <button onclick="closeModal('viewAppointmentModal')" 
                        class="p-2 hover:bg-gray-100 rounded-lg transition-colors">
                        <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Modal Content -->
            <div class="p-8">
                <!-- Appointment Type & Status -->
                <div class="flex justify-between items-center mb-8">
                    <span class="px-4 py-1.5 text-sm font-medium rounded-full" id="appointmentType"></span>
                    <span class="px-4 py-1.5 text-sm font-medium rounded-full" id="appointmentStatus"></span>
                </div>

                <!-- Details Grid -->
                <div class="grid grid-cols-2 gap-6">
                    <!-- Personal Information Section -->
                    <div class="col-span-2">
                        <h4 class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-4">Personal Information</h4>
                        <div class="grid grid-cols-2 gap-4 bg-gray-50 p-4 rounded-lg">
                            <div>
                                <p class="text-sm text-gray-500">Name</p>
                                <p class="font-medium text-gray-900" id="appointmentName"></p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Email</p>
                                <p class="font-medium text-gray-900" id="appointmentEmail"></p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Phone Number</p>
                                <p class="font-medium text-gray-900" id="appointmentPhone"></p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Company/Organization</p>
                                <p class="font-medium text-gray-900" id="appointmentCompany"></p>
                            </div>
                            <div class="col-span-2">
                                <p class="text-sm text-gray-500">College/Office</p>
                                <p class="font-medium text-gray-900" id="appointmentCollege"></p>
                            </div>
                            <div class="col-span-2">
                                <p class="text-sm text-gray-500">Address</p>
                                <p class="font-medium text-gray-900" id="appointmentAddress"></p>
                            </div>
                        </div>
                    </div>

                    <!-- Appointment Details Section -->
                    <div class="col-span-2">
                        <h4 class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-4">Appointment Details</h4>
                        <div class="grid grid-cols-2 gap-4 bg-gray-50 p-4 rounded-lg">
                            <div>
                                <p class="text-sm text-gray-500">Date</p>
                                <p class="font-medium text-gray-900" id="appointmentDate"></p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Time</p>
                                <p class="font-medium text-gray-900" id="appointmentTime"></p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Purpose</p>
                                <p class="font-medium text-gray-900" id="appointmentPurpose"></p>
                            </div>
                            <div class="col-span-2">
                                <p class="text-sm text-gray-500">Description</p>
                                <p class="font-medium text-gray-900" id="appointmentDescription"></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="p-6 border-t border-gray-100 bg-gray-50 rounded-b-xl sticky bottom-0">
                <div class="flex justify-end">
                    <button onclick="closeModal('viewAppointmentModal')"
                        class="px-6 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 rounded-lg">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function viewAppointmentDetails(appointmentId) {
    fetch(`/admin/appointments/${appointmentId}`)
        .then(response => response.json())
        .then(appointment => {
            // Set appointment type with appropriate styling
            const typeElement = document.getElementById('appointmentType');
            typeElement.textContent = appointment.appointment_type;
            typeElement.className = `px-3 py-1 text-sm font-medium rounded-full ${
                appointment.appointment_type === 'Internal' 
                    ? 'bg-blue-100 text-blue-700' 
                    : 'bg-green-100 text-green-700'
            }`;

            // Set status with appropriate styling
            const statusElement = document.getElementById('appointmentStatus');
            statusElement.textContent = appointment.status.charAt(0).toUpperCase() + appointment.status.slice(1);
            let statusClass = '';
            switch(appointment.status) {
                case 'pending':
                    statusClass = 'bg-yellow-100 text-yellow-700';
                    break;
                case 'confirmed':
                    statusClass = 'bg-green-100 text-green-700';
                    break;
                case 'completed':
                    statusClass = 'bg-blue-100 text-blue-700';
                    break;
                case 'cancelled':
                    statusClass = 'bg-red-100 text-red-700';
                    break;
            }
            statusElement.className = `px-3 py-1 text-sm font-medium rounded-full ${statusClass}`;

            // Set other appointment details
            document.getElementById('appointmentName').textContent = appointment.appointment_type === 'Internal' 
                ? appointment.user.name 
                : `${appointment.first_name} ${appointment.last_name}`;
            document.getElementById('appointmentEmail').textContent = appointment.email || appointment.user.email;
            document.getElementById('appointmentPhone').textContent = appointment.phone_number;
            document.getElementById('appointmentCompany').textContent = appointment.company_name || 'N/A';
            document.getElementById('appointmentCollege').textContent = appointment.appointment_type === 'Internal' 
                ? (appointment.user?.college_office || 'N/A')
                : (appointment.college_name || 'N/A');
            document.getElementById('appointmentAddress').textContent = appointment.address || 'N/A';
            document.getElementById('appointmentDate').textContent = moment(appointment.date).format('MMMM D, YYYY');

            // Extract time and convert to 12-hour format
            const timeOnly = appointment.time.split(' ')[1];
            const [hours, minutes] = timeOnly.split(':');
            const ampm = hours >= 12 ? 'PM' : 'AM';
            const hours12 = hours % 12 || 12;
            const formattedTime = `${hours12}:${minutes} ${ampm}`;
            document.getElementById('appointmentTime').textContent = formattedTime;
            document.getElementById('appointmentPurpose').textContent = appointment.purpose;
            document.getElementById('appointmentDescription').textContent = appointment.description;

            // Open the modal
            openModal('viewAppointmentModal');
        })
        .catch(error => {
            console.error('Error fetching appointment details:', error);
        });
}
</script> 