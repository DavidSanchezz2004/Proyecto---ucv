<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Línea base de acceso manual al Menú SOL (segundos)
    |--------------------------------------------------------------------------
    | Estimación del tiempo promedio que tarda un asistente contable en
    | ingresar manualmente al Menú SOL de SUNAT (buscar URL, escribir RUC,
    | usuario y contraseña). Usado en los reportes de eficiencia.
    */
    'manual_baseline_seconds' => 30,

    /*
    |--------------------------------------------------------------------------
    | Pasos de la simulación de acceso automatizado
    |--------------------------------------------------------------------------
    | Cada paso tiene un label descriptivo y una duración en milisegundos.
    | El total aproximado es ~2800 ms, lo que demuestra la reducción de tiempo
    | frente a los 30 segundos del acceso manual.
    */
    'simulation_steps' => [
        ['label' => 'Conectando al portal SUNAT...', 'duration_ms' => 600],
        ['label' => 'Identificando contribuyente...', 'duration_ms' => 400],
        ['label' => 'Ingresando RUC del contribuyente...', 'duration_ms' => 350],
        ['label' => 'Ingresando usuario SOL...', 'duration_ms' => 350],
        ['label' => 'Ingresando clave SOL cifrada...', 'duration_ms' => 350],
        ['label' => 'Verificando credenciales autorizadas...', 'duration_ms' => 500],
        ['label' => 'Acceso al Menú SOL completado ✓', 'duration_ms' => 250],
    ],
];
