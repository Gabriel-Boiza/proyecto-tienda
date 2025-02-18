<aside class="sidebar w-64 p-6">
            <div class="text-xl font-bold text-purple-500 mb-8">Dashboard</div>
            <nav class="space-y-4">
                <a href="{{route('app-admin')}}" class="flex items-center space-x-2 text-purple-500">
                    <i data-feather="home"></i>
                    <span>Inicio</span>
                </a>
                <a href="{{route('productos.index')}}" class="flex items-center space-x-2 text-gray-500 hover:text-gray-300">
                    <i data-feather="box"></i>
                    <span>Productos</span>
                </a>
                <a href="{{route('categorias.index')}}" class="flex items-center space-x-2 text-gray-500 hover:text-gray-300">
                    <i data-feather="shopping-cart"></i>
                    <span>Categorias</span>
                </a>
                <a href="{{route('marcas.index')}}" class="flex items-center space-x-2 text-gray-500 hover:text-gray-300">
                    <i data-feather="users"></i>
                    <span>Marcas</span>
                </a>
                <a href="#" class="flex items-center space-x-2 text-gray-500 hover:text-gray-300">
                    <i data-feather="bar-chart-2"></i>
                    <span>Analytics</span>
                </a>
            </nav>
        </aside>