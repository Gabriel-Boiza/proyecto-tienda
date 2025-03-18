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
        $clientes = [
            [
                'nombre' => 'Juan',
                'apellido' => 'Pérez',
                'email' => 'juan.perez@example.com',
                'telefono' => '612345678',
                'direccion' => 'Calle Falsa 123',
                'ciudad' => 'Ciudad',
                'codigo_postal' => '08001',
                'pais' => 'España',
                'password' => bcrypt('aaaaaa'),
            ],
            [
                'nombre' => 'Ana',
                'apellido' => 'Gómez',
                'email' => 'ana.gomez@example.com',
                'telefono' => '612345679',
                'direccion' => 'Avenida Principal 456',
                'ciudad' => 'Ciudad',
                'codigo_postal' => '08002',
                'pais' => 'España',
                'password' => bcrypt('password456'),
            ]
        ];
        
        foreach ($clientes as $cliente) {
            Cliente::create($cliente);
        } 
        

    }
}
