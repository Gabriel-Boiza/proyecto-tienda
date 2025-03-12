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
            ->select(
                'productos.id',
                'productos.nombre',
                'productos.descripcion',
                'productos.precio',
                'productos.descuento', 
                'productos.imagen_principal', 
                'carritos.cantidad'
            )
            ->get();

        return response()->json(['carrito' => $carrito]);
    }


    // Actualizar el carrito del cliente
    public function actualizarCarrito(Request $request)
    {
        $clienteId = Session::get('cliente_id');
        $productos = $request->cart;
    
        foreach ($productos as $producto) {
            $productoId = $producto['id'];
            $cantidad = $producto['cantidad'];
    
            // Verificar si el producto ya existe en el carrito del cliente
            $carritoExistente = Carrito::where('cliente_id', $clienteId)
                                       ->where('producto_id', $productoId)
                                       ->first();
    
            if ($carritoExistente) {
                // Si el producto ya existe, actualizar la cantidad
                $carritoExistente->update(['cantidad' => $cantidad]);
            } else {
                // Si el producto no existe, crearlo
                Carrito::create([
                    'cliente_id' => $clienteId,
                    'producto_id' => $productoId,
                    'cantidad' => $cantidad
                ]);
            }
        }
    
        return response()->json(['message' => 'Carrito sincronizado correctamente']);
    }

    public function eliminarProductoDelCarrito($clienteId, $productoId)
    {
        $carrito = Carrito::where('cliente_id', $clienteId)->where('producto_id', $productoId)->first();

        if (!$carrito) {
            return response()->json(['error' => 'Producto no encontrado en el carrito'], 404);
        }

        $carrito->delete();

        return response()->json(['message' => 'Producto eliminado del carrito']);
    }

    


}
