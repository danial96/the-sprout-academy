<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserManagementController extends Controller
{
    /**
     * List all employee users.
     */
    public function index()
    {
        $employees = User::where('role', 'employee')->orderByDesc('created_at')->get();

        return view('backend.pages.users.index', compact('employees'));
    }

    /**
     * Show form for creating a new employee user.
     */
    public function create()
    {
        return view('backend.pages.users.create');
    }

    /**
     * Store a newly created employee user.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8'],
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => 'employee',
        ]);

        // Optionally mark as verified so they don't see verify email screens
        $user->forceFill([
            'email_verified_at' => now(),
        ])->save();

        return redirect()
            ->route('admin.users.index')
            ->with('status', "Employee user created successfully. Email: {$user->email}");
    }

    /**
     * Show form for editing employee user password.
     */
    public function edit($id)
    {
        $employee = User::where('role', 'employee')->findOrFail($id);
        return view('backend.pages.users.edit', compact('employee'));
    }

    /**
     * Update employee user password.
     */
    public function update(Request $request, $id)
    {
        $employee = User::where('role', 'employee')->findOrFail($id);

        $data = $request->validate([
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $employee->update([
            'password' => Hash::make($data['password']),
        ]);

        return redirect()
            ->route('admin.users.index')
            ->with('status', "Password updated successfully for {$employee->email}");
    }
}


