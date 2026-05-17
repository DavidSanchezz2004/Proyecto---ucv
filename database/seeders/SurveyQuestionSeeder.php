<?php

namespace Database\Seeders;

use App\Models\SurveyQuestion;
use Illuminate\Database\Seeder;

class SurveyQuestionSeeder extends Seeder
{
    public function run(): void
    {
        $questions = [
            // Variable Independiente: Automatización del acceso al Menú SOL
            // Dimensión: Reducción de pasos manuales
            [1,  'Variable Independiente', 'Reducción de pasos manuales',    'El acceso automatizado redujo los pasos necesarios para ingresar al Menú SOL.'],
            [2,  'Variable Independiente', 'Reducción de pasos manuales',    'El sistema evitó copiar y pegar credenciales manualmente.'],
            [3,  'Variable Independiente', 'Reducción de pasos manuales',    'El flujo de acceso fue más simple que el ingreso manual.'],
            // Dimensión: Automatización del inicio de sesión
            [4,  'Variable Independiente', 'Automatización del inicio de sesión', 'El sistema facilitó el inicio de sesión al Menú SOL.'],
            [5,  'Variable Independiente', 'Automatización del inicio de sesión', 'El botón de acceso directo ayudó a iniciar más rápido las tareas tributarias.'],
            [6,  'Variable Independiente', 'Automatización del inicio de sesión', 'El acceso automatizado evitó repetir acciones manuales.'],
            // Dimensión: Facilidad de uso
            [7,  'Variable Independiente', 'Facilidad de uso',               'El sistema fue fácil de entender y utilizar.'],
            [8,  'Variable Independiente', 'Facilidad de uso',               'El botón Menú SOL fue cómodo de utilizar.'],
            [9,  'Variable Independiente', 'Facilidad de uso',               'La automatización ayudó a usuarios con menor dominio digital.'],

            // Variable Dependiente: Eficiencia operativa
            // Dimensión: Optimización del tiempo
            [10, 'Variable Dependiente',   'Optimización del tiempo',        'El sistema permitió ahorrar tiempo al ingresar al Menú SOL.'],
            [11, 'Variable Dependiente',   'Optimización del tiempo',        'El acceso automatizado ayudó a iniciar más rápido las tareas tributarias.'],
            [12, 'Variable Dependiente',   'Optimización del tiempo',        'La reducción de tiempo favoreció el avance del trabajo contable.'],
            // Dimensión: Disminución de errores
            [13, 'Variable Dependiente',   'Disminución de errores',         'El sistema ayudó a reducir errores al ingresar credenciales.'],
            [14, 'Variable Dependiente',   'Disminución de errores',         'El acceso automatizado disminuyó los intentos fallidos de ingreso.'],
            [15, 'Variable Dependiente',   'Disminución de errores',         'El sistema redujo equivocaciones al copiar datos de acceso.'],
            // Dimensión: Capacidad de respuesta operativa
            [16, 'Variable Dependiente',   'Capacidad de respuesta operativa', 'El acceso rápido al Menú SOL permitió atender mejor las solicitudes.'],
            [17, 'Variable Dependiente',   'Capacidad de respuesta operativa', 'El sistema ayudó a mantener la continuidad del trabajo contable.'],
            [18, 'Variable Dependiente',   'Capacidad de respuesta operativa', 'La automatización mejoró la fluidez de las actividades contables.'],
        ];

        foreach ($questions as [$order, $variable, $dimension, $text]) {
            SurveyQuestion::updateOrCreate(
                ['order_number' => $order],
                [
                    'variable'      => $variable,
                    'dimension'     => $dimension,
                    'order_number'  => $order,
                    'question_text' => $text,
                    'is_active'     => true,
                ]
            );
        }
    }
}
