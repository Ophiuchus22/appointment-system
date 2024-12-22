<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
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
                                <p class="text-sm text-gray-500 mt-1">Manage system users and administrators</p>
                            </div>
                            <div class="relative">
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
                                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                    class="text-red-600 hover:text-red-900 flex items-center"
                                                    onclick="return confirm('Are you sure you want to delete this user?')">
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                    </svg>
                                                    Delete
                                                </button>
                                            </form>
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
    </script>

    <style>
        .fade-out {
            opacity: 0;
            transition: opacity 0.5s ease-out;
        }
    </style>
</body>
</html>