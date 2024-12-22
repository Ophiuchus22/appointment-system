<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('admin_side.users', compact('users'));
    }

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

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return response()->json($user);
    }

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

    public function destroy($id)
    {
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
    }
}