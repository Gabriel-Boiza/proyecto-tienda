<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Productos</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-zinc-900 text-white p-8">
    <div class="flex">
        <!-- Aside -->
        @include('app-admin.componentes.panel_admin')
        
        <!-- Main Content -->
        <main class="flex-1 p-6">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-xl font-bold">Lista de Productos</h1>
                <a href="{{ route('productos.create') }}" class="bg-purple-600 text-white px-4 py-2 rounded-md inline-block hover:bg-purple-700">
                    Añadir Producto
                </a>
            </div>

            <!-- Search and Filter Section -->
            <div class="mb-6 space-y-4">
                <!-- Search bar -->
                <div class="flex space-x-4">
                    <input type="text" 
                           id="searchInput"
                           placeholder="Buscar productos..." 
                           class="flex-1 bg-zinc-800 rounded-md px-4 py-2 text-gray-300">
                    
                    <!-- Categories Dropdown -->
                    <select id="categoryFilter" 
                            class="bg-zinc-800 rounded-md px-4 py-2 text-gray-300">
                        <option value="">Todas las categorías</option>
                    </select>
                </div>
            </div>

            <!-- Products Table -->
            <div class="bg-zinc-800/50 rounded-lg overflow-hidden">
                <table id="tabla-productos" class="w-full">
                    <thead>
                        <tr class="text-left text-gray-400 border-b border-zinc-700">
                            <th class="p-4">ID</th>
                            <th class="p-4">Nombre</th>
                            <th class="p-4">Descripción</th>
                            <th class="p-4">Precio</th>
                            <th class="p-4">Stock</th>
                            <th class="p-4">Categorías</th>
                            <th class="p-4">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Los productos se llenarán aquí con JavaScript -->
                    </tbody>
                </table>
            </div>
        </main>
    </div>

    <script>
        let allProducts = []; // Store all products
        let categories = new Set(); // Store unique categories

        // Function to filter products
        function filterProducts() {
            const searchTerm = document.getElementById('searchInput').value.toLowerCase();
            const selectedCategory = document.getElementById('categoryFilter').value.toLowerCase();
            
            const filteredProducts = allProducts.filter(product => {
                const matchesSearch = product.nombre.toLowerCase().includes(searchTerm);
                const matchesCategory = selectedCategory === '' || 
                    (product.categorias && product.categorias.some(cat => 
                        cat.nombre_categoria.toLowerCase() === selectedCategory
                    ));
                return matchesSearch && matchesCategory;
            });

            updateTable(filteredProducts);
        }

        // Function to update the table with filtered products
        function updateTable(products) {
            const tablaProductos = document.getElementById('tabla-productos').getElementsByTagName('tbody')[0];
            tablaProductos.innerHTML = ''; // Clear current table

            products.forEach(producto => {
                const row = tablaProductos.insertRow();
                row.className = "border-b border-zinc-700 hover:bg-zinc-700/50";

                const cells = [
                    row.insertCell(0), // ID
                    row.insertCell(1), // Nombre
                    row.insertCell(2), // Descripción
                    row.insertCell(3), // Precio
                    row.insertCell(4), // Stock
                    row.insertCell(5), // Categorías
                    row.insertCell(6)  // Acciones
                ];

                cells.forEach(cell => {
                    cell.className = "p-4 text-gray-300";
                });

                cells[0].textContent = producto.id;
                cells[1].textContent = producto.nombre;
                cells[2].textContent = producto.descripcion;
                cells[3].textContent = `$${producto.precio.toFixed(2)}`;
                cells[4].textContent = producto.stock;

                if (producto.categorias && producto.categorias.length > 0) {
                    const categoriasContainer = document.createElement('div');
                    categoriasContainer.className = 'flex flex-wrap gap-2';
                    
                    producto.categorias.forEach(categoria => {
                        const categoriaTag = document.createElement('span');
                        categoriaTag.className = 'bg-purple-500/30 text-purple-200 px-2 py-1 rounded-md text-xs';
                        categoriaTag.textContent = categoria.nombre_categoria;
                        categoriasContainer.appendChild(categoriaTag);
                    });
                    
                    cells[5].appendChild(categoriasContainer);
                } else {
                    cells[5].textContent = 'Sin categorías';
                }

                // Crear contenedor para los iconos de acciones
                const accionesContainer = document.createElement('div');
                accionesContainer.className = 'flex items-center gap-3';

                // Icono de Ver
                const verBtn = document.createElement('button');
                verBtn.className = 'text-blue-400 hover:text-blue-300';
                verBtn.innerHTML = `
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                `;
                verBtn.onclick = () => verProducto(producto.id);

                // Icono de Editar
                const editarBtn = document.createElement('button');
                editarBtn.className = 'text-yellow-400 hover:text-yellow-300';
                editarBtn.innerHTML = `
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                    </svg>
                `;
                editarBtn.onclick = () => editarProducto(producto.id);

                // Icono de Eliminar
                const eliminarBtn = document.createElement('button');
                eliminarBtn.className = 'text-red-400 hover:text-red-300';
                eliminarBtn.innerHTML = `
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                    </svg>
                `;
                eliminarBtn.onclick = () => eliminarProducto(producto.id);

                accionesContainer.appendChild(verBtn);
                accionesContainer.appendChild(editarBtn);
                accionesContainer.appendChild(eliminarBtn);
                cells[6].appendChild(accionesContainer);
            });
        }

        // Initial data load
        fetch('/api/productos')
            .then(response => response.json())
            .then(data => {
                allProducts = data;
                
                // Extract unique categories and populate the dropdown
                data.forEach(product => {
                    if (product.categorias) {
                        product.categorias.forEach(categoria => {
                            categories.add(categoria.nombre_categoria);
                        });
                    }
                });

                // Populate category dropdown
                const categoryFilter = document.getElementById('categoryFilter');
                categories.forEach(category => {
                    const option = document.createElement('option');
                    option.value = category;
                    option.textContent = category;
                    categoryFilter.appendChild(option);
                });

                // Initial table population
                updateTable(data);
            })
            .catch(error => console.error('Error al cargar los productos:', error));

        // Add event listeners for search and filter
        document.getElementById('searchInput').addEventListener('input', filterProducts);
        document.getElementById('categoryFilter').addEventListener('change', filterProducts);

        // Functions for handling actions (unchanged)
        function verProducto(id) {
            window.location.href = `/productos/${id}`;
        }

        function editarProducto(id) {
            window.location.href = `/productos/${id}/edit`;
        }

        function eliminarProducto(id) {
            if (confirm('¿Estás seguro de que deseas eliminar este producto?')) {
                fetch(`/api/productos/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                })
                .then(response => {
                    if (response.ok) {
                        window.location.reload();
                    } else {
                        alert('Error al eliminar el producto');
                    }
                })
                .catch(error => console.error('Error:', error));
            }
        }
    </script>
</body>
</html>