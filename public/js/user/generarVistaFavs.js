document.addEventListener('DOMContentLoaded', () => {
    const obtenerProductosFavoritos = () => {
        return Object.keys(localStorage)
            .filter(key => key.startsWith('productoFavs'))
            .map(key => JSON.parse(localStorage.getItem(key)));
    };

    const calcularTotales = (productos) => ({
        totalProductos: productos.length,
        valorTotal: productos.reduce((suma, producto) => suma + producto.precio, 0),
        ahorroTotal: productos.reduce((suma, producto) => suma + (producto.precio * (producto.descuento / 100)), 0)
    });

    const formatearPrecio = (precio) => `${precio.toFixed(2)}€`;

    const generarHTMLProducto = (producto) => {
        const precioDescontado = producto.descuento > 0 
            ? producto.precio * (1 - producto.descuento / 100) 
            : producto.precio;

        return `
            <div class="bg-gray-800 rounded-xl p-6 flex flex-col md:flex-row gap-6 items-center">
                <img src="/storage/${producto.imagen_principal}" alt="${producto.nombre}" class="md:w-48 h-48 object-cover rounded-lg">
                <div class="flex-grow">
                    <div class="flex items-start justify-between">
                        <div>
                            <h3 class="text-xl font-bold">${producto.nombre}</h3>
                            <p class="text-gray-400 mt-2">${producto.descripcion}</p>
                        </div>
                        <button class="text-gray-400 hover:text-red-500 transition-colors" onclick="eliminarDeFavoritos(${producto.id})">
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
        // Si no hay productos, mostrar valores en 0
        const totalProductos = totales.totalProductos || 0;
        const valorTotal = totales.valorTotal || 0;
        const ahorroTotal = totales.ahorroTotal || 0;

        document.querySelector('.grid-cols-1.md\\:grid-cols-3').innerHTML = `
            <div class="bg-gray-800 p-6 rounded-xl">
                <p class="text-gray-400 mb-1">Total Productos</p>
                <p class="text-3xl font-bold">${totalProductos}</p>
            </div>
            <div class="bg-gray-800 p-6 rounded-xl">
                <p class="text-gray-400 mb-1">Valor Total</p>
                <p class="text-3xl font-bold">${formatearPrecio(valorTotal)}</p>
            </div>
            <div class="bg-gray-800 p-6 rounded-xl">
                <p class="text-gray-400 mb-1">Ahorro Total</p>
                <p class="text-3xl font-bold text-green-500">${formatearPrecio(ahorroTotal)}</p>
            </div>
        `;
    };

    window.eliminarDeFavoritos = (productoId) => {
        localStorage.removeItem('productoFavs' + productoId);
        renderizarFavoritos();
    };

    window.añadirAlCarrito = (productoId) => {
        console.log(`Añadiendo producto ${productoId} al carrito`);
    };

    const renderizarFavoritos = () => {
        const productos = obtenerProductosFavoritos();
        const contenedorProductos = document.querySelector('.space-y-6');
        const estadoVacio = document.querySelector('.hidden.text-center');

        if (productos.length === 0) {
            contenedorProductos.innerHTML = '';
            estadoVacio.classList.remove('hidden');
            // Asegurarse de que las estadísticas también se actualicen con valores en 0
            actualizarEstadisticas({ totalProductos: 0, valorTotal: 0, ahorroTotal: 0 });
        } else {
            estadoVacio.classList.add('hidden');
            contenedorProductos.innerHTML = productos.map(generarHTMLProducto).join('');
            actualizarEstadisticas(calcularTotales(productos));
        }
    };

    renderizarFavoritos();
});
