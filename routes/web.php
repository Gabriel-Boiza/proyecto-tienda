<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\Auth\LoginController;

// Rutas públicas (para usuarios/clientes)
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/', [ProductoController::class, 'destacados']); // Ruta pública
Route::get('/periferico/{id}', [ProductoController::class, 'userShow']); // Ruta pública
Route::get('/categoria/{id}', [CategoriaController::class, 'userShow']); // Ruta pública

Route::get('/api/productos', [ProductoController::class, 'obtenerProductos']); // Obtiene json para peticiones fetch (público)
Route::get('/api/categorias', [CategoriaController::class, 'obtenerCategorias']); // Obtiene json para peticiones fetch (público)


Route::middleware('auth')->group(function () {
    Route::get('/app-admin', function () {
        return view('app-admin.inicio');
    })->name('app-admin');

    Route::resources([
        'categorias' => CategoriaController::class,
        'productos' => ProductoController::class,
    ]);
});
