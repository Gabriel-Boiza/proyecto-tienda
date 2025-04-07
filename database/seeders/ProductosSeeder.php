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
            ['nombre' => 'Ratón Logitech G Pro', 'descripcion' => 'Ratón gaming profesional con sensor HERO', 'precio' => 89.99, 'stock' => 0, 'imagen_principal' => 'productos/imagen1.jpeg', 'descuento' => 0, 'personalizable'=> false, 'fk_marca' => 1, 'codigo_producto' => 'LO-001RP'],
            ['nombre' => 'Teclado mecánico Corsair K95', 'descripcion' => 'Teclado mecánico con retroiluminación RGB', 'precio' => 149.99, 'stock' => 30, 'imagen_principal' => 'productos/imagen2.jpeg', 'descuento' => 0, 'personalizable'=> false, 'fk_marca' => 2, 'codigo_producto' => 'CO-002TK'],
            ['nombre' => 'Auriculares SteelSeries Arctis 7', 'descripcion' => 'Auriculares inalámbricos para gaming con sonido envolvente', 'precio' => 139.99, 'stock' => 15, 'imagen_principal' => 'productos/imagen3.jpeg', 'personalizable'=> false, 'descuento' => 0, 'fk_marca' => 3, 'codigo_producto' => 'ST-003AA'],
            ['nombre' => 'Mousepad Razer Goliathus', 'descripcion' => 'Alfombrilla de ratón de tela con iluminación RGB', 'precio' => 29.99, 'stock' => 100, 'imagen_principal' => 'productos/imagen4.jpeg', 'descuento' => 0, 'personalizable'=> false, 'fk_marca' => 4, 'codigo_producto' => 'RA-004MG'],
            ['nombre' => 'Monitor ASUS TUF Gaming', 'descripcion' => 'Monitor Full HD de 24" con tasa de refresco de 144Hz', 'precio' => 179.99, 'stock' => 20, 'imagen_principal' => 'productos/imagen5.jpeg', 'descuento' => 0, 'personalizable'=> false, 'fk_marca' => 5, 'codigo_producto' => 'AS-005MT'],
            ['nombre' => 'Webcam Logitech C920', 'descripcion' => 'Cámara web HD para streaming y videollamadas', 'precio' => 69.99, 'stock' => 40, 'imagen_principal' => 'productos/imagen6.jpeg', 'descuento' => 0, 'personalizable'=> false, 'fk_marca' => 1, 'codigo_producto' => 'LO-006WC'],
            ['nombre' => 'Teclado mecánico Razer Huntsman', 'descripcion' => 'Teclado con switches ópticos para una respuesta más rápida', 'precio' => 129.99, 'stock' => 25, 'imagen_principal' => 'productos/imagen7.jpeg', 'descuento' => 0, 'personalizable'=> false,'fk_marca' => 4, 'codigo_producto' => 'RA-007TH'],
            ['nombre' => 'Ratón Razer DeathAdder V2', 'descripcion' => 'Ratón ergonómico con sensor óptico de 20,000 DPI', 'precio' => 69.99, 'stock' => 45, 'imagen_principal' => 'productos/imagen8.jpg', 'descuento' => 0,'personalizable'=> true, 'fk_marca' => 4, 'codigo_producto' => 'RA-008RD'],
            ['nombre' => 'Alfombrilla Logitech G640', 'descripcion' => 'Alfombrilla de gran tamaño para gamers', 'precio' => 19.99, 'stock' => 60, 'imagen_principal' => 'productos/imagen9.jpeg', 'descuento' => 0,'personalizable'=> false, 'fk_marca' => 1, 'codigo_producto' => 'LO-009AL'],
            ['nombre' => 'Silla gaming DXRacer Formula', 'descripcion' => 'Silla ergonómica para largas sesiones de gaming', 'precio' => 299.99, 'stock' => 10, 'imagen_principal' => 'productos/imagen10.jpeg', 'descuento' => 0, 'personalizable'=> false,'fk_marca' => 6, 'codigo_producto' => 'DX-010SF']
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
        
        DB::table('productos_caracteristicas')->insert([
            ['id_producto' => 1, 'id_caracteristica' => 1],
            ['id_producto' => 2, 'id_caracteristica' => 2],
            ['id_producto' => 3, 'id_caracteristica' => 3],
            ['id_producto' => 4, 'id_caracteristica' => 4],
            ['id_producto' => 5, 'id_caracteristica' => 5],
            ['id_producto' => 6, 'id_caracteristica' => 6],
            ['id_producto' => 7, 'id_caracteristica' => 7],
            ['id_producto' => 8, 'id_caracteristica' => 8],
            ['id_producto' => 9, 'id_caracteristica' => 9],
            ['id_producto' => 10, 'id_caracteristica' => 10],
        ]);

        DB::table('productos_pedidos')->insert([
            [
                'pedido_id' => 1, // Pedido de Juan Pérez
                'producto_id' => 1, // Producto 1
                'cantidad' => 2,
            ],
            [
                'pedido_id' => 1, // Pedido de Juan Pérez
                'producto_id' => 2, // Producto 2
                'cantidad' => 1,
            ],
            [
                'pedido_id' => 2, // Pedido de Ana Gómez
                'producto_id' => 1, // Producto 1
                'cantidad' => 3,
            ],
            [
                'pedido_id' => 3, // Otro pedido de Juan Pérez
                'producto_id' => 3, // Producto 3
                'cantidad' => 5,
            ],
            [
                'pedido_id' => 4, // Pedido de Ana Gómez
                'producto_id' => 2, // Producto 2
                'cantidad' => 4,
            ],
        ]);
    }
}

