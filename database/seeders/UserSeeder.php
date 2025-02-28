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
            'password' => Hash::make('a'), // Usa Hash::make() para cifrar la contraseña
        ]);

        // Crear más usuarios si es necesario
        User::create([
            'name' => 'Usuario de prueba',
            'email' => 'user@example.com',
            'password' => Hash::make('a'),
        ]);


    }
}

