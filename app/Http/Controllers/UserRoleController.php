<?php

namespace App\Http\Controllers;

use App\Models\User;
use Modules\Org\Models\Branch;
use Illuminate\Support\Facades\Auth;
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
        $query = User::with(['roles', 'branch'])->orderBy('id', 'asc');
        if (!Auth::user()->hasRole('admin')) {
            $query->where('branch_id', Auth::user()->branch_id);
        }
        $users = $query->paginate(15);
        return view('users.index', compact('users'));
    }

    // Resource: GET /users/create
    public function create()
    {
        $roles = Role::orderBy('name')->pluck('name', 'name');
        $branches = Branch::where('is_active', true)->orderBy('name');
        if (!Auth::user()->hasRole('admin')) {
            $branches->where('id', Auth::user()->branch_id);
        }
        $branches = $branches->get();
        return view('users.create', compact('roles', 'branches'));
    }

    // Resource: POST /users
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'branch_id' => ['required', 'exists:branches,id'],
            'roles' => ['sometimes', 'array'],
            'roles.*' => ['string', 'exists:roles,name'],
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'branch_id' => $data['branch_id'],
        ]);

        $user->syncRoles($data['roles'] ?? []);

        return redirect()->route('users.index')->with('success', __('users.User created successfully'));
    }

    // Resource: GET /users/{user}
    public function show(User $user)
    {
        $user->load('roles', 'branch');
        return view('users.show', compact('user'));
    }

    // Resource: GET /users/{user}/edit
    public function edit(User $user)
    {
        $roles = Role::orderBy('name')->pluck('name', 'name');
        $branches = Branch::where('is_active', true)->orderBy('name');
        if (!Auth::user()->hasRole('admin')) {
            $branches->where('id', Auth::user()->branch_id);
        }
        $branches = $branches->get();
        $current = $user->roles->pluck('name')->toArray();
        return view('users.edit', compact('user', 'roles', 'current', 'branches'));
    }

    // Resource: PUT/PATCH /users/{user}
    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', UniqueRule::unique(User::class)->ignore($user->id)],
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
            'branch_id' => ['required', 'exists:branches,id'],
            'roles' => ['sometimes', 'array'],
            'roles.*' => ['string', 'exists:roles,name'],
        ]);

        $user->name = $data['name'];
        $user->email = $data['email'];
        if (!empty($data['password'])) {
            $user->password = Hash::make($data['password']);
        }
        $user->branch_id = $data['branch_id'];
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

