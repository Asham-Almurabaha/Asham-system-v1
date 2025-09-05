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
    public function index()
    {
        // هنعرض كل المستخدمين مع أدوارهم
        $users = User::with('roles')->orderBy('id','asc')->paginate(15);
        return view('users.index', compact('users'));
    }

    public function create()
    {
        $roles = Role::orderBy('name')->pluck('name', 'name');
        return view('users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'roles'   => ['sometimes','array'],
            'roles.*' => ['string','exists:roles,name'],
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        $user->syncRoles($data['roles'] ?? []);

        return redirect()->route('users.index')->with('success', __('users.User created successfully'));
    }

    public function editUser(User $user)
    {
        $roles   = Role::orderBy('name')->pluck('name', 'name');
        $current = $user->roles->pluck('name')->toArray();
        return view('users.edit', compact('user','roles','current'));
    }

    public function updateUser(Request $request, User $user)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', UniqueRule::unique(User::class)->ignore($user->id)],
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
            'roles'   => ['sometimes','array'],
            'roles.*' => ['string','exists:roles,name'],
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

    public function edit(User $user)
    {
        // كل الأدوار المتاحة
        $roles   = Role::orderBy('name')->pluck('name', 'name'); // ['admin'=>'admin', ...]
        $current = $user->roles->pluck('name')->toArray();

        return view('users.edit-roles', compact('user','roles','current'));
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'roles'   => ['array'],
            'roles.*' => ['string','exists:roles,name'],
        ]);

        // استبدال الأدوار الحالية بالجديدة
        $user->syncRoles($data['roles'] ?? []);

        return redirect()
            ->route('users.index')
            ->with('success', 'تم تحديث أدوار المستخدم بنجاح.');
    }
}
