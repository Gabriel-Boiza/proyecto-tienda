<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categoria;

class CategoriaController extends Controller
{

    public function obtenerCategorias(){
        $categorias = Categoria::all();

        return response()->json($categorias);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categorias = Categoria::all();

        return view("app-admin.categorias.leer", compact('categorias'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("categorias/crear_formulario");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validar la categoría si es necesario
        $request->validate([
            'categoria' => 'required|string|max:255', // Ajusta según las reglas de validación que necesites
        ]);
    
        // Crear la nueva categoría en la base de datos
        Categoria::create([
            'nombre_categoria' => $request->input('categoria'), // Obtener el valor de la categoría desde el cuerpo de la solicitud
        ]);
    
        // Si todo sale bien, devolver una respuesta de éxito
        return response()->json([
            'message' => 'Categoría creada con éxito'
        ], 201); // 201 es el código de estado para "creado"
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
        $categoria = Categoria::find($id);
        $categoria->delete();

        return response()->json(['message' => 'Producto eliminado correctamente']);
    }
}
