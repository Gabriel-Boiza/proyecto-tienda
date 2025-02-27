@extends('app-admin.vista_admin')

@section('title', 'Editar Producto')

@section('contentAdmin')
<div class="flex-1 p-8 flex flex-col h-full">
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-xl font-bold">Editar Producto</h1>
        <a href="/productos" class="text-gray-400 hover:text-white">
            Volver a la lista
        </a>
    </div>

    <form action="{{ route('productos.update', $producto->id) }}" method="POST" enctype="multipart/form-data" class="bg-zinc-800/50 border border-zinc-700 rounded-md p-6 space-y-6">
        @csrf
        @method('PUT')
        
        <!-- Información básica -->
        <div class="space-y-6">
            <h2 class="text-lg font-semibold border-b border-zinc-700 pb-2">Información Básica</h2>
            
            <div class="grid grid-cols-2 gap-6">
                <!-- Nombre -->
                <div>
                    <label for="nombre" class="block text-sm font-medium text-gray-400 mb-1">Nombre del Producto</label>
                    <input type="text" 
                           name="nombre" 
                           id="nombre" 
                           value="{{ $producto->nombre }}"
                           class="w-full bg-zinc-800 border border-zinc-700 rounded-md px-4 py-2 text-white focus:border-purple-500 focus:ring-1 focus:ring-purple-500">
                </div>

                <!-- Precio -->
                <div>
                    <label for="precio" class="block text-sm font-medium text-gray-400 mb-1">Precio</label>
                    <div class="relative">
                        <span class="absolute left-3 top-2 text-gray-500">$</span>
                        <input type="number" 
                               name="precio" 
                               id="precio" 
                               step="0.01" 
                               value="{{ $producto->precio }}"
                               class="w-full bg-zinc-800 border border-zinc-700 rounded-md pl-8 pr-4 py-2 text-white focus:border-purple-500 focus:ring-1 focus:ring-purple-500">
                    </div>
                </div>
            </div>

            <!-- Descripción -->
            <div>
                <label for="descripcion" class="block text-sm font-medium text-gray-400 mb-1">Descripción</label>
                <textarea name="descripcion" 
                          id="descripcion" 
                          rows="3" 
                          class="w-full bg-zinc-800 border border-zinc-700 rounded-md px-4 py-2 text-white focus:border-purple-500 focus:ring-1 focus:ring-purple-500">{{ $producto->descripcion }}</textarea>
            </div>

            <!-- Stock -->
            <div>
                <label for="stock" class="block text-sm font-medium text-gray-400 mb-1">Stock Disponible</label>
                <input type="number" 
                       name="stock" 
                       id="stock" 
                       min="0" 
                       value="{{ $producto->stock }}"
                       class="w-full bg-zinc-800 border border-zinc-700 rounded-md px-4 py-2 text-white focus:border-purple-500 focus:ring-1 focus:ring-purple-500">
            </div>
        </div>

        <!-- Categorías -->
        <div class="space-y-4">
            <h2 class="text-lg font-semibold border-b border-zinc-700 pb-2">Categorías</h2>
            <div class="grid grid-cols-3 gap-4">
                @foreach($categorias as $categoria)
                    <label class="flex items-center space-x-2">
                        <input type="checkbox" 
                               name="categorias[]" 
                               value="{{ $categoria->id }}" 
                               {{ $producto->categorias->contains($categoria->id) ? 'checked' : '' }}
                               class="rounded text-purple-500 bg-zinc-800 border-zinc-700">
                        <span>{{ $categoria->nombre_categoria }}</span>
                    </label>
                @endforeach
            </div>
        </div>

        <!-- Marca -->
        <div class="relative w-full">
            <label for="marca" class="block text-sm font-medium text-gray-400 mb-1">Marca</label>
            <select id="marca" name="fk_marca" 
                class="appearance-none w-full bg-zinc-800 border border-zinc-700 rounded-md px-4 py-2 text-white focus:border-purple-500 focus:ring-1 focus:ring-purple-500">

                <option value="" disabled {{ $producto->marca ? '' : 'selected' }}>Selecciona una marca...</option>

                @foreach($marcas as $marca)
                    <option value="{{ $marca->id }}" 
                        {{ $producto->marca && $producto->marca->id == $marca->id ? 'selected' : '' }}>
                        {{ $marca->nombre }}
                    </option>
                @endforeach
            </select>
        </div>
        
        <!-- Contenedor para las características -->
        <div class="space-y-4">
            <h2 class="text-lg font-semibold border-b border-zinc-700 pb-2">Características</h2>
            <div>
                <div id='caracteristicas-container' class="caracteristica-input flex flex-wrap">
                </div>
            </div>
            
            <!-- Botón para añadir otra característica -->
            <button type="button" id="agregarCaracteristica" class="mt-2 px-4 py-2 bg-purple-500 text-white rounded-md">
                Añadir otra característica
            </button>
            
            <!-- Botón para crear una nueva característica (acción personalizada) -->
            <button type="button" id="crearCaracteristica" class="mt-2 px-4 py-2 bg-purple-500 text-white rounded-md">
                Crear nueva característica
            </button>
        </div>

        <!-- Imágenes -->
        <div class="space-y-4">
            <h2 class="text-lg font-semibold border-b border-zinc-700 pb-2">Imágenes</h2>
            
            <!-- Imagen Principal -->
            <div>
                <label class="block text-sm font-medium text-gray-400 mb-2">Imagen Principal Actual</label>
                <img id="imagenPrincipalPreview" 
                    src="{{ asset('storage/'.$producto->imagen_principal) }}" 
                    alt="Imagen principal" 
                    class="w-32 h-32 object-cover rounded-md mb-2">
                <input type="file" 
                    name="imagen_principal" 
                    accept="image/*"
                    onchange="previewImage(event, 'imagenPrincipalPreview')" 
                    class="block w-full text-sm text-gray-400
                            file:mr-4 file:py-2 file:px-4
                            file:rounded-md file:border-0
                            file:text-sm file:font-semibold
                            file:bg-purple-600 file:text-white
                            hover:file:bg-purple-500">
            </div>

            <!-- Imágenes Adicionales -->
            <div>
                <label class="block text-sm font-medium text-gray-400 mb-2">Imágenes Adicionales</label>
                <div id="preview-container" class="grid grid-cols-4 gap-4 mb-4">
                    @foreach($imagenesAdicionales as $imagen)
                        <div class="relative group" id="imagen-{{ $imagen->id }}">
                            <img src="{{ asset('storage/'.$imagen->imagen) }}" 
                                alt="Imagen adicional" 
                                class="w-full h-24 object-cover rounded-md">
                            
                            <!-- Botón de eliminación con evento onclick -->
                            <button type="button" 
                                    onclick="eliminarImagen('{{ $imagen->id }}')"
                                    class="absolute top-1 right-1 bg-red-500 rounded-full p-1 text-white">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                            
                            <!-- Input oculto para enviar imágenes a eliminar -->
                            <input type="hidden" name="imagenes_eliminar[]" value="{{ $imagen->id }}" disabled>
                        </div>
                    @endforeach
                </div>
                <input type="file" 
                name="imagenes_adicionales[]" 
                multiple 
                accept="image/*"
                onchange="handleImageUpload(event)"
                class="block w-full text-sm text-gray-400
                        file:mr-4 file:py-2 file:px-4
                        file:rounded-md file:border-0
                        file:text-sm file:font-semibold
                        file:bg-purple-600 file:text-white
                        hover:file:bg-purple-500">
            </div>
        </div>

        <!-- Botones -->
        <div class="flex justify-end space-x-4 pt-6 border-t border-zinc-700">
            <button type="button" 
                    onclick="window.history.back()" 
                    class="px-4 py-2 bg-zinc-700 text-white rounded-md hover:bg-zinc-600">
                Cancelar
            </button>
            <button type="submit" 
                    class="px-4 py-2 bg-purple-600 text-white rounded-md hover:bg-purple-500">
                Guardar Cambios
            </button>
        </div>
    </form>
</div>

<script src="{{ asset('js/app-admin/editarCaracteristicas.js') }}"></script>
<script>
    const marcaInput = document.getElementById('marca');
    const marcaList = document.getElementById('marcas');

    marcaInput.addEventListener('input', function() {
        const option = Array.from(marcaList.options).find(option => option.value === marcaInput.value);
        
        if (option) {
            marcaInput.value = option.value;  // Muestra el nombre de la marca
            document.getElementById('marca-id').value = option.getAttribute('data-id'); // Establece el id de la marca seleccionada
        }
    });
    
    const maxImages = 4;
    let uploadedImages = {{ count($imagenesAdicionales) }};
    let currentFiles = new DataTransfer();

    function handleImageUpload(event) {
        const input = event.target;
        const files = input.files;
        const previewContainer = document.getElementById('preview-container');

        if (uploadedImages + files.length > maxImages) {
            alert(`Solo puedes subir un máximo de ${maxImages} imágenes.`);
            input.value = "";
            return;
        }

        Array.from(files).forEach(file => {
            if (uploadedImages >= maxImages) return;

            currentFiles.items.add(file);

            const reader = new FileReader();
            reader.onload = function(e) {
                const previewDiv = document.createElement('div');
                previewDiv.className = 'relative group';
                previewDiv.dataset.filename = file.name;
                
                previewDiv.innerHTML = `
                    <img src="${e.target.result}" class="w-full h-32 object-cover rounded-md" />
                    <button type="button" onclick="removeImage(this, '${file.name}')" class="absolute top-2 right-2 bg-red-500 text-white rounded-full p-1 opacity-0 group-hover:opacity-100 transition-opacity">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                `;
                
                previewContainer.appendChild(previewDiv);
                uploadedImages++;
            };
            reader.readAsDataURL(file);
        });

        // Asignar los archivos actualizados al input
        input.files = currentFiles.files;
    }

    function removeImage(button, filename) {
        const previewDiv = button.parentElement;
        previewDiv.remove();
        uploadedImages--;

        // Eliminar archivo del DataTransfer
        const newFiles = new DataTransfer();
        Array.from(currentFiles.files).forEach(file => {
            if (file.name !== filename) {
                newFiles.items.add(file);
            }
        });

        currentFiles = newFiles;
        document.getElementById('imagenes_adicionales').files = currentFiles.files;
    }

    function previewImage(event, previewElementId) {
        const reader = new FileReader();
        reader.onload = function() {
            document.getElementById(previewElementId).src = reader.result;
        }
        reader.readAsDataURL(event.target.files[0]);
    }

    function eliminarImagen(id) {
        const imageDiv = document.getElementById(`imagen-${id}`);
        if (imageDiv) {
            // Buscar el input oculto y activarlo
            const hiddenInput = imageDiv.querySelector(`input[name="imagenes_eliminar[]"]`);
            hiddenInput.removeAttribute("disabled");

            // Ocultar la imagen
            imageDiv.style.display = "none";

            uploadedImages--;

            console.log(`Imagen eliminada. Total ahora: ${uploadedImages}`);
        }
    }
</script>
@endsection