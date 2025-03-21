@extends('welcome')

@section('content')
    <!-- Product Section -->
    <div class="container mx-auto px-4 py-8">
        <!-- Breadcrumbs -->
        <div class="text-sm mb-8">
            <a href="/" class="text-gray-400 hover:text-purple-500">Inicio</a>
            <span class="text-gray-600 mx-2">/</span>
            @foreach($producto->categorias as $categoria)
            <a href="/categoria/{{{$categoria->id}}}" class="text-gray-400 hover:text-purple-500">{{$categoria->nombre_categoria}}</a>
            <span class="text-gray-600 mx-2">/</span>
            @endforeach
            <span class="text-purple-500">{{$producto->nombre}}</span>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Product Images -->
            <div class="space-y-4">
                <div class="relative bg-gray-800 rounded-lg overflow-hidden">
                    <img src="{{ asset('storage/' . $producto->imagen_principal) }}" alt="{{$producto->nombre}}" class="w-full h-96 object-cover">
                    @if($producto->descuento != 0)
                    <div class="absolute top-4 left-4 bg-purple-600 px-3 py-1 rounded-full text-sm font-semibold">
                        -{{$producto->descuento}}%
                    </div>
                    @endif
                </div>
                <div class="grid grid-cols-4 gap-4">
                    <template x-for="(image, index) in images" :key="index">
                        <button 
                            @click="currentImage = index"
                            class="bg-gray-800 rounded-lg overflow-hidden hover:ring-2 hover:ring-purple-500 transition-all"
                            :class="{'ring-2 ring-purple-500': currentImage === index}"
                        >
                            <img :src="image" alt="Thumbnail" class="w-full h-20 object-cover">
                        </button>
                    </template>
                </div>
            </div>

            <div class="space-y-6">
                <div>
                    <h1 class="text-3xl font-bold mb-2">{{$producto->nombre}}</h1>
                    <div class="flex items-center space-x-4">
                        <div class="flex text-yellow-400">
                            <template x-for="i in 5">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                            </template>
                        </div>
                    </div>
                </div>

                <div class="space-y-4">
                    <div class="flex items-baseline space-x-4">
                        <span class="text-4xl font-bold">{{$producto->precio}}€</span>
                        @if($producto->descuento != 0)
                        <span class="text-xl text-gray-400 line-through">149.99€</span>
                        @endif
                    </div>
                    @if($producto->stock != 0)
                    <p class="text-green-500">En stock - Envío en 24/48h</p>
                    @else
                    <p class="text-red-500">Sin stock disponible</p>
                    @endif
                </div>

                <div class="space-y-4">
                    <div>
                    <div>
                        <h3 class="text-lg font-semibold mb-2">Cantidad</h3>
                        <div class="flex items-center space-x-2">
                        <div class="flex items-center space-x-2">
                            <button id='restar'
                                class="w-10 h-10 rounded-lg bg-gray-800 flex items-center justify-center hover:bg-gray-700"
                            >-</button>

                            <input id='cantidadProducto' type='text' value=1 class="w-16 text-center text-xl bg-gray-900 border border-gray-700 rounded-lg p-1"/>

                            <button id='sumar'
                                class="w-10 h-10 rounded-lg bg-gray-800 flex items-center justify-center hover:bg-gray-700"
                            >+</button>
                        </div>
                        </div>
                    </div>
                </div>

                <div class="space-y-4">
                <button id="agregar"
                        value="{{ Session::has('cliente_id') ? $producto->id : json_encode($producto) }}"
                        class="add-to-cart-button w-full bg-purple-600 hover:bg-purple-700 py-4 rounded-lg font-bold transform hover:scale-105 transition-all duration-200"
                    >
                        Agregar al carrito
                    </button>
                    <button class="w-full bg-gray-800 hover:bg-gray-700 py-4 rounded-lg font-bold">
                        Añadir a Favoritos
                    </button>
                </div>

                <div class="space-y-4 border-t border-gray-800 pt-6">
                    <div class="prose prose-invert">
                        <h3 class="text-lg font-semibold mb-2">Descripción</h3>
                        <p class="text-gray-400">
                            Teclado mecánico gaming de alta gama con switches Cherry MX Red, retroiluminación RGB personalizable, 
                            construcción en aluminio, teclas PBT de doble inyección y cable USB-C desmontable. Incluye reposamuñecas 
                            ergonómico y software de personalización avanzado.
                        </p>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <h4 class="font-semibold mb-2">Características</h4>
                            <ul class="space-y-2 text-gray-400">
                                @foreach($producto->caracteristicas as $caracteristica)
                                    <li>• {{ $caracteristica->nombre }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if(Session::get('cliente_id'))
    <script src="{{ asset('js/user/verMasProductoLogueado.js') }}"></script>
    @else
    <script src="{{ asset('js/user/verMasProducto.js') }}"></script>
    @endif
@endsection

