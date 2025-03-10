@extends('welcome')

@section('content')

<div class="relative bg-gradient-to-r from-purple-900 to-blue-900">
    <div class="absolute inset-0 bg-black/50"></div>
    <div class="relative container mx-auto px-4 py-24">
        <div class="max-w-3xl">
            <h1 class="text-5xl font-bold mb-6">Periféricos Gaming de Alta Gama</h1>
            <p class="text-xl mb-8 text-gray-200">
                Descubre nuestra selección premium de periféricos gaming. Hasta 50% de descuento en productos seleccionados
            </p>
            <div class="flex flex-wrap gap-4">
                <button class="bg-purple-600 hover:bg-purple-700 px-8 py-3 rounded-lg font-bold transform hover:scale-105 transition-all duration-200">
                    Ver Ofertas
                </button>
            </div>
        </div>
    </div>
</div>

<div class="container mx-auto px-4 py-8">
    <form class="max-w-3xl mx-auto" action="" method="GET">
        <div class="relative">
            <input 
                id='busqueda' 
                type="text" 
                placeholder="Busca periféricos gaming..." 
                class="w-full px-4 py-3 pr-12 bg-gray-800 border border-gray-700 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-purple-600 transition-all duration-300"
            >
        </div>
    </form>
</div>

<div class="container mx-auto px-4 py-16">
    <h2 class="text-3xl font-bold mb-8">Productos Destacados</h2>
    <div id="productos-buscados" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        @foreach($productos as $producto)
        <div class="bg-gray-800 rounded-xl overflow-hidden shadow-lg hover:-translate-y-2 transition-transform duration-300">
            <div class="relative">
                <img src="{{ asset('storage/' . $producto->imagen_principal) }}" alt="{{$producto->nombre}}" class="w-full h-48 object-cover">
                @if($producto->descuento != 0)
                <div class="absolute top-2 left-2 bg-purple-600 px-2 py-1 rounded text-sm">-{{$producto->descuento}}%</div>
                @endif
                <div class="absolute top-2 right-2 flex gap-2">
                    <button value='{{$producto}}' class="favoritos p-2 bg-gray-900/50 rounded-full hover:bg-gray-900 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                        </svg>
                    </button>
                    <button value='{{$producto}}' class="carrito p-2 bg-gray-900/50 rounded-full hover:bg-gray-900 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </button>
                </div>
            </div>
            <div class="p-4">
                <h3 class="font-bold text-lg mb-2">{{$producto->nombre}}</h3>
                <p class="text-gray-400 text-sm mb-3">{{$producto->descripcion}}</p>
                <div class="flex items-center mb-3">
                    <div class="flex text-yellow-400 mr-2">
                        @for($i = 0; $i < 5; $i++)
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
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

<script src="{{ asset('js/user/carrito.js') }}"></script>
<script src="{{ asset('js/user/favoritos.js') }}"></script>
<script src="{{ asset('js/user/busquedaProductos.js') }}"></script>
@endsection
