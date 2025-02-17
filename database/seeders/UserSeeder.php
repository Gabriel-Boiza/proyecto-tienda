<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Crear un usuario de prueba
        User::create([
            'name' => 'Administrador',
            'email' => 'admin@example.com',
            'password' => Hash::make('password123'), // Usa Hash::make() para cifrar la contraseña
        ]);

        // Crear más usuarios si es necesario
        User::create([
            'name' => 'Usuario de prueba',
            'email' => 'user@example.com',
            'password' => Hash::make('password123'),
        ]);

        // Si usas Factory, también puedes generar varios usuarios de forma más sencilla
        // User::factory(10)->create(); // Esto creará 10 usuarios utilizando una fábrica (si la tienes definida)
    }
}

