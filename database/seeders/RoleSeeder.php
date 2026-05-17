<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            ['name' => 'admin',      'display_name' => 'Administrador',      'description' => 'Acceso total al sistema. Gestiona usuarios, empresas, credenciales y reportes.'],
            ['name' => 'supervisor', 'display_name' => 'Supervisor',          'description' => 'Visualiza empresas, historial de accesos y reportes de eficiencia.'],
            ['name' => 'asistente',  'display_name' => 'Asistente Contable',  'description' => 'Accede al Menú SOL de empresas asignadas y completa la encuesta piloto.'],
        ];

        foreach ($roles as $role) {
            Role::updateOrCreate(['name' => $role['name']], $role);
        }
    }
}
