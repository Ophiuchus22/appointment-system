<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

/**
 * Handles user management operations
 * 
 * This controller manages administrative user operations including:
 * - Listing all users
 * - Creating new users (admin/regular)
 * - Editing user details
 * - Managing user roles and college offices
 * - User deletion with admin protection
 */
class UserController extends Controller
{
    /**
     * Display a listing of all users
     * 
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $users = User::all();
        return view('admin_side.users', compact('users'));
    }

    /**
     * Store a newly created user
     * 
     * Handles user creation with:
     * - Role-based validation
     * - Password hashing
     * - College office assignment for regular users
     * 
     * @param Request $request Contains user details and role
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Validate base requirements
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => 'required|in:admin,user',
        ];

        // Add college_office validation only if role is user
        if ($request->input('role') === 'user') {
            $rules['college_office'] = 'required|string|in:COLLEGE OF ARTS AND SCIENCES,COLLEGE OF BUSINESS EDUCATION,COLLEGE OF CRIMINAL JUSTICE,COLLEGE OF ENGINEERING AND TECHNOLOGY,COLLEGE OF TEACHER EDUCATION,COLLEGE OF ALLIED HEALTH SCIENCES,FINANCE OFFICE,CASHIER\'S OFFICE,REGISTRAR\'S OFFICE,GUIDANCE OFFICE,SSC OFFICE';
        }

        $validatedData = $request->validate($rules);

        // Create user with correct data
        $userData = [
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
            'role' => $validatedData['role'],
        ];

        // Only add college_office if role is user
        if ($validatedData['role'] === 'user') {
            $userData['college_office'] = $validatedData['college_office'];
        }

        User::create($userData);

        return redirect()->route('admin.users.index')
            ->with('success', 'User created successfully');
    }

    /**
     * Get user details for editing
     * 
     * @param int $id User ID
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return response()->json($user);
    }

    /**
     * Update user details
     * 
     * Handles updates including:
     * - Basic information
     * - Role-specific fields
     * - Optional password change
     * 
     * @param Request $request Contains updated user details
     * @param int $id User ID
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        // Base validation rules
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$id,
        ];

        // Add college_office validation if role is user
        if ($user->role === 'user') {
            $rules['college_office'] = 'required|string|in:COLLEGE OF ARTS AND SCIENCES,COLLEGE OF BUSINESS EDUCATION,COLLEGE OF CRIMINAL JUSTICE,COLLEGE OF ENGINEERING AND TECHNOLOGY,COLLEGE OF TEACHER EDUCATION,COLLEGE OF ALLIED HEALTH SCIENCES,FINANCE OFFICE,CASHIER\'S OFFICE,REGISTRAR\'S OFFICE,GUIDANCE OFFICE,SSC OFFICE';
        }

        // Add password validation if password is being changed
        if ($request->filled('password')) {
            $rules['password'] = ['required', 'confirmed', Rules\Password::defaults()];
        }

        $validatedData = $request->validate($rules);

        // Update basic info
        $user->name = $validatedData['name'];
        $user->email = $validatedData['email'];

        // Update college_office if user is not admin
        if ($user->role === 'user') {
            $user->college_office = $validatedData['college_office'];
        }

        // Update password if provided
        if ($request->filled('password')) {
            $user->password = Hash::make($validatedData['password']);
        }

        $user->save();

        return redirect()->route('admin.users.index')
            ->with('success', 'User updated successfully');
    }

    /**
     * Delete a user
     * 
     * Includes protection against deleting the last admin user
     * 
     * @param int $id User ID
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        try {
            $user = User::findOrFail($id);
            
            // Prevent deleting the last admin
            if ($user->role === 'admin') {
                $adminCount = User::where('role', 'admin')->count();
                if ($adminCount <= 1) {
                    return redirect()->route('admin.users.index')
                        ->with('error', 'Cannot delete the last admin user');
                }
            }

            $user->delete();

            return redirect()->route('admin.users.index')
                ->with('success', 'User deleted successfully');
        } catch (\Exception $e) {
            return redirect()->route('admin.users.index')
                ->with('error', 'An error occurred while deleting the user');
        }
    }
}