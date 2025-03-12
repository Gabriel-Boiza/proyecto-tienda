document.addEventListener('DOMContentLoaded', () => {
    const csrfTokenElement = document.querySelector('meta[name="csrf-token"]');
    const csrfToken = csrfTokenElement ? csrfTokenElement.content : '';
    const cliente = document.querySelector('meta[name="cliente-id"]')?.content;

    if (!cliente) {
        console.error("No se encontró el ID del cliente.");
        return;
    }

    const obtenerProductosCarrito = () => {
        return fetch(`/api/carrito/${cliente}`)
            .then(response => response.json())
            .then(data => data.carrito || [])
            .catch(error => {
                console.error("Error obteniendo el carrito:", error);
                return [];
            });
    };

    const calcularTotales = (productos) => ({
        totalProductos: productos.length,
        valorTotal: productos.reduce((suma, producto) => suma + producto.precio, 0),
        ahorroTotal: productos.reduce((suma, producto) => suma + (producto.precio * (producto.descuento / 100)), 0)
    });

    const formatearPrecio = (precio) => {
        if (typeof precio !== 'number' || isNaN(precio)) {
            console.error('Precio inválido:', precio);
            return '0.00€';
        }
        return `${precio.toFixed(2)}€`;
    };
    
    const generarHTMLProducto = (producto) => {
        console.log('Producto recibido:', producto); // 🔍 Verifica los datos antes de usarlos

        const precioDescontado = producto.descuento > 0 
            ? producto.precio * (1 - producto.descuento / 100) 
            : producto.precio;

        return `
            <div class="bg-gray-800 rounded-xl p-6 flex flex-col md:flex-row gap-6 items-center">
                <img src="/storage/${producto.imagen_principal}" alt="${producto.nombre}" class="w-full md:w-48 h-48 object-cover rounded-lg">
                <div class="flex-grow">
                    <div class="flex items-start justify-between">
                        <div>
                            <h3 class="text-xl font-bold">${producto.nombre}</h3>
                            <p class="text-gray-400 mt-2">${producto.descripcion}</p>
                        </div>
                        <button class="text-gray-400 hover:text-red-500 transition-colors" onclick="eliminarDeCarrito(${producto.id})">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                    <div class="flex flex-wrap items-center gap-4 mt-4">
                        <div class="flex items-center gap-2">
                            <span class="text-2xl font-bold">${formatearPrecio(precioDescontado)}</span>
                            ${producto.descuento > 0 ? `
                                <span class="text-sm text-gray-400 line-through">${formatearPrecio(producto.precio)}</span>
                                <span class="bg-purple-600/20 text-purple-400 px-2 py-1 rounded text-sm">-${producto.descuento}%</span>
                            ` : ''}
                        </div>
                    </div>
                    <div class="flex gap-4 mt-6">
                        <button class="bg-purple-600 hover:bg-purple-700 px-6 py-2 rounded-lg flex items-center gap-2 transition-colors" onclick="añadirAlCarrito(${producto.id})">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                      d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                            Añadir al Carrito
                        </button>
                        <a href="periferico/${producto.id}" class="text-purple-500 hover:text-purple-400 flex items-center gap-2">
                            Ver Detalles
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        `;
    };

    const actualizarEstadisticas = (totales) => {
        document.querySelector('.grid-cols-1.md\\:grid-cols-3').innerHTML = `
            <div class="bg-gray-800 p-6 rounded-xl">
                <p class="text-gray-400 mb-1">Total Productos</p>
                <p class="text-3xl font-bold">${totales.totalProductos}</p>
            </div>
            <div class="bg-gray-800 p-6 rounded-xl">
                <p class="text-gray-400 mb-1">Valor Total</p>
                <p class="text-3xl font-bold">${formatearPrecio(totales.valorTotal)}</p>
            </div>
            <div class="bg-gray-800 p-6 rounded-xl">
                <p class="text-gray-400 mb-1">Ahorro Total</p>
                <p class="text-3xl font-bold text-green-500">${formatearPrecio(totales.ahorroTotal)}</p>
            </div>
        `;
    };

    window.eliminarDeCarrito = (productoId) => {
        fetch(`/api/carrito/${cliente}/${productoId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': csrfToken
            }
        })
        .then(response => response.json())
        .then(data => {
            console.log("Producto eliminado del carrito:", data);
            renderizarCarrito();
        })
        .catch(error => console.error("Error eliminando producto del carrito:", error));
    };

    const renderizarCarrito = async () => {
        const productos = await obtenerProductosCarrito();
        const contenedorProductos = document.querySelector('.space-y-6');
        const estadoVacio = document.querySelector('.hidden.text-center');

        if (productos.length === 0) {
            contenedorProductos.innerHTML = '';
            estadoVacio.classList.remove('hidden');
            actualizarEstadisticas({ totalProductos: 0, valorTotal: 0, ahorroTotal: 0 });
        } else {
            estadoVacio.classList.add('hidden');
            contenedorProductos.innerHTML = productos.map(generarHTMLProducto).join('');
            actualizarEstadisticas(calcularTotales(productos));
        }
    };

    renderizarCarrito();
});
