@extends('app-admin.vista_admin')

@section('title', 'Tienda de Teclados Gaming')

@section('contentAdmin')
   
   
<div class="flex justify-between items-center mb-8">
    <h1 class="text-xl font-bold">Detalle del Producto</h1>
    <a href="/productos" class="text-gray-400 hover:text-white">
        Volver a la lista
    </a>
</div>

<div class="bg-zinc-800/50 border border-zinc-700 rounded-md p-6 space-y-6">
    <!-- Imagen Principal con Navegación -->
    <div class="max-w-2xl mx-auto">
        <div class="relative pt-[75%] rounded-lg overflow-hidden bg-zinc-700">
            <img 
                id="mainImage" 
                src="{{ asset('storage/'.$producto->imagen_principal) }}" 
                alt="Imagen del producto" 
                class="absolute inset-0 w-full h-full object-contain"
            >
        </div>
        <!-- Controles de navegación -->
        <div class="flex justify-between mt-4">
            <button 
                onclick="navigateImages('prev')" 
                class="px-4 py-2 bg-zinc-700 rounded-md hover:bg-zinc-600 transition-colors"
            >
                Anterior
            </button>
            <button 
                onclick="navigateImages('next')" 
                class="px-4 py-2 bg-zinc-700 rounded-md hover:bg-zinc-600 transition-colors"
            >
                Siguiente
            </button>
        </div>
    </div>

    <!-- Información del Producto -->
    <div class="space-y-6 mt-8">
        <h2 class="text-lg font-semibold border-b border-zinc-700 pb-2">
            Información del Producto
        </h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Nombre -->
            <div>
                <label class="block text-sm font-medium text-gray-400 mb-1">
                    Nombre del Producto
                </label>
                <p class="text-white">{{ $producto->nombre }}</p>
            </div>

            <!-- Precio -->
            <div>
                <label class="block text-sm font-medium text-gray-400 mb-1">
                    Precio
                </label>
                <p class="text-white">${{ number_format($producto->precio, 2) }}</p>
            </div>
        </div>

        <!-- Descripción -->
        <div>
            <label class="block text-sm font-medium text-gray-400 mb-1">
                Descripción
            </label>
            <p class="text-white whitespace-pre-line">{{ $producto->descripcion }}</p>
        </div>

        <!-- Stock -->
        <div>
            <label class="block text-sm font-medium text-gray-400 mb-1">
                Stock Disponible
            </label>
            <p class="text-white">{{ $producto->stock }}</p>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-400 mb-1">
                Descuento actual
            </label>
            <p class="text-white">{{ $producto->descuento }}</p>
        </div>
    </div>

    

    <!-- Categorías -->
    <div class="space-y-4">
        <h2 class="text-lg font-semibold border-b border-zinc-700 pb-2">
            Categorías
        </h2>
        <div class="flex flex-wrap gap-2">
            @forelse($producto->categorias as $categoria)
                <span class="px-3 py-1 bg-zinc-700 rounded-full text-sm">
                    {{ $categoria->nombre_categoria }}
                </span>
            @empty
                <p class="text-gray-400">No hay categorías asignadas</p>
            @endforelse
        </div>
    </div>

    <!-- Botones de acción -->
    <div class="flex justify-end space-x-4 pt-6 border-t border-zinc-700">
        <a 
            href="/productos/{{ $producto->id }}/edit"
            class="px-4 py-2 bg-purple-600 text-white rounded-md hover:bg-purple-500 transition-colors"
        >
            Editar Producto
        </a>
    </div>
</div>

<script>
    let currentImageIndex = 0;
    const images = [
        '{{ asset("storage/".$producto->imagen_principal) }}',
        @foreach ($imagenesAdicionales as $imagen) 
            '{{ asset("storage/".$imagen->imagen) }}',
        @endforeach
    ];

    function navigateImages(direction) {
        if (direction === 'next') {
            currentImageIndex = (currentImageIndex + 1) % images.length;
        } else {
            currentImageIndex = currentImageIndex === 0 ? images.length - 1 : currentImageIndex - 1;
        }
        updateMainImage();
    }

    function updateMainImage() {
        const mainImage = document.getElementById('mainImage');
        mainImage.style.opacity = '0';
        setTimeout(() => {
            mainImage.src = images[currentImageIndex];
            mainImage.style.opacity = '1';
        }, 150);
    }

    // Añadir transición suave a las imágenes
    document.getElementById('mainImage').style.transition = 'opacity 150ms ease-in-out';
</script>

@endsection