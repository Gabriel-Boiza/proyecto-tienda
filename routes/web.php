<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\MarcaController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ClienteLoginController;
use App\Http\Controllers\CarritoController;
use App\Models\Carrito;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;


Route::get('/productos/buscar', [ProductoController::class, 'buscar']);

Route::get('/loginCliente', [ClienteLoginController::class, 'showLoginForm']);
Route::get('/logoutCliente', [ClienteLoginController::class, 'logout']);
Route::get('/registroCliente', [ClienteLoginController::class, 'registro']);
Route::post('/registradoCliente', [ClienteLoginController::class, 'store']);



Route::get('/carrito', [CarritoController::class, 'index']);
Route::post('/api/carrito', [CarritoController::class, 'actualizarCarrito']);
Route::post('/requestLoginCliente', [ClienteLoginController::class, 'loginCliente']);


Route::get('/carrito', function () {
    $clienteId = Session::get('cliente_id');
    $carrito = Carrito::where('cliente_id', $clienteId)
                      ->join('productos', 'carritos.producto_id', '=', 'productos.id')
                      ->select('productos.id', 'productos.nombre', 'carritos.cantidad')
                      ->get();

    return response()->json(['carrito' => $carrito]);
});

Route::post('/carrito', function (Request $request) {
    $clienteId = Session::get('cliente_id');
    
    $productoId = $request->producto_id;
    $cantidad = $request->cantidad ?? 1;

    Carrito::updateOrCreate(
        ['cliente_id' => $clienteId, 'producto_id' => $productoId],
        ['cantidad' => $cantidad]
    );

    return response()->json(['message' => 'Carrito actualizado']);
});


// Rutas públicas (para usuarios/clientes)
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/', [ProductoController::class, 'destacados']);
Route::get('/favoritos', [ProductoController::class, 'favoritos']);     
Route::get('/periferico/{id}', [ProductoController::class, 'userShow']); 
Route::get('/categoria/{id}', [CategoriaController::class, 'userShow']); 

Route::get('/api/productos', [ProductoController::class, 'obtenerProductos']); 
Route::get('/api/categorias', [CategoriaController::class, 'obtenerCategorias']);
Route::get('/api/carrito', [CarritoController::class,'obtenerCarrito']);


Route::middleware('auth')->group(function () {
    Route::get('/app-admin', function () {
        return view('app-admin.inicio');
    })->name('app-admin');

    Route::resources([
        'categorias' => CategoriaController::class,
        'productos' => ProductoController::class,
        'marcas' => MarcaController::class,
    ]);

    Route::get('/api/productos', [ProductoController::class, 'obtenerProductos']); 
    Route::get('/api/categorias', [CategoriaController::class, 'obtenerCategorias']); 
    Route::get('/api/marcas', [MarcaController::class, 'obtenerMarcas']);

});
