@extends('app-admin.vista_admin')

@section('title', 'Lista de Clientes')

@section('contentAdmin')
<div class="flex-1 p-6">
    <div class="flex flex-col sm:flex-row justify-between items-center mb-6 productos-header">
        <h1 class="text-xl font-bold mb-4 sm:mb-0">Lista de Clientes</h1>
    </div>

    <!-- Search and Filter Section -->
    <div class="mb-6 space-y-4">
        <!-- Search bar -->
        <div class="flex flex-col md:flex-row space-y-4 md:space-y-0 md:space-x-4">
            <input type="text" 
                   id="searchInput"
                   placeholder="Buscar clientes..." 
                   class="w-full md:flex-1 bg-zinc-800 rounded-md px-4 py-2 text-gray-300 search-input">
            
            <!-- Ciudad Dropdown -->
            <select id="ciudadFilter" 
                    class="w-full md:w-auto bg-zinc-800 rounded-md px-4 py-2 text-gray-300 filter-select">
                <option value="">Todas las ciudades</option>
            </select>
        </div>
    </div>

    <!-- Clientes Table -->
    <div class="bg-zinc-800/50 rounded-lg overflow-x-auto productos-table">
        <table id="tabla-clientes" class="w-full">
            <thead>
                <tr class="text-left text-gray-400 border-b border-zinc-700">
                    <th class="p-4">ID</th>
                    <th class="p-4">Nombre</th>
                    <th class="p-4 hidden sm:table-cell">Apellido</th>
                    <th class="p-4 hidden md:table-cell">Email</th>
                    <th class="p-4 hidden lg:table-cell">Teléfono</th>
                    <th class="p-4 hidden md:table-cell">Ciudad</th>
                    <th class="p-4">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($clientes as $cliente)
                <tr class="border-b border-zinc-700 hover:bg-zinc-700/50">
                    <td class="p-4">{{ $cliente['id'] }}</td>
                    <td class="p-4">{{ $cliente['nombre'] }}</td>
                    <td class="p-4 hidden sm:table-cell">{{ $cliente['apellido'] }}</td>
                    <td class="p-4 hidden md:table-cell">{{ $cliente['email'] }}</td>
                    <td class="p-4 hidden lg:table-cell">{{ $cliente['telefono'] }}</td>
                    <td class="p-4 hidden md:table-cell">{{ $cliente['ciudad'] }}</td>
                    <td class="p-4">
                        <div class="flex space-x-2">
                            <a href="{{ route('clientes.show', $cliente->id) }}" title="Ver historial de pedidos" class="text-blue-400 hover:text-blue-300">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                            </a>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Obtener ciudades únicas de los clientes
    const clientes = @json($clientes);
    const ciudades = [...new Set(clientes.map(cliente => cliente.ciudad))];
    
    // Llenar filtro de ciudades
    const ciudadFilter = document.getElementById('ciudadFilter');
    ciudades.forEach(ciudad => {
        const option = document.createElement('option');
        option.value = ciudad;
        option.textContent = ciudad;
        ciudadFilter.appendChild(option);
    });
    
    // Configurar filtrado
    const searchInput = document.getElementById('searchInput');
    const tabla = document.getElementById('tabla-clientes');
    const tbody = tabla.querySelector('tbody');
    
    function filtrarClientes() {
        const searchTerm = searchInput.value.toLowerCase();
        const ciudadSeleccionada = ciudadFilter.value;
        
        // Ocultar/mostrar filas según filtros
        const filas = tbody.querySelectorAll('tr');
        filas.forEach(fila => {
            const nombre = fila.querySelector('td:nth-child(2)').textContent.toLowerCase();
            const apellido = fila.querySelector('td:nth-child(3)').textContent.toLowerCase();
            const email = fila.querySelector('td:nth-child(4)').textContent.toLowerCase();
            const telefono = fila.querySelector('td:nth-child(5)').textContent;
            const ciudad = fila.querySelector('td:nth-child(6)').textContent;
            
            const matchSearch = 
                nombre.includes(searchTerm) || 
                apellido.includes(searchTerm) || 
                email.includes(searchTerm) ||
                telefono.includes(searchTerm);
                
            const matchCiudad = !ciudadSeleccionada || ciudad === ciudadSeleccionada;
            
            fila.style.display = matchSearch && matchCiudad ? '' : 'none';
        });
    }
    
    // Event listeners
    searchInput.addEventListener('input', filtrarClientes);
    ciudadFilter.addEventListener('change', filtrarClientes);
});
</script>
@endsection