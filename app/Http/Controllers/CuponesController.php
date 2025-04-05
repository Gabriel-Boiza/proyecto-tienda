<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cupon;
use Illuminate\Support\Facades\Session;



class CuponesController extends Controller
{
    public function recogerCuponRandom(){

        if (Session::has('cupon_temporal')) {
            $cupon = Session::get('cupon_temporal');
        
            if (!now()->lessThan($cupon['expira_en'])) {
                Session::forget('cupon_temporal');
            }
        }
        
        if(Session::exists('cupon_temporal')){
            return response()->json(Session::get('cupon_temporal'));
        }
        
        $cupon = Cupon::inRandomOrder()->first();
        Session::put('cupon_temporal', [
            'id' => $cupon->id,
            'codigo' => $cupon->codigo,
            'descuento' => $cupon->descuento,
            'expira_en' => now()->addMinutes(1440),
            'usado' => 0,
        ]);

        return response()->json(Session::get('cupon_temporal'));
    }

    public function validarCupon(Request $request){
        
        $request->validate([
            'codigo' => 'required|string',
        ]);
        
        $codigo = $request->codigo;
        
        if (!Session::has('cupon_temporal')) {
            return response()->json([
                'success' => false,
                'message' => 'No hay cupón disponible'
            ]);
        }
        
        $cuponTemporal = Session::get('cupon_temporal');
        
        if ($cuponTemporal['codigo'] == $codigo) {
            if (now()->gt(\Carbon\Carbon::parse($cuponTemporal['expira_en']))) {
                Session::forget('cupon_temporal');
                return response()->json([
                    'success' => false,
                    'message' => 'El cupón ha expirado'
                ]);
            }
            
            if ($cuponTemporal['usado'] == 1) {
                return response()->json([
                    'success' => false,
                    'message' => 'Este cupón ya ha sido utilizado'
                ]);
            }
            
            return response()->json([
                'success' => true,
                'message' => 'Cupón aplicado correctamente',
                'cupon' => $cuponTemporal
            ]);
        }
        
        return response()->json([
            'success' => false,
            'message' => 'Código de cupón inválido'
        ]);
    }
}
