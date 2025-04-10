<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pedido;
use App\Models\Cliente;
use App\Models\Carrito;
use Illuminate\Support\Facades\Session;

use Barryvdh\DomPDF\Facade\Pdf as PDF;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

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

    public function userIndex(Request $request){
        if(Session::exists('cliente_id')){
            $id = Session::get('cliente_id');
            $estado = $request->input('estado', 'todos');
            
            // Obtener el cliente con sus pedidos
            $cliente = Cliente::find($id);
            
            if($estado == 'todos'){
                // Obtener todos los pedidos del cliente
                $pedidos = $cliente->pedidos;
            } else {
                // Filtrar pedidos por estado
                $pedidos = $cliente->pedidos()->where('estado', $estado)->get();
            }
            
            return view('user.misPedidos', compact('pedidos', 'estado'));
        }
        return redirect()->route('inicio');
    }
    public function confirmarPedido($id){
        $pedido = Pedido::find($id);
        $pedido->estado = 'entregado';
        $pedido->save();

        return redirect()->back();
    }

    public function cancelarPedido($id){
        $pedido = Pedido::find($id);
        $pedido->estado = 'cancelado';
        $pedido->save();

        return redirect()->back();
    }

    public function productosPedido($id){
        $productos = Pedido::with('productos')->find($id)->productos;
        $pedido = Pedido::with('productos')->find($id);

        if($pedido->cliente_id == Session::get('cliente_id')){
            return view('user.productosPedido', compact('productos'));
        }
        return redirect()->route('inicio');

    }

    public function generarPdf($id){

    
        $pedido = Pedido::with('productos', 'cliente')->findOrFail($id);
        $productos = $pedido->productos;

        $pdf = PDF::loadView('user.pdf.factura', compact('productos', 'pedido'));

        if($pedido->cliente_id == Session::get('cliente_id')){
            return $pdf->stream('pedido.pdf'); 
        }

        return redirect()->route('inicio');
    }

    public function pagarPedido(){
        $clienteProductos = Carrito::with('producto')->where('cliente_id', Session::get('cliente_id'))->get();
        
        $total = $clienteProductos->sum(function ($item) {
            return $item->producto->precio * $item->cantidad * (1 - ($item->producto->descuento / 100));
        });
        //return response()->json($clienteProductos);

        return view('user.pagar', compact('clienteProductos', 'total'));
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

        if($pedido->estado == 'enviado'){
            $pedido->fecha_envio = now();   
            $pedido->save();
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function obtenerProductosMasVendidos()
    {
        // Suponiendo que tienes la tabla 'productos_pedidos' y la columna 'total' para las ventas
        $productos = DB::table('productos_pedidos')
            ->select('producto_id', DB::raw('count(*) as total'))
            ->groupBy('producto_id')
            ->orderByDesc('total')
            ->get();

        // Obtener nombres de los productos
        $productos = $productos->map(function ($producto) {
            $producto->nombre = DB::table('productos')
                ->where('id', $producto->producto_id)
                ->value('nombre');
            return $producto;
        });

        // Retornar los productos como JSON
        return response()->json($productos);
    }

    public function obtenerPedidosMensuales()
    {
        // Establecer la localización en español
        Carbon::setLocale('es');

        // Obtener los pedidos agrupados por mes y año usando el campo 'created_at'
        $pedidosMensuales = DB::table('pedidos')
            ->select(DB::raw('YEAR(created_at) as anio, MONTH(created_at) as mes, COUNT(*) as total'))
            ->groupBy(DB::raw('YEAR(created_at), MONTH(created_at)'))
            ->orderBy('anio', 'asc')
            ->orderBy('mes', 'asc')
            ->get();

        // Transformar los datos para usarlos fácilmente en el gráfico
        $pedidosMensuales = $pedidosMensuales->map(function ($pedido) {
            // Crear un campo de nombre para cada mes en español y capitalizar la primera letra
            $pedido->mes_nombre = ucfirst(Carbon::createFromDate($pedido->anio, $pedido->mes, 1)->locale('es')->monthName) . ' ' . $pedido->anio;
            return $pedido;
        });

        return response()->json($pedidosMensuales);
    }


}
