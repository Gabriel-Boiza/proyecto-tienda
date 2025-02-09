<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalle de Producto</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-zinc-900 text-white">
    <div class="flex">
        <!-- Aside -->
        @include('app-admin.componentes.panel_admin')

        <!-- Main Content -->
        <main class="flex-1 p-8">
            <div class="flex justify-between items-center mb-8">
                <h1 class="text-xl font-bold">Detalle del Producto</h1>
                <a href="/productos" class="text-gray-400 hover:text-white">
                    Volver a la lista
                </a>
            </div>

            <div class="bg-zinc-800/50 border border-zinc-700 rounded-md p-6 space-y-6">
                <!-- Galería de Imágenes -->
                <div class="space-y-4">
                    <h2 class="text-lg font-semibold border-b border-zinc-700 pb-2">Imágenes del Producto</h2>
                   
                    <div class="relative">
                        <!-- Imagen Principal -->
                        <div class="w-full h-96 overflow-hidden rounded-lg">
                            <!-- Aquí es donde se carga la imagen principal desde la base de datos -->
                            <img id="mainImage" src="{{ asset('storage/'.$producto->imagen_principal) }}" alt="Imagen del producto" class="w-full h-full object-cover">
                        </div>

                        <!-- Controles de Navegación -->
                        <button onclick="prevImage()" class="absolute left-0 top-1/2 transform -translate-y-1/2 bg-black/50 p-2 rounded-r">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                            </svg>
                        </button>
                        <button onclick="nextImage()" class="absolute right-0 top-1/2 transform -translate-y-1/2 bg-black/50 p-2 rounded-l">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </button>

                        <!-- Miniaturas -->
                    </div>
                </div>

                <!-- Información del Producto -->
                <div class="space-y-6">
                    <h2 class="text-lg font-semibold border-b border-zinc-700 pb-2">Información del Producto</h2>
                   
                    <div class="grid grid-cols-2 gap-6">
                        <!-- Nombre -->
                        <div>
                            <label class="block text-sm font-medium text-gray-400 mb-1">Nombre del Producto</label>
                            <p class="text-white">{{ $producto->nombre }}</p>
                        </div>

                        <!-- Precio -->
                        <div>
                            <label class="block text-sm font-medium text-gray-400 mb-1">Precio</label>
                            <p class="text-white">${{ number_format($producto->precio, 2) }}</p>
                        </div>
                    </div>

                    <!-- Descripción -->
                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-1">Descripción</label>
                        <p class="text-white">{{ $producto->descripcion }}</p>
                    </div>

                    <!-- Stock -->
                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-1">Stock Disponible</label>
                        <p class="text-white">{{ $producto->stock }}</p>
                    </div>
                </div>

                <!-- Categorías -->
                <div class="space-y-4">
                    <h2 class="text-lg font-semibold border-b border-zinc-700 pb-2">Categorías</h2>
                    <div class="flex flex-wrap gap-2">
                        @foreach($producto->categorias as $categoria)
                        <span class="px-3 py-1 bg-zinc-700 rounded-full text-sm">
                            {{ $categoria->nombre }}
                        </span>
                        @endforeach
                    </div>
                </div>

                <!-- Botones de acción -->
                <div class="flex justify-end space-x-4 pt-6 border-t border-zinc-700">
                    <a href="/productos/{{ $producto->id }}/edit"
                       class="px-4 py-2 bg-purple-600 text-white rounded-md hover:bg-purple-500">
                        Editar Producto
                    </a>
                </div>
            </div>
        </main>
    </div>

    

    <script>
        let currentImageIndex = 0;

        function showImage(index) {
            if (index >= 0 && index < images.length) {
                currentImageIndex = index;
                document.getElementById('mainImage').src = images[currentImageIndex];
            }
        }

        function nextImage() {
            currentImageIndex = (currentImageIndex + 1) % images.length;
            showImage(currentImageIndex);
        }

        function prevImage() {
            currentImageIndex = (currentImageIndex - 1 + images.length) % images.length;
            showImage(currentImageIndex);
        }
    </script>
</body>
</html>
