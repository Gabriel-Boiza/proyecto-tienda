<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\MarcaController;
use App\Http\Controllers\CaracteristicaController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ClienteLoginController;
use App\Http\Controllers\CarritoController;


Route::get('/productos/buscar', [ProductoController::class, 'buscar']);

Route::get('/loginCliente', [ClienteLoginController::class, 'showLoginForm']);
Route::post('/requestLoginCliente', [ClienteLoginController::class, 'loginCliente']);
Route::get('/logoutCliente', [ClienteLoginController::class, 'logout']);
Route::get('/registroCliente', [ClienteLoginController::class, 'registro']);
Route::post('/registradoCliente', [ClienteLoginController::class, 'store']);


Route::post('/addCart', [CarritoController::class, 'addToCart']);
Route::post('/cartDatabase', [CarritoController::class, 'syncCartWithDatabase']);
Route::get('/carrito', [CarritoController::class, 'showCart'])->name('carrito.show');




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


Route::middleware('auth')->group(function () {
    Route::get('/app-admin', function () {
        return view('app-admin.inicio');
    })->name('app-admin');

    Route::resources([
        'categorias' => CategoriaController::class,
        'productos' => ProductoController::class,
        'marcas' => MarcaController::class,
        'caracteristicas' => CaracteristicaController::class,
    ]);

    Route::get('/api/productos', [ProductoController::class, 'obtenerProductos']); 
    Route::get('/api/categorias', [CategoriaController::class, 'obtenerCategorias']); 
    Route::get('/api/marcas', [MarcaController::class, 'obtenerMarcas']);
    Route::get('/api/caracteristicas/{id}', [CaracteristicaController::class, 'apiCaracteristicas']);

});
