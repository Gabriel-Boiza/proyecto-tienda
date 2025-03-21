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
            <div class="space-y-4 relative">
                <div class="bg-gray-900 p-3 rounded-lg flex items-center justify-between space-x-4">
            <!-- Herramientas de dibujo -->
                    <div class="flex space-x-2">
                        <button id="pencilTool" class="tool-btn bg-purple-600 p-2 rounded-lg hover:bg-purple-700 active">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                            </svg>
                        </button>
                        <button id="textTool" class="tool-btn bg-gray-700 p-2 rounded-lg hover:bg-gray-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                        </button>
                        <button id="eraserTool" class="tool-btn bg-gray-700 p-2 rounded-lg hover:bg-gray-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </button>
                        <!-- Nuevo botón de imagen -->
                        <label for="imageInput" class="tool-btn bg-gray-700 p-2 rounded-lg hover:bg-gray-600 cursor-pointer">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </label>
                        <input type="file" id="imageInput" accept="image/*" class="hidden">
                    </div>

                    <!-- Color y grosor -->
                    <div class="flex items-center space-x-4">
                        <input type="color" id="colorPicker" class="w-8 h-8 rounded cursor-pointer" value="#FF0000">
                        <div class="flex items-center space-x-2">
                            <input type="range" id="lineWidth" min="1" max="20" value="2" 
                                class="w-24 h-2 bg-gray-700 rounded-lg appearance-none cursor-pointer">
                            <span id="lineWidthValue" class="text-sm text-white">2px</span>
                        </div>
                    </div>

                    <!-- Botón de borrar todo -->
                    <button id="clearCanvas" class="bg-red-600 p-2 rounded-lg hover:bg-red-700">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                    </button>
                </div>
                <div class="relative bg-gray-800 rounded-lg overflow-hidden">
                    <img src="{{ asset('storage/' . $producto->imagen_principal) }}" 
                         alt="{{$producto->nombre}}" 
                         class="w-full h-96 object-cover" 
                         id="product-image">
                         <div class="absolute top-3/4 left-1/2 transform -translate-x-1/2 -translate-y-1/2">
                            <div class="w-48 h-48"> <!-- 256x256 píxeles -->
                                <canvas id="productCanvas"
                                        class="w-full h-full border-2 border-purple-500 rounded-lg"
                                        style="background: transparent;">
                                </canvas>
                            </div>
                        </div>
                   
                    <img src="{{ asset('storage/' . $producto->imagen_principal) }}" alt="{{$producto->nombre}}" class="w-full h-96 object-cover">
                    @if($producto->descuento != 0)
                    <div class="absolute top-4 left-4 bg-purple-600 px-3 py-1 rounded-full text-sm font-semibold">
                        -{{$producto->descuento}}%
                    </div>
                    @endif
                    
                </div>

                <div class="grid grid-cols-4 gap-4 mt-4">
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

<script src='{{asset("js/user/canvasImagen.js")}}'></script>


