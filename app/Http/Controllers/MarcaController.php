<?php

namespace App\Http\Controllers;

use App\Models\Marca;
use Illuminate\Http\Request;

class MarcaController extends Controller
{



    public function obtenerMarcas(){
        $marcas = Marca::all();
        return response()->json($marcas);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {   
        return view('app-admin.marcas.leer');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'marca' => 'required|string|max:255', 
        ]);
    

        Marca::create([
            'nombre' => $request->input('marca'), 
        ]);
    

        return response()->json(['message' => 'Marca creada con éxito']); 
    }

    /**
     * Display the specified resource.
     */
    public function show(Marca $marca)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Marca $marca)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'marca' => 'required|string|max:255'
        ]);
    
        try {
 
            $marca = Marca::findOrFail($id);
            
            $marca->nombre = $request->marca;
            $marca->save();

            $datos = ['message' => 'marca actualizada correctamente', 'marca' => $marca];

            return response()->json($datos);
    
        } catch (Exception $e) {

            return response()->json(['message' => 'Error al actualizar la marca']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $marca = Marca::find($id);
        $marca->delete();

        return response()->json(['message' => 'Marca eliminada correctamente']);
    }
}
