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
use App\Http\Controllers\GameController;
use App\Http\Controllers\PersonalizadosController;
use App\Http\Controllers\PagoController;
use App\Http\Controllers\CuponesController;
// Rutas de productos

Route::get('/cupon', [CuponesController::class, 'recogerCuponRandom']);
Route::post('/validar-cupon', [CuponesController::class, 'validarCupon']);


Route::get('/productos/buscar', [ProductoController::class, 'buscar']);

Route::get('/productos-stock', [ProductoController::class, 'getProductosStock']);
Route::get('/productos-vendidos',[PedidosController::class, 'obtenerProductosMasVendidos']);


// Rutas de login y registro de cliente
Route::get('/loginCliente', [ClienteLoginController::class, 'showLoginForm']);
Route::get('/logoutCliente', [ClienteLoginController::class, 'logout']);
Route::get('/registroCliente', [ClienteLoginController::class, 'registro']);
Route::post('/registradoCliente', [ClienteLoginController::class, 'store']);
Route::post('/requestLoginCliente', [ClienteLoginController::class, 'loginCliente']);
Route::get('/editPerfil', [ClientesController::class, 'edit']);
Route::post('/updatePerfil/{id}', [ClientesController::class, 'update']);
Route::get('perfil', [ClientesController::class, 'userShow'])->name('perfil');
// Rutas del carrito
Route::get('/carrito', [CarritoController::class, 'index']); // Esta ruta puede ser la vista del carrito

Route::get('/api/carrito/{clienteId}', [CarritoController::class, 'obtenerCarrito']);


Route::delete('/api/carrito/{clienteId}/{productoId}', [CarritoController::class, 'eliminarProductoDelCarrito']);

Route::get('/api/carrito', [CarritoController::class, 'obtenerCarrito']); 

Route::get('/verCarrito', [CarritoController::class, 'show']); 
Route::get('/cantidadCarrito', [CarritoController::class, 'verCantidad']);

Route::get('/verificarStock', [CarritoController::class, 'verificarStock']); 

Route::post('/api/carrito', [CarritoController::class, 'store']);

Route::post('/sincronizarCarrito', [CarritoController::class, 'sincronizarCarrito']);

Route::post('/agregarCarrito', [CarritoController::class, 'agregarCarrito']);

Route::post('/actualizarCantidad/{id}', [CarritoController::class, 'actualizarCantidad']);

Route::delete('/api/carrito/{id}', [CarritoController::class, 'destroy'])->name('carrito.destroy');


Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');


Route::get('/', [ProductoController::class, 'destacados'])->name('inicio');
Route::get('/favoritos', [ProductoController::class, 'favoritos']);     
Route::get('/periferico/{id}', [ProductoController::class, 'userShow']); 
Route::get('/categoria/{id}', [CategoriaController::class, 'userShow']); 

Route::get('/api/productos', [ProductoController::class, 'obtenerProductos']); 
Route::get('/api/categorias', [CategoriaController::class, 'obtenerCategorias']);
Route::post('/api/productosBusqueda', [ProductoController::class, 'obtenerProductosBusqueda']); 
Route::get('/api/categorias', [CategoriaController::class, 'obtenerCategorias']); 

Route::get('/mis-pedidos', [PedidosController::class, 'userIndex']);
Route::get('/cancelar-pedido/{id}', [PedidosController::class, 'cancelarPedido']);
Route::get('/confirmar-pedido/{id}', [PedidosController::class, 'confirmarPedido']);

Route::get('/productosPedido/{id}', [PedidosController::class, 'productosPedido']);
Route::get('/generarPdf/{id}', [PedidosController::class, 'generarPdf']);
Route::post('/products/store', [ProductoController::class, 'guardarImagen'])->name('products.store');

Route::post('/save-personalized', [PersonalizadosController::class, 'store'])->name('save.personalized');
Route::get('/get-personalized/{producto_id}', [PersonalizadosController::class, 'getPersonalizedImage'])->name('get.personalized');

Route::get('/pedidos-mensuales', [PedidosController::class, 'obtenerPedidosMensuales']);

Route::get('/pagarPedido', [PedidosController::class, 'pagarPedido']);

Route::get('/juego', [GameController::class, 'juego'])->name('juego');

Route::post('/pago', [PagoController::class, 'crearPago']);
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
        'cupones' => CuponesController::class,
    ]);

    Route::get('/api/caracteristicas/{id}', [CaracteristicaController::class, 'apiCaracteristicas']);
    Route::get('/api/caracteristica', [CaracteristicaController::class, 'apiCaracteristicasCrud']);

    Route::get('/api/cupones', [CuponesController::class, 'apiCupones']);

    Route::get('/api/marcas', [MarcaController::class, 'obtenerMarcas']);

});



