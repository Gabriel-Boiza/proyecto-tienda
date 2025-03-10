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

    public function obtenerCarrito(){
        $clienteId = Session::get('cliente_id');

        if (!$clienteId) {
            return response()->json(['error' => 'No autenticado'], 401);
        }

        // Consultar los productos en el carrito de la base de datos
        $carrito = DB::table('carritos')
            ->where('cliente_id', $clienteId)
            ->join('productos', 'carritos.producto_id', '=', 'productos.id')
            ->select('productos.id', 'productos.nombre', 'productos.precio', 'carritos.cantidad')
            ->get();

        return response()->json(['carrito' => $carrito]);
    }

    public function actualizarCarrito(Request $request) {
        $request->validate([
            'producto_id' => 'required|integer',
            'cantidad' => 'required|integer|min:1',
        ]);

        $clienteId = session('cliente_id');

        if (!$clienteId) {
            return response()->json(['error' => 'Usuario no autenticado'], 401);
        }

        $carrito = Carrito::updateOrCreate(
            ['cliente_id' => $clienteId, 'producto_id' => $request->producto_id],
            ['cantidad' => $request->cantidad]
        );

        return response()->json(['message' => 'Carrito actualizado', 'carrito' => $carrito]);
    }

}
