<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\Rule as UniqueRule;

class UserRoleController extends Controller
{
    // Resource: GET /users
    public function index()
    {
        $users = User::with('roles')->orderBy('id', 'asc')->paginate(15);
        return view('users.index', compact('users'));
    }

    // Resource: GET /users/create
    public function create()
    {
        $roles = Role::orderBy('name')->pluck('name', 'name');
        return view('users.create', compact('roles'));
    }

    // Resource: POST /users
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'roles' => ['sometimes', 'array'],
            'roles.*' => ['string', 'exists:roles,name'],
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        $user->syncRoles($data['roles'] ?? []);

        return redirect()->route('users.index')->with('success', __('users.User created successfully'));
    }

    // Resource: GET /users/{user}
    public function show(User $user)
    {
        $user->load('roles');
        return view('users.show', compact('user'));
    }

    // Resource: GET /users/{user}/edit
    public function edit(User $user)
    {
        $roles = Role::orderBy('name')->pluck('name', 'name');
        $current = $user->roles->pluck('name')->toArray();
        return view('users.edit', compact('user', 'roles', 'current'));
    }

    // Resource: PUT/PATCH /users/{user}
    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', UniqueRule::unique(User::class)->ignore($user->id)],
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
            'roles' => ['sometimes', 'array'],
            'roles.*' => ['string', 'exists:roles,name'],
        ]);

        $user->name = $data['name'];
        $user->email = $data['email'];
        if (!empty($data['password'])) {
            $user->password = Hash::make($data['password']);
        }
        $user->save();

        $user->syncRoles($data['roles'] ?? []);

        return redirect()->route('users.index')->with('success', __('users.User updated successfully'));
    }

    // Resource: DELETE /users/{user}
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', __('users.User deleted successfully'));
    }
}

