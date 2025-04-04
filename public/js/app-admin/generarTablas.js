document.addEventListener('DOMContentLoaded', function(event){

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

            // Crear celdas con clases responsivas
            const cells = [
                row.insertCell(0), // ID
                row.insertCell(1), // Nombre
                row.insertCell(2), // Descripción
                row.insertCell(3), // Precio
                row.insertCell(4), // Stock
                row.insertCell(5), // Categorías
                row.insertCell(6)  // Acciones
            ];

            // Aplicar clases base a todas las celdas
            cells.forEach(cell => {
                cell.className = "p-4 text-gray-300";
            });

            // Aplicar clases responsivas específicas
            cells[2].className += " hidden md:table-cell"; // Descripción - oculta en móviles
            cells[4].className += " hidden sm:table-cell"; // Stock - oculta en móviles pequeños
            cells[5].className += " hidden lg:table-cell"; // Categorías - oculta en tablets y móviles

            cells[0].textContent = producto.codigo_producto;
            cells[1].textContent = producto.nombre;
            cells[2].textContent = producto.descripcion;
            cells[3].textContent = `${producto.precio.toFixed(2)}€`;
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
                const categoriasContainer = document.createElement('div');
                categoriasContainer.className = 'flex flex-wrap gap-2';
                
                const categoriaTag = document.createElement('span');
                categoriaTag.className = 'bg-purple-500/30 text-purple-200 px-2 py-1 rounded-md text-xs';
                categoriaTag.textContent = 'Sin categorías';
                categoriasContainer.appendChild(categoriaTag);
                
                cells[5].appendChild(categoriasContainer);
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
            fetch(`productos/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(response => {
                if (response.ok) {
                    // Remove product from allProducts array
                    allProducts = allProducts.filter(product => product.id !== id);
                    // Update the table with the filtered products
                    filterProducts();
                } else {
                    alert('Error al eliminar el producto');
                }
            })
            .catch(error => console.error('Error:', error));
        }
    }
});