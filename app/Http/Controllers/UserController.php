<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('username', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $users = $query->latest()->paginate(12);

        $roles = [
            'owner' => 'Owner / Admin',
            'sales' => 'Sales Executive',
            'smm' => 'Social Media Manager',
            'designer' => 'Senior Designer',
            'motion' => 'Motion Designer',
            'video' => 'Video Editor',
            'seo' => 'SEO & Web Developer',
            'mediabuyer' => 'Media Buyer'
        ];

        return view('team.index', compact('users', 'roles'));
    }

    public function create()
    {
        $roles = [
            'owner' => 'Owner / Admin',
            'sales' => 'Sales Executive',
            'smm' => 'Social Media Manager',
            'designer' => 'Senior Designer',
            'motion' => 'Motion Designer',
            'video' => 'Video Editor',
            'seo' => 'SEO & Web Developer',
            'mediabuyer' => 'Media Buyer'
        ];

        return view('team.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username',
            'email' => 'nullable|email|max:255|unique:users,email',
            'password' => 'required|string|min:6',
            'role' => 'required|in:owner,sales,smm,designer,motion,video,seo,developer,mediabuyer',
            'color' => 'nullable|string|max:20',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'username' => strtolower($validated['username']),
            'email' => $validated['email'] ?? null,
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
            'color' => $validated['color'] ?? '#64748b',
            'active' => true,
        ]);

        return redirect()->route('team.index')->with('success', "Team member '{$user->name}' created successfully!");
    }

    public function edit(User $user)
    {
        $roles = [
            'owner' => 'Owner / Admin',
            'sales' => 'Sales Executive',
            'smm' => 'Social Media Manager',
            'designer' => 'Senior Designer',
            'motion' => 'Motion Designer',
            'video' => 'Video Editor',
            'seo' => 'SEO & Web Developer',
            'mediabuyer' => 'Media Buyer'
        ];

        return view('team.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
            'email' => 'nullable|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:6',
            'role' => 'required|in:owner,sales,smm,designer,motion,video,seo,developer,mediabuyer',
            'color' => 'nullable|string|max:20',
            'active' => 'required|boolean',
        ]);

        $data = [
            'name' => $validated['name'],
            'username' => strtolower($validated['username']),
            'email' => $validated['email'] ?? null,
            'role' => $validated['role'],
            'color' => $validated['color'] ?? '#64748b',
            'active' => $validated['active'],
        ];

        if (!empty($validated['password'])) {
            $data['password'] = Hash::make($validated['password']);
        }

        $user->update($data);

        return redirect()->route('team.index')->with('success', "User '{$user->name}' updated successfully!");
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', "You cannot delete yourself!");
        }

        $user->update(['active' => false]);
        return redirect()->route('team.index')->with('success', "User '{$user->name}' deactivated!");
    }
}
