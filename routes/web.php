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

// Rutas de productos
Route::get('/productos/buscar', [ProductoController::class, 'buscar']);

// Rutas de login y registro de cliente
Route::get('/loginCliente', [ClienteLoginController::class, 'showLoginForm']);
Route::get('/logoutCliente', [ClienteLoginController::class, 'logout']);
Route::get('/registroCliente', [ClienteLoginController::class, 'registro']);
Route::post('/registradoCliente', [ClienteLoginController::class, 'store']);
Route::post('/requestLoginCliente', [ClienteLoginController::class, 'loginCliente']);

// Rutas del carrito
Route::get('/carrito', [CarritoController::class, 'index']); // Esta ruta puede ser la vista del carrito

// Ruta para obtener el carrito en formato JSON
Route::get('/api/carrito', [CarritoController::class, 'obtenerCarrito']); // Devuelve el carrito como JSON

// Ruta para actualizar el carrito en la base de datos (usando POST)
Route::post('/api/carrito', [CarritoController::class, 'actualizarCarrito']); // Actualiza el carrito en la base de datos

// Rutas de la tienda
Route::get('/', [ProductoController::class, 'destacados']);
Route::get('/favoritos', [ProductoController::class, 'favoritos']);     
Route::get('/periferico/{id}', [ProductoController::class, 'userShow']); 
Route::get('/categoria/{id}', [CategoriaController::class, 'userShow']); 

Route::get('/api/productos', [ProductoController::class, 'obtenerProductos']); 
Route::get('/api/categorias', [CategoriaController::class, 'obtenerCategorias']);

// Rutas de administración (requieren autenticación)
Route::middleware('auth')->group(function () {
    Route::get('/app-admin', function () {
        return view('app-admin.inicio');
    })->name('app-admin');

    Route::resources([
        'categorias' => CategoriaController::class,
        'productos' => ProductoController::class,
        'marcas' => MarcaController::class,
    ]);

    Route::get('/api/marcas', [MarcaController::class, 'obtenerMarcas']);
});

