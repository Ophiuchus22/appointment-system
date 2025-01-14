<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management</title>
    <link rel="icon" type="image/png" href="{{ asset('logo/system-logo.png') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/shepherd.js@10.0.1/dist/css/shepherd.css"/>
    <script src="https://cdn.jsdelivr.net/npm/shepherd.js@10.0.1/dist/js/shepherd.min.js"></script>
</head>
<body class="bg-gray-100">
        <div class="flex">
            @include('layouts.sidebar')

            <!-- Main Content -->
            <div class="flex-1 p-8">
                <div class="bg-white rounded-xl shadow-sm border border-gray-100">
                    <!-- Header Section -->
                    <div class="p-6 border-b border-gray-100">
                        <div class="flex justify-between items-center">
                            <div>
                                <h1 class="text-2xl font-bold text-gray-800">User Management</h1>
                                <p class="text-sm text-gray-500 mt-1">Manage administrators and users</p>
                            </div>
                            <div class="flex space-x-3">
                                <button id="startTour" 
                                    class="group relative inline-flex items-center px-4 py-2.5 text-sm font-medium bg-gradient-to-r from-blue-50 to-indigo-50 text-blue-600 border border-blue-200 rounded-lg hover:from-blue-100 hover:to-indigo-100 hover:border-blue-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200 shadow-sm">
                                    <span class="absolute inset-0 bg-gradient-to-r from-blue-500/0 to-indigo-500/0 group-hover:from-blue-500/5 group-hover:to-indigo-500/5 rounded-lg transition-all duration-200"></span>
                                    <svg class="w-5 h-5 mr-2 text-blue-500 group-hover:text-blue-600 transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3c-3.75 0-6.75 2.25-6.75 6.75 0 1.875.75 3.375 1.875 4.5L8.25 21h7.5l1.125-6.75c1.125-1.125 1.875-2.625 1.875-4.5C18.75 5.25 15.75 3 12 3z"/>
                                    </svg>
                                    <span class="relative">Help Guide</span>
                                    <span class="absolute -top-1 -right-1 h-3 w-3 bg-blue-500 rounded-full ring-2 ring-white animate-pulse" id="helpNotificationDot"></span>
                                </button>
                                <button 
                                    onclick="toggleDropdown(event)" 
                                    class="inline-flex items-center px-4 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all duration-200"
                                    id="dropdownButton"
                                >
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                    </svg>
                                    Add New Account
                                </button>
                                <div id="dropdownMenu" class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg hidden border border-gray-100 overflow-hidden z-50">
                                    <ul class="py-1">
                                        <li>
                                            <button onclick="openAddAdminModal()" class="w-full text-left px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 flex items-center">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                                </svg>
                                                Add Admin
                                            </button>
                                        </li>
                                        <li>
                                            <button onclick="openAddUserModal()" class="w-full text-left px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 flex items-center">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                                </svg>
                                                Add User
                                            </button>
                                        </li>
                                    </ul>
                                </div>
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

                    <!-- Table Section -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Name</th>
                                    <th class="px-6 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Email</th>
                                    <th class="px-6 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Role</th>
                                    <th class="px-6 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">College/Office</th>
                                    <th class="px-6 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($users as $user)
                                <tr class="hover:bg-gray-50 transition-colors duration-200">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $user->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $user->email }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2.5 py-1 text-xs font-medium rounded-full {{ $user->role === 'admin' ? 'bg-purple-100 text-purple-700' : 'bg-blue-100 text-blue-700' }}">
                                            {{ ucfirst($user->role) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $user->college_office }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        <div class="flex items-center space-x-3">
                                            <button 
                                                onclick="openEditModal({{ $user->id }}, '{{ $user->role }}')" 
                                                class="text-blue-600 hover:text-blue-900 flex items-center">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                </svg>
                                                Edit
                                            </button>
                                            <button 
                                                onclick="deleteUser({{ $user->id }})" 
                                                class="text-red-600 hover:text-red-900 flex items-center">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                                Delete
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        @include('admin_side.Modals.add_user_modal')
        @include('admin_side.Modals.add_admin_modal')
        @include('admin_side.Modals.edit_user_modal')
        @include('admin_side.Modals.confirmation_modal')

    <script>
        // Add this at the beginning of your script section
        document.addEventListener('DOMContentLoaded', function() {
            // Handle success message
            const successMessage = document.getElementById('success-message');
            if (successMessage) {
                setTimeout(() => {
                    successMessage.classList.add('fade-out');
                    setTimeout(() => {
                        successMessage.style.display = 'none';
                    }, 500); // Wait for fade animation to complete
                }, 3000);
            }

            // Handle error message
            const errorMessage = document.getElementById('error-message');
            if (errorMessage) {
                setTimeout(() => {
                    errorMessage.classList.add('fade-out');
                    setTimeout(() => {
                        errorMessage.style.display = 'none';
                    }, 500); // Wait for fade animation to complete
                }, 3000);
            }
        });

        // Modal management functions
    function openAddUserModal() {
        document.getElementById('addUserModal').classList.remove('hidden');
        // Close dropdown when modal opens
        document.getElementById('dropdownMenu').classList.add('hidden');
    }

    function closeAddUserModal() {
        document.getElementById('addUserModal').classList.add('hidden');
    }

    function openAddAdminModal() {
        document.getElementById('addAdminModal').classList.remove('hidden');
        // Close dropdown when modal opens
        document.getElementById('dropdownMenu').classList.add('hidden');
    }

    function closeAddAdminModal() {
        document.getElementById('addAdminModal').classList.add('hidden');
    }

    function openEditModal(userId, userRole) {
        // Get the edit modal element
        const modal = document.getElementById('editUserModal');
        
        // Fetch user data
        fetch(`/admin/users/${userId}/edit`)
            .then(response => response.json())
            .then(user => {
                // Update form action URL
                document.getElementById('editUserForm').action = `/admin/users/${userId}`;
                
                // Fill in the form fields
                document.getElementById('edit_user_name').value = user.name;
                document.getElementById('edit_user_email').value = user.email;
                
                // Handle college field visibility and value
                const collegeField = document.getElementById('edit_user_college');
                const collegeContainer = collegeField.parentElement;
                
                if (userRole === 'user') {
                    collegeContainer.style.display = 'block';
                    collegeField.value = user.college_office;
                    collegeField.required = true;
                } else {
                    collegeContainer.style.display = 'none';
                    collegeField.value = '';
                    collegeField.required = false;
                }
                
                // Show the modal
                modal.classList.remove('hidden');
            })
            .catch(error => {
                console.error('Error fetching user data:', error);
                alert('There was an error loading user data. Please try again.');
            });
    }

    function closeEditModal() {
        document.getElementById('editUserModal').classList.add('hidden');
    }

    // Generic modal close function
    function closeModal(modalId) {
        document.getElementById(modalId).classList.add('hidden');
    }

    // Close modals when clicking outside
    document.addEventListener('DOMContentLoaded', function() {
        const modals = ['addUserModal', 'addAdminModal', 'editUserModal'];
        
        window.addEventListener('click', function(event) {
            modals.forEach(modalId => {
                const modal = document.getElementById(modalId);
                if (event.target === modal) {
                    closeModal(modalId);
                }
            });
        });

        // Add form submission handlers
        const forms = document.querySelectorAll('form');
        forms.forEach(form => {
            form.addEventListener('submit', function(e) {
                const passwordField = form.querySelector('input[name="password"]');
                const confirmPasswordField = form.querySelector('input[name="password_confirmation"]');
                
                if (passwordField.value || confirmPasswordField.value) {
                    if (passwordField.value !== confirmPasswordField.value) {
                        e.preventDefault();
                        alert('Passwords do not match!');
                        return false;
                    }
                }
            });
        });
    });

    // Handle escape key to close modals
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            const modals = ['addUserModal', 'addAdminModal', 'editUserModal'];
            modals.forEach(modalId => {
                const modal = document.getElementById(modalId);
                if (!modal.classList.contains('hidden')) {
                    closeModal(modalId);
                }
            });
        }
    });

    function toggleDropdown(event) {
        event.stopPropagation(); // Prevent the event from bubbling up to the document
        const dropdownMenu = document.getElementById('dropdownMenu');
        dropdownMenu.classList.toggle('hidden');
    }

    document.addEventListener('click', function (event) {
        const dropdownMenu = document.getElementById('dropdownMenu');
        const dropdownButton = document.getElementById('dropdownButton');
        const modals = ['addUserModal', 'addAdminModal', 'editUserModal'];
        
        // Check if any modal is visible
        const isAnyModalVisible = modals.some(modalId => 
            !document.getElementById(modalId).classList.contains('hidden')
        );

        // If clicking outside dropdown and button, or if a modal is visible, close the dropdown
        if ((!dropdownMenu.contains(event.target) && event.target !== dropdownButton) || isAnyModalVisible) {
            dropdownMenu.classList.add('hidden');
        }
    });

    // Notification functions
    function showSuccessNotification(message) {
        const notification = document.createElement('div');
        notification.className = 'fixed top-4 right-4 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg shadow-lg transition-all duration-500 transform translate-x-0 z-50';
        notification.innerHTML = `
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span>${message}</span>
            </div>
        `;
        
        document.body.appendChild(notification);
        
        setTimeout(() => {
            notification.style.opacity = '0';
            setTimeout(() => notification.remove(), 500);
        }, 3000);
    }

    function showErrorNotification(message) {
        const notification = document.createElement('div');
        notification.className = 'fixed top-4 right-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg shadow-lg transition-all duration-500 transform translate-x-0 z-50';
        notification.innerHTML = `
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span>${message}</span>
            </div>
        `;
        
        document.body.appendChild(notification);
        
        setTimeout(() => {
            notification.style.opacity = '0';
            setTimeout(() => notification.remove(), 500);
        }, 5000);
    }

    // Modal handling function
    function showConfirmationModal(title, message, onConfirm) {
        const modal = document.getElementById('confirmationModal');
        const titleElement = document.getElementById('modal-title');
        const messageElement = document.getElementById('modal-message');
        const confirmButton = document.getElementById('confirmButton');
        const cancelButton = document.getElementById('cancelButton');

        titleElement.textContent = title;
        messageElement.textContent = message;

        modal.classList.remove('hidden');

        const handleConfirm = () => {
            modal.classList.add('hidden');
            confirmButton.removeEventListener('click', handleConfirm);
            cancelButton.removeEventListener('click', handleCancel);
            onConfirm();
        };

        const handleCancel = () => {
            modal.classList.add('hidden');
            confirmButton.removeEventListener('click', handleConfirm);
            cancelButton.removeEventListener('click', handleCancel);
        };

        confirmButton.addEventListener('click', handleConfirm);
        cancelButton.addEventListener('click', handleCancel);
    }

    // User deletion function
    function deleteUser(userId) {
        showConfirmationModal(
            'Delete User',
            'Are you sure you want to delete this user? This action cannot be undone.',
            () => {
                // Create a form dynamically
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `/admin/users/${userId}`;
                
                // Add CSRF token
                const csrfToken = document.createElement('input');
                csrfToken.type = 'hidden';
                csrfToken.name = '_token';
                csrfToken.value = '{{ csrf_token() }}';
                form.appendChild(csrfToken);
                
                // Add method field
                const methodField = document.createElement('input');
                methodField.type = 'hidden';
                methodField.name = '_method';
                methodField.value = 'DELETE';
                form.appendChild(methodField);
                
                // Add form to document and submit it
                document.body.appendChild(form);
                form.submit();
            }
        );
    }

    document.addEventListener('DOMContentLoaded', function() {
        const tour = new Shepherd.Tour({
            useModalOverlay: true,
            defaultStepOptions: {
                classes: 'shadow-xl bg-white rounded-xl border border-gray-100',
                scrollTo: { behavior: 'smooth', block: 'center' },
                cancelIcon: {
                    enabled: true
                }
            }
        });

        // Welcome step
        tour.addStep({
            id: 'welcome',
            text: `
                <div class="text-gray-800 animate-fade-in">
                    <h3 class="text-xl font-semibold mb-3 text-blue-600">Welcome to User Management! 👋</h3>
                    <p class="mb-4">This guide will help you understand how to manage administrators and users in the system.</p>
                    <div class="bg-blue-50 p-4 rounded-lg">
                        <p class="text-sm text-blue-600">💡 Tip: You can restart this tour anytime using the Help Guide button.</p>
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

        // Add New Account step
        tour.addStep({
            id: 'add-account',
            attachTo: {
                element: '#dropdownButton',
                on: 'bottom'
            },
            text: `
                <div class="text-gray-800">
                    <h3 class="text-lg font-semibold mb-3 text-blue-600">Adding New Accounts</h3>
                    <div class="space-y-4">
                        <p class="text-sm">Click "Add New Account" to create:</p>
                        <div class="space-y-2">
                            <div class="flex items-center space-x-2 p-2 bg-purple-50 rounded-lg">
                                <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                </svg>
                                <span class="text-sm text-purple-700">Administrators - Full system access</span>
                            </div>
                            <div class="flex items-center space-x-2 p-2 bg-blue-50 rounded-lg">
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                                <span class="text-sm text-blue-700">Users - College/Office specific access</span>
                            </div>
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

        // User Table step
        tour.addStep({
            id: 'user-table',
            attachTo: {
                element: 'table',
                on: 'bottom'
            },
            text: `
                <div class="text-gray-800">
                    <h3 class="text-lg font-semibold mb-3 text-blue-600">User Management Table</h3>
                    <div class="space-y-4">
                        <p class="text-sm">The table shows all users with their details:</p>
                        <ul class="space-y-2 text-sm">
                            <li class="flex items-center space-x-2">
                                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                                <span>Name and Email</span>
                            </li>
                            <li class="flex items-center space-x-2">
                                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                </svg>
                                <span>Role (Admin/User)</span>
                            </li>
                            <li class="flex items-center space-x-2">
                                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                </svg>
                                <span>College/Office Assignment</span>
                            </li>
                        </ul>
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

        // User Actions step
        tour.addStep({
            id: 'user-actions',
            attachTo: {
                element: 'table tbody tr:first-child td:last-child',
                on: 'left'
            },
            text: `
                <div class="text-gray-800">
                    <h3 class="text-lg font-semibold mb-3 text-blue-600">Managing Users</h3>
                    <div class="space-y-4">
                        <p class="text-sm">Available actions for each user:</p>
                        <div class="space-y-2">
                            <div class="flex items-center space-x-2 p-2 bg-blue-50 rounded-lg">
                                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                                <span class="text-sm">Edit - Update user information</span>
                            </div>
                            <div class="flex items-center space-x-2 p-2 bg-red-50 rounded-lg">
                                <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                                <span class="text-sm">Delete - Remove user access</span>
                            </div>
                        </div>
                        <div class="bg-yellow-50 p-3 rounded-lg">
                            <p class="text-sm text-yellow-700">⚠️ Note: The system prevents deletion of the last admin user for security.</p>
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

        // Completion step
        tour.addStep({
            id: 'completion',
            text: `
                <div class="text-gray-800">
                    <h3 class="text-lg font-semibold mb-3 text-blue-600">You're All Set! 🎉</h3>
                    <div class="space-y-4">
                        <p>You now know how to manage users in the system. Remember:</p>
                        <div class="bg-gray-50 p-4 rounded-lg space-y-2">
                            <p class="text-sm">👥 Carefully assign user roles</p>
                            <p class="text-sm">🔐 Maintain secure password practices</p>
                            <p class="text-sm">🏢 Assign correct college/office for users</p>
                            <p class="text-sm">⚡ Use quick actions for efficient management</p>
                        </div>
                        <div class="mt-4 text-sm text-gray-600">
                            Need a refresher? Click the Help Guide button anytime!
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

        // Handle tour button and notification dot
        const notificationDot = document.getElementById('helpNotificationDot');
        
        if (localStorage.getItem('userManagementTourShown')) {
            notificationDot.classList.add('hidden');
        }

        document.getElementById('startTour').addEventListener('click', () => {
            tour.start();
            notificationDot.classList.add('hidden');
            localStorage.setItem('userManagementTourShown', 'true');
        });
    });
    </script>

    <style>
        .fade-out {
            opacity: 0;
            transition: opacity 0.5s ease-out;
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

        /* Additional Tour Element Styles */
        .shepherd-has-title .shepherd-content .shepherd-header {
            @apply bg-gray-50 rounded-t-xl px-4 py-2;
        }

        .shepherd-element {
            max-width: 400px;
            z-index: 100;
        }

        .shepherd-modal-overlay-container {
            z-index: 99;
        }
    </style>
</body>
</html>