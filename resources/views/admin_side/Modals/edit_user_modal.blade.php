<!-- resources/views/admin_side/Modals/edit_user_modal.blade.php -->
<div id="editUserModal" class="fixed inset-0 bg-black bg-opacity-60 backdrop-blur-sm hidden">
    <div class="flex items-center justify-center min-h-screen p-2">
        <div class="bg-white rounded-2xl shadow-2xl p-6 w-full max-w-md transform transition-all">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-2xl font-semibold text-gray-800">Edit User</h2>
                <button onclick="closeEditModal()" class="text-gray-400 hover:text-gray-600 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            
            <form id="editUserForm" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="role" value="user">
                
                <div class="space-y-4">
                    <div class="relative">
                        <label class="text-gray-700 text-sm font-medium mb-0.5 block">Name</label>
                        <input type="text" name="name" id="edit_user_name" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all" required>
                    </div>

                    <div class="relative">
                        <label class="text-gray-700 text-sm font-medium mb-1 block">Email</label>
                        <input type="email" name="email" id="edit_user_email" 
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all" required>
                    </div>

                    <div class="relative">
                        <label class="text-gray-700 text-sm font-medium mb-1 block">College/Office</label>
                        <select name="college_office" id="edit_user_college" 
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all appearance-none bg-white" required>
                            <option value="">Select College/Office</option>
                            <option value="COLLEGE OF ARTS AND SCIENCES">College of Arts and Sciences</option>
                            <option value="COLLEGE OF BUSINESS EDUCATION">College of Business Education</option>
                            <option value="COLLEGE OF CRIMINAL JUSTICE">College of Criminal Justice</option>
                            <option value="COLLEGE OF ENGINEERING AND TECHNOLOGY">College of Engineering and Technology</option>
                            <option value="COLLEGE OF TEACHER EDUCATION">College of Teacher Education</option>
                            <option value="COLLEGE OF ALLIED HEALTH SCIENCES">College of Allied Health Sciences</option>
                            <option value="FINANCE OFFICE">Finance Office</option>
                            <option value="CASHIER'S OFFICE">Cashier's Office</option>
                            <option value="REGISTRAR'S OFFICE">Registrar's Office</option>
                            <option value="GUIDANCE OFFICE">Guidance Office</option>
                            <option value="SSC OFFICE">SSC Office</option>
                        </select>
                        <div class="absolute right-3 top-[60%] pointer-events-none">
                            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                    </div>

                    <div class="relative">
                        <label class="text-gray-700 text-sm font-medium mb-1 block">New Password (leave blank to keep current)</label>
                        <input type="password" name="password" 
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
                        <p class="text-sm text-gray-500 mt-2">
                            Password must be at least 8 characters long and contains at least one number.
                        </p>
                    </div>

                    <div class="relative">
                        <label class="text-gray-700 text-sm font-medium mb-1 block">Confirm New Password</label>
                        <input type="password" name="password_confirmation" 
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
                    </div>
                </div>

                <div class="flex justify-end space-x-3 mt-6">
                    <button type="button" onclick="closeEditModal()" 
                        class="px-5 py-2.5 rounded-lg bg-gray-100 text-gray-700 hover:bg-gray-200 font-medium transition-all">
                        Cancel
                    </button>
                    <button type="submit" 
                        class="px-5 py-2.5 rounded-lg bg-blue-600 text-white hover:bg-blue-700 font-medium transition-all">
                        Update User
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>