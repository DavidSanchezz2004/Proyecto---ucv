<?php

namespace App\Services;

class SunatService
{
    const SISTEMAS = [
        'menu' => [
            'nombre'       => 'Menú SOL',
            'icono'        => '🛡️',
            'descripcion'  => 'Operaciones en línea — Buzón, comprobantes, RUC',
            'oauthAppUuid' => '4f3b88b3-d9d6-402a-b85d-6a0bc857746a',
            'originalUrl'  => 'https://e-menu.sunat.gob.pe/cl-ti-itmenu/AutenticaMenuInternet.htm',
            'flow'         => 'classic',
            'startUrl'     => 'https://e-menu.sunat.gob.pe/cl-ti-itmenu/MenuInternet.htm',
            'color'        => '#dc2626',
        ],
        'pagos' => [
            'nombre'       => 'Declaraciones y Pagos',
            'icono'        => '💰',
            'descripcion'  => 'PLAME, DJ Anual, Formulario Virtual, Pagos a SUNAT',
            'oauthAppUuid' => '59d39217-c025-4de5-b342-393b0f4630ab',
            'originalUrl'  => 'https://e-menu.sunat.gob.pe/cl-ti-itmenu2/AutenticaMenuInternetPlataforma.htm',
            'flow'         => 'classic',
            'startUrl'     => 'https://e-menu.sunat.gob.pe/cl-ti-itmenu2/MenuInternetPlataforma.htm?pestana=*&agrupacion=*&exe=55.1.1.1.1',
            'color'        => '#2563eb',
        ],
        'sunafil' => [
            'nombre'       => 'SUNAFIL',
            'icono'        => '⛑️',
            'descripcion'  => 'Casilla Electrónica de Fiscalización Laboral',
            'oauthAppUuid' => 'b6474e23-8a3b-4153-b301-dafcc9646250',
            'originalUrl'  => 'https://casillaelectronica.sunafil.gob.pe/si.inbox/Login/Empresa',
            'flow'         => 'direct',
            'startUrl'     => null,
            'color'        => '#059669',
        ],
    ];

    public static function getSistemas(): array
    {
        return self::SISTEMAS;
    }

    public function getActionUrl(string $sistema): string
    {
        $uuid = self::SISTEMAS[$sistema]['oauthAppUuid'] ?? '';
        return "https://api-seguridad.sunat.gob.pe/v1/clientessol/{$uuid}/oauth2/j_security_check";
    }

    /**
     * Obtiene el state OAuth de SUNAT para el sistema indicado.
     * Retorna ['state', 'originalUrl', 'lang'] en éxito o ['error'] en fallo.
     */
    public function getState(string $sistema): array
    {
        $config = self::SISTEMAS[$sistema] ?? null;
        if (!$config) {
            return ['error' => 'Sistema no válido'];
        }

        if ($config['flow'] === 'direct') {
            return [
                'state'       => 's',
                'originalUrl' => $config['originalUrl'],
                'lang'        => 'es-PE',
            ];
        }

        // Flujo clásico: Menú SOL / Declaraciones y Pagos
        $ua = 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:130.0) Gecko/20100101 Firefox/130.0';
        $headers = [
            'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
            'Accept-Language: es-PE,es;q=0.9',
            'Accept-Encoding: gzip, deflate, br',
            'Upgrade-Insecure-Requests: 1',
        ];

        $cookieJar = tempnam(sys_get_temp_dir(), 'sunat_');

        try {
            // STEP 1: GET startUrl — buscar redirect OAuth
            $ch = curl_init($config['startUrl']);
            curl_setopt_array($ch, [
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_COOKIEJAR      => $cookieJar,
                CURLOPT_COOKIEFILE     => $cookieJar,
                CURLOPT_USERAGENT      => $ua,
                CURLOPT_HTTPHEADER     => $headers,
                CURLOPT_ENCODING       => '',
                CURLOPT_TIMEOUT        => 10,
                CURLOPT_CONNECTTIMEOUT => 6,
            ]);
            $html1 = curl_exec($ch);
            $code1 = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            if ($code1 !== 200 || !$html1) {
                throw new \Exception("SUNAT no disponible (HTTP {$code1})");
            }

            if (!preg_match('/redirect\("(https:\/\/api-seguridad\.sunat\.gob\.pe[^"]+)"\)/', $html1, $m)) {
                throw new \Exception('No se encontró redirect OAuth en SUNAT');
            }
            $authenUrl = $m[1];

            // STEP 2: GET authenUrl siguiendo redirecciones — extraer state
            $ch = curl_init($authenUrl);
            curl_setopt_array($ch, [
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_MAXREDIRS      => 6,
                CURLOPT_COOKIEJAR      => $cookieJar,
                CURLOPT_COOKIEFILE     => $cookieJar,
                CURLOPT_USERAGENT      => $ua,
                CURLOPT_HTTPHEADER     => $headers,
                CURLOPT_ENCODING       => '',
                CURLOPT_TIMEOUT        => 15,
                CURLOPT_CONNECTTIMEOUT => 6,
            ]);
            curl_exec($ch);
            $code2    = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $finalUrl = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);
            curl_close($ch);

            if ($code2 !== 200) {
                throw new \Exception("Error en OAuth SUNAT (HTTP {$code2})");
            }

            $parsed = parse_url($finalUrl);
            parse_str($parsed['query'] ?? '', $params);
            $state = $params['state'] ?? null;

            if (!$state) {
                throw new \Exception('SUNAT no devolvió el state OAuth');
            }

            return [
                'state'       => $state,
                'originalUrl' => $params['originalUrl'] ?? $config['originalUrl'],
                'lang'        => $params['lang'] ?? 'es-PE',
            ];
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        } finally {
            @unlink($cookieJar);
        }
    }
}
