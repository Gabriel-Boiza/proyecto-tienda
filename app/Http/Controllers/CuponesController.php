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
}
