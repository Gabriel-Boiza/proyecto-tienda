<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Carrito;
use App\Models\Producto;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use App\Models\Categoria;
use App\Models\Cliente;

class CarritoController extends Controller
{
    public function index(){
        $productos = Producto::whereRelation('categorias', 'nombre_categoria', 'destacado')->get();  
        $categorias = Categoria::withCount('productos')->get(); 
        //return response()->json($productos);
        return view('user/carrito', compact('productos', 'categorias'));
    }

    public function obtenerCarrito()
    {
        $clienteId = Session::get('cliente_id'); // Obtén el ID del cliente desde la sesión
        $carrito = Carrito::where('cliente_id', $clienteId)
                          ->join('productos', 'carritos.producto_id', '=', 'productos.id')
                          ->select('productos.id', 'productos.nombre', 'carritos.cantidad')
                          ->get();

        return response()->json(['carrito' => $carrito]);
    }

    // Actualizar el carrito del cliente
    public function actualizarCarrito(Request $request)
{
    $clienteId = Session::get('cliente_id');
    $productos = $request->cart;

    foreach ($productos as $producto) {
        $productoId = $producto['id'];  // Asumiendo que el producto tiene un campo 'id'
        $cantidad = $producto['cantidad'];

        // Asegúrate de que tanto el producto_id como la cantidad estén presentes
        if (isset($productoId) && isset($cantidad)) {
            Carrito::updateOrCreate(
                ['cliente_id' => $clienteId, 'producto_id' => $productoId],
                ['cantidad' => $cantidad]
            );
        }
    }

    return response()->json(['message' => 'Carrito sincronizado correctamente']);
}


}
