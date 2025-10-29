<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'nombres' => 'Administrador',
            'apellido_paterno' => 'Inicial',
            'email' => 'admin@ejemplo.com',
            'password' => 'password123',
            'rol' => 'administrador',
            'estado' => 'activo',
        ]);
    }
}
