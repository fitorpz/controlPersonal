<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'nombres' => 'Administrador',
            'apellido_paterno' => 'Principal',
            'apellido_materno' => null,
            'email' => 'admin@example.com',
            'password' => Hash::make('password123'),
            'rol' => 'administrador',
            'estado' => 'activo',
            'creado_por' => null,
            'actualizado_por' => null,
        ]);
    }
}
