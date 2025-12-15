<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRoleRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','verified','admin']);
    }

    public function index(): View
    {
        $users = User::with('roles')
            ->orderBy('name')
            ->paginate(15);

        return view('users.index', compact('users'));
    }

    public function create(): View
    {
        $roles = Role::orderBy('name')->get();

        return view('users.create', compact('roles'));
    }

    public function store(StoreUserRequest $request): RedirectResponse
    {
        $data = $request->validated();

        $user = User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        $roleNames = $data['roles'] ?? [];
        if (!empty($roleNames)) {
            $roleIds = Role::whereIn('name', $roleNames)->pluck('id')->all();
            $user->roles()->sync($roleIds);
        }

        return redirect()
            ->route('users.index')
            ->with('success', 'User baru berhasil dibuat.');
    }

    public function edit(User $user): View
    {
        $roles = Role::orderBy('name')->get();

        return view('users.edit', compact('user','roles'));
    }

    public function update(UpdateUserRoleRequest $request, User $user): RedirectResponse
    {
        $data      = $request->validated();
        $roleNames = $data['roles'] ?? [];

        $roleIds = Role::whereIn('name', $roleNames)->pluck('id')->all();
        $user->roles()->sync($roleIds);

        return redirect()
            ->route('users.index')
            ->with('success', 'Role user diperbarui.');
    }

    public function destroy(User $user): RedirectResponse
    {
        if (auth()->id() === $user->id) {
            return back()->with('error', 'Tidak bisa menghapus akun sendiri.');
        }

        $user->roles()->detach();
        $user->delete();

        return redirect()
            ->route('users.index')
            ->with('success', 'User berhasil dihapus.');
    }
}
