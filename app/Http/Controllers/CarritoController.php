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

    public function store(Request $request){
        $carrito = Carrito::create([
            'producto_id' => $request->input('id'),
            'cliente_id' => Session::get('cliente_id'),
            'cantidad' => 1,
        ]);

        return response()->json($carrito);
    }

    public function destroy(string $id){
        $carrito = Carrito::where([
            'producto_id' => $id,
            'cliente_id' => Session::get('cliente_id')
        ])->first();
        $carrito->delete();
        return response()->json('Eliminado exitosamente');
    }
    


}
