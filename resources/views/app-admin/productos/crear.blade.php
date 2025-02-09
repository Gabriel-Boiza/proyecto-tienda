<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Producto</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-zinc-900 text-white h-screen">
    <div class="flex h-full">
        <!-- Aside -->
        @include('app-admin.componentes.panel_admin')

        <!-- Main Content -->
        <main class="flex-1 p-8 flex flex-col h-full">
            <div class="flex justify-between items-center mb-4">
                <h1 class="text-xl font-bold">Crear Nuevo Producto</h1>
                <a href="/productos" class="text-gray-400 hover:text-white">
                    Volver a la lista
                </a>
            </div>

            <form action="{{ route('productos.store') }}" method="POST" enctype="multipart/form-data" class="bg-zinc-800/50 border border-zinc-700 rounded-md p-6 space-y-6 flex-1 overflow-auto">
            @csrf
                
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
                                  class="w-full bg-zinc-800 border border-zinc-700 rounded-md px-4 py-2 text-white focus:border-purple-500 focus:ring-1 focus:ring-purple-500"></textarea>
                    </div>

                    <!-- Stock -->
                    <div>
                        <label for="stock" class="block text-sm font-medium text-gray-400 mb-1">Stock Disponible</label>
                        <input type="number" 
                               name="stock" 
                               id="stock" 
                               min="0" 
                               class="w-full bg-zinc-800 border border-zinc-700 rounded-md px-4 py-2 text-white focus:border-purple-500 focus:ring-1 focus:ring-purple-500">
                    </div>
                </div>

                <!-- Categorías -->
                <div class="space-y-4">
                    <h2 class="text-lg font-semibold border-b border-zinc-700 pb-2">Categorías</h2>
                    <div class="grid grid-cols-3 gap-4">
                        <?php
                            foreach($categorias as $indice => $categoria){
                                ?>
                                <label class="flex items-center space-x-2">
                                    <input type="checkbox" 
                                        name="categorias[]" 
                                        value="<?php echo $categoria['id']; ?>" 
                                        class="rounded text-purple-500 bg-zinc-800 border-zinc-700">
                                    <span><?php echo $categoria['nombre_categoria']; ?></span>
                                </label>
                                <?php
                                }
                        ?>
                    </div>
                </div>

                <!-- Imágenes -->
                <div class="space-y-4">
                    <h2 class="text-lg font-semibold border-b border-zinc-700 pb-2">Imágenes del Producto</h2>
                    
                    <!-- Imagen Principal -->
                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-2">Imagen Principal</label>
                        <div class="flex items-center justify-center w-full">
                            <label class="flex flex-col w-full h-32 border-2 border-dashed border-zinc-700 rounded-md hover:bg-zinc-800 cursor-pointer">
                                <div class="flex flex-col items-center justify-center pt-7">
                                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    <p class="pt-1 text-sm tracking-wider text-gray-400">Subir imagen principal</p>
                                </div>
                                <input type="file" name="imagen_principal" class="opacity-0" accept="image/*"/>
                            </label>
                        </div>
                    </div>

                    <!-- Imágenes Adicionales -->
                    <div class="space-y-4">
                        <label class="block text-sm font-medium text-gray-400 mb-2">
                            Imágenes Adicionales (<span id="image-counter">0</span>/4)
                        </label>
                        
                        <!-- Preview Container -->
                        <div id="preview-container" class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-4">
                            <!-- Preview images will be inserted here -->
                        </div>

                        <!-- Upload Button - Only shown if less than 4 images -->
                        <div id="upload-container" class="flex items-center justify-center w-full">
                            <label class="flex flex-col w-full h-32 border-2 border-dashed border-zinc-700 rounded-md hover:bg-zinc-800 cursor-pointer">
                                <div class="flex flex-col items-center justify-center pt-7">
                                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    <p class="pt-1 text-sm tracking-wider text-gray-400">Subir imágenes adicionales</p>
                                </div>
                                <input type="file" 
                                       name="imagenes_adicionales[]" 
                                       id="imagenes_adicionales"
                                       class="opacity-0" 
                                       accept="image/*" 
                                       multiple
                                       onchange="handleImageUpload(this)"/>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Botones de acción -->
                <div class="flex justify-end space-x-4 pt-6 border-t border-zinc-700">
                    <button type="button" 
                            onclick="window.history.back()" 
                            class="px-4 py-2 bg-zinc-700 text-white rounded-md hover:bg-zinc-600">
                        Cancelar
                    </button>
                    <button type="submit" 
                            class="px-4 py-2 bg-purple-600 text-white rounded-md hover:bg-purple-500">
                        Crear Producto
                    </button>
                </div>
            </form>
        </main>
    </div>

    <script>
    const maxImages = 4;
    let uploadedImages = 0;
    let currentFiles = new DataTransfer();

    function handleImageUpload(input) {
        const previewContainer = document.getElementById('preview-container');
        const uploadContainer = document.getElementById('upload-container');
        const counter = document.getElementById('image-counter');
        const files = input.files;

        // Check if adding these files would exceed the limit
        if (uploadedImages + files.length > maxImages) {
            alert(`Solo puedes subir un máximo de ${maxImages} imágenes. Por favor, selecciona menos imágenes.`);
            input.value = '';
            return;
        }

        // Process each selected file
        Array.from(files).forEach(file => {
            if (uploadedImages >= maxImages) return;

            // Add file to our DataTransfer object
            currentFiles.items.add(file);

            const reader = new FileReader();
            reader.onload = function(e) {
                // Create preview element
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

                // Hide upload button if max images reached
                if (uploadedImages >= maxImages) {
                    uploadContainer.style.display = 'none';
                }
            };
            reader.readAsDataURL(file);
        });

        // Update the input's files
        input.files = currentFiles.files;
    }

    function removeImage(button) {
        const previewDiv = button.parentElement;
        const filename = previewDiv.dataset.filename;
        const input = document.getElementById('imagenes_adicionales');
        const uploadContainer = document.getElementById('upload-container');
        const counter = document.getElementById('image-counter');

        // Create new DataTransfer object
        const newFiles = new DataTransfer();

        // Add all files except the one being removed
        Array.from(currentFiles.files).forEach(file => {
            if (file.name !== filename) {
                newFiles.items.add(file);
            }
        });

        // Update our currentFiles
        currentFiles = newFiles;

        // Update the input's files
        input.files = currentFiles.files;

        previewDiv.remove();
        uploadedImages--;
        counter.textContent = uploadedImages;

        // Show upload button if below max images
        if (uploadedImages < maxImages) {
            uploadContainer.style.display = 'flex';
        }
    }
    </script>
</body>
</html>