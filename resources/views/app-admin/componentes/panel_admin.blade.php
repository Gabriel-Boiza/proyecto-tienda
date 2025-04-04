<!-- Botón de menú hamburguesa (visible solo en móviles) -->
<div class="lg:hidden fixed top-0 left-0 z-50 w-full bg-zinc-900 shadow-md">
    <div class="flex items-center justify-between p-4">
        <div class="text-xl font-bold text-purple-500">PePeriféricos</div>
        <button id="menu-toggle" class="text-gray-300 hover:text-white focus:outline-none">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>
    </div>
</div>

<!-- Panel lateral (oculto en móviles por defecto) -->
<aside id="sidebar" class="fixed inset-y-0 left-0 transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out lg:relative w-64 p-6 bg-zinc-900 shadow z-40 lg:z-0 h-full overflow-y-auto pt-16 lg:pt-6">
    <!-- Logo (oculto en móviles porque ya está en la barra superior) -->
    <div class="text-xl font-bold text-purple-500 mb-8 hidden lg:block">
        PePeriféricos
    </div>

    <!-- Navigation -->
    <nav class="space-y-4">
        <!-- Inicio - Dashboard icon -->
        <a href="{{route('app-admin')}}" 
            class="flex items-center space-x-2 {{ request()->routeIs('app-admin') ? 'text-purple-500' : 'text-gray-500 hover:text-gray-300' }}">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="3" y="3" width="7" height="7"></rect>
                <rect x="14" y="3" width="7" height="7"></rect>
                <rect x="14" y="14" width="7" height="7"></rect>
                <rect x="3" y="14" width="7" height="7"></rect>
            </svg>
            <span>Inicio</span>
        </a>

        <!-- Productos - Box/Package icon -->
        <a href="{{route('productos.index')}}" 
            class="flex items-center space-x-2 {{ request()->routeIs('productos.index') ? 'text-purple-500' : 'text-gray-500 hover:text-gray-300' }}">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path>
                <polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline>
                <line x1="12" y1="22.08" x2="12" y2="12"></line>
            </svg>
            <span>Productos</span>
        </a>

        <!-- Categorias - Tag/Label icon -->
        <a href="{{route('categorias.index')}}" 
            class="flex items-center space-x-2 {{ request()->routeIs('categorias.index') ? 'text-purple-500' : 'text-gray-500 hover:text-gray-300' }}">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"></path>
                <line x1="7" y1="7" x2="7.01" y2="7"></line>
            </svg>
            <span>Categorias</span>
        </a>

        <!-- Marcas - Briefcase/Brand icon -->
        <a href="{{route('marcas.index')}}" 
            class="flex items-center space-x-2 {{ request()->routeIs('marcas.index') ? 'text-purple-500' : 'text-gray-500 hover:text-gray-300' }}">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect>
                <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path>
            </svg>
            <span>Marcas</span>
        </a>

        <!-- Caracteristicas - Settings/Features icon -->
        <a href="{{route('caracteristicas.index')}}" 
            class="flex items-center space-x-2 {{ request()->routeIs('caracteristicas.index') ? 'text-purple-500' : 'text-gray-500 hover:text-gray-300' }}">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="3"></circle>
                <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path>
            </svg>
            <span>Caracteristicas</span>
        </a>

        <!-- Clientes - Users icon -->
        <a href="{{route('clientes.index')}}" 
            class="flex items-center space-x-2 {{ request()->routeIs('clientes.index') ? 'text-purple-500' : 'text-gray-500 hover:text-gray-300' }}">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                <circle cx="9" cy="7" r="4"></circle>
                <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
            </svg>
            <span>Clientes</span>
        </a>

        <!-- Pedidos - Shopping cart/Orders icon -->
        <a href="{{route('pedidos.index')}}" 
            class="flex items-center space-x-2 {{ request()->routeIs('pedidos.index') ? 'text-purple-500' : 'text-gray-500 hover:text-gray-300' }}">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="9" cy="21" r="1"></circle>
                <circle cx="20" cy="21" r="1"></circle>
                <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
            </svg>
            <span>Pedidos</span>
        </a>
    </nav>
</aside>

<!-- Overlay para cerrar el menú al hacer clic fuera (solo en móviles) -->
<div id="sidebar-overlay" class="fixed inset-0 bg-black opacity-0 pointer-events-none transition-opacity duration-300 ease-in-out z-30 lg:hidden"></div>

<!-- Script para controlar el menú hamburguesa -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const menuToggle = document.getElementById('menu-toggle');
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebar-overlay');
        
        // Función para abrir/cerrar el menú
        function toggleMenu() {
            if (sidebar.classList.contains('-translate-x-full')) {
                // Abrir menú
                sidebar.classList.remove('-translate-x-full');
                overlay.classList.remove('opacity-0', 'pointer-events-none');
                overlay.classList.add('opacity-50', 'pointer-events-auto');
            } else {
                // Cerrar menú
                sidebar.classList.add('-translate-x-full');
                overlay.classList.remove('opacity-50', 'pointer-events-auto');
                overlay.classList.add('opacity-0', 'pointer-events-none');
            }
        }
        
        // Event listeners
        menuToggle.addEventListener('click', toggleMenu);
        overlay.addEventListener('click', toggleMenu);
        
        // Cerrar menú al hacer clic en un enlace (en móviles)
        const navLinks = sidebar.querySelectorAll('nav a');
        navLinks.forEach(link => {
            link.addEventListener('click', function() {
                if (window.innerWidth < 1024) { // lg breakpoint
                    toggleMenu();
                }
            });
        });
        
        // Ajustar para cambios de tamaño de ventana
        window.addEventListener('resize', function() {
            if (window.innerWidth >= 1024) {
                // En pantallas grandes, asegurarse de que el menú esté visible
                sidebar.classList.remove('-translate-x-full');
                overlay.classList.remove('opacity-50', 'pointer-events-auto');
                overlay.classList.add('opacity-0', 'pointer-events-none');
            } else if (!sidebar.classList.contains('-translate-x-full')) {
                // En pantallas pequeñas, si el menú está abierto, cerrarlo
                toggleMenu();
            }
        });
    });
</script>