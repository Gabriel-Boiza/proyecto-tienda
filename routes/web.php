<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\MarcaController;
use App\Http\Controllers\CaracteristicaController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ClienteLoginController;
use App\Http\Controllers\CarritoController;
use App\Http\Controllers\PedidosController;
use App\Http\Controllers\ClientesController;





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
Route::get('perfil/{id}', [ClientesController::class, 'userShow']);

Route::get('/', [ProductoController::class, 'destacados']);
Route::get('/favoritos', [ProductoController::class, 'favoritos']);     
Route::get('/periferico/{id}', [ProductoController::class, 'userShow']); 
Route::get('/categoria/{id}', [CategoriaController::class, 'userShow']); 

Route::get('/api/productos', [ProductoController::class, 'obtenerProductos']); 
Route::post('/api/productosBusqueda', [ProductoController::class, 'obtenerProductosBusqueda']); 
Route::get('/api/categorias', [CategoriaController::class, 'obtenerCategorias']); 

Route::get('/mis-pedidos/{id}', [PedidosController::class, 'userIndex']);
Route::get('/cancelar-pedido/{id}', [PedidosController::class, 'cancelarPedido']);
Route::get('/productosPedido/{id}', [PedidosController::class, 'productosPedido']);
Route::get('/generarPdf/{id}', [PedidosController::class, 'generarPdf']);




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

    Route::get('/api/productos', [ProductoController::class, 'obtenerProductos']); 
    Route::get('/api/categorias', [CategoriaController::class, 'obtenerCategorias']); 
    Route::get('/api/marcas', [MarcaController::class, 'obtenerMarcas']);
    Route::get('/api/caracteristicas/{id}', [CaracteristicaController::class, 'apiCaracteristicas']);
    Route::get('api/caracteristica', [CaracteristicaController::class, 'apiCaracteristicasCrud']);

});
