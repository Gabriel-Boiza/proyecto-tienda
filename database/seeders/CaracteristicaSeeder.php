<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CaracteristicaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('caracteristicas')->insert([
            ['nombre' => 'Switches rojos, RGB.'],
            ['nombre' => 'Sensor 16000 DPI, 6 botones.'],
            ['nombre' => 'Bluetooth, batería 1000mAh.'],
            ['nombre' => 'Diseño vertical, sensor óptico.'],
            ['nombre' => '60%, teclas PBT, USB-C.'],
            ['nombre' => 'Peso 60g, cable paracord.'],
            ['nombre' => 'Teclas dedicadas, retroiluminado.'],
            ['nombre' => 'Conexión 2.4GHz, batería recargable.'],
            ['nombre' => 'Estilo máquina de escribir, teclas redondas.'],
            ['nombre' => 'Clicks silenciosos, diseño compacto.'],
        ]);
    }
}
