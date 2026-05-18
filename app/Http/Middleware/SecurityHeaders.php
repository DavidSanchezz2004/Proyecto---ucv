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

        // Anti-MIME-Sniffing
        $response->headers->set('X-Content-Type-Options', 'nosniff');

        // Anti-Clickjacking
        $response->headers->set('X-Frame-Options', 'SAMEORIGIN');

        // XSS Protection (legacy browsers)
        $response->headers->set('X-XSS-Protection', '1; mode=block');

        // Referrer
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');

        // Permissions Policy
        $response->headers->set('Permissions-Policy', 'camera=(), microphone=(), geolocation=()');

        // Content Security Policy
        // CDNs usados: jsdelivr (Bootstrap, Alpine, Chart.js, Bootstrap Icons)
        //              Google Fonts (fonts.googleapis.com, fonts.gstatic.com)
        $csp = implode('; ', [
            "default-src 'self'",
            "script-src 'self' 'unsafe-inline' 'unsafe-eval' https://cdn.jsdelivr.net",
            "style-src 'self' 'unsafe-inline' https://cdn.jsdelivr.net https://fonts.googleapis.com",
            "font-src 'self' https://fonts.gstatic.com https://cdn.jsdelivr.net data:",
            "img-src 'self' data:",
            "connect-src 'self' https://cdn.jsdelivr.net",
            "frame-ancestors 'self'",
            "base-uri 'self'",
            "form-action 'self' https://*.sunat.gob.pe",
        ]);
        $response->headers->set('Content-Security-Policy', $csp);

        return $response;
    }
}
