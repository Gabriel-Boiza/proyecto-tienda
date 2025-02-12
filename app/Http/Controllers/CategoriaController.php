<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categoria;

class CategoriaController extends Controller
{

    public function userShow(string $id){
        
        echo $id;
    }

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

        $request->validate([
            'categoria' => 'required|string|max:255',  //categoria es el valor que le paso por fetch
        ]);
    

        Categoria::create([
            'nombre_categoria' => $request->input('categoria'), 
        ]);
    

        return response()->json(['message' => 'Categoría creada con éxito']); 
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
  
        $request->validate([
            'categoria' => 'required|string|max:255'
        ]);
    
        try {
 
            $categoria = Categoria::findOrFail($id);
            
            $categoria->nombre_categoria = $request->categoria;
            $categoria->save();

            $datos = ['message' => 'Categoría actualizada correctamente', 'categoria' => $categoria];

            return response()->json($datos);
    
        } catch (Exception $e) {

            return response()->json(['message' => 'Error al actualizar la categoría']);
        }
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
