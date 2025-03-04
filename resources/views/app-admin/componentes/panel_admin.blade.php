<aside class="w-64 p-6 bg-zinc-900 shadow">
        <!-- Logo -->
    <div class="text-xl font-bold text-purple-500 mb-8">
        PePeriféricos
    </div>

    <!-- Navigation -->
    <nav class="space-y-4">
        <a href="{{route('app-admin')}}" 
            class="flex items-center space-x-2 {{ request()->routeIs('app-admin') ? 'text-purple-500' : 'text-gray-500 hover:text-gray-300' }}">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                <polyline points="9 22 9 12 15 12 15 22"></polyline>
            </svg>
            <span>Inicio</span>
        </a>

        <a href="{{route('productos.index')}}" 
            class="flex items-center space-x-2 {{ request()->routeIs('productos.index') ? 'text-purple-500' : 'text-gray-500 hover:text-gray-300' }}">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path>
            </svg>
            <span>Productos</span>
        </a>

        <a href="{{route('categorias.index')}}" 
            class="flex items-center space-x-2 {{ request()->routeIs('categorias.index') ? 'text-purple-500' : 'text-gray-500 hover:text-gray-300' }}">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="9" cy="21" r="1"></circle>
                <circle cx="20" cy="21" r="1"></circle>
                <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
            </svg>
            <span>Categorias</span>
        </a>

        <a href="{{route('marcas.index')}}" 
            class="flex items-center space-x-2 {{ request()->routeIs('marcas.index') ? 'text-purple-500' : 'text-gray-500 hover:text-gray-300' }}">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                <circle cx="9" cy="7" r="4"></circle>
                <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
            </svg>
            <span>Marcas</span>
        </a>

        <a href="{{route('caracteristicas.index')}}" 
            class="flex items-center space-x-2 {{ request()->routeIs('caracteristicas.index') ? 'text-purple-500' : 'text-gray-500 hover:text-gray-300' }}">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                <circle cx="9" cy="7" r="4"></circle>
                <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
            </svg>
            <span>Caracteristicas</span>
        </a>

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


        <a href="{{route('pedidos.index')}}" 
            class="flex items-center space-x-2 {{ request()->routeIs('pedidos.index') ? 'text-purple-500' : 'text-gray-500 hover:text-gray-300' }}">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path>
            </svg>
            <span>Pedidos</span>
        </a>
    </nav>
</aside>
