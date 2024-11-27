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
            @include('admin_side.sidebar')

            <!-- Main Content -->
            <div class="flex-1 p-8">
                <div class="bg-white rounded-lg shadow-md p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h1 class="text-2xl font-bold">User Management</h1>
                        <div class="relative">
                            <button 
                                onclick="toggleDropdown(event)" 
                                class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md"
                                id="dropdownButton"
                            >
                                Add New Account
                            </button>
                            <div id="dropdownMenu" class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg hidden">
                                <ul class="py-1">
                                    <li>
                                        <button onclick="openAddAdminModal()" class="w-full text-left px-4 py-2 text-gray-700 hover:bg-gray-100">
                                            Add Admin
                                        </button>
                                    </li>
                                    <li>
                                        <button onclick="openAddUserModal()" class="w-full text-left px-4 py-2 text-gray-700 hover:bg-gray-100">
                                            Add User
                                        </button>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    @if(session('success'))
                        <div id="success-message" class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div id="error-message" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                            {{ session('error') }}
                        </div>
                    @endif

                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            const successMessage = document.getElementById('success-message');
                            const errorMessage = document.getElementById('error-message');
                            
                            // Function to handle message dismissal
                            function dismissMessage(messageElement) {
                                if (messageElement) {
                                    setTimeout(function() {
                                        messageElement.classList.add('fade-out');
                                        setTimeout(function() {
                                            messageElement.remove();
                                        }, 500); // Additional 500ms for fade-out animation
                                    }, 3000); // 3 seconds
                                }
                            }

                            // Dismiss success message if exists
                            dismissMessage(successMessage);
                            
                            // Dismiss error message if exists
                            dismissMessage(errorMessage);
                        });
                    </script>

                    <!-- Users Table (unchanged) -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">College</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach($users as $user)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $user->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $user->email }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ ucfirst($user->role) }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $user->college }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <button onclick="openEditModal({{ $user->id }}, '{{ $user->role }}')" class="text-blue-600 hover:text-blue-900 mr-3">Edit</button>
                                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Are you sure you want to delete this user?')">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Add User Modal -->
        <div id="addUserModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden">
            <div class="flex items-center justify-center min-h-screen">
                <div class="bg-white rounded-lg shadow-xl p-6 w-full max-w-md">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-xl font-bold">Add New User</h2>
                        <button onclick="closeAddUserModal()" class="text-gray-500 hover:text-gray-700">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                    <form action="{{ route('admin.users.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="role" value="user">
                        
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Name</label>
                            <input type="text" name="name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Email</label>
                            <input type="email" name="email" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">College</label>
                            <select name="college" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                                <option value="">Select College</option>
                                <option value="COLLEGE OF ARTS AND SCIENCES">College of Arts and Sciences</option>
                                <option value="COLLEGE OF BUSINESS EDUCATION">College of Business Education</option>
                                <option value="COLLEGE OF CRIMINAL JUSTICE">College of Criminal Justice</option>
                                <option value="COLLEGE OF ENGINEERING AND TECHNOLOGY">College of Engineering and Technology</option>
                                <option value="COLLEGE OF TEACHER EDUCATION">College of Teacher Education</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Password</label>
                            <input type="password" name="password" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                            <p class="text-xs text-gray-600 mt-2">
                                Password must be at least 8 characters long and contains at least one number.
                            </p>
                        </div>

                        <div class="mb-6">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Confirm Password</label>
                            <input type="password" name="password_confirmation" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                        </div>

                        <div class="flex justify-end">
                            <button type="button" onclick="closeAddUserModal()" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded mr-2">Cancel</button>
                            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">Add User</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Add Admin Modal -->
        <div id="addAdminModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden">
            <div class="flex items-center justify-center min-h-screen">
                <div class="bg-white rounded-lg shadow-xl p-6 w-full max-w-md">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-xl font-bold">Add New Admin</h2>
                        <button onclick="closeAddAdminModal()" class="text-gray-500 hover:text-gray-700">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                    <form action="{{ route('admin.users.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="role" value="admin">
                        
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Name</label>
                            <input type="text" name="name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Email</label>
                            <input type="email" name="email" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Password</label>
                            <input type="password" name="password" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                            <p class="text-xs text-gray-600 mt-2">
                                Password must be at least 8 characters long and contains at least one number.
                            </p>
                        </div>

                        <div class="mb-6">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Confirm Password</label>
                            <input type="password" name="password_confirmation" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                        </div>

                        <div class="flex justify-end">
                            <button type="button" onclick="closeAddAdminModal()" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded mr-2">Cancel</button>
                            <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded">Add Admin</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Edit User Modal -->
        <div id="editUserModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden">
            <div class="flex items-center justify-center min-h-screen">
                <div class="bg-white rounded-lg shadow-xl p-6 w-full max-w-md">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-xl font-bold">Edit User</h2>
                        <button onclick="closeEditModal()" class="text-gray-500 hover:text-gray-700">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                    <form id="editUserForm" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="role" value="user">
                        
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Name</label>
                            <input type="text" name="name" id="edit_user_name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Email</label>
                            <input type="email" name="email" id="edit_user_email" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">College</label>
                            <select name="college" id="edit_user_college" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                                <option value="">Select College</option>
                                <option value="COLLEGE OF ARTS AND SCIENCES">College of Arts and Sciences</option>
                                <option value="COLLEGE OF BUSINESS EDUCATION">College of Business Education</option>
                                <option value="COLLEGE OF CRIMINAL JUSTICE">College of Criminal Justice</option>
                                <option value="COLLEGE OF ENGINEERING AND TECHNOLOGY">College of Engineering and Technology</option>
                                <option value="COLLEGE OF TEACHER EDUCATION">College of Teacher Education</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">New Password (leave blank to keep current)</label>
                            <input type="password" name="password" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            <p class="text-xs text-gray-600 mt-2">
                                Password must be at least 8 characters long and contains at least one number.
                            </p>
                        </div>

                        <div class="mb-6">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Confirm New Password</label>
                            <input type="password" name="password_confirmation" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        </div>

                        <div class="flex justify-end">
                            <button type="button" onclick="closeModal('editUserModal')" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded mr-2">
                            Cancel
                        </button>
                        <button type="submit" class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                            Update User
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Modal management functions
    function openAddUserModal() {
        document.getElementById('addUserModal').classList.remove('hidden');
    }

    function closeAddUserModal() {
        document.getElementById('addUserModal').classList.add('hidden');
    }

    function openAddAdminModal() {
        document.getElementById('addAdminModal').classList.remove('hidden');
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
                
                // Handle college field visibility
                const collegeSelect = document.getElementById('edit_user_college');
                if (userRole === 'user') {
                    collegeSelect.parentElement.style.display = 'block';
                    collegeSelect.value = user.college;
                } else {
                    collegeSelect.parentElement.style.display = 'none';
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

        // Close the dropdown if clicking outside of the dropdown or the button
        if (!dropdownMenu.contains(event.target) && event.target !== dropdownButton) {
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