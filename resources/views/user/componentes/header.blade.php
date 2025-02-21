<nav class="bg-gradient-to-r from-gray-900 to-black sticky top-0 z-50 shadow-xl border-b border-purple-800">
    <div class="container mx-auto px-4 py-3">
        <div class="flex justify-between items-center">
            <!-- Logo -->
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-gradient-to-br from-purple-600 to-purple-800 rounded-full flex items-center justify-center shadow-lg transform hover:scale-105 transition-transform">
                    <span class="text-xl font-bold text-white">T</span>
                </div>
                <span class="text-xl font-bold text-white tracking-wide">PePeriféricos</span>
            </div>

            <!-- Desktop Menu -->
            <div class="hidden md:flex space-x-8">
                <a href="#" class="py-2 border-b-2 border-transparent hover:border-purple-500 hover:text-purple-500 transition-all duration-200 text-gray-300">Teclados</a>
                <a href="#" class="py-2 border-b-2 border-transparent hover:border-purple-500 hover:text-purple-500 transition-all duration-200 text-gray-300">Ratones</a>
                <a href="#" class="py-2 border-b-2 border-transparent hover:border-purple-500 hover:text-purple-500 transition-all duration-200 text-gray-300">Auriculares</a>
                <a href="#" class="py-2 border-b-2 border-transparent hover:border-purple-500 hover:text-purple-500 transition-all duration-200 text-gray-300">Monitores</a>
            </div>

            <!-- Search and Cart -->
            <div class="hidden md:flex items-center space-x-6">
                <!-- Search Input -->
                <div class="relative">
                    <input 
                        type="search" 
                        id="search" 
                        placeholder="Buscar productos..." 
                        class="w-72 px-4 py-2 bg-gray-800/50 rounded-lg border border-gray-700 focus:ring-2 focus:ring-purple-500 focus:border-transparent focus:outline-none placeholder-gray-400 text-white transition-all duration-300 hover:bg-gray-800"
                    >
        

                    <!-- Dropdown for search results -->
                    <div id="search-results" class="absolute w-full bg-gray-800/95 text-white mt-2 rounded-lg shadow-xl hidden backdrop-blur-sm border border-gray-700">
                        <!-- Results will be populated here -->
                    </div>
                </div>

                <!-- Cart -->
                <div class="relative group">
                    <button class="p-2 hover:text-purple-500 transition-colors">
                        <svg class="w-6 h-6 text-gray-300 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </button>
                    <span class="absolute -top-2 -right-2 bg-gradient-to-br from-purple-500 to-purple-700 text-xs text-white font-bold rounded-full w-5 h-5 flex items-center justify-center shadow-lg transform transition-transform group-hover:scale-110">3</span>
                </div>
            </div>

            <!-- Mobile Menu Button -->
            <button class="md:hidden p-2 hover:bg-gray-800 rounded-lg transition-colors" @click="mobileMenu = !mobileMenu">
                <svg class="w-6 h-6 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-16 6h16"/>
                </svg>
            </button>
        </div>

        <!-- Mobile Menu Panel -->
        <div class="md:hidden" x-show="mobileMenu" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-4">
            <div class="px-2 pt-4 pb-3 space-y-1">
                <a href="#" class="block px-3 py-2 rounded-lg text-gray-300 hover:text-white hover:bg-purple-600/20 transition-colors">Teclados</a>
                <a href="#" class="block px-3 py-2 rounded-lg text-gray-300 hover:text-white hover:bg-purple-600/20 transition-colors">Ratones</a>
                <a href="#" class="block px-3 py-2 rounded-lg text-gray-300 hover:text-white hover:bg-purple-600/20 transition-colors">Auriculares</a>
                <a href="#" class="block px-3 py-2 rounded-lg text-gray-300 hover:text-white hover:bg-purple-600/20 transition-colors">Monitores</a>
                <!-- Mobile Search -->
                <div class="relative mt-3">
                    <input 
                        type="search" 
                        placeholder="Buscar productos..." 
                        class="w-full px-4 py-2 bg-gray-800/50 rounded-lg border border-gray-700 focus:ring-2 focus:ring-purple-500 focus:border-transparent focus:outline-none placeholder-gray-400 text-white"
                    >
                    <button class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-purple-500 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>
</nav>

<script>
document.getElementById('search').addEventListener('input', function() {
    const query = this.value;
    const resultsContainer = document.getElementById('search-results');

    if (query.length > 2) {
        fetch(`/productos/buscar?query=${query}`)
            .then(response => response.json())
            .then(data => {
                // Limpiar resultados anteriores y mostrar el contenedor
                resultsContainer.innerHTML = '';
                resultsContainer.classList.remove('hidden');

                if (data.length > 0) {
                    data.forEach(producto => {
                        const productElement = document.createElement('a');
                        productElement.classList.add(
                            'block', 
                            'px-4', 
                            'py-3', 
                            'hover:bg-purple-600/20', 
                            'rounded-lg',
                            'transition-colors',
                            'border-b',
                            'border-gray-700/50',
                            'last:border-0'
                        );
                        productElement.href = `/periferico/${producto.id}`;
                        productElement.innerHTML = `
                            <div class="flex justify-between items-center">
                                <div>
                                    <h3 class="text-md font-semibold text-white">${producto.nombre}</h3>
                                    <p class="text-sm text-gray-400">${producto.categoria || ''}</p>
                                </div>
                                <p class="text-purple-400 font-semibold">$${producto.precio}</p>
                            </div>
                        `;
                        resultsContainer.appendChild(productElement);
                    });
                } else {
                    resultsContainer.innerHTML = `
                        <p class="px-4 py-3 text-gray-400 text-center">No se encontraron productos</p>
                    `;
                }
            })
            .catch(error => {
                console.error('Error en la búsqueda:', error);
                resultsContainer.innerHTML = `
                    <p class="px-4 py-3 text-red-400 text-center">Error al buscar productos</p>
                `;
            });
    } else {
        resultsContainer.classList.add('hidden');
    }
});

// Cerrar resultados al hacer clic fuera
document.addEventListener('click', function(event) {
    const searchInput = document.getElementById('search');
    const resultsContainer = document.getElementById('search-results');
    
    if (!searchInput.contains(event.target) && !resultsContainer.contains(event.target)) {
        resultsContainer.classList.add('hidden');
    }
});
</script>