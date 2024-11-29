<!-- resources/views/admin_side/Modals/add_admin_modal.blade.php -->
<div id="addAdminModal" class="fixed inset-0 bg-black bg-opacity-60 backdrop-blur-sm hidden">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-2xl shadow-2xl p-8 w-full max-w-md transform transition-all">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-semibold text-gray-800">Add New Admin</h2>
                <button onclick="closeAddAdminModal()" class="text-gray-400 hover:text-gray-600 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            
            <form action="{{ route('admin.users.store') }}" method="POST">
                @csrf
                <input type="hidden" name="role" value="admin">
                
                <div class="space-y-5">
                    <div class="relative">
                        <label class="text-gray-700 text-sm font-medium mb-1 block">Name</label>
                        <input type="text" name="name" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all" required>
                    </div>

                    <div class="relative">
                        <label class="text-gray-700 text-sm font-medium mb-1 block">Email</label>
                        <input type="email" name="email" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all" required>
                    </div>

                    <div class="relative">
                        <label class="text-gray-700 text-sm font-medium mb-1 block">Password</label>
                        <input type="password" name="password" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all" required>
                        <p class="text-sm text-gray-500 mt-2">
                            Password must be at least 8 characters long and contains at least one number.
                        </p>
                    </div>

                    <div class="relative">
                        <label class="text-gray-700 text-sm font-medium mb-1 block">Confirm Password</label>
                        <input type="password" name="password_confirmation" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all" required>
                    </div>
                </div>

                <div class="flex justify-end space-x-3 mt-8">
                    <button type="button" onclick="closeAddAdminModal()" 
                        class="px-5 py-2.5 rounded-lg bg-gray-100 text-gray-700 hover:bg-gray-200 font-medium transition-all">
                        Cancel
                    </button>
                    <button type="submit" 
                        class="px-5 py-2.5 rounded-lg bg-blue-600 text-white hover:bg-blue-700 font-medium transition-all">
                        Add Admin
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>