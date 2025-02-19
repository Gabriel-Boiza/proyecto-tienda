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
            ['nombre' => 'Ratón Logitech G Pro', 'descripcion' => 'Ratón gaming profesional con sensor HERO', 'precio' => 89.99, 'stock' => 50, 'imagen_principal' => 'productos/imagen1.jpeg', 'descuento' => 0],
            ['nombre' => 'Teclado mecánico Corsair K95', 'descripcion' => 'Teclado mecánico con retroiluminación RGB', 'precio' => 149.99, 'stock' => 30, 'imagen_principal' => 'productos/imagen2.jpeg', 'descuento' => 0],
            ['nombre' => 'Auriculares SteelSeries Arctis 7', 'descripcion' => 'Auriculares inalámbricos para gaming con sonido envolvente', 'precio' => 139.99, 'stock' => 15, 'imagen_principal' => 'productos/imagen3.jpeg', 'descuento' => 0],
            ['nombre' => 'Mousepad Razer Goliathus', 'descripcion' => 'Alfombrilla de ratón de tela con iluminación RGB', 'precio' => 29.99, 'stock' => 100, 'imagen_principal' => 'productos/imagen1.jpeg', 'descuento' => 0],
            ['nombre' => 'Monitor ASUS TUF Gaming', 'descripcion' => 'Monitor Full HD de 24" con tasa de refresco de 144Hz', 'precio' => 179.99, 'stock' => 20, 'imagen_principal' => 'productos/imagen4.jpeg', 'descuento' => 0],
            ['nombre' => 'Webcam Logitech C920', 'descripcion' => 'Cámara web HD para streaming y videollamadas', 'precio' => 69.99, 'stock' => 40, 'imagen_principal' => 'productos/imagen5.jpeg', 'descuento' => 0],
            ['nombre' => 'Teclado mecánico Razer Huntsman', 'descripcion' => 'Teclado con switches ópticos para una respuesta más rápida', 'precio' => 129.99, 'stock' => 25, 'imagen_principal' => 'productos/imagen2.jpeg', 'descuento' => 0],
            ['nombre' => 'Ratón Razer DeathAdder V2', 'descripcion' => 'Ratón ergonómico con sensor óptico de 20,000 DPI', 'precio' => 69.99, 'stock' => 45, 'imagen_principal' => 'productos/imagen5.jpeg', 'descuento' => 0],
            ['nombre' => 'Alfombrilla Logitech G640', 'descripcion' => 'Alfombrilla de gran tamaño para gamers', 'precio' => 19.99, 'stock' => 60, 'imagen_principal' => 'productos/imagen2.jpeg', 'descuento' => 0],
            ['nombre' => 'Silla gaming DXRacer Formula', 'descripcion' => 'Silla ergonómica para largas sesiones de gaming', 'precio' => 299.99, 'stock' => 10, 'imagen_principal' => 'productos/imagen3.jpeg', 'descuento' => 0]
        ]);
    }
}

