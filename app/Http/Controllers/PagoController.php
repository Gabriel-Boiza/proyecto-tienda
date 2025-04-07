<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Charge;
use App\Models\Pedido;
use App\Models\Producto;
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
            $carritos = Carrito::with('producto')->where('cliente_id', Session::get('cliente_id'))->get();

            foreach($carritos as $carrito){
                if($carrito->producto->stock < $carrito->cantidad){
                    return back()->with('error', 'Stock del producto insuficiente');
                }
            }
    
                
            $pedido = Pedido::create([
                'cliente_id' => Session::get('cliente_id'),
                'total' => $request->total,
                'estado' => 'pendiente',
            ]);
    
            foreach ($carritos as $carrito) {
                DB::table('productos_pedidos')->insert([
                    'pedido_id' => $pedido->id,
                    'producto_id' => $carrito->producto_id,  
                    'cantidad' => $carrito->cantidad, 
                ]);
                
                DB::table('productos')->where('id', $carrito->producto_id)->decrement('stock', $carrito->cantidad);
                $carrito->delete(); 
            }
    
            $charge = Charge::create([
                'amount' => intval(round($request->total * 100)),
                'currency' => 'eur',
                'description' => 'Pago en tu tienda online',
                'source' => $request->stripeToken,
            ]);
    
            return back()->with('success', 'Pago realizado con éxito');
        } catch (\Exception $e) {
            return back()->with('error', 'Error en el pago: ' . $e->getMessage());
        }
    }
    
}
