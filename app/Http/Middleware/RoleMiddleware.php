<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        if (!$user->is_active) {
            Auth::logout();
            $request->session()->invalidate();
            return redirect()->route('login')
                ->withErrors(['email' => 'Tu cuenta está desactivada. Contacta al administrador.']);
        }

        if (!empty($roles) && !$user->hasRole(...$roles)) {
            abort(403, 'No tienes permiso para acceder a esta sección.');
        }

        return $next($request);
    }
}
