<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $adminRole = Role::where('name', 'admin')->firstOrFail();

        // Solo el administrador del sistema — cambia email y contraseña antes de deploy
        User::updateOrCreate(
            ['email' => env('ADMIN_EMAIL', 'admin@sol.test')],
            [
                'name'      => 'Administrador',
                'password'  => Hash::make(env('ADMIN_PASSWORD', 'Admin@123')),
                'role_id'   => $adminRole->id,
                'is_active' => true,
            ]
        );
    }
}
