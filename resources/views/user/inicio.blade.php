@extends('welcome')

@section('content')

<!-- Hero con gradiente animado -->
<div class="relative w-full h-screen overflow-hidden bg-gradient-animate">
    <!-- Efecto de partículas/líneas -->
    <div class="absolute inset-0 pattern-overlay"></div>

    <div class="absolute inset-0 bg-black/60"></div>

    <!-- Logo flotante grande -->
    <div class="absolute inset-0 flex items-center justify-center" aria-hidden="true">
        <h1 class="text-9xl font-extrabold text-white opacity-5 select-none tracking-widest">PEPERIFERICOS</h1>
    </div>

    <div class="relative container mx-auto px-4 py-24 flex items-center h-full">
        <div class="max-w-3xl">
            <span class="inline-block px-4 py-1 bg-purple-600/30 text-purple-300 rounded-full mb-4 border border-purple-500/20 text-sm font-medium">EXPERIENCIA GAMING PREMIUM</span>
            <h1 class="text-5xl font-bold mb-6 text-white">Periféricos Gaming de Alta Gama</h1>
            <p class="text-xl mb-8 text-gray-200">
                Descubre nuestra selección premium de periféricos gaming. Hasta 50% de descuento en productos seleccionados
            </p>
            <div class="flex flex-wrap gap-4">
                <button id="scrollToProductos" class="bg-purple-600 hover:bg-purple-700 px-8 py-3 rounded-lg font-bold transform hover:scale-105 transition-all duration-200 text-white shadow-lg shadow-purple-600/30" aria-label="Ir a la sección de productos destacados">
                    Ver productos
                </button>
                <button id="scrollToCategorias" class="bg-transparent hover:bg-white/10 border border-purple-400 px-8 py-3 rounded-lg font-bold transform hover:scale-105 transition-all duration-200 text-white" aria-label="Ir a la sección de categorías">
                    Explorar categorías
                </button>
            </div>
        </div>
    </div>

    <!-- Scroll indicator -->
    <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 animate-bounce" aria-hidden="true">
        <svg class="w-6 h-6 text-white/70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
        </svg>
    </div>
</div>


<!-- Barra de búsqueda -->
<div class="container mx-auto px-4 -mt-16 relative z-10 mb-8">
    <form class="max-w-3xl mx-auto" action="" method="GET" role="search">
        <div class="relative">
            <input
                id='busqueda'
                type="text"
                placeholder="Busca periféricos gaming..."
                aria-label="Campo de búsqueda de periféricos gaming"
                class="w-full px-6 py-4 pr-12 bg-gray-800/90 backdrop-blur-sm border border-gray-700 rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-purple-600 transition-all duration-300 shadow-xl"
            >
            <div class="absolute right-4 top-1/2 transform -translate-y-1/2" aria-hidden="true">
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </div>
        </div>
    </form>
</div>

<!-- Productos Destacados -->
<div id="productos-destacados" class="container mx-auto px-4 py-16">
    <h2 id="subtitulo" class="text-3xl font-bold mb-8 relative inline-block">
        Productos Destacados
        <span class="absolute -bottom-2 left-0 w-1/2 h-1 bg-gradient-to-r from-purple-600 to-blue-600" aria-hidden="true"></span>
    </h2>
    <div id="productos-buscados" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        @foreach($productos as $producto)
        <div class="producto bg-gray-800 rounded-xl overflow-hidden shadow-lg hover:-translate-y-2 transition-transform duration-300 border border-gray-700/50 min-h-[400px] flex flex-col" data-producto-id="{{$producto->id}}">
            <div class="relative">
                <img src="{{ asset('storage/' . $producto->imagen_principal) }}" alt="{{$producto->nombre}}" class="w-full h-48 object-cover">
                @if($producto->descuento != 0)
                <div class="span-descuento" aria-label="Descuento del {{$producto->descuento}}%">-{{$producto->descuento}}%</div>
                @endif
                <div class="absolute top-3 right-3 flex gap-2">
                    <button value='{{$producto}}' class="favoritos p-2 bg-gray-900/70 backdrop-blur-sm rounded-full hover:bg-gray-900 transition-colors" aria-label="Añadir {{$producto->nombre}} a favoritos">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                        </svg>
                    </button>
                    <button value='{{$producto}}' class="carrito p-2 bg-gray-900/70 backdrop-blur-sm rounded-full hover:bg-gray-900 transition-colors" aria-label="Añadir {{$producto->nombre}} al carrito">
                        <svg class="carrito-icono w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </button>
                </div>
            </div>
            <div class="p-5 flex flex-col flex-grow">
                <h3 class="producto-info font-bold text-lg mb-2">{{$producto->nombre}}</h3>
                <p class="text-gray-400 text-sm mb-3 flex-grow">{{$producto->descripcion}}</p>
                <div class="flex items-center justify-between">
                    <div>
                        <span class="text-2xl font-bold">{{number_format($producto->precio * (100-$producto->descuento)/100, 2)}}€</span>
                        @if($producto->descuento != 0)
                        <span class="text-sm text-gray-400 line-through ml-2" aria-label="Precio original">{{$producto->precio}}€</span>
                        @endif
                    </div>
                    <a href="periferico/{{{$producto->id}}}" class="button" aria-label="Ver más detalles de {{$producto->nombre}}">
                        Ver más
                    </a>
                </div>
            </div>
        </div>

        @endforeach
    </div>
</div>

<!-- Categorías -->
<div id="categorias" class="container mx-auto px-4 py-16">
    <h2 class="text-3xl font-bold mb-8 relative inline-block">
        Categorías
        <span class="absolute -bottom-2 left-0 w-1/2 h-1 bg-gradient-to-r from-purple-600 to-blue-600" aria-hidden="true"></span>
    </h2>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
    @foreach($categorias as $categoria)
    <a href="categoria/{{$categoria->id}}" class="group" aria-label="Ver productos de la categoría {{$categoria->nombre_categoria}}">
        <div class="bg-gray-800 rounded-xl p-6 text-center hover:bg-gray-700 transition-all duration-300 transform hover:-translate-y-1 border border-gray-700/50 relative overflow-hidden">
            <!-- Fondo de gradiente sutil -->
            <div class="absolute inset-0 bg-gradient-to-br from-purple-600/5 to-blue-600/5 opacity-0 group-hover:opacity-100 transition-opacity" aria-hidden="true"></div>

            <div class="bg-purple-600/10 w-16 h-16 rounded-full mx-auto mb-4 flex items-center justify-center group-hover:bg-purple-600/20 transition-colors relative z-10">
                <!-- Ícono genérico para todas las categorías -->
                <svg class="w-8 h-8 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                </svg>
            </div>
            <h3 class="text-lg font-semibold mb-2 relative z-10">{{$categoria->nombre_categoria}}</h3>
            <p class="text-gray-400 text-sm relative z-10">{{$categoria->productos_count}} productos</p>
        </div>
    </a>
    @endforeach
</div>
</div>

<script src="{{ asset('js/user/busquedaProductos.js') }}"></script>
<script src="{{ asset('js/user/favoritos.js') }}"></script>

<!-- Script para el scroll suave -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Botón "Ver productos" - scroll a "Productos Destacados"
    document.getElementById('scrollToProductos').addEventListener('click', function() {
        const productosDestacados = document.getElementById('productos-destacados');

        if (productosDestacados) {
            window.scrollTo({
                top: productosDestacados.offsetTop - 80, // Offset para considerar headers o navbar
                behavior: 'smooth'
            });
        }
    });

    // Botón "Explorar categorías" - scroll a "Categorías"
    document.getElementById('scrollToCategorias').addEventListener('click', function() {
        const categorias = document.getElementById('categorias');

        if (categorias) {
            window.scrollTo({
                top: categorias.offsetTop - 80, // Offset para considerar headers o navbar
                behavior: 'smooth'
            });
        }
    });
});
</script>
@endsection
