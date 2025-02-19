<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('categorias')->insert([
            ['nombre_categoria' => 'Teclados'],
            ['nombre_categoria' => 'Ratones'],
            ['nombre_categoria' => 'Monitores'],
            ['nombre_categoria' => 'Auriculares'],
            ['nombre_categoria' => 'Altavoces'],
            ['nombre_categoria' => 'Micrófonos'],
            ['nombre_categoria' => 'destacado'],
        ]);
    }
}
