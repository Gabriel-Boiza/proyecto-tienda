<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Carrito;
use App\Models\Producto;
use Illuminate\Support\Facades\Session;
use App\Models\Cliente;

class CarritoController extends Controller
{
    // Añadir productos al carrito (si no estás logueado)
    public function addToCart(Request $request)
    {
        $producto_id = $request->input('producto_id');
        $cantidad = $request->input('cantidad', 1);

        // Si el usuario está logueado
        if (Session::has('cliente_id')) {
            $cliente_id = Session::get('cliente_id');
            $carrito = Carrito::where('cliente_id', $cliente_id)
                            ->where('producto_id', $producto_id)
                            ->first();
            
            if ($carrito) {
                // Si el producto ya está en el carrito, actualiza la cantidad
                $carrito->cantidad += $cantidad;
                $carrito->save();
            } else {
                // Si no está en el carrito, lo agrega
                Carrito::create([
                    'cliente_id' => $cliente_id,
                    'producto_id' => $producto_id,
                    'cantidad' => $cantidad
                ]);
            }

            return response()->json(['status' => 'Producto añadido al carrito']);
        }

        // Si no está logueado, guardar en localStorage (en el front)
        $carrito = json_decode(session()->get('local_cart', '[]'));

        // Verificar si el producto ya está en el carrito local
        $productExists = false;
        foreach ($carrito as $item) {
            if ($item->producto_id == $producto_id) {
                $item->cantidad += $cantidad;
                $productExists = true;
                break;
            }
        }

        if (!$productExists) {
            $carrito[] = ['producto_id' => $producto_id, 'cantidad' => $cantidad];
        }

        session()->put('local_cart', json_encode($carrito));

        return response()->json(['status' => 'Producto añadido al carrito local']);
    }

    // Cuando el usuario inicie sesión, mover los productos del localStorage al carrito de la base de datos
    public function syncCartWithDatabase()
    {
        $cliente_id = Session::get('cliente_id');

        if ($cliente_id && session()->has('local_cart')) {
            $localCart = json_decode(session()->get('local_cart', '[]'), true);

            foreach ($localCart as $item) {
                $producto = Producto::find($item['producto_id']);
                if ($producto) {
                    // Agregar al carrito de la base de datos
                    Carrito::create([
                        'cliente_id' => $cliente_id,
                        'producto_id' => $producto->id,
                        'cantidad' => $item['cantidad']
                    ]);
                }
            }

            // Limpiar el carrito local después de agregar los productos a la base de datos
            session()->forget('local_cart');
        }

        return redirect()->route('carrito.show');
    }

    // Mostrar los productos del carrito (localStorage + base de datos)
    public function showCart()
    {
        $cliente_id = Session::get('cliente_id');
        $carritoDb = [];

        if ($cliente_id) {
            // Obtener los productos del carrito del usuario logueado
            $carritoDb = Carrito::where('cliente_id', $cliente_id)->with('producto')->get();
        }

        // Obtener los productos del carrito local
        $carritoLocal = session()->get('local_cart', '[]');
        $carritoLocal = json_decode($carritoLocal, true);

        // Aquí puedes combinar ambos carritos (local y base de datos)
        $carrito = array_merge($carritoDb, $carritoLocal);

        return view('user/carrito', compact('carrito'));
    }


    public function sincronizarCarrito()
    {
        $carritoLocal = session()->get('local_cart', []);

        foreach ($carritoLocal as $item) {
            Carrito::updateOrCreate(
                [
                    'user_id' => \Illuminate\Support\Facades\Auth::user()->id,
                    'producto_id' => $item['producto_id']
                ],
                [
                    'cantidad' => $item['cantidad']
                ]
            );
        }

        session()->forget('local_cart');

        return response()->json(['status' => 'Carrito sincronizado']);
    }

}
