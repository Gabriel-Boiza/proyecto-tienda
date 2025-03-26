<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Charge;
use App\Models\Pedido;
use App\Models\Carrito;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;


class PagoController extends Controller
{
    public function crearPago(Request $request)
    {
        $request->validate([
            'stripeToken' => 'required',
        ]);
    
        Stripe::setApiKey(config('services.stripe.secret'));
    
        try {
            // Obtener los carritos con la relación 'productos' correctamente
            $carritos = Carrito::with('producto')  // Cambié 'producto' por 'productos'
                ->where('cliente_id', Session::get('cliente_id'))
                ->get();
    
                
            // Crear el pedido
            $pedido = Pedido::create([
                'cliente_id' => Session::get('cliente_id'),
                'total' => $request->total,
                'estado' => 'pendiente',
            ]);
    
            // Insertar los productos en la tabla productos_pedidos
            foreach ($carritos as $carrito) {
                DB::table('productos_pedidos')->insert([
                    'pedido_id' => $pedido->id,
                    'producto_id' => $carrito->producto_id,  
                    'cantidad' => $carrito->cantidad, 
                ]);
            
                $carrito->delete(); 
            }
    
            $charge = Charge::create([
                'amount' => $request->total * 100, // Convertir a centavos
                'currency' => 'eur',
                'description' => 'Pago en tu tienda online',
                'source' => $request->stripeToken,
            ]);
    
            // Redirigir con mensaje de éxito
            return back()->with('success', 'Pago realizado con éxito');
        } catch (\Exception $e) {
            return back()->with('error', 'Error en el pago: ' . $e->getMessage());
        }
    }
    
}
