<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Company;
use App\Models\Role;
use App\Models\SolCredential;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules\Password;

class RegisterController extends Controller
{
    public function showForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name'         => ['required', 'string', 'max:255'],
            'email'        => ['required', 'email', 'max:255', 'unique:users,email'],
            'password'     => ['required', 'confirmed', Password::min(8)->mixedCase()->numbers()],
            'ruc'          => ['nullable', 'regex:/^\d{11}$/', 'unique:companies,ruc'],
            'razon_social' => ['required_with:ruc', 'nullable', 'string', 'max:255'],
            'usuario_sol'  => ['required_with:ruc', 'nullable', 'string', 'max:8'],
            'clave_sol'    => ['required_with:ruc', 'nullable', 'string', 'min:6'],
        ], [
            'ruc.regex'          => 'El RUC debe tener exactamente 11 dígitos.',
            'ruc.unique'         => 'Este RUC ya está registrado en el sistema.',
            'razon_social.required_with' => 'La Razón Social es obligatoria si ingresa un RUC.',
            'usuario_sol.required_with'  => 'El Usuario SOL es obligatorio si ingresa un RUC.',
            'clave_sol.required_with'    => 'La Clave SOL es obligatoria si ingresa un RUC.',
            'usuario_sol.max'    => 'El Usuario SOL no puede superar 8 caracteres (máximo SUNAT).',
        ]);

        DB::transaction(function () use ($request) {
            $role = Role::where('name', 'asistente')->firstOrFail();

            $user = User::create([
                'name'      => $request->name,
                'email'     => $request->email,
                'password'  => $request->password,
                'role_id'   => $role->id,
                'is_active' => true,
            ]);

            if ($request->filled('ruc')) {
                $company = Company::create([
                    'ruc'          => $request->ruc,
                    'razon_social' => strtoupper($request->razon_social),
                    'estado'       => 'ACTIVO',
                    'created_by'   => $user->id,
                ]);

                SolCredential::create([
                    'company_id'  => $company->id,
                    'usuario_sol' => strtoupper($request->usuario_sol),
                    'clave_sol'   => $request->clave_sol,
                    'created_by'  => $user->id,
                ]);
            }

            ActivityLog::record('register', "Nuevo contador registrado: {$user->email}", [
                'model_type' => User::class,
                'model_id'   => $user->id,
            ]);

            Auth::login($user);
        });

        return redirect()->route('dashboard')
            ->with('success', '¡Bienvenido! Tu cuenta ha sido creada correctamente.');
    }
}
