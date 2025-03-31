<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Carrito;
use App\Models\Producto;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use App\Models\Categoria;
use App\Models\Cliente;
use App\Http\Controllers\PersonalizadosController;

class CarritoController extends Controller
{
    public function index(){


        $clienteProductos = Cliente::with('productos')->find(Session::get('cliente_id'));

        return view('user/carrito', compact('clienteProductos'));
    }

    public function obtenerCarrito()
    {
        $clienteId = Session::get('cliente_id'); // Obtén el ID del cliente desde la sesión

        $carrito = Carrito::where('cliente_id', $clienteId)
            ->join('productos', 'carritos.producto_id', '=', 'productos.id')
            ->select(
                'productos.id',
                'productos.nombre',
                'productos.descripcion',
                'productos.precio',
                'productos.descuento', 
                'productos.imagen_principal', 
                'carritos.cantidad'
            )
            ->get();

        return response()->json(['carrito' => $carrito]);
    }

    public function store(Request $request){
        $carrito = Carrito::create([
            'producto_id' => $request->input('id'),
            'cliente_id' => Session::get('cliente_id'),
            'cantidad' => 1,
        ]);

        return response()->json($carrito);
    }

    public function sincronizarCarrito(Request $request)
    {
        $carritosCliente = $request->all();

        $array = [];
    
        foreach($carritosCliente as $index => $carritoCliente){
            $carrito = Carrito::where([
                'cliente_id' => Session::get('cliente_id'),
                'producto_id' => $carritoCliente['id'],
            ])->first();

            if($carrito == null){
                Carrito::create([
                    'cliente_id' => Session::get('cliente_id'),
                    'producto_id' => $carritoCliente['id'],
                    'cantidad' => $carritoCliente['cantidad'],
                ]);
            }
            else{
                $carrito->update([
                    'cantidad' => $carrito->cantidad + $carritoCliente['cantidad'],
                ]);
            }
        }
        
        return response()->json([
            'mensaje' => $array
        ]);
    }
    
    public function agregarCarrito(Request $request){
        $producto = $request->all();
    
        // Buscar el carrito asociado al cliente y producto
        $carrito = Carrito::where([
            'cliente_id' => Session::get('cliente_id'),
            'producto_id' => $producto['idProducto'],
        ])->first();  // Usa `first()` para obtener el primer resultado o `null`
    
        if($carrito != null){
            // Si el carrito ya existe, actualiza la cantidad
            $carrito->update([
                'cantidad' => $carrito->cantidad + $producto['valor'],
            ]);
        }
        else{
            // Si no existe, crea un nuevo carrito
            Carrito::create([
                'cliente_id' => Session::get('cliente_id'),
                'producto_id' => $producto['idProducto'],
                'cantidad' => $producto['valor'],  // La cantidad es igual al valor recibido
            ]);
        }
    
        return response()->json([
            'mensaje' => 'Producto agregado al carrito',
            'producto' => $producto  // Devolver los datos del producto
        ]);
    }
    

    public function actualizarCantidad(Request $request, string $id){
        $cantidad = $request->all()[0];

        $carrito = Carrito::where([
            'producto_id' => $id,
            'cliente_id' => Session::get('cliente_id')
        ])->first();

        $carrito->update([
            'cantidad' => $cantidad,
        ]);
 

        return response()->json(['cantidad' => $cantidad]);
    }

    public function verificarStock(){
        $carrito = Carrito::join('productos as p', 'carritos.producto_id', '=', 'p.id')
        ->select('carritos.*', 'p.nombre', 'p.precio')->where([
            'carritos.cliente_id' => Session::get('cliente_id'),
            'p.stock' => 0,
        ])
        ->exists();
        
        if($carrito){
            return response()->json(['respuesta' => $carrito]);
        }
        
        return response()->json(['respuesta' => $carrito]);
    }

    public function destroy($productoId)
    {
        try {
            DB::beginTransaction();

            $clienteId = Session::get('cliente_id');
            $cliente = Cliente::find($clienteId);

            if (!$cliente) {
                return response()->json(['error' => 'Cliente no encontrado'], 404);
            }

            // Eliminar el diseño personalizado si existe
            $personalizadosController = new PersonalizadosController();
            $personalizadosController->eliminarPersonalizado($productoId);

            // Eliminar el producto del carrito
            $cliente->productos()->detach($productoId);

            DB::commit();
            return response()->json(['message' => 'Producto eliminado correctamente']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Error al eliminar el producto'], 500);
        }
    }




}
