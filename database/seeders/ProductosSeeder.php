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
            ['nombre' => 'Ratón Logitech G Pro', 'descripcion' => 'Ratón gaming profesional con sensor HERO', 'precio' => 89.99, 'stock' => 0, 'imagen_principal' => 'productos/imagen1.jpeg', 'descuento' => 0, 'fk_marca' => 1], // Logitech
            ['nombre' => 'Teclado mecánico Corsair K95', 'descripcion' => 'Teclado mecánico con retroiluminación RGB', 'precio' => 149.99, 'stock' => 30, 'imagen_principal' => 'productos/imagen2.jpeg', 'descuento' => 0, 'fk_marca' => 2], // Corsair
            ['nombre' => 'Auriculares SteelSeries Arctis 7', 'descripcion' => 'Auriculares inalámbricos para gaming con sonido envolvente', 'precio' => 139.99, 'stock' => 15, 'imagen_principal' => 'productos/imagen3.jpeg', 'descuento' => 0, 'fk_marca' => 3], // SteelSeries
            ['nombre' => 'Mousepad Razer Goliathus', 'descripcion' => 'Alfombrilla de ratón de tela con iluminación RGB', 'precio' => 29.99, 'stock' => 100, 'imagen_principal' => 'productos/imagen1.jpeg', 'descuento' => 0, 'fk_marca' => 4], // Razer
            ['nombre' => 'Monitor ASUS TUF Gaming', 'descripcion' => 'Monitor Full HD de 24" con tasa de refresco de 144Hz', 'precio' => 179.99, 'stock' => 20, 'imagen_principal' => 'productos/imagen4.jpeg', 'descuento' => 0, 'fk_marca' => 5], // ASUS ROG
            ['nombre' => 'Webcam Logitech C920', 'descripcion' => 'Cámara web HD para streaming y videollamadas', 'precio' => 69.99, 'stock' => 40, 'imagen_principal' => 'productos/imagen5.jpeg', 'descuento' => 0, 'fk_marca' => 1], // Logitech
            ['nombre' => 'Teclado mecánico Razer Huntsman', 'descripcion' => 'Teclado con switches ópticos para una respuesta más rápida', 'precio' => 129.99, 'stock' => 25, 'imagen_principal' => 'productos/imagen2.jpeg', 'descuento' => 0, 'fk_marca' => 4], // Razer
            ['nombre' => 'Ratón Razer DeathAdder V2', 'descripcion' => 'Ratón ergonómico con sensor óptico de 20,000 DPI', 'precio' => 69.99, 'stock' => 45, 'imagen_principal' => 'productos/imagen5.jpeg', 'descuento' => 0, 'fk_marca' => 4], // Razer
            ['nombre' => 'Alfombrilla Logitech G640', 'descripcion' => 'Alfombrilla de gran tamaño para gamers', 'precio' => 19.99, 'stock' => 60, 'imagen_principal' => 'productos/imagen2.jpeg', 'descuento' => 0, 'fk_marca' => 1], // Logitech
            ['nombre' => 'Silla gaming DXRacer Formula', 'descripcion' => 'Silla ergonómica para largas sesiones de gaming', 'precio' => 299.99, 'stock' => 10, 'imagen_principal' => 'productos/imagen3.jpeg', 'descuento' => 0, 'fk_marca' => 6] // DXRacer
        ]);

        DB::table('productos_categorias')->insert([
            ['id_producto' => 1, 'id_categoria' => 7],
            ['id_producto' => 2, 'id_categoria' => 7],
            ['id_producto' => 3, 'id_categoria' => 7],
            ['id_producto' => 4, 'id_categoria' => 7],
            ['id_producto' => 5, 'id_categoria' => 7],
            ['id_producto' => 6, 'id_categoria' => 7],
            ['id_producto' => 7, 'id_categoria' => 7],
            ['id_producto' => 8, 'id_categoria' => 7],
            ['id_producto' => 9, 'id_categoria' => 7],
            ['id_producto' => 10, 'id_categoria' => 7],
        ]);
        
    }
}

