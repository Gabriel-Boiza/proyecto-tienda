<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TechPerif - Gaming Peripherals</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .hero-gradient {
            background: linear-gradient(45deg, #4C1D95, #1E40AF);
        }
    </style>
</head>
<body class="bg-gray-900 text-white">
    <!-- Navigation -->
    <nav class="bg-black p-4">
        <div class="container mx-auto flex justify-between items-center">
            <div class="text-xl font-bold">TechPerif</div>
            <div class="flex space-x-6">
                <a href="#" class="hover:text-purple-500">Teclados</a>
                <a href="#" class="hover:text-purple-500">Ratones</a>
                <a href="#" class="hover:text-purple-500">Auriculares</a>
                <a href="#" class="hover:text-purple-500">Monitores</a>
            </div>
            <div class="flex items-center space-x-4">
                <input type="search" placeholder="Buscar productos..." class="px-4 py-2 rounded bg-gray-800 text-white">
                <button class="text-purple-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </button>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="hero-gradient h-96">
        <div class="container mx-auto px-6 py-20">
            <h1 class="text-4xl font-bold mb-4">Periféricos Gaming de Alta Gama</h1>
            <p class="text-xl mb-8">Descubre nuestra selección premium de periféricos gaming. Hasta 50% de descuento en productos seleccionados</p>
            <button class="bg-purple-600 hover:bg-purple-700 text-white font-bold py-2 px-6 rounded">
                Ver Ofertas
            </button>
        </div>
    </div>

    <!-- Featured Products -->
    <div class="container mx-auto px-6 py-16">
        <h2 class="text-2xl font-bold mb-8">Productos Destacados</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
        @foreach($productos as $producto)
            <!-- Product Card 1 -->
            <div class="bg-gray-800 rounded-lg overflow-hidden">
                <div class="relative">
                    <span class="absolute top-2 left-2 bg-purple-600 text-white px-2 py-1 rounded">-20%</span>
                    <img src="{{ asset('storage/' . $producto->imagen_principal) }}" alt="Teclado" class="w-full h-48 object-cover"/>



                </div>
                <div class="p-4">
                    <h3 class="font-bold">{{$producto->nombre}}</h3>
                    <p class="text-gray-400">{{$producto->descripcion}}</p>
                    <div class="flex justify-between items-center mt-4">
                        <span class="text-xl font-bold">${{$producto->precio}}</span>
                        <button class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded">Añadir</button>
                    </div>
                </div>
            </div>
        @endforeach
            <!-- Product Card 2 -->
            

            <!-- Product Card 4 -->
            
    </div>

    <!-- Categories -->
    <div class="container mx-auto px-6 py-16">
        <h2 class="text-2xl font-bold mb-8">Categorías</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="bg-gray-800 p-6 rounded-lg text-center hover:bg-gray-700 cursor-pointer transition duration-300">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
                </svg>
                <span>Teclados</span>
            </div>
            <div class="bg-gray-800 p-6 rounded-lg text-center hover:bg-gray-700 cursor-pointer transition duration-300">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5M7.188 2.239l.777 2.897M5.136 7.965l-2.898-.777M13.95 4.05l-2.122 2.122m-5.657 5.656l-2.12 2.122" />
                </svg>
                <span>Ratones</span>
            </div>
            <div class="bg-gray-800 p-6 rounded-lg text-center hover:bg-gray-700 cursor-pointer transition duration-300">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15.536a5 5 0 001.414 1.414m2.828-9.9a9 9 0 012.828-2.828" />
                </svg>
                <span>Auriculares</span>
            </div>
            <div class="bg-gray-800 p-6 rounded-lg text-center hover:bg-gray-700 cursor-pointer transition duration-300">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
                <span>Monitores</span>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-800 text-gray-300 mt-16">
        <div class="container mx-auto px-6 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <h3 class="text-lg font-bold mb-4">TechPerif</h3>
                    <p class="text-sm">Tu tienda de confianza para periféricos gaming de alta calidad</p>
                </div>
                <div>
                    <h3 class="text-lg font-bold mb-4">Enlaces Rápidos</h3>
                    <ul class="text-sm space-y-2">
                        <li><a href="#" class="hover:text-white transition duration-300">Inicio</a></li>
                        <li><a href="#" class="hover:text-white transition duration-300">Productos</a></li>
                        <li><a href="#" class="hover:text-white transition duration-300">Ofertas</a></li>
                        <li><a href="#" class="hover:text-white transition duration-300">Sobre Nosotros</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-lg font-bold mb-4">Contacto</h3>
                    <ul class="text-sm space-y-2">
                        <li>info@techperif.com</li>
                        <li>+34 900 123 456</li>
                        <li>Madrid, España</li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-lg font-bold mb-4">Síguenos</h3>
                    <div class="flex space-x-4">
                        <a href="#" class="hover:text-white transition duration-300">
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                            </svg>
                        </a>
                        <a href="#" class="hover:text-white transition duration-300">
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                            </svg>
                        </a>
                        <a href="#" class="hover:text-white transition duration-300">
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 0C8.74 0 8.333.015 7.053.072 5.775.132 4.905.333 4.14.63c-.789.306-1.459.717-2.126 1.384S.935 3.35.63 4.14C.333 4.905.131 5.775.072 7.053.012 8.333 0 8.74 0 12s.015 3.667.072 4.947c.06 1.277.261 2.148.558 2.913.306.788.717 1.459 1.384 2.126.667.666 1.336 1.079 2.126 1.384.766.296 1.636.499 2.913.558C8.333 23.988 8.74 24 12 24s3.667-.015 4.947-.072c1.277-.06 2.148-.262 2.913-.558.788-.306 1.459-.718 2.126-1.384.666-.667 1.079-1.335 1.384-2.126.296-.765.499-1.636.558-2.913.06-1.28.072-1.687.072-4.947s-.015-3.667-.072-4.947c-.06-1.277-.262-2.149-.558-2.913-.306-.789-.718-1.459-1.384-2.126C21.319 1.347 20.651.935 19.86.63c-.765-.297-1.636-.499-2.913-.558C15.667.012 15.26 0 12 0zm0 2.16c3.203 0 3.585.016 4.85.071 1.17.055 1.805.249 2.227.415.562.217.96.477 1.382.896.419.42.679.819.896 1.381.164.422.36 1.057.413 2.227.057 1.266.07 1.646.07 4.85s-.015 3.585-.074 4.85c-.061 1.17-.256 1.805-.421 2.227-.224.562-.479.96-.897 1.382-.419.419-.824.679-1.38.896-.42.164-1.065.36-2.235.413-1.274.057-1.649.07-4.859.07-3.211 0-3.586-.015-4.859-.074-1.171-.061-1.816-.256-2.236-.421-.569-.224-.96-.479-1.379-.897-.421-.419-.69-.824-.9-1.38-.165-.42-.359-1.065-.42-2.235-.045-1.26-.061-1.649-.061-4.844 0-3.196.016-3.586.061-4.861.061-1.17.255-1.814.42-2.234.21-.57.479-.96.9-1.381.419-.419.81-.689 1.379-.898.42-.166 1.051-.361 2.221-.421 1.275-.045 1.65-.06 4.859-.06l.045.03zm0 3.678c-3.405 0-6.162 2.76-6.162 6.162 0 3.405 2.76 6.162 6.162 6.162 3.405 0 6.162-2.76 6.162-6.162 0-3.405-2.76-6.162-6.162-6.162zM12 16c-2.21 0-4-1.79-4-4s1.79-4 4-4 4 1.79 4 4-1.79 4-4 4zm7.846-10.405c0 .795-.646 1.44-1.44 1.44-.795 0-1.44-.646-1.44-1.44 0-.794.646-1.439 1.44-1.439.793-.001 1.44.645 1.44 1.439z"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
            <div class="border-t border-gray-700 mt-8 pt-8 text-sm text-center">
                <p>&copy; 2024 TechPerif. Todos los derechos reservados.</p>
            </div>
        </div>
    </footer>