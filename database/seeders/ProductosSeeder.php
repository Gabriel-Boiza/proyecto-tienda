<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('productos')->insert([
            ['nombre' => 'Ratón Logitech G Pro', 'descripcion' => 'Ratón gaming profesional con sensor HERO', 'precio' => 89.99, 'stock' => 50, 'imagen_principal' => 'imagenes/logitech_gpro.jpg'],
            ['nombre' => 'Teclado mecánico Corsair K95', 'descripcion' => 'Teclado mecánico con retroiluminación RGB', 'precio' => 149.99, 'stock' => 30, 'imagen_principal' => 'imagenes/corsair_k95.jpg'],
            ['nombre' => 'Auriculares SteelSeries Arctis 7', 'descripcion' => 'Auriculares inalámbricos para gaming con sonido envolvente', 'precio' => 139.99, 'stock' => 15, 'imagen_principal' => 'imagenes/arctis_7.jpg'],
            ['nombre' => 'Mousepad Razer Goliathus', 'descripcion' => 'Alfombrilla de ratón de tela con iluminación RGB', 'precio' => 29.99, 'stock' => 100, 'imagen_principal' => 'imagenes/razer_goliathus.jpg'],
            ['nombre' => 'Monitor ASUS TUF Gaming', 'descripcion' => 'Monitor Full HD de 24" con tasa de refresco de 144Hz', 'precio' => 179.99, 'stock' => 20, 'imagen_principal' => 'imagenes/asus_tuf.jpg'],
            ['nombre' => 'Webcam Logitech C920', 'descripcion' => 'Cámara web HD para streaming y videollamadas', 'precio' => 69.99, 'stock' => 40, 'imagen_principal' => 'imagenes/logitech_c920.jpg'],
            ['nombre' => 'Teclado mecánico Razer Huntsman', 'descripcion' => 'Teclado con switches ópticos para una respuesta más rápida', 'precio' => 129.99, 'stock' => 25, 'imagen_principal' => 'imagenes/razer_huntsman.jpg'],
            ['nombre' => 'Ratón Razer DeathAdder V2', 'descripcion' => 'Ratón ergonómico con sensor óptico de 20,000 DPI', 'precio' => 69.99, 'stock' => 45, 'imagen_principal' => 'imagenes/deathadder_v2.jpg'],
            ['nombre' => 'Alfombrilla Logitech G640', 'descripcion' => 'Alfombrilla de gran tamaño para gamers', 'precio' => 19.99, 'stock' => 60, 'imagen_principal' => 'imagenes/logitech_g640.jpg'],
            ['nombre' => 'Silla gaming DXRacer Formula', 'descripcion' => 'Silla ergonómica para largas sesiones de gaming', 'precio' => 299.99, 'stock' => 10, 'imagen_principal' => 'imagenes/dxracer_formula.jpg']
        ]);

    }
}
