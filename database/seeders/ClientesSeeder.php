<?php

namespace Database\Seeders;

use App\Models\Cliente;
use Illuminate\Database\Seeder;

class ClientesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     */
    public function run()
    {
        Cliente::create([
            'nombre' => 'Juan',
            'apellido' => 'Pérez',
            'email' => 'juan.perez@example.com',
            'telefono' => '612345678',
            'direccion' => 'Calle Falsa 123, Ciudad, País',
            'password' => bcrypt('password123'),
        ]);
        
        Cliente::create([
            'nombre' => 'Ana',
            'apellido' => 'Gómez',
            'email' => 'ana.gomez@example.com',
            'telefono' => '612345679',
            'direccion' => 'Avenida Principal 456, Ciudad, País',
            'password' => bcrypt('password456'),
        ]);
        

    }
}
