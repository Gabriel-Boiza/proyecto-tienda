@extends('welcome')

@section('title', 'Tienda de Teclados Gaming')

@section('content')
    <!-- Hero Section -->
    <div class="max-w-7xl mx-auto px-4 py-8">
        <h1 class="text-2xl text-gray-400 mb-8">
            Conoce más sobre {{$categorias->nombre_categoria}}
        </h1>

        <!-- Botón para mostrar filtros en móvil -->
        <button id="filtrosBtn" aria-label="Mostrar u ocultar filtros de productos" aria-expanded="false" aria-controls="filterMenu" class="md:hidden w-full bg-gray-800/30 rounded-lg p-4 mb-4 flex justify-between items-center">
            <span class="font-bold">Filtros</span>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 transform transition-transform" id="filterIcon" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
            </svg>
        </button>

        <div class="flex flex-col md:flex-row gap-8">
            <!-- Sidebar de Filtros -->
            <aside id="filterMenu" class="hidden md:block w-full md:w-64 bg-gray-800/30 p-6 rounded-lg h-fit">
                <h2 class="font-bold mb-4 md:block hidden">Filtros</h2>

                <form action="" method="GET">

                    <div class="mb-6">
                        <label for="priceRange" class="block text-gray-400 mb-2">Precio</label>
                        <input name='precio' type="range" min="{{$precioMinimo}}" max="{{$precioMaximo}}" value="{{$precioActual}}"
                            class="w-full accent-purple-500" id="priceRange" aria-label="Filtrar por rango de precio">
                        <div class="flex justify-between text-sm text-gray-400">
                            <span>{{$precioMinimo}}€</span>
                            <span id="priceValue">{{$precioActual}}€</span>
                        </div>
                    </div>

                    <div class="mb-6">
                        <h3 class="text-gray-400 mb-2">Marca</h3>
                        <div class="space-y-2">
                            @foreach($marcas as $marca)
                            <label class="flex items-center space-x-2">
                                <input name='marcas[]' value='{{$marca->id}}' type="checkbox" class="rounded text-purple-600" @if(in_array($marca->id, $marcasActuales)) checked @endif aria-label="Filtrar por marca {{ $marca->nombre }}">
                                <span>{{$marca->nombre}}</span>
                            </label>
                            @endforeach
                        </div>
                    </div>

                    <div>
                        <label for="ordenSelect" class="block text-gray-400 mb-2">Ordenar por</label>
                        <select id="ordenSelect" name='orden' class="w-full bg-gray-700 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-purple-500" aria-label="Seleccionar criterio de ordenación de productos">
                            <option value='asc' {{ request('orden') == 'asc' ? 'selected' : '' }}>Precio: Menor a mayor</option>
                            <option value='desc' {{ request('orden') == 'desc' ? 'selected' : '' }}>Precio: Mayor a menor</option>
                        </select>
                    </div>

                    <div class="mt-6">
                        <input type="submit" value="Aplicar filtros" aria-label="Aplicar filtros seleccionados" class="w-full bg-purple-600 text-white rounded-lg px-4 py-2 transition-all duration-300 hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500 cursor-pointer">
                    </div>

                </form>
            </aside>

            <!-- Grid de Productos -->
            <section class="flex-1">
                @if(count($productos) > 0)
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($productos as $producto)
                            <article class="bg-gray-800/30 rounded-lg overflow-hidden flex flex-col">
                                <div class="relative">
                                    <img src="{{ asset('storage/' . $producto->imagen_principal) }}"
                                        alt="{{ $producto->nombre }}"
                                        class="w-full h-48 object-cover">
                                    @if($producto->descuento > 0)
                                        <span class="absolute top-2 left-2 px-2 py-1 rounded text-sm bg-purple-500">
                                            -{{ $producto->descuento }}%
                                        </span>
                                    @endif
                                </div>
                                <div class="p-4 flex flex-col flex-grow">
                                    <h3 class="font-bold mb-1">{{ $producto->nombre }}</h3>
                                    <p class="text-gray-400 text-sm mb-2 flex-grow">{{ $producto->descripcion }}</p>
                                    <div class="flex justify-between items-center mt-auto">
                                        <div>
                                            <span class="font-bold">{{ number_format($producto->precio * (100 - $producto->descuento) / 100, 2) }}€</span>
                                            @if($producto->descuento > 0)
                                                <span class="text-gray-400 line-through ml-2 text-sm">
                                                    {{ number_format($producto->precio, 2) }}€
                                                </span>
                                            @endif
                                        </div>
                                        <a href="/periferico/{{$producto->id}}" aria-label="Ver más detalles sobre {{ $producto->nombre }}" class="bg-purple-600 p-2 rounded-lg hover:bg-purple-700 flex items-center text-white">Ver más</a>
                                    </div>
                                </div>
                            </article>
                        @endforeach
                    </div>

                    <!-- Paginación -->
                    <div class="flex justify-center mt-8 space-x-2">
                        {{-- Laravel's default pagination usually handles aria-labels well --}}
                        {{$productos->links()}}
                    </div>
                @else
                    <div class="bg-gray-800/30 rounded-lg p-8 text-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <h3 class="text-xl font-bold mb-2">No se encontraron productos</h3>
                        <p class="text-gray-400 mb-4">No hay productos disponibles con los filtros seleccionados.</p>
                        <a href="{{ url()->current() }}" aria-label="Restablecer todos los filtros de productos" class="inline-block bg-purple-600 text-white rounded-lg px-4 py-2 transition-all duration-300 hover:bg-purple-700">
                            Restablecer filtros
                        </a>
                    </div>
                @endif
            </section>
        </div>
    </div>

    <script>
        const priceRange = document.getElementById('priceRange');
        const priceValue = document.getElementById('priceValue');
        if (priceRange && priceValue) {
            priceRange.addEventListener('input', (e) => {
                priceValue.textContent = `${e.target.value}€`;
            });
        }

        const filtrosBtn = document.getElementById('filtrosBtn');
        const filterMenu = document.getElementById('filterMenu');
        const filterIcon = document.getElementById('filterIcon');

        if (filtrosBtn && filterMenu && filterIcon) {
            filtrosBtn.addEventListener('click', () => {
                const isHidden = filterMenu.classList.toggle('hidden');
                filterIcon.classList.toggle('rotate-180');
                // Update aria-expanded state
                filtrosBtn.setAttribute('aria-expanded', !isHidden);
            });
        }

        window.addEventListener('resize', () => {
            if (filterMenu) {
                const isMobile = window.innerWidth < 768; // md breakpoint
                if (!isMobile) {
                    filterMenu.classList.remove('hidden');
                    // Ensure aria-expanded is correct on resize if button exists
                    if (filtrosBtn) {
                        filtrosBtn.setAttribute('aria-expanded', 'true');
                    }
                } else {
                    // Only hide if it wasn't explicitly opened on mobile
                    if (!filtrosBtn || filtrosBtn.getAttribute('aria-expanded') === 'false') {
                         filterMenu.classList.add('hidden');
                    }
                }
            }
        });

        // Initial state for aria-expanded on mobile button
        if (filtrosBtn && filterMenu) {
             filtrosBtn.setAttribute('aria-expanded', !filterMenu.classList.contains('hidden'));
        }
    </script>
@endsection