<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\MarcaController;
use App\Http\Controllers\CaracteristicaController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ClienteLoginController;
use App\Http\Controllers\CarritoController;
use App\Models\Carrito;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use App\Http\Controllers\PedidosController;
use App\Http\Controllers\ClientesController;


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

Route::get('/api/carrito/{clienteId}', [CarritoController::class, 'obtenerCarrito']);


Route::delete('/api/carrito/{clienteId}/{productoId}', [CarritoController::class, 'eliminarProductoDelCarrito']);

Route::get('/api/carrito', [CarritoController::class, 'obtenerCarrito']); 

Route::get('/verCarrito', [CarritoController::class, 'show']); 

Route::post('/api/carrito', [CarritoController::class, 'store']);

Route::post('/sincronizarCarrito', [CarritoController::class, 'sincronizarCarrito']);

Route::post('/agregarCarrito', [CarritoController::class, 'agregarCarrito']);

Route::delete('/api/carrito/{id}', [CarritoController::class, 'destroy']);

Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');
Route::get('perfil/{id}', [ClientesController::class, 'userShow']);

Route::get('/', [ProductoController::class, 'destacados']);
Route::get('/favoritos', [ProductoController::class, 'favoritos']);     
Route::get('/periferico/{id}', [ProductoController::class, 'userShow']); 
Route::get('/categoria/{id}', [CategoriaController::class, 'userShow']); 

Route::get('/api/productos', [ProductoController::class, 'obtenerProductos']); 
Route::get('/api/categorias', [CategoriaController::class, 'obtenerCategorias']);
Route::post('/api/productosBusqueda', [ProductoController::class, 'obtenerProductosBusqueda']); 
Route::get('/api/categorias', [CategoriaController::class, 'obtenerCategorias']); 

Route::get('/mis-pedidos/{id}', [PedidosController::class, 'userIndex']);
Route::get('/cancelar-pedido/{id}', [PedidosController::class, 'cancelarPedido']);
Route::get('/productosPedido/{id}', [PedidosController::class, 'productosPedido']);
Route::get('/generarPdf/{id}', [PedidosController::class, 'generarPdf']);




// Rutas de administración (requieren autenticación)
Route::middleware('auth')->group(function () {
    Route::get('app-admin', [ProductoController::class, 'appAdmin'])->name('app-admin'); 

    Route::resources([
        'categorias' => CategoriaController::class,
        'productos' => ProductoController::class,
        'marcas' => MarcaController::class,
        'caracteristicas' => CaracteristicaController::class,
        'clientes' => ClientesController::class,
        'pedidos' => PedidosController::class,
    ]);

    Route::get('/api/caracteristicas/{id}', [CaracteristicaController::class, 'apiCaracteristicas']);
    Route::get('/api/caracteristica', [CaracteristicaController::class, 'apiCaracteristicasCrud']);

    Route::get('/api/marcas', [MarcaController::class, 'obtenerMarcas']);

});

