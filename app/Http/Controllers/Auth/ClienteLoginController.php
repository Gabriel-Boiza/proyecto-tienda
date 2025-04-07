<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Models\Cliente;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Models\Carrito;
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
             'email' => 'required|email',
             'password' => 'required|min:6',
         ]);
     
         $cliente = Cliente::where('email', $request->email)->first();
     
         if ($cliente && Hash::check($request->password, $cliente->password)) {
             Session::put('cliente_id', $cliente->id);
             Session::put('cliente_email', $cliente->email);
     
             return redirect()->intended('/'); // Redirige a la ruta protegida que intentó acceder
         }
     
         return back()->withErrors(['email' => 'Las credenciales no son correctas.'])->withInput();
     }

     public function logout()
     {
         Session::flush();
         return redirect()->route('inicio');
     }

     public function registro()
     {
         return view('auth.registroCliente');
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
        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:clientes,email',
            'contraseña' => 'required|min:6',
            'teléfono' => 'nullable|string|max:20',
            'dirección' => 'nullable|string|max:255',
            'ciudad' => 'nullable|string|max:100',
            'codigo_postal' => 'nullable|string|max:20',
            'pais' => 'nullable|string|max:50',
        ]);

        $cliente = Cliente::create([
            'nombre' => $request->nombre,
            'apellido' => $request->apellido,
            'email' => $request->email,
            'password' => Hash::make($request->contraseña),
            'telefono' => $request->teléfono,
            'direccion' => $request->dirección,
            'ciudad' => $request->ciudad,
            'codigo_postal' => $request->codigo_postal,
            'pais' => $request->pais,
        ]);

        Session::put('cliente_id', $cliente->id);
        return redirect()->route('juego');
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
