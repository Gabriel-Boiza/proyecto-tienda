@extends('app-admin.vista_admin')

@section('title', 'Lista de Productos')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/app-admin/productos.css') }}">
@endsection

@section('contentAdmin')
<div class="flex-1 p-6">
    <div class="flex flex-col sm:flex-row justify-between items-center mb-6 productos-header">
        <h1 class="text-xl font-bold mb-4 sm:mb-0">Lista de Productos</h1>
        <a href="{{ route('productos.create') }}" class="bg-purple-600 text-white px-4 py-2 rounded-md inline-block hover:bg-purple-700 btn-add-producto w-full sm:w-auto text-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block mr-1 -mt-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
              <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
            </svg>
            Añadir Producto
        </a>
    </div>

    <!-- Search and Filter Section -->
    <div class="mb-6 space-y-4">
        <!-- Search bar -->
        <div class="flex flex-col md:flex-row space-y-4 md:space-y-0 md:space-x-4">
            <label for="searchInput" class="sr-only">Buscar productos</label> {{-- Added screen-reader only label --}}
            <input type="text"
                   id="searchInput"
                   placeholder="Buscar productos..."
                   aria-label="Buscar productos por nombre o descripción" {{-- Added aria-label --}}
                   class="w-full md:flex-1 bg-zinc-800 rounded-md px-4 py-2 text-gray-300 search-input">

            <!-- Categories Dropdown -->
            <label for="categoryFilter" class="sr-only">Filtrar por categoría</label> {{-- Added screen-reader only label --}}
            <select id="categoryFilter"
                    aria-label="Filtrar productos por categoría" {{-- Added aria-label --}}
                    class="w-full md:w-auto bg-zinc-800 rounded-md px-4 py-2 text-gray-300 filter-select">
                <option value="">Todas las categorías</option>
                {{-- Category options will likely be populated by JS or server-side --}}
            </select>
        </div>
    </div>

    <!-- Products Table -->
    <div class="bg-zinc-800/50 rounded-lg overflow-x-auto productos-table">
        <table id="tabla-productos" class="w-full" aria-label="Tabla de productos registrados"> {{-- Added aria-label to table --}}
            <thead>
                <tr class="text-left text-gray-400 border-b border-zinc-700">
                    <th scope="col" class="p-4">ID</th> {{-- Added scope --}}
                    <th scope="col" class="p-4">Nombre</th> {{-- Added scope --}}
                    <th scope="col" class="p-4 hidden md:table-cell">Descripción</th> {{-- Added scope --}}
                    <th scope="col" class="p-4">Precio</th> {{-- Added scope --}}
                    <th scope="col" class="p-4 hidden sm:table-cell">Stock</th> {{-- Added scope --}}
                    <th scope="col" class="p-4 hidden lg:table-cell">Categorías</th> {{-- Added scope --}}
                    <th scope="col" class="p-4">Acciones</th> {{-- Added scope --}}
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>
<script src="{{ asset('js/app-admin/generarTablas.js') }}"></script>
@endsection