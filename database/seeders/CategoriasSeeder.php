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
        $categorias = [
            'Teclados',
            'Ratones',
            'Monitores',
            'Auriculares',
            'Altavoces',
            'Micrófonos',
            'destacado',
        ];

        foreach ($categorias as $categoria) {
            DB::table('categorias')->updateOrInsert(
                ['nombre_categoria' => $categoria],
                ['nombre_categoria' => $categoria]
            );
        }
    }
}
