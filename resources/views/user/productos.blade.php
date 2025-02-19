@extends('welcome')

@section('title', 'Tienda de Teclados Gaming')

@section('content')
    <!-- Hero Section -->
    <div class="max-w-7xl mx-auto px-4 py-8">
        <h1 class="text-2xl text-gray-400 mb-8">
            Conoce más sobre {{$categorias->nombre_categoria}}
        </h1>

        <div class="flex gap-8">
            <!-- Sidebar de Filtros -->
            <aside class="w-64 bg-gray-800/30 p-6 rounded-lg h-fit">
                <h2 class="font-bold mb-4">Filtros</h2>
                
                <div class="mb-6">
                    <h3 class="text-gray-400 mb-2">Precio</h3>
                    <input type="range" min="{{$precioMinimo}}" max="{{$precioMaximo}}" value="{{$precioMaximo}}" 
                           class="w-full accent-purple-500" id="priceRange">
                    <div class="flex justify-between text-sm text-gray-400">
                        <span>{{$precioMinimo}}€</span>
                        <span id="priceValue">{{$precioMaximo}}€</span>
                    </div>
                </div>

                <div class="mb-6">
                    <h3 class="text-gray-400 mb-2">Marca</h3>
                    <div class="space-y-2">
                        @foreach($marcas as $marca)
                        <label class="flex items-center space-x-2">
                            <input type="checkbox" class="rounded text-purple-600">
                            <span>{{$marca->nombre}}</span>
                        </label>
                        @endforeach
                    </div>
                </div>

                <div>
                    <h3 class="text-gray-400 mb-2">Ordenar por</h3>
                    <select class="w-full bg-gray-700 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-purple-500">
                        <option>Más populares</option>
                        <option>Precio: Menor a mayor</option>
                        <option>Precio: Mayor a menor</option>
                    </select>
                </div>
            </aside>

            <!-- Grid de Productos -->
            <section class="flex-1">
                <div class="grid grid-cols-3 gap-6">
                    @foreach($productos as $producto)
                        <article class="bg-gray-800/30 rounded-lg overflow-hidden">
                            <div class="relative">
                                <img src="{{ asset('storage/' . $producto->imagen_principal) }}" 
                                     alt="{{ $producto->nombre }}" 
                                     class="w-full h-48 object-cover">
                                @if($producto->descuento > 0)
                                    <span class="absolute top-2 left-2 px-2 py-1 rounded text-sm bg-purple-500">
                                        -{{ $producto->descuento }}%
                                    </span>
                                @endif
                            </div>
                            <div class="p-4">
                                <h3 class="font-bold mb-1">{{ $producto->nombre }}</h3>
                                <p class="text-gray-400 text-sm mb-2">{{ $producto->descripcion }}</p>
                                <div class="flex justify-between items-center">
                                    <div>
                                        <span class="font-bold">{{$producto->precio * (100-$producto->descuento)/100}}€</span>
                                        @if($producto->descuento > 0)
                                            <span class="text-gray-400 line-through ml-2 text-sm">
                                                {{ $producto->precio }}€
                                            </span>
                                        @endif
                                    </div>
                                    <a href="/periferico/{{$producto->id}}" class="bg-purple-600 p-2 rounded-lg hover:bg-purple-700 flex items-center text-white">Ver más</a>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>

                <!-- Paginación -->
                <div class="flex justify-center mt-8 space-x-2">
                    {{$productos->links()}}
                </div>
            </section>
        </div>
    </div>

    <script>
        // Actualizar el valor del rango de precios
        document.getElementById('priceRange').addEventListener('input', (e) => {
            document.getElementById('priceValue').textContent = `${e.target.value}€`;
        });
    </script>
@endsection