@extends('welcome')

@section('content')
<!-- Header más minimalista -->
<div class="bg-gray-900 py-8">
    <div class="container mx-auto px-4">
        <h1 class="text-3xl font-bold flex items-center gap-3">
            <svg class="w-8 h-8 text-purple-500" fill="currentColor" viewBox="0 0 24 24">
                <path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
            </svg>
            Lista de Deseos
        </h1>
    </div>
</div>

<!-- Contenido Principal -->
<div class="container mx-auto px-4 py-12">
    <!-- Stats Summary -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
        <div class="bg-gray-800 p-6 rounded-xl">
            <p class="text-gray-400 mb-1">Total Productos</p>
            <p class="text-3xl font-bold">3</p>
        </div>
        <div class="bg-gray-800 p-6 rounded-xl">
            <p class="text-gray-400 mb-1">Valor Total</p>
            <p class="text-3xl font-bold">297.48€</p>
        </div>
        <div class="bg-gray-800 p-6 rounded-xl">
            <p class="text-gray-400 mb-1">Ahorro Total</p>
            <p class="text-3xl font-bold text-green-500">42.50€</p>
        </div>
    </div>

    <!-- Lista de Productos -->
    <div class="space-y-6">
        <!-- Producto 1 -->
        <div class="bg-gray-800 rounded-xl p-6 flex flex-col md:flex-row gap-6 items-center">
            <img src="/storage/productos/teclado-mecanico.jpg" alt="Teclado Mecánico RGB" 
                 class="w-full md:w-48 h-48 object-cover rounded-lg">
            
            <div class="flex-grow">
                <div class="flex items-start justify-between">
                    <div>
                        <h3 class="text-xl font-bold">Teclado Mecánico RGB Pro</h3>
                        <p class="text-gray-400 mt-2">Teclado gaming mecánico con switches Cherry MX y retroiluminación RGB personalizable</p>
                    </div>
                    <button class="text-gray-400 hover:text-red-500 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                
                <div class="flex flex-wrap items-center gap-4 mt-4">
                    <div class="flex items-center gap-2">
                        <span class="text-2xl font-bold">127.50€</span>
                        <span class="text-sm text-gray-400 line-through">150€</span>
                        <span class="bg-purple-600/20 text-purple-400 px-2 py-1 rounded text-sm">-15%</span>
                    </div>
                    <div class="flex items-center text-yellow-400">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                        <span class="ml-1">4.8</span>
                    </div>
                </div>

                <div class="flex gap-4 mt-6">
                    <button class="bg-purple-600 hover:bg-purple-700 px-6 py-2 rounded-lg flex items-center gap-2 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                        Añadir al Carrito
                    </button>
                    <a href="periferico/1" class="text-purple-500 hover:text-purple-400 flex items-center gap-2">
                        Ver Detalles
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>

        <!-- Producto 2 - Similar estructura pero con diferentes datos -->
        <div class="bg-gray-800 rounded-xl p-6 flex flex-col md:flex-row gap-6 items-center">
            <img src="/storage/productos/raton-gaming.jpg" alt="Ratón Gaming" 
                 class="w-full md:w-48 h-48 object-cover rounded-lg">
            
            <div class="flex-grow">
                <div class="flex items-start justify-between">
                    <div>
                        <h3 class="text-xl font-bold">Ratón Gaming Ultra Ligero</h3>
                        <p class="text-gray-400 mt-2">Ratón ultraligero con sensor óptico de alta precisión y 6 botones programables</p>
                    </div>
                    <button class="text-gray-400 hover:text-red-500 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                
                <div class="flex flex-wrap items-center gap-4 mt-4">
                    <span class="text-2xl font-bold">89.99€</span>
                    <div class="flex items-center text-yellow-400">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                        <span class="ml-1">4.6</span>
                    </div>
                </div>

                <div class="flex gap-4 mt-6">
                    <button class="bg-purple-600 hover:bg-purple-700 px-6 py-2 rounded-lg flex items-center gap-2 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                        Añadir al Carrito
                    </button>
                    <a href="periferico/2" class="text-purple-500 hover:text-purple-400 flex items-center gap-2">
                        Ver Detalles
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Empty State (se mostraría cuando no hay favoritos) -->
    <div class="hidden text-center py-16">
        <div class="bg-gray-800/50 rounded-full w-20 h-20 mx-auto flex items-center justify-center mb-6">
            <svg class="w-10 h-10 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                      d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
            </svg>
        </div>
        <h3 class="text-xl font-bold mb-2">Tu lista de deseos está vacía</h3>
        <p class="text-gray-400 mb-6">Explora nuestro catálogo y guarda tus productos favoritos</p>
        <a href="/" class="bg-purple-600 hover:bg-purple-700 px-6 py-3 rounded-lg inline-flex items-center gap-2">
            Explorar Productos
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
            </svg>
        </a>
    </div>
</div>

<script src="{{ asset('js/user/carrito.js') }}"></script>
<script src="{{ asset('js/user/favoritos.js') }}"></script>
@endsection