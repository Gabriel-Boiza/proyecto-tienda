<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;

class ProductoController extends Controller
{
    public function obtenerProductos(){

        $productos = Producto::all();

        return response()->json($productos);
    }
    
    public function index()
    {
        $productos = Producto::with('categorias')->get();

        
        return view('productos/listar_productos', compact('productos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("productos/crear_formulario");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Producto::create([
            'nombre' => request('nombre')
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
