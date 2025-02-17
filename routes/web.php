<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ProductoController;

Route::middleware(['auth'])->group(function () {
    Route::get('/app-admin', function () {
        return view('app-admin.inicio');
    })->name('app-admin');

    Route::get('/api/productos', [ProductoController::class, 'obtenerProductos']); //obtiene json para peticion fetch

    Route::get('/api/categorias', [CategoriaController::class, 'obtenerCategorias']); //obtiene json para peticion fetch

    Route::resources([
        'categorias' => CategoriaController::class,
        'productos' => ProductoController::class
    ]);
});


Route::get('/', [ProductoController::class, 'destacados']);

Route::get('/periferico/{id}', [ProductoController::class, 'userShow']);

Route::get('/categoria/{id}', [CategoriaController::class, 'userShow']);