
<nav class="bg-gradient-to-r from-gray-900 to-black sticky top-0 z-50 shadow-xl border-b border-purple-800">
    <div class="container mx-auto px-4 py-3">
        <div class="flex justify-between items-center">
            <!-- Logo -->
             <a href="{{ url('/') }}" class="block">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-gradient-to-br from-purple-600 to-purple-800 rounded-full flex items-center justify-center shadow-lg transform hover:scale-105 transition-transform">
                        <img src="{{asset('img/productos/logo.png')}}" alt="">
                    </div>
                    <span class="text-xl font-bold text-white tracking-wide">PePeriféricos</span>
                </div>
            </a>

            <!-- Botón de menú hamburguesa (visible solo en móvil) -->
            <button id="menuToggle" class="md:hidden text-white focus:outline-none">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>

            <!-- Search and Icons -->
            <div class="hidden md:flex items-center space-x-6">
                <!-- Search Input -->
                <div class="relative">
                    <input 
                        type="search" 
                        id="search" 
                        placeholder="Buscar productos..." 
                        class="w-72 px-4 py-2 bg-gray-800/50 rounded-lg border border-gray-700 focus:ring-2 focus:ring-purple-500 focus:border-transparent focus:outline-none placeholder-gray-400 text-white transition-all duration-300 hover:bg-gray-800"
                    >
                    <div id="search-results" class="absolute w-full bg-gray-800/95 text-white mt-2 rounded-lg shadow-xl hidden backdrop-blur-sm border border-gray-700"></div>
                </div>

                <!-- Favoritos -->
                <a href="/favoritos" class="relative group p-2 hover:text-purple-500 transition-colors">
                    <svg class="w-6 h-6 text-gray-300 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                    </svg>
                </a>

                <!-- Cart -->
                 <a href="/carrito">
                    <div class="relative group">
                        <button class="p-2 hover:text-purple-500 transition-colors">
                            <svg class="w-6 h-6 text-gray-300 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                        </button>
                        <span id="valorCarrito" class="absolute -top-2 -right-2 bg-gradient-to-br from-purple-500 to-purple-700 text-xs text-white font-bold rounded-full w-5 h-5 flex items-center justify-center shadow-lg transform transition-transform group-hover:scale-110"></span>
                    </div>
                </a>

                <!-- User Menu -->
                <div class="relative group">
                    <button class="p-2 hover:text-purple-500 transition-colors">
                        <svg class="w-6 h-6 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    </button>
                    <div class="absolute right-0 w-48 bg-gray-800 rounded-lg shadow-xl py-2 border border-gray-700 
                                opacity-0 pointer-events-none transition-opacity duration-300 
                                group-hover:opacity-100 group-hover:pointer-events-auto 
                                "
                    >
                        @if(Session::Has('cliente_id'))

                            <a href="/perfil/{{Session::get('cliente_id')}}" class="block px-4 py-2 text-sm text-gray-300 hover:bg-purple-600/20 hover:text-white transition-colors">Mi Perfil</a>
                            <a href="/mis-pedidos/{{Session::get('cliente_id')}}" class="block px-4 py-2 text-sm text-gray-300 hover:bg-purple-600/20 hover:text-white transition-colors">Mis Pedidos</a>
                            <div class="border-t border-gray-700 my-2"></div>
                            <a href="/logoutCliente" class="block px-4 py-2 text-sm text-red-400 hover:bg-red-500/10 transition-colors">Cerrar Sesión</a>
                        @else
                            <a href="/loginCliente" class="block px-4 py-2 text-sm text-gray-300 hover:bg-purple-600/20 hover:text-white transition-colors">Iniciar Sesión</a>
                            <a href="/registroCliente" class="block px-4 py-2 text-sm text-gray-300 hover:bg-purple-600/20 hover:text-white transition-colors">Registrarse</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Menú móvil (oculto por defecto) -->
        <div id="mobileMenu" class="md:hidden hidden mt-4 pb-2">
            <!-- Buscador móvil -->
            <div class="relative mb-4">
                <input 
                    type="search" 
                    id="searchMobile" 
                    placeholder="Buscar productos..." 
                    class="w-full px-4 py-2 bg-gray-800/50 rounded-lg border border-gray-700 focus:ring-2 focus:ring-purple-500 focus:border-transparent focus:outline-none placeholder-gray-400 text-white transition-all duration-300 hover:bg-gray-800"
                >
                <div id="search-results-mobile" class="absolute w-full bg-gray-800/95 text-white mt-2 rounded-lg shadow-xl hidden backdrop-blur-sm border border-gray-700"></div>
            </div>

            <!-- Enlaces de navegación -->
            <div class="flex flex-col space-y-3">
                <a href="/favoritos" class="flex items-center space-x-3 text-gray-300 hover:text-white hover:bg-purple-600/20 p-2 rounded-lg transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                    </svg>
                    <span>Favoritos</span>
                </a>
                
                <a href="/carrito" class="flex items-center space-x-3 text-gray-300 hover:text-white hover:bg-purple-600/20 p-2 rounded-lg transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                    <span>Carrito</span>
                    <span id="valorCarritoMobile" class="bg-gradient-to-br from-purple-500 to-purple-700 text-xs text-white font-bold rounded-full w-5 h-5 flex items-center justify-center shadow-lg"></span>
                </a>

                <div class="border-t border-gray-700 my-1 pt-1"></div>

                @if(Session::Has('cliente_id'))
                    <a href="/perfil/{{Session::get('cliente_id')}}" class="flex items-center space-x-3 text-gray-300 hover:text-white hover:bg-purple-600/20 p-2 rounded-lg transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        <span>Mi Perfil</span>
                    </a>
                    <a href="/mis-pedidos/{{Session::get('cliente_id')}}" class="flex items-center space-x-3 text-gray-300 hover:text-white hover:bg-purple-600/20 p-2 rounded-lg transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                        <span>Mis Pedidos</span>
                    </a>
                    <a href="/logoutCliente" class="flex items-center space-x-3 text-red-400 hover:text-red-300 hover:bg-red-500/10 p-2 rounded-lg transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                        </svg>
                        <span>Cerrar Sesión</span>
                    </a>
                @else
                    <a href="/loginCliente" class="flex items-center space-x-3 text-gray-300 hover:text-white hover:bg-purple-600/20 p-2 rounded-lg transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                        </svg>
                        <span>Iniciar Sesión</span>
                    </a>
                    <a href="/registroCliente" class="flex items-center space-x-3 text-gray-300 hover:text-white hover:bg-purple-600/20 p-2 rounded-lg transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                        </svg>
                        <span>Registrarse</span>
                    </a>
                @endif
            </div>
        </div>
    </div>
</nav>

<script src="{{ asset('js/user/funciones/funcionesCarrito.js') }}"></script>
<script src="{{ asset('js/user/funciones/funcionFetch.js') }}"></script>
@if(Session::Has('cliente_id'))
    <script src="{{ asset('js/user/carrito/carritoLogueado.js') }}"></script>
@else
    <script src="{{ asset('js/user/carrito/carrito.js') }}"></script>
@endif

<script>
var usuarioAutenticado = @json(session()->has('cliente_id'));

// Función para configurar la búsqueda
function setupSearch(inputId, resultsId) {
    document.getElementById(inputId).addEventListener('input', function() {
        const query = this.value;
        const resultsContainer = document.getElementById(resultsId);

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
}

// Configurar búsqueda para escritorio y móvil
setupSearch('search', 'search-results');
setupSearch('searchMobile', 'search-results-mobile');

// Cerrar resultados al hacer clic fuera
document.addEventListener('click', function(event) {
    const searchInput = document.getElementById('search');
    const resultsContainer = document.getElementById('search-results');
    const searchInputMobile = document.getElementById('searchMobile');
    const resultsContainerMobile = document.getElementById('search-results-mobile');
    
    if (!searchInput.contains(event.target) && !resultsContainer.contains(event.target)) {
        resultsContainer.classList.add('hidden');
    }
    
    if (!searchInputMobile.contains(event.target) && !resultsContainerMobile.contains(event.target)) {
        resultsContainerMobile.classList.add('hidden');
    }
});

// Menú hamburguesa
document.addEventListener('DOMContentLoaded', function() {
    const menuToggle = document.getElementById('menuToggle');
    const mobileMenu = document.getElementById('mobileMenu');
    
    if (menuToggle && mobileMenu) {
        menuToggle.addEventListener('click', function() {
            mobileMenu.classList.toggle('hidden');
        });
    }
    
    // Sincronizar contador del carrito entre versión móvil y escritorio
    function updateMobileCartCounter() {
        const desktopCounter = document.getElementById('valorCarrito');
        const mobileCounter = document.getElementById('valorCarritoMobile');
        
        if (desktopCounter && mobileCounter) {
            mobileCounter.textContent = desktopCounter.textContent;
        }
    }
    
    // Actualizar contador móvil inicialmente y cuando cambie el contador de escritorio
    updateMobileCartCounter();
    
    // Observar cambios en el contador de escritorio
    const observer = new MutationObserver(updateMobileCartCounter);
    const desktopCounter = document.getElementById('valorCarrito');
    
    if (desktopCounter) {
        observer.observe(desktopCounter, { childList: true, characterData: true, subtree: true });
    }
});
</script>
