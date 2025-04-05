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
                @if($producto->personalizable==true && Session::get('cliente_id'))
                <button id="toggleTools" class="mb-2 bg-purple-600 hover:bg-purple-700 py-2 px-4 rounded-lg font-bold flex items-center space-x-2" aria-label="Mostrar u ocultar herramientas de edición">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                    </svg>
                    <span>Herramientas de edición</span>
                </button>
            <div id="toolsPanel" class="hidden bg-gray-900 p-3 rounded-lg flex items-center justify-between space-x-4">
            <!-- Herramientas de dibujo -->
            <div class="flex space-x-2">
                <button id="pencilTool" class="tool-btn bg-purple-600 p-2 rounded-lg hover:bg-purple-700 active" aria-label="Herramienta de lápiz">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                    </svg>
                </button>
                <button id="textTool" class="tool-btn bg-gray-700 p-2 rounded-lg hover:bg-gray-600" aria-label="Herramienta de texto">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                </button>
                <button id="eraserTool" class="tool-btn bg-gray-700 p-2 rounded-lg hover:bg-gray-600" aria-label="Borrador">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                </button>
                <label for="imageInput" class="tool-btn bg-gray-700 p-2 rounded-lg hover:bg-gray-600 cursor-pointer" aria-label="Subir imagen">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </label>
                <button id="saveButton" class="tool-btn bg-gray-700 p-2 rounded-lg hover:bg-gray-600" aria-label="Guardar diseño">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/>
                    </svg>
                </button>
                <input type="file" id="imageInput" accept="image/*" class="hidden" aria-label="Seleccionar archivo de imagen para subir">
            </div>

                    <!-- Color y grosor -->
                    <div class="flex items-center space-x-4">
                        <input type="color" id="colorPicker" class="w-8 h-8 rounded cursor-pointer" value="#FF0000" aria-label="Selector de color para el pincel">
                        <div class="flex items-center space-x-2">
                            <input type="range" id="lineWidth" min="1" max="20" value="2"
                                class="w-24 h-2 bg-gray-700 rounded-lg appearance-none cursor-pointer" aria-label="Selector de grosor del pincel">
                            <span id="lineWidthValue" class="text-sm text-white">2px</span>
                        </div>
                    </div>

                    <!-- Botón de borrar todo -->
                    <button id="clearCanvas" class="bg-red-600 p-2 rounded-lg hover:bg-red-700" aria-label="Borrar todo el diseño del lienzo">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                    </button>
                </div>
                <!-- Mensaje para pantallas pequeñas -->
                <div class="md:hidden bg-yellow-600 text-white p-3 rounded-lg mb-4">
                    <p class="font-medium">Para personalizar este producto, por favor utiliza un dispositivo con pantalla más grande (mínimo 720p).</p>
                </div>
                @endif

                <div class="relative bg-gray-800 rounded-lg overflow-hidden">
                    @if($producto->personalizable == true && Session::get('cliente_id'))
                        <!-- Contenedor para productos personalizables -->
                        <div class="relative">
                            <img src="{{ asset('storage/' . $producto->imagen_principal) }}"
                                alt="{{$producto->nombre}}"
                                class="w-full object-contain"
                                id="product-image">

                            <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 mt-28 hidden md:block" id="canvasWrapper">
                                <div id="canvasContainer" class="hidden w-32 h-32 md:w-64 md:h-64" style="display: none; background-color: rgba(0,0,0,0.1); border: 2px dashed #9333ea; border-radius: 0.5rem;">
                                    <canvas id="productCanvas"
                                            class="w-full h-full rounded-lg"
                                            style="background: transparent;"
                                            aria-label="Lienzo de personalización del producto">
                                    </canvas>
                                </div>
                            </div>
                        </div>
                    @else
                        <!-- Contenedor para productos no personalizables -->
                        <img src="{{ asset('storage/' . $producto->imagen_principal) }}"
                            alt="{{$producto->nombre}}"
                            class="w-full h-96 object-cover"
                            id="product-image">
                    @endif

                    @if($producto->descuento != 0)
                    <div class="span-descuento">
                        -{{$producto->descuento}}%
                    </div>
                    @endif
                </div>

                <div class="grid grid-cols-4 gap-4 mt-4">
                    @if(isset($imagenesAdicionales) && $imagenesAdicionales->isNotEmpty())
                        @foreach($imagenesAdicionales as $imagen)
                            <img src="{{ asset('storage/' . $imagen->imagen) }}" alt="Imagen adicional del producto {{ $loop->iteration }}" class="object-cover rounded">
                        @endforeach
                    @endif
                </div>


            </div>


            <div class="space-y-6">
                <div>
                    <h1 class="text-3xl font-bold mb-2">{{$producto->nombre}}</h1>
                    <div class="flex items-center space-x-4">
                        <div class="flex text-yellow-400" aria-label="Valoración del producto"> <!-- Assuming this is for rating -->
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
                        <span class="text-4xl font-bold">{{ number_format($producto->precio * (1 - ($producto->descuento / 100)), 2) }}€</span>
                        @if($producto->descuento != 0)
                        <span class="text-xl text-gray-400 line-through">{{$producto->precio}}€</span>
                        @endif
                    </div>
                    @if($producto->stock != 0)
                    <p class="text-green-500">En stock - Envío en 24/48h / Stock: {{$producto->stock}}</p>
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
                                aria-label="Disminuir cantidad del producto"
                            >-</button>

                            <input id='cantidadProducto' type='text' value=1 class="w-16 text-center text-xl bg-gray-900 border border-gray-700 rounded-lg p-1" aria-label="Cantidad del producto"/>

                            <button id='sumar'
                                class="w-10 h-10 rounded-lg bg-gray-800 flex items-center justify-center hover:bg-gray-700"
                                aria-label="Aumentar cantidad del producto"
                            >+</button>
                        </div>
                        </div>
                    </div>
                </div>

                <div class="space-y-4">
                <button id="agregar"
                        value="{{ Session::has('cliente_id') ? $producto->id : json_encode($producto) }}"
                        class="add-to-cart-button w-full bg-purple-600 hover:bg-purple-700 py-4 rounded-lg font-bold transform hover:scale-105 transition-all duration-200"
                        aria-label="Agregar producto al carrito"
                    >
                        Agregar al carrito
                    </button>
                    <button value="{{ $producto }}" class="favoritosMostrar w-full bg-gray-800 hover:bg-gray-700 py-4 rounded-lg font-bold" aria-label="Añadir producto a favoritos">
                        Añadir a Favoritos
                    </button>
                </div>

                <div class="space-y-4 border-t border-gray-800 pt-6">
                    <div class="prose prose-invert">
                        <h3 class="text-lg font-semibold mb-2">Descripción</h3>
                        <p class="text-gray-400">
                            {{$producto->descripcion}}
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
<script src='{{ asset("js/user/favoritosMostrar.js") }}'></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Function to check if the screen is 16:9 and at least 720p
        function checkAspectRatio() {
            const width = window.innerWidth;
            const height = window.innerHeight;
            const aspectRatio = width / height;
            const is16by9 = Math.abs(aspectRatio - (16/9)) < 0.3; // Further increased tolerance for 16:9
            const is720pOrHigher = width >= 1280 && height >= 720;

            const canvasWrapper = document.getElementById('canvasWrapper');
            const toolsPanel = document.getElementById('toolsPanel');
            const toggleToolsButton = document.getElementById('toggleTools');

            // console.log(`Width: ${width}, Height: ${height}, Aspect Ratio: ${aspectRatio}`);
            // console.log(`is16by9: ${is16by9}, is720pOrHigher: ${is720pOrHigher}`);

            if (canvasWrapper && toolsPanel && toggleToolsButton) {
                if (is720pOrHigher && is16by9) {
                    toggleToolsButton.classList.remove('hidden');
                } else {
                    // Hide customization elements if conditions are not met
                    const canvasContainer = document.getElementById('canvasContainer');
                    if (canvasContainer) canvasContainer.style.display = 'none'; // Ensure canvas container is hidden
                    if (toolsPanel) toolsPanel.classList.add('hidden'); // Ensure tools panel is hidden
                    if (toggleToolsButton) toggleToolsButton.classList.add('hidden'); // Ensure toggle button is hidden
                }
            }
        }


        // Check on load and when the window is resized
        checkAspectRatio();
        window.addEventListener('resize', checkAspectRatio);


    });
</script>