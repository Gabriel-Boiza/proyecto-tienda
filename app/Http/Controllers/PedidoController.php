<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Models\Cliente;
use App\Models\Producto;
use Illuminate\Http\Request;

class PedidoController extends Controller
{
    public function index()
    {
        $pedidos = Pedido::with('cliente', 'productos')->get();
        return view('pedidos.index', compact('pedidos'));
    }

    public function show($id)
    {
        $pedido = Pedido::with('cliente', 'productos')->findOrFail($id);
        return view('pedidos.show', compact('pedido'));
    }

    public function create()
    {
        $clientes = Cliente::all();
        $productos = Producto::all();
        return view('pedidos.create', compact('clientes', 'productos'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'total' => 'required|numeric',
            'estado' => 'required|string',
            'productos' => 'required|array',
            'productos.*' => 'exists:productos,id',
        ]);

        $pedido = Pedido::create($validated);
        $pedido->productos()->attach($validated['productos']);

        return redirect()->route('pedidos.index')->with('success', 'Pedido creado con éxito.');
    }

    public function edit($id)
    {
        $pedido = Pedido::findOrFail($id);
        $clientes = Cliente::all();
        $productos = Producto::all();
        return view('pedidos.edit', compact('pedido', 'clientes', 'productos'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'total' => 'required|numeric',
            'estado' => 'required|string',
            'productos' => 'required|array',
            'productos.*' => 'exists:productos,id',
        ]);

        $pedido = Pedido::findOrFail($id);
        $pedido->update($validated);
        $pedido->productos()->sync($validated['productos']);

        return redirect()->route('pedidos.index')->with('success', 'Pedido actualizado con éxito.');
    }

    public function destroy($id)
    {
        $pedido = Pedido::findOrFail($id);
        $pedido->delete();

        return redirect()->route('pedidos.index')->with('success', 'Pedido eliminado con éxito.');
    }
}
