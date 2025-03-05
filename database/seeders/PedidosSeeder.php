<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PedidosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('pedidos')->insert([
            [
                'cliente_id' => 1,
                'total' => 150.75,
                'estado' => 'pendiente',
            ],
            [
                'cliente_id' => 2,
                'total' => 89.99,
                'estado' => 'enviado',
            ],
            [
                'cliente_id' => 1,
                'total' => 250.50,
                'estado' => 'enviado',
            ],
            [
                'cliente_id' => 1,
                'total' => 120.00,
                'estado' => 'entregado',
            ],
            [
                'cliente_id' => 2,
                'total' => 55.10,
                'estado' => 'cancelado',
            ],
        ]);
    }
}
