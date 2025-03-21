<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pedido;
use App\Models\Cliente;
use App\Models\Carrito;
use Illuminate\Support\Facades\Session;

use Barryvdh\DomPDF\Facade\Pdf as PDF;

use Illuminate\Support\Facades\Route;

class PedidosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pedidos = Pedido::all();
        return view('app-admin.pedidos.leer', compact('pedidos'));
    }

    public function userIndex($id){
        $pedidos = Cliente::with('pedidos')->find($id)->pedidos;
        return view('user.misPedidos', compact('pedidos'));
    }

    public function cancelarPedido($id){
        $pedido = Pedido::find($id);
        $pedido->estado = 'cancelado';
        $pedido->save();

        return redirect()->back();
    }

    public function productosPedido($id){
        $productos = Pedido::with('productos')->find($id)->productos;
        return view('user.productosPedido', compact('productos'));
    }

    public function generarPdf($id){

        
    $pedido = Pedido::with('productos', 'cliente')->findOrFail($id);
    $productos = $pedido->productos;

    $pdf = PDF::loadView('user.pdf.factura', compact('productos', 'pedido'));

    return $pdf->stream('pedido.pdf'); 
        
    }

    public function pagarPedido(){
        $clienteProductos = Carrito::with('producto')->where('cliente_id', Session::get('cliente_id'))->get();
        //return response()->json(['resultados' => $clienteProductos]);

        return view('user.pagar', compact('clienteProductos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
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
        echo $id;
        echo $request->estado;

        $pedido = Pedido::find($id);
        $pedido->estado = $request->estado;
        $pedido->save();    

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
