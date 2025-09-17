<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of users
     */
    public function index(Request $request)
    {
        $query = User::with('roles');
        
        // Search functionality
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }
        
        // Filter by role
        if ($request->has('role') && $request->role) {
            $query->whereHas('roles', function($q) use ($request) {
                $q->where('name', $request->role);
            });
        }
        
        $users = $query->paginate(10);
        $roles = Role::where('is_active', true)->get();
        
        return view('users.index', compact('users', 'roles'));
    }

    /**
     * Show the form for creating a new user
     */
    public function create()
    {
        $roles = Role::where('is_active', true)->get();
        return view('users.create', compact('roles'));
    }

    /**
     * Store a newly created user
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'roles' => 'array',
            'roles.*' => 'exists:roles,id'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'email_verified_at' => now()
        ]);

        // Assign roles
        if ($request->has('roles')) {
            $user->roles()->attach($request->roles);
        }

        return redirect()->route('users.index')
            ->with('success', 'User berhasil dibuat!');
    }

    /**
     * Display the specified user
     */
    public function show(User $user)
    {
        $user->load('roles');
        return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified user
     */
    public function edit(User $user)
    {
        $user->load('roles');
        $roles = Role::where('is_active', true)->get();
        $userRoleIds = $user->roles->pluck('id')->toArray();
        
        return view('users.edit', compact('user', 'roles', 'userRoleIds'));
    }

    /**
     * Update the specified user
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => 'nullable|string|min:8|confirmed',
            'roles' => 'array',
            'roles.*' => 'exists:roles,id'
        ]);

        $updateData = [
            'name' => $request->name,
            'email' => $request->email,
        ];

        // Update password if provided
        if ($request->filled('password')) {
            $updateData['password'] = Hash::make($request->password);
        }

        $user->update($updateData);

        // Sync roles
        $user->roles()->sync($request->roles ?? []);

        return redirect()->route('users.index')
            ->with('success', 'User berhasil diupdate!');
    }

    /**
     * Remove the specified user
     */
    public function destroy(User $user)
    {
        // Prevent deleting current user
        if ($user->id === auth()->id()) {
            return redirect()->route('users.index')
                ->with('error', 'Anda tidak bisa menghapus akun sendiri!');
        }

        $user->roles()->detach();
        $user->delete();

        return redirect()->route('users.index')
            ->with('success', 'User berhasil dihapus!');
    }

    /**
     * Toggle user status (activate/deactivate)
     */
    public function toggleStatus(User $user)
    {
        $user->update([
            'is_active' => !$user->is_active
        ]);

        $status = $user->is_active ? 'diaktifkan' : 'dinonaktifkan';
        
        return redirect()->back()
            ->with('success', "User berhasil {$status}!");
    }

    /**
     * Assign role to user
     */
    public function assignRole(Request $request, User $user)
    {
        $request->validate([
            'role_id' => 'required|exists:roles,id'
        ]);

        $role = Role::find($request->role_id);
        
        if (!$user->hasRole($role)) {
            $user->assignRole($role);
            return response()->json([
                'success' => true,
                'message' => "Role {$role->display_name} berhasil ditambahkan!"
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'User sudah memiliki role tersebut!'
        ]);
    }

    /**
     * Remove role from user
     */
    public function removeRole(Request $request, User $user)
    {
        $request->validate([
            'role_id' => 'required|exists:roles,id'
        ]);

        $role = Role::find($request->role_id);
        $user->removeRole($role);

        return response()->json([
            'success' => true,
            'message' => "Role {$role->display_name} berhasil dihapus!"
        ]);
    }
}