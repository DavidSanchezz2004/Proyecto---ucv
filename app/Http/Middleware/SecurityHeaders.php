<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityHeaders
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Eliminar cabeceras que revelan tecnología
        $response->headers->remove('X-Powered-By');
        $response->headers->remove('Server');

        // HSTS — fuerza HTTPS por 2 años incluyendo subdominios
        $response->headers->set('Strict-Transport-Security', 'max-age=63072000; includeSubDomains; preload');

        // Anti-MIME-Sniffing
        $response->headers->set('X-Content-Type-Options', 'nosniff');

        // Anti-Clickjacking
        $response->headers->set('X-Frame-Options', 'SAMEORIGIN');

        // XSS — desactivado (legacy, deprecated; CSP es la defensa real)
        $response->headers->set('X-XSS-Protection', '0');

        // Referrer
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');

        // Permissions Policy — deshabilitar features no usadas
        $response->headers->set('Permissions-Policy',
            'camera=(), microphone=(), geolocation=(), payment=(), usb=(), ' .
            'accelerometer=(), gyroscope=(), magnetometer=(), ' .
            'interest-cohort=(), browsing-topics=()'
        );

        // Cross-Origin policies — protección contra side-channel (Spectre-class)
        $response->headers->set('Cross-Origin-Opener-Policy', 'same-origin');
        $response->headers->set('Cross-Origin-Resource-Policy', 'same-site');

        // Cache-Control — evitar que el browser cachee páginas autenticadas en disco
        if (auth()->check()) {
            $response->headers->set('Cache-Control', 'no-store, max-age=0, private');
        }

        // Content Security Policy
        $csp = implode('; ', [
            "default-src 'self'",
            "script-src 'self' 'unsafe-inline' 'unsafe-eval' https://cdn.jsdelivr.net",
            "style-src 'self' 'unsafe-inline' https://cdn.jsdelivr.net https://fonts.googleapis.com",
            "font-src 'self' https://fonts.gstatic.com https://cdn.jsdelivr.net data:",
            "img-src 'self' data: https://lh3.googleusercontent.com",
            "connect-src 'self' https://cdn.jsdelivr.net",
            "frame-ancestors 'self'",
            "base-uri 'self'",
            "form-action 'self' https://e-menu.sunat.gob.pe https://api-sso.sunat.gob.pe https://api-seguridad.sunat.gob.pe",
        ]);
        $response->headers->set('Content-Security-Policy', $csp);

        return $response;
    }
}
