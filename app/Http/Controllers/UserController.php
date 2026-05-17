<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $users = User::with('role')
            ->when($request->q, fn($q, $term) => $q->where('name', 'like', "%$term%")->orWhere('email', 'like', "%$term%"))
            ->orderBy('name')
            ->paginate(15)
            ->withQueryString();

        return view('users.index', compact('users'));
    }

    public function create()
    {
        $roles = Role::all();
        return view('users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role_id'  => ['required', 'exists:roles,id'],
        ]);

        $user = User::create([
            ...$data,
            'password' => Hash::make($data['password']),
        ]);

        ActivityLog::record('create_user', "Usuario creado: {$user->email}", [
            'model_type' => User::class,
            'model_id'   => $user->id,
        ]);

        return redirect()->route('users.index')
            ->with('success', "Usuario {$user->name} creado correctamente.");
    }

    public function edit(User $user)
    {
        $roles = Role::all();
        return view('users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'role_id'  => ['required', 'exists:roles,id'],
        ]);

        $updateData = [
            'name'    => $data['name'],
            'email'   => $data['email'],
            'role_id' => $data['role_id'],
        ];

        if (!empty($data['password'])) {
            $updateData['password'] = Hash::make($data['password']);
        }

        $user->update($updateData);

        ActivityLog::record('update_user', "Usuario actualizado: {$user->email}", [
            'model_type' => User::class,
            'model_id'   => $user->id,
        ]);

        return redirect()->route('users.index')
            ->with('success', "Usuario {$user->name} actualizado correctamente.");
    }

    public function toggle(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->withErrors(['error' => 'No puedes desactivar tu propia cuenta.']);
        }

        $user->update(['is_active' => !$user->is_active]);
        $estado = $user->is_active ? 'activado' : 'desactivado';

        ActivityLog::record('toggle_user', "Usuario {$estado}: {$user->email}", [
            'model_type' => User::class,
            'model_id'   => $user->id,
        ]);

        return back()->with('success', "Usuario {$user->name} {$estado} correctamente.");
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->withErrors(['error' => 'No puedes eliminar tu propia cuenta.']);
        }

        ActivityLog::record('delete_user', "Usuario eliminado: {$user->email}");
        $user->delete();

        return redirect()->route('users.index')
            ->with('success', "Usuario eliminado correctamente.");
    }
}
