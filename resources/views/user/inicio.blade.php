@extends('welcome')

@section('content')

<!-- Hero Section -->
<div class="relative bg-gradient-to-r from-purple-900 to-blue-900">
    <div class="absolute inset-0 bg-black/50"></div>
    <div class="relative container mx-auto px-4 py-24">
        <div class="max-w-3xl">
            <h1 class="text-5xl font-bold mb-6">Periféricos Gaming de Alta Gama</h1>
            <p class="text-xl mb-8 text-gray-200">Descubre nuestra selección premium de periféricos gaming. Hasta 50% de descuento en productos seleccionados</p>
            <div class="flex flex-wrap gap-4">
                <button class="bg-purple-600 hover:bg-purple-700 px-8 py-3 rounded-lg font-bold transform hover:scale-105 transition-all duration-200">
                    Ver Ofertas
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Featured Products -->
<div class="container mx-auto px-4 py-16">
    <h2 class="text-3xl font-bold mb-8">Productos Destacados</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        @foreach($productos as $producto)
        <div class="producto bg-gray-800 rounded-xl overflow-hidden shadow-lg hover:-translate-y-2 transition-transform duration-300" data-producto-id="{{$producto->id}}">
        <div class="relative">
        <img src="{{ asset('storage/' . $producto->imagen_principal) }}" alt="{{$producto->nombre}}" class="w-full h-48 object-cover">
        @if($producto->descuento != 0)
        <div class="absolute top-2 left-2 bg-purple-600 px-2 py-1 rounded text-sm">-{{$producto->descuento}}%</div>
        @endif
        <div class="absolute top-2 right-2 flex gap-2">
            <button value='{{$producto}}'  class="favoritos p-2 bg-gray-900/50 rounded-full hover:bg-gray-900 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
            </button>
            <button value='{{$producto}}' class="carrito p-2 bg-gray-900/50 rounded-full hover:bg-gray-900 transition-colors">
                <svg class="carrito-icono w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
            </button>
        </div>
    </div>
    <div class="p-4">
    <h3 class="producto-info font-bold text-lg mb-2">{{$producto->nombre}}</h3>
    <p class="text-gray-400 text-sm mb-3">{{$producto->descripcion}}</p>
        <div class="flex items-center mb-3">
            <div class="flex text-yellow-400 mr-2">
                @for($i = 0; $i < 5; $i++)
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                @endfor
            </div>
            <span class="text-sm text-gray-400">(150 reviews)</span>
        </div>
        <div class="flex items-center justify-between">
            <div>
                <span class="text-2xl font-bold">{{$producto->precio * (100-$producto->descuento)/100}}€</span>
                @if($producto->descuento != 0)
                <span class="text-sm text-gray-400 line-through ml-2">{{$producto->precio}}€</span>
                @endif
            </div>
            <a href="periferico/{{{$producto->id}}}" class="bg-purple-600 hover:bg-purple-700 px-4 py-2 rounded-lg transition-colors">
                Ver más
            </a>
        </div>
    </div>
</div>
        @endforeach
    </div>
</div>

<!-- Categories -->
<div class="container mx-auto px-4 py-16">
    <h2 class="text-3xl font-bold mb-8">Categorías</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        @foreach($categorias as $categoria)
        <a href="categoria/{{$categoria->id}}" class="group">
            <div class="bg-gray-800 rounded-xl p-6 text-center hover:bg-gray-700 transition-all duration-300 transform hover:-translate-y-1">
                <div class="bg-purple-600/10 w-16 h-16 rounded-full mx-auto mb-4 flex items-center justify-center group-hover:bg-purple-600/20 transition-colors">
                    <svg class="w-8 h-8 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/></svg>
                </div>
                <h3 class="text-lg font-semibold mb-2">{{$categoria->nombre_categoria}}</h3>
                <p class="text-gray-400 text-sm">{{$categoria->productos_count}} productos</p>
            </div>
        </a>
        @endforeach
    </div>
</div>

<script src="{{ asset('js/user/favoritos.js') }}"></script>
<script src="{{ asset('js/user/carrito.js') }}" defer></script>

@endsection
