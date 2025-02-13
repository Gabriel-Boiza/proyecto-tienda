<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Producto</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-zinc-900 text-white h-screen">
    <div class="flex h-full">
        <!-- Aside -->
        @include('app-admin.componentes.panel_admin')

        <!-- Main Content -->
        <main class="flex-1 p-8 flex flex-col h-full">
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
                <div class="relative">
                    <img src="{{ asset('storage/'.$imagen->imagen) }}" 
                        alt="Imagen adicional" 
                        class="w-full h-24 object-cover rounded-md">
                    <button type="button" 
                            onclick="this.parentElement.remove()"
                            class="absolute top-1 right-1 bg-red-500 rounded-full p-1 text-white">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
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
        </main>
    </div>

    <script>
    const maxImages = 4;
    let uploadedImages = {{ count($imagenesAdicionales) }};
    let currentFiles = new DataTransfer();

    function handleImageUpload(input) {
        const previewContainer = document.getElementById('preview-container');
        const uploadContainer = document.getElementById('upload-container');
        const counter = document.getElementById('image-counter');
        const files = input.files;

        if (uploadedImages + files.length > maxImages) {
            alert(`Solo puedes subir un máximo de ${maxImages} imágenes. Por favor, selecciona menos imágenes.`);
            input.value = '';
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
                    <button type="button" onclick="removeImage(this)" class="absolute top-2 right-2 bg-red-500 text-white rounded-full p-1 opacity-0 group-hover:opacity-100 transition-opacity">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                `;
                
                previewContainer.appendChild(previewDiv);
                uploadedImages++;
                counter.textContent = uploadedImages;

                if (uploadedImages >= maxImages) {
                    uploadContainer.style.display = 'none';
                }
            };
            reader.readAsDataURL(file);
        });

        input.files = currentFiles.files;
    }

    function removeImage(button) {
        const previewDiv = button.parentElement;
        const filename = previewDiv.dataset.filename;
        
        // If removing an existing image, add it to a list of images to delete
        const existingImageInput = previewDiv.querySelector('input[name="imagenes_existentes[]"]');
        if (existingImageInput) {
            const deleteInput = document.createElement('input');
            deleteInput.type = 'hidden';
            deleteInput.name = 'imagenes_eliminar[]';
            deleteInput.value = existingImageInput.value;
            document.querySelector('form').appendChild(deleteInput);
        } else {
            // If removing a new image, update the DataTransfer object
            const newFiles = new DataTransfer();
            Array.from(currentFiles.files).forEach(file => {
                if (file.name !== filename) {
                    newFiles.items.add(file);
                }
            });
            currentFiles = newFiles;
            document.getElementById('imagenes_adicionales').files = currentFiles.files;
        }

        previewDiv.remove();
        uploadedImages--;
        document.getElementById('image-counter').textContent = uploadedImages;

        if (uploadedImages < maxImages) {
            document.getElementById('upload-container').style.display = 'flex';
        }
    }
    function previewImage(event, previewElementId) {
        const reader = new FileReader();
        reader.onload = function() {
            const previewElement = document.getElementById(previewElementId);
            previewElement.src = reader.result;
        }
        reader.readAsDataURL(event.target.files[0]);
    }
    function handleImageUpload(event) {
        const files = event.target.files;
        const previewContainer = document.getElementById('preview-container');
        
        Array.from(files).forEach(file => {
            const reader = new FileReader();
            reader.onload = function(e) {
                const previewDiv = document.createElement('div');
                previewDiv.className = 'relative group';
                previewDiv.innerHTML = `
                    <img src="${e.target.result}" class="w-full h-24 object-cover rounded-md" />
                    <button type="button" onclick="removePreview(this)" class="absolute top-2 right-2 bg-red-500 text-white rounded-full p-1 opacity-0 group-hover:opacity-100 transition-opacity">
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
    }

    function removePreview(button) {
        const previewDiv = button.parentElement;
        previewDiv.remove();
        uploadedImages--;
    }
    </script>
</body>
</html>