<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Models\Cliente;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;

class ClienteLoginController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     public function showLoginForm()
     {
         return view('auth.loginCliente');
     }
 
     public function loginCliente(Request $request)
     {
             
            $request->validate([
                'email' => 'required',
                'password' => 'required',
            ]);
            
            $cliente = Cliente::where('email', $request->email)->first();

            if ($cliente && Hash::check($request->password, $cliente->password)) {

                Session::put('cliente_id', $cliente->id);
                Session::put('cliente_email', $cliente->email);

                return redirect()->intended('/');
            }
            return back()->withErrors([
                'email' => 'El mail o la contraseña son incorrectos.',
            ]);
     }

     public function logout()
     {
         Session::flush();
         return back();
     }


    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
