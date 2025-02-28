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
    

}
