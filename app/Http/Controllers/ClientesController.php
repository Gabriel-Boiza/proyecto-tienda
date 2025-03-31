<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;

class ClientesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clientes = Cliente::all();
        return view('app-admin.clientes.leer', compact('clientes'));
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {   
        $cliente = Cliente::with('pedidos')->find($id);
        return view('app-admin.clientes.mostrar', compact('cliente'));
    }

    public function userShow($id){
        $cliente = Cliente::find($id);
        return view('user.perfil', compact('cliente'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $cliente = Cliente::find($id);
        return view('user.editarCliente', compact('cliente'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validar los datos del formulario
        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'telefono' => 'nullable|string|max:20',
            'direccion' => 'nullable|string|max:255',
            'ciudad' => 'nullable|string|max:255',
            'codigo_postal' => 'nullable|string|max:20',
            'pais' => 'nullable|string|max:255',
        ]);
    
        // Buscar el cliente en la base de datos
        $cliente = Cliente::findOrFail($id);
    
        // Actualizar los datos del cliente
        $cliente->update($request->all());
    
        // Redirigir con un mensaje de éxito
        return redirect("/perfil/$cliente->id")->with('success', 'Perfil actualizado correctamente.');
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
