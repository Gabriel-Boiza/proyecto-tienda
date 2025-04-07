<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Carrito;

class PersonalizadosController extends Controller
{
    public function store(Request $request)
    {
        try {
            // Validar la solicitud
            $request->validate([
                'image' => 'required',
                'producto_id' => 'required|exists:productos,id'
            ]);

            // Obtener el ID del cliente de la sesión
            $clienteId = session('cliente_id');
            if (!$clienteId) {
                return response()->json(['success' => false, 'message' => 'Usuario no autenticado'], 401);
            }

            // Verificar si el producto ya está en el carrito
            $carritoExistente = Carrito::where([
                'cliente_id' => $clienteId,
                'producto_id' => $request->producto_id,
            ])->first();

            DB::beginTransaction();

            // Si el producto no está en el carrito, agregarlo
            if (!$carritoExistente) {
                Carrito::create([
                    'cliente_id' => $clienteId,
                    'producto_id' => $request->producto_id,
                    'cantidad' => 1,
                ]);
            }

            // Procesar la imagen base64
            $image_parts = explode(";base64,", $request->image);
            $image_base64 = base64_decode($image_parts[1]);
            
            // Generar nombre único para la imagen
            $filename = 'personalizados/' . Str::random(40) . '.png';
            
            // Guardar la imagen
            Storage::disk('public')->put($filename, $image_base64);

            // Guardar en la base de datos
            DB::table('personalizados')->insert([
                'cliente_id' => $clienteId,
                'producto_id' => $request->producto_id,
                'imagen_personalizada' => $filename,
                'created_at' => now(),
                'updated_at' => now()
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => $carritoExistente ? 'Diseño guardado correctamente' : 'Producto agregado al carrito y diseño guardado'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function getPersonalizedImage($productoId)
    {
        $clienteId = session('cliente_id');
        
        if (!$clienteId) {
            return null;
        }

        return DB::table('personalizados')
            ->where('cliente_id', $clienteId)
            ->where('producto_id', $productoId)
            ->orderBy('created_at', 'desc')
            ->first();
    }
    public function eliminarPersonalizado($productoId)
    {
        $clienteId = session('cliente_id');
        
        if (!$clienteId) {
            return response()->json(['success' => false, 'message' => 'Usuario no autenticado'], 401);
        }

        DB::table('personalizados')
            ->where('cliente_id', $clienteId)
            ->where('producto_id', $productoId)
            ->delete();

        return response()->json(['success' => true]);
    }
}