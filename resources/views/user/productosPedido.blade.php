@extends('welcome')

@section('title', 'Productos - Tienda de Teclados Gaming')

@section('content')
    <div class="max-w-7xl mx-auto px-4 py-8">
        <h1 class="text-2xl text-gray-400 mb-8">
            Productos del pedido
        </h1>

        <div class="flex gap-8">

            <section class="flex-1">
                <div class="bg-gray-800/30 rounded-lg overflow-hidden">
                    <div class="p-6 border-b border-gray-700">
                        <h2 class="font-bold text-xl">Productos Disponibles</h2>
                    </div>
                    
                    <div class="divide-y divide-gray-700">
                        @foreach($productos as $producto)
                            <div class="p-6 flex items-center">
                                <div class="w-20 h-20 rounded-lg overflow-hidden flex-shrink-0">
                                    <img src="{{ asset('storage/' . $producto->imagen_principal) }}" 
                                         alt="{{ $producto->nombre }}" 
                                         class="w-full h-full object-cover">
                                </div>
                                
                                <div class="ml-6 flex-1">
                                    <h3 class="font-bold text-lg">{{ $producto->nombre }}</h3>
                                    <p class="text-gray-400 text-sm">{{ $producto->descripcion }}</p>
                                </div>
                                
                                <div class="text-right">
                                    <p class="font-bold text-lg">{{ $producto->precio }}€</p>
                                    @if($producto->descuento > 0)
                                        <p class="text-gray-400 text-sm">
                                            Descuento: {{ $producto->descuento }}%
                                        </p>
                                        <p class="text-green-400 text-sm">
                                            Precio final: {{ $producto->precio * (100-$producto->descuento)/100 }}€
                                        </p>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection