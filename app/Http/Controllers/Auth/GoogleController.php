<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
        } catch (\Exception $e) {
            return redirect()->route('login')
                ->with('error', 'No se pudo conectar con Google. Intenta nuevamente.');
        }

        // Usuario ya registrado con Google → login directo
        $user = User::where('google_id', $googleUser->getId())->first();

        if ($user) {
            if (!$user->is_active) {
                return redirect()->route('login')
                    ->with('error', 'Tu cuenta está desactivada. Contacta al administrador.');
            }
            $user->update(['last_login_at' => now()]);
            Auth::login($user);
            ActivityLog::record('login', "Inicio de sesión con Google: {$user->email}");
            return redirect()->intended(route('dashboard'));
        }

        // Usuario con mismo email pero sin google_id → vincular
        $existing = User::where('email', $googleUser->getEmail())->first();
        if ($existing) {
            $existing->update([
                'google_id'     => $googleUser->getId(),
                'google_avatar' => $googleUser->getAvatar(),
                'last_login_at' => now(),
            ]);
            Auth::login($existing);
            ActivityLog::record('login', "Cuenta vinculada con Google: {$existing->email}");
            return redirect()->intended(route('dashboard'));
        }

        // Nuevo usuario → guardar datos en sesión y pedir T&C
        session([
            'google_pending' => [
                'google_id'     => $googleUser->getId(),
                'name'          => $googleUser->getName(),
                'email'         => $googleUser->getEmail(),
                'avatar'        => $googleUser->getAvatar(),
            ]
        ]);

        return redirect()->route('google.terms');
    }

    public function showTerms()
    {
        if (!session('google_pending')) {
            return redirect()->route('register');
        }
        return view('auth.google-terms');
    }

    public function completeRegistration(Request $request)
    {
        $request->validate([
            'terms' => ['accepted'],
        ], [
            'terms.accepted' => 'Debes leer y aceptar los Términos y Condiciones para continuar.',
        ]);

        $pending = session('google_pending');
        if (!$pending) {
            return redirect()->route('register');
        }

        $asistente = Role::where('name', 'asistente')->first();

        $user = User::create([
            'name'               => $pending['name'],
            'email'              => $pending['email'],
            'google_id'          => $pending['google_id'],
            'google_avatar'      => $pending['avatar'],
            'password'           => bcrypt(\Illuminate\Support\Str::random(32)),
            'password_set'       => false,
            'role_id'            => $asistente?->id,
            'is_active'          => true,
            'terms_accepted_at'  => now(),
            'terms_accepted_ip'  => $request->ip(),
            'last_login_at'      => now(),
        ]);

        session()->forget('google_pending');
        Auth::login($user);

        ActivityLog::record('register', "Registro con Google: {$user->email}");

        return redirect()->route('dashboard')
            ->with('terms_accepted', true);
    }
}
