<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Carrito;
use App\Models\Producto;
use Illuminate\Support\Facades\Session;
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

    public function syncCart(Request $request)
    {
        $cliente = Cliente::find(Session::get('cliente_id'));

        if (!$cliente) {
            return response()->json(['error' => 'No authenticated user'], 401);
        }

        $cartItems = $request->input('cart');

        foreach ($cartItems as $item) {
            Carrito::create([
                'cliente_id' => $cliente->id,
                'producto_id' => $item['producto_id'],
                'cantidad' => $item['cantidad'],
            ]);
        }

        return response()->json(['success' => 'Cart synced successfully']);
    }

}
