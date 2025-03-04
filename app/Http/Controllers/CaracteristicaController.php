<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Caracteristica;
use App\Models\Producto;

class CaracteristicaController extends Controller
{   


    public function apiCaracteristicas($id){
        $caracteristicas = Caracteristica::all();
        $producto_caracteristicas = Producto::with('caracteristicas')->find($id);

        return response()->json(['caracteristicas' => $caracteristicas, 'productos_caracteristicas' => $producto_caracteristicas]);
    } 

    public function apiCaracteristicasCrud(){
        $caracteristicas = Caracteristica::all();
        return response()->json(['caracteristicas' => $caracteristicas]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('app-admin.caracteristicas.leer');
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

        $valor = $request->input('caracteristica');

        $caracteristica = Caracteristica::create([
            'nombre' => $valor
        ]);
        
        return response()->json(['message' => 'Característica creada con éxito', 'nombre' => $valor, 'id' => $caracteristica->id]);
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
        $caracteristica = Caracteristica::find($id);
        $caracteristica->nombre = $request->caracteristica;

        $caracteristica->save();

        $datos = ['message' => 'Categoría actualizada correctamente', 'caracteristica' => $caracteristica];

        return response()->json($datos);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $caracteristica = Caracteristica::find($id);
        $caracteristica->delete();

        return response()->json(['message' => 'Caracteristica eliminado correctamente']);
    }
}
