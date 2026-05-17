<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => ['required', 'email', 'max:255'],
            'password' => ['required', 'string'],
        ]);

        $email = strtolower(trim($request->email));
        $user  = User::where('email', $email)->first();

        // Verifica si la cuenta está bloqueada
        if ($user && $user->isLocked()) {
            $minutes = now()->diffInMinutes($user->locked_until);
            throw ValidationException::withMessages([
                'email' => "Cuenta bloqueada por múltiples intentos fallidos. Intente en {$minutes} minuto(s).",
            ]);
        }

        if (!Auth::attempt(['email' => $email, 'password' => $request->password], $request->boolean('remember'))) {
            if ($user) {
                $user->increment('login_attempts');
                // Bloquea tras 5 intentos fallidos
                if ($user->login_attempts >= 5) {
                    $user->update(['locked_until' => now()->addMinutes(15)]);
                    ActivityLog::record('account_locked', "Cuenta bloqueada: {$email}");
                }
            }
            ActivityLog::record('login_failed', "Intento fallido: {$email}");
            throw ValidationException::withMessages([
                'email' => 'Las credenciales no coinciden con nuestros registros.',
            ]);
        }

        // Login exitoso
        $user->update([
            'login_attempts' => 0,
            'locked_until'   => null,
            'last_login_at'  => now(),
        ]);

        $request->session()->regenerate();
        ActivityLog::record('login', "Inicio de sesión: {$user->email}");

        return redirect()->intended(route('dashboard'));
    }

    public function logout(Request $request)
    {
        ActivityLog::record('logout', 'Cierre de sesión');
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login')->with('success', 'Has cerrado sesión correctamente.');
    }
}
