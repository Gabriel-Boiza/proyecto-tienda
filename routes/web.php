<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ProductoController;


Route::get('/', [ProductoController::class, 'obtenerProductosUsuarios']);


Route::get('/app-admin', function () {
    return view('app-admin.vista_admin');
})->name('app-admin');

Route::get('/api/productos', [ProductoController::class, 'obtenerProductos']);

Route::get('/api/categorias', [CategoriaController::class, 'obtenerCategorias']);




Route::resources([
    'categorias' => CategoriaController::class,
    'productos' => ProductoController::class
]);

