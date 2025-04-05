@extends('app-admin.vista_admin')

@section('title', 'Editar Producto')

@section('contentAdmin')
<div class="flex-1 p-8 flex flex-col h-full">
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-xl font-bold">Editar Producto</h1>
        <a href="/productos" class="text-gray-400 hover:text-white" aria-label="Volver a la lista de productos">
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
                           class="w-full bg-zinc-800 border border-zinc-700 rounded-md px-4 py-2 text-white focus:border-purple-500 focus:ring-1 focus:ring-purple-500"
                           aria-label="Nombre del producto"> {{-- Added aria-label --}}
                </div>

                <!-- Precio -->
                <div>
                    <label for="precio" class="block text-sm font-medium text-gray-400 mb-1">Precio</label>
                    <div class="relative">
                        <span class="absolute left-3 top-2 text-gray-500" aria-hidden="true">€</span> {{-- Changed to € and added aria-hidden --}}
                        <input type="number"
                               name="precio"
                               id="precio"
                               step="0.01"
                               value="{{ $producto->precio }}"
                               class="w-full bg-zinc-800 border border-zinc-700 rounded-md pl-8 pr-4 py-2 text-white focus:border-purple-500 focus:ring-1 focus:ring-purple-500"
                               aria-label="Precio del producto en euros"> {{-- Added aria-label --}}
                    </div>
                </div>
            </div>

            <!-- Descripción -->
            <div>
                <label for="descripcion" class="block text-sm font-medium text-gray-400 mb-1">Descripción</label>
                <textarea name="descripcion"
                          id="descripcion"
                          rows="3"
                          class="w-full bg-zinc-800 border border-zinc-700 rounded-md px-4 py-2 text-white focus:border-purple-500 focus:ring-1 focus:ring-purple-500"
                          aria-label="Descripción detallada del producto">{{ $producto->descripcion }}</textarea> {{-- Added aria-label --}}
            </div>

            <!-- Stock -->
            <div>
                <label for="stock" class="block text-sm font-medium text-gray-400 mb-1">Stock Disponible</label>
                <input type="number"
                       name="stock"
                       id="stock"
                       min="0"
                       value="{{ $producto->stock }}"
                       class="w-full bg-zinc-800 border border-zinc-700 rounded-md px-4 py-2 text-white focus:border-purple-500 focus:ring-1 focus:ring-purple-500"
                       aria-label="Cantidad de stock disponible"> {{-- Added aria-label --}}
            </div>

            <div>
                <label class="flex items-center space-x-2">
                    <input type="checkbox"
                        name="personalizable"
                        id="personalizable"
                        {{ $producto->personalizable ? 'checked' : '' }}
                        class="rounded text-purple-500 bg-zinc-800 border-zinc-700"
                        aria-describedby="personalizable-descripcion"> {{-- Added aria-describedby --}}
                    <span class="text-sm font-medium text-gray-400">Producto Personalizable</span>
                </label>
                <p id="personalizable-descripcion" class="mt-1 text-sm text-gray-500">Marca esta opción si el producto puede ser personalizado por el cliente</p>
            </div>
            <!-- Descuento -->
            <div>
                <label for="descuento" class="block text-sm font-medium text-gray-400 mb-1">Descuento</label>
                <div class="relative">
                    <input type="number"
                        name="descuento"
                        id="descuento"
                        min="0"
                        max="100"
                        value="{{ $producto->descuento }}"
                        class="w-full bg-zinc-800 border border-zinc-700 rounded-md pr-8 px-4 py-2 text-white focus:border-purple-500 focus:ring-1 focus:ring-purple-500"
                        aria-label="Porcentaje de descuento aplicado al producto"> {{-- Added aria-label --}}
                    <span class="absolute right-3 top-2 text-gray-500" aria-hidden="true">%</span> {{-- Added aria-hidden --}}
                </div>
            </div>
        </div>

        <!-- Categorías -->
        <div class="space-y-4">
            <h2 class="text-lg font-semibold border-b border-zinc-700 pb-2">Categorías</h2>
            <div class="grid grid-cols-3 gap-4" role="group" aria-labelledby="categorias-heading"> {{-- Added role and aria-labelledby --}}
                 <h3 id="categorias-heading" class="sr-only">Seleccionar categorías</h3> {{-- Screen reader only heading --}}
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
                class="appearance-none w-full bg-zinc-800 border border-zinc-700 rounded-md px-4 py-2 text-white focus:border-purple-500 focus:ring-1 focus:ring-purple-500"
                aria-label="Seleccionar la marca del producto"> {{-- Added aria-label --}}

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
                    {{-- Characteristics added by JS will need aria-labels added in editarCaracteristicas.js --}}
                </div>
            </div>

            <!-- Botón para añadir otra característica -->
            <button type="button" id="agregarCaracteristica" class="mt-2 px-4 py-2 bg-purple-500 text-white rounded-md" aria-label="Añadir otra característica al producto">
                Añadir otra característica
            </button>

            <!-- Botón para crear una nueva característica (acción personalizada) -->
            <button type="button" id="crearCaracteristica" class="mt-2 px-4 py-2 bg-purple-500 text-white rounded-md" aria-label="Crear una nueva característica y añadirla a la lista">
                Crear nueva característica
            </button>
        </div>

        <!-- Imágenes -->
        <div class="space-y-4">
            <h2 class="text-lg font-semibold border-b border-zinc-700 pb-2">Imágenes</h2>

            <!-- Imagen Principal -->
            <div>
                <label for="imagen_principal_input" class="block text-sm font-medium text-gray-400 mb-2">Imagen Principal Actual</label> {{-- Changed label 'for' --}}
                <img id="imagenPrincipalPreview"
                    src="{{ asset('storage/'.$producto->imagen_principal) }}"
                    alt="Imagen principal actual del producto {{ $producto->nombre }}" {{-- Improved alt text --}}
                    class="w-32 h-32 object-cover rounded-md mb-2">
                <input type="file"
                    name="imagen_principal"
                    id="imagen_principal_input" {{-- Added ID --}}
                    accept="image/*"
                    onchange="previewImage(event, 'imagenPrincipalPreview')"
                    class="block w-full text-sm text-gray-400
                            file:mr-4 file:py-2 file:px-4
                            file:rounded-md file:border-0
                            file:text-sm file:font-semibold
                            file:bg-purple-600 file:text-white
                            hover:file:bg-purple-500"
                    aria-label="Subir nueva imagen principal"> {{-- Added aria-label --}}
            </div>

            <!-- Imágenes Adicionales -->
            <div>
                <label for="imagenes_adicionales_input" class="block text-sm font-medium text-gray-400 mb-2">Imágenes Adicionales</label> {{-- Changed label 'for' --}}
                <div id="preview-container" class="grid grid-cols-4 gap-4 mb-4">
                    @foreach($imagenesAdicionales as $imagen)
                        <div class="relative group" id="imagen-{{ $imagen->id }}">
                            <img src="{{ asset('storage/'.$imagen->imagen) }}"
                                alt="Imagen adicional {{ $loop->iteration }} del producto {{ $producto->nombre }}" {{-- Improved alt text --}}
                                class="w-full h-24 object-cover rounded-md">

                            <!-- Botón de eliminación con evento onclick -->
                            <button type="button"
                                    onclick="eliminarImagen('{{ $imagen->id }}')"
                                    class="absolute top-1 right-1 bg-red-500 rounded-full p-1 text-white"
                                    aria-label="Eliminar imagen adicional {{ $loop->iteration }}"> {{-- Added aria-label --}}
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"> {{-- Added aria-hidden --}}
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>

                            <!-- Input oculto para enviar imágenes a eliminar -->
                            <input type="hidden" name="imagenes_eliminar[]" value="{{ $imagen->id }}" disabled>
                        </div>
                    @endforeach
                    {{-- Previews for new images added by JS will need aria-labels on their delete buttons (added in JS) --}}
                </div>
                <input type="file"
                    name="imagenes_adicionales[]"
                    id="imagenes_adicionales_input" {{-- Added ID --}}
                    multiple
                    accept="image/*"
                    onchange="handleImageUpload(event)"
                    class="block w-full text-sm text-gray-400
                            file:mr-4 file:py-2 file:px-4
                            file:rounded-md file:border-0
                            file:text-sm file:font-semibold
                            file:bg-purple-600 file:text-white
                            hover:file:bg-purple-500"
                    aria-label="Subir nuevas imágenes adicionales (hasta 4 en total)"> {{-- Added aria-label --}}
            </div>
        </div>

        <!-- Botones -->
        <div class="flex justify-end space-x-4 pt-6 border-t border-zinc-700">
            <button type="button"
                    onclick="window.history.back()"
                    class="px-4 py-2 bg-zinc-700 text-white rounded-md hover:bg-zinc-600"
                    aria-label="Cancelar edición y volver atrás">
                Cancelar
            </button>
            <button type="submit"
                    class="px-4 py-2 bg-purple-600 text-white rounded-md hover:bg-purple-500"
                    aria-label="Guardar los cambios realizados en el producto">
                Guardar Cambios
            </button>
        </div>
    </form>
</div>

<script src="{{ asset('js/app-admin/editarCaracteristicas.js') }}"></script>
<script>
    // Removed duplicate marca script as it wasn't functional

    const maxImages = 4;
    let uploadedImages = {{ count($imagenesAdicionales) }};
    let currentFiles = new DataTransfer();

    function handleImageUpload(event) {
        const input = event.target;
        const files = input.files;
        const previewContainer = document.getElementById('preview-container');

        if (uploadedImages + files.length > maxImages) {
            alert(`Solo puedes subir un máximo de ${maxImages} imágenes.`);
            // Clear the selection in the file input
             input.value = ""; // For modern browsers
             // For older browsers, you might need to recreate the input element
            return;
        }

        Array.from(files).forEach(file => {
            if (uploadedImages >= maxImages) return;

            // Check if file already exists in currentFiles based on name and size
            let fileExists = false;
            for (let i = 0; i < currentFiles.items.length; i++) {
                const existingFile = currentFiles.items[i].getAsFile();
                if (existingFile && existingFile.name === file.name && existingFile.size === file.size) {
                    fileExists = true;
                    break;
                }
            }

            if (fileExists) {
                console.warn(`File "${file.name}" already added. Skipping.`);
                return; // Skip adding duplicate file
            }


            currentFiles.items.add(file);

            const reader = new FileReader();
            reader.onload = function(e) {
                const previewDiv = document.createElement('div');
                previewDiv.className = 'relative group';
                previewDiv.dataset.filename = file.name; // Store filename for removal

                previewDiv.innerHTML = `
                    <img src="${e.target.result}" alt="Previsualización de nueva imagen adicional: ${file.name}" class="w-full h-24 object-cover rounded-md" /> {{-- Improved alt text --}}
                    <button type="button" onclick="removeImage(this, '${file.name}')" class="absolute top-1 right-1 bg-red-500 text-white rounded-full p-1 opacity-0 group-hover:opacity-100 transition-opacity" aria-label="Eliminar previsualización de imagen ${file.name}"> {{-- Added aria-label --}}
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"> {{-- Added aria-hidden --}}
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                `;

                previewContainer.appendChild(previewDiv);
                uploadedImages++;
                updateFileInput(); // Update the input after adding
            };
            reader.readAsDataURL(file);
        });

        // Clear the input value after processing to allow re-selecting the same file if removed
        input.value = "";
    }

     function removeImage(button, filename) {
        const previewDiv = button.closest('.relative.group'); // Find the parent container
        if (!previewDiv) return;

        previewDiv.remove();
        uploadedImages--;

        // Remove file from DataTransfer
        const newFiles = new DataTransfer();
        let removed = false;
        Array.from(currentFiles.files).forEach(file => {
            if (file.name === filename && !removed) {
                removed = true; // Remove only the first match
            } else {
                newFiles.items.add(file);
            }
        });

        currentFiles = newFiles;
        updateFileInput(); // Update the input after removing
    }

    function updateFileInput() {
         // Assign the updated files list back to the input
        const fileInput = document.getElementById('imagenes_adicionales_input');
        if (fileInput) {
            fileInput.files = currentFiles.files;
        }
        console.log(`Total images now: ${uploadedImages}`, currentFiles.files);
    }


    function previewImage(event, previewElementId) {
        const input = event.target;
        const preview = document.getElementById(previewElementId);
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.alt = `Previsualización de nueva imagen principal: ${input.files[0].name}`; // Update alt text
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    function eliminarImagen(id) {
        const imageDiv = document.getElementById(`imagen-${id}`);
        if (imageDiv) {
            // Find the hidden input and enable it
            const hiddenInput = imageDiv.querySelector(`input[name="imagenes_eliminar[]"]`);
            if (hiddenInput) {
                hiddenInput.disabled = false; // Enable the input so its value is submitted
            }

            // Hide the image visually
            imageDiv.style.display = "none";

            uploadedImages--; // Decrement count of existing images

            console.log(`Imagen existente ${id} marcada para eliminar. Total ahora: ${uploadedImages}`);
            updateFileInput(); // Update input in case this affects total count logic
        }
    }

    // Ensure the characteristics script runs after the DOM is ready
    // document.addEventListener('DOMContentLoaded', (event) => {
    //     // Call functions from editarCaracteristicas.js if needed here
    // });

</script>
@endsection