@extends('app-admin.vista_admin')

@section('title', 'Lista de Productos')

@section('contentAdmin')
<div class="flex-1 p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-xl font-bold">Lista de Productos</h1>
        <a href="{{ route('productos.create') }}" class="bg-purple-600 text-white px-4 py-2 rounded-md inline-block hover:bg-purple-700">
            Añadir Producto
        </a>
    </div>

    <!-- Search and Filter Section -->
    <div class="mb-6 space-y-4">
        <!-- Search bar -->
        <div class="flex space-x-4">
            <input type="text" 
                   id="searchInput"
                   placeholder="Buscar productos..." 
                   class="flex-1 bg-zinc-800 rounded-md px-4 py-2 text-gray-300">
            
            <!-- Categories Dropdown -->
            <select id="categoryFilter" 
                    class="bg-zinc-800 rounded-md px-4 py-2 text-gray-300">
                <option value="">Todas las categorías</option>
            </select>
        </div>
    </div>

    <!-- Products Table -->
    <div class="bg-zinc-800/50 rounded-lg overflow-hidden">
        <table id="tabla-productos" class="w-full">
            <thead>
                <tr class="text-left text-gray-400 border-b border-zinc-700">
                    <th class="p-4">ID</th>
                    <th class="p-4">Nombre</th>
                    <th class="p-4">Descripción</th>
                    <th class="p-4">Precio</th>
                    <th class="p-4">Stock</th>
                    <th class="p-4">Categorías</th>
                    <th class="p-4">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <!-- Los productos se llenarán aquí con JavaScript -->
            </tbody>
        </table>
    </div>
</div>
<script src="{{ asset('js/app-admin/generarTablas.js') }}"></script>
@endsection
