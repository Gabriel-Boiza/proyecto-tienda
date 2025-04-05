@extends('welcome')

@section('content')
<div class="bg-gray-900 py-8">
    <div class="container mx-auto px-4">
        <h1 class="text-3xl font-bold flex items-center gap-3">
            <svg class="w-8 h-8 text-purple-500" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
            </svg>
            Carrito
        </h1>
    </div>
</div>

<div class="container mx-auto px-4 py-12">
    @if(session('cliente_id'))
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
        <div class="md:col-span-2">
            <div class="bg-gray-800 rounded-lg p-6 mb-6">
                <h2 class="text-xl font-bold mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                    </svg>
                    Productos en tu carrito
                </h2>
                <div id='contenedorPrincipal' class="space-y-4">
                    @foreach($clienteProductos->productos as $producto)
                    <div  class="contenedorProducto border-b border-gray-700 pb-4 last:border-0 last:pb-0">
                        <div class="flex items-center gap-4">
                        <div class="w-20 h-20 bg-gray-700 rounded-lg overflow-hidden">
                            @php
                                $personalizadosController = new App\Http\Controllers\PersonalizadosController();
                                $personalizado = $personalizadosController->getPersonalizedImage($producto->id);
                                $imagenUrl = $personalizado ? asset('storage/' . $personalizado->imagen) : asset('storage/' . $producto->imagen_principal);
                            @endphp
                            <img src="{{ $imagenUrl }}"
                                alt="{{ $producto->nombre }}" {{-- Alt attribute already provides description --}}
                                class="w-20 h-20 object-cover">
                        </div>
                            <div class="flex-grow">
                                <h3 class="font-medium">{{ $producto->nombre }}</h3>
                                <p class="text-gray-400 text-sm">{{ Str::limit($producto->descripcion, 60) }}</p>
                                <div class="flex items-center justify-between mt-2">
                                    <div class="flex items-center gap-2">
                                        <button class="restarCantidad" data-id='{{$producto->id}}' aria-label="Restar una unidad de {{ $producto->nombre }}">
                                            <svg class="w-5 h-5 text-gray-400 hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/>
                                            </svg>
                                        </button>
                                        <span class='cantidadLogged' data-id='{{$producto->id}}' class="px-3 py-1 bg-gray-700 rounded-md" aria-live="polite" aria-atomic="true">
                                            {{ $producto->pivot->cantidad }}
                                        </span>
                                        <button data-id='{{$producto->id}}' class="sumarCantidad" aria-label="Sumar una unidad a {{ $producto->nombre }}">
                                            <svg class="w-5 h-5 text-gray-400 hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                            </svg>
                                        </button>
                                    </div>
                                    <button class="eliminar" data-id="{{ $producto->id }}" aria-label="Eliminar {{ $producto->nombre }} del carrito">
                                        <svg class="w-5 h-5 text-red-500 hover:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            @php
                                $precioConDescuento = $producto->precio - ($producto->precio * $producto->descuento / 100);
                            @endphp

                            <div class="text-right">
                                <div class="text-lg font-bold">
                                    {{ number_format($precioConDescuento, 2) }}€
                                    @if($producto->descuento > 0)
                                        <span class="line-through text-sm text-gray-400 ml-2">{{ number_format($producto->precio, 2) }}€</span>
                                    @endif
                                </div>
                                <div class="text-sm text-gray-400">
                                    <span id="total_producto" aria-live="polite" aria-atomic="true">Total: {{ number_format($precioConDescuento * $producto->pivot->cantidad, 2) }}€</span>
                                </div>
                                @if($producto->stock <= 0)
                                    <div class="text-xs text-red-500 mt-1">Agotado</div>
                                @elseif($producto->stock < 5)
                                    <div class="text-xs text-yellow-500 mt-1">¡Solo {{ $producto->stock }} disponibles!</div>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div>
            <div class="bg-gray-800 rounded-lg p-6 sticky top-6">
                <h2 class="text-xl font-bold mb-4">Resumen del pedido</h2>

                @php
                    $total = 0;
                    $productosNoDisponibles = false;

                    foreach($clienteProductos->productos as $producto) {
                        $total += ($producto->precio - ($producto->precio * $producto->descuento / 100)) * $producto->pivot->cantidad; // Corrected total calculation
                        if($producto->stock <= 0) {
                            $productosNoDisponibles = true;
                        }
                    }

                @endphp

                <div class="space-y-3 mb-6">

                    <div class="border-t border-gray-700 pt-3 flex justify-between font-bold">
                        <span>Total:</span>
                        <span id="total" class="text-xl text-purple-500" aria-live="polite" aria-atomic="true">{{ number_format($total, 2) }}€</span>
                    </div>
                </div>

                <div class="space-y-3">
                <a href="pagarPedido"
                id="proceder-compra"
                class="w-full bg-purple-600 hover:bg-purple-700 py-3 rounded-lg flex items-center justify-center gap-2
                        {{ $productosNoDisponibles ? 'opacity-50 pointer-events-none' : '' }}"
                data-enabled="{{ $productosNoDisponibles ? 'false' : 'true' }}"
                @if($productosNoDisponibles) aria-disabled="true" @endif>
                    Proceder al pago
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                    </svg>
                </a>


                    <a href="/" class="w-full bg-gray-700 hover:bg-gray-600 py-3 rounded-lg flex items-center justify-center gap-2 text-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        Seguir comprando
                    </a>
                </div>

                @if($productosNoDisponibles)
                <div id='noDisponibles' class="mt-4 p-3 bg-red-900/30 border border-red-500/30 rounded-lg text-sm text-red-400" role="alert">
                    <p>Algunos productos de tu carrito no están disponibles. Por favor, elimínalos para continuar.</p>
                </div>
                @endif

                <div class="mt-6">
                    <div class="text-sm text-gray-400 mb-2">Datos de envío:</div>
                    <div class="bg-gray-700/50 p-3 rounded-lg">
                        <p class="font-medium">{{ $clienteProductos->nombre }} {{ $clienteProductos->apellido }}</p>
                        <p class="text-sm text-gray-400">{{ $clienteProductos->direccion }}</p>
                        <p class="text-sm text-gray-400">{{ $clienteProductos->codigo_postal }}, {{ $clienteProductos->ciudad }}</p>
                        <p class="text-sm text-gray-400">{{ $clienteProductos->pais }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('js/user/carrito/controlesCarritoLogueado.js') }}"></script>





    @else
    <div  class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-12"> {{-- Adjusted grid columns for better layout when not logged in --}}
        <div id="carritoLocalStorage2">
            <!--Espacio generado por js -->
            <script src="{{ asset('js/user/carrito/generarVistaCarrito.js') }}"></script>
        </div>
        <div class="bg-gray-800 rounded-lg p-6 text-center self-start"> {{-- Added self-start --}}
            <h2 class="text-xl font-bold mb-4">Inicia sesión para continuar</h2>
            <a href="/loginCliente"
            class="w-full bg-purple-600 hover:bg-purple-700 py-3 rounded-lg text-white font-bold inline-block">
                Iniciar sesión
            </a>
        </div>
    </div>

    <div id="carritoVacio" class="text-center py-16 hidden">
        <div class="bg-gray-800/50 rounded-full w-20 h-20 mx-auto flex items-center justify-center mb-6">
            <svg class="w-10 h-10 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
            </svg>
        </div>
        <h3 class="text-xl font-bold mb-2">Tu carrito está vacío</h3>
        <p class="text-gray-400 mb-6">Explora nuestro catálogo y añade tus productos al carrito</p>
        <a href="/" class="bg-purple-600 hover:bg-purple-700 px-6 py-3 rounded-lg inline-flex items-center gap-2">
            Explorar Productos
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
            </svg>
        </a>
    </div>
    @endif
</div>

@endsection
