<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $this->call([
            MarcaSeeder::class,
            CategoriasSeeder::class,
            UserSeeder::class,
            CaracteristicaSeeder::class,
            ClientesSeeder::class,
            PedidosSeeder::class,
            ProductosSeeder::class,
            CuponesSedeer::class,
        ]);
    }
}
