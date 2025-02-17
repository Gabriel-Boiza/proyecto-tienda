<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gaming Store</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.29.0/feather.min.js"></script>
</head>
<body class="bg-[#0f1520] text-gray-100">
    <!-- Navigation -->
    <nav class="bg-[#131927] p-4">
        <div class="container mx-auto px-8 flex justify-between items-center">
            <div class="flex space-x-8">
                <a href="#" class="hover:text-blue-500 text-gray-300">Teclados</a>
                <a href="#" class="hover:text-blue-500 text-gray-300">Ratones</a>
                <a href="#" class="hover:text-blue-500 text-gray-300">Auriculares</a>
                <a href="#" class="hover:text-blue-500 text-gray-300">Monitores</a>
            </div>
            
            <div class="flex items-center space-x-4">
                <div class="relative">
                    <input type="text" placeholder="Buscar productos..." 
                           class="bg-[#1c2433] rounded-lg px-4 py-2 w-64 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <i data-feather="search" class="absolute right-3 top-2.5 text-gray-400 w-5 h-5"></i>
                </div>
                <i data-feather="user" class="text-gray-400 hover:text-blue-500 cursor-pointer w-6 h-6"></i>
                <i data-feather="shopping-cart" class="text-gray-400 hover:text-blue-500 cursor-pointer w-6 h-6"></i>
            </div>
        </div>
    </nav>

    <main class="container mx-auto px-8 py-8">
        <!-- Hero Section -->
        <h1 class="text-2xl text-gray-400 mb-8">
            Descubre nuestra selección de teclados gaming de alta gama con las últimas tecnologías y diseños más innovadores.
        </h1>

        <div class="flex gap-8">
            <!-- Filters -->
            <div class="w-72 bg-[#131927] p-6 rounded-lg h-fit">
                <h2 class="font-bold mb-4">Filtros</h2>
                
                <div class="mb-6">
                    <h3 class="text-gray-400 mb-2">Precio</h3>
                    <input type="range" min="0" max="300" value="300" 
                           class="w-full accent-blue-500" id="priceRange">
                    <div class="flex justify-between text-sm text-gray-400">
                        <span>0€</span>
                        <span id="priceValue">300€</span>
                    </div>
                </div>

                <div class="mb-6">
                    <h3 class="text-gray-400 mb-2">Marca</h3>
                    <div class="space-y-2">
                        <label class="flex items-center space-x-2">
                            <input type="checkbox" class="rounded text-blue-600">
                            <span>Razer</span>
                        </label>
                        <label class="flex items-center space-x-2">
                            <input type="checkbox" class="rounded text-blue-600">
                            <span>Logitech</span>
                        </label>
                        <label class="flex items-center space-x-2">
                            <input type="checkbox" class="rounded text-blue-600">
                            <span>Corsair</span>
                        </label>
                    </div>
                </div>

                <div>
                    <h3 class="text-gray-400 mb-2">Ordenar por</h3>
                    <select class="w-full bg-[#1c2433] rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option>Más populares</option>
                        <option>Precio: Menor a mayor</option>
                        <option>Precio: Mayor a menor</option>
                    </select>
                </div>
            </div>

            <!-- Products Grid -->
            <div class="flex-1">
                <div class="grid grid-cols-3 gap-8">

                @foreach($categorias->productos as $producto)
                    <div class="bg-[#131927] rounded-lg overflow-hidden">
                        <div class="relative">
                            <img src="{{ asset('storage/' . $producto->imagen_principal) }}" alt="{{$producto->nombre}}" class="w-full h-48 object-cover">
                            <span class="absolute top-2 left-2 px-2 py-1 rounded text-sm bg-blue-500">-20%</span>
                        </div>
                        <div class="p-4">
                            <h3 class="font-bold mb-1">{{$producto->nombre}}</h3>
                            <p class="text-gray-400 text-sm mb-2">{{$producto->descripcion}}</p>
                            <div class="flex justify-between items-center">
                                <div>
                                    <span class="font-bold">{{$producto->precio * (100-$producto->descuento)/100}}€</span>
                                    <span class="text-gray-400 line-through ml-2 text-sm">{{$producto->precio}}€</span>
                                </div>
                                <button class="bg-blue-600 p-2 rounded-lg hover:bg-blue-700">
                                    <i data-feather="shopping-cart" class="w-5 h-5"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach



                <!-- Pagination -->
                <div class="flex justify-center mt-8 space-x-2">
                    <button class="w-8 h-8 flex items-center justify-center rounded-lg bg-blue-600 text-white">1</button>
                    <button class="w-8 h-8 flex items-center justify-center rounded-lg bg-[#1c2433] text-white hover:bg-[#262f3f]">2</button>
                    <button class="w-8 h-8 flex items-center justify-center rounded-lg bg-[#1c2433] text-white hover:bg-[#262f3f]">3</button>
                </div>
            </div>
        </div>
    </main>

    <script>
        // Initialize Feather Icons
        feather.replace();

        // Price Range Functionality
        const priceRange = document.getElementById('priceRange');
        const priceValue = document.getElementById('priceValue');
        
        priceRange.addEventListener('input', (e) => {
            priceValue.textContent = `${e.target.value}€`;
        });
    </script>
</body>
</html>