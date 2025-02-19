<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MarcaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('marcas')->insert([
            ['nombre' => 'Logitech'],
            ['nombre' => 'Razer'],
            ['nombre' => 'Corsair'],
            ['nombre' => 'SteelSeries'],
            ['nombre' => 'HyperX'],
            ['nombre' => 'ASUS ROG'],
            ['nombre' => 'MSI'],
            ['nombre' => 'Cooler Master'],
            ['nombre' => 'Thermaltake'],
            ['nombre' => 'EVGA'],
            ['nombre' => 'Gigabyte Aorus'],
            ['nombre' => 'Zowie'],
            ['nombre' => 'Ducky'],
            ['nombre' => 'Glorious'],
            ['nombre' => 'Redragon'],
            ['nombre' => 'Trust Gaming'],
            ['nombre' => 'Mad Catz'],
            ['nombre' => 'Turtle Beach'],
            ['nombre' => 'BenQ'],
            ['nombre' => 'AOC'],
            ['nombre' => 'HP Omen'],
            ['nombre' => 'Dell Alienware'],
            ['nombre' => 'XPG'],
            ['nombre' => 'NZXT'],
        ]);
        
    }
}
