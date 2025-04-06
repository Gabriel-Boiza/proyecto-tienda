@extends('welcome')


@section('content')
    <!-- Hero Section -->
    <div class="max-w-7xl mx-auto px-4 py-8">
        <h1 class="text-2xl text-gray-400 mb-8">
            Mis Pedidos
        </h1>

        <div class="flex flex-col md:flex-row gap-8">
            <!-- Sidebar de Información -->
            <aside class="w-full md:w-64 bg-gray-800/30 p-6 rounded-lg h-fit">
                <h2 class="font-bold mb-4">Información</h2>
                
                <div class="space-y-4">
                    <div>
                        <h3 class="text-gray-400 mb-1">Total de pedidos</h3>
                        <p class="font-bold text-lg">{{ count($pedidos) }}</p>
                    </div>
                    
                    <div>
                        <h3 class="text-gray-400 mb-1">Estado de pedidos</h3>
                        <ul class="space-y-2 mt-2">
                            <li class="flex items-center">
                                <span class="w-3 h-3 rounded-full bg-yellow-500 mr-2"></span>
                                <span>Pendientes</span>
                            </li>
                            <li class="flex items-center">
                                <span class="w-3 h-3 rounded-full bg-green-500 mr-2"></span>
                                <span>Completados</span>
                            </li>
                            <li class="flex items-center">
                                <span class="w-3 h-3 rounded-full bg-red-500 mr-2"></span>
                                <span>Cancelados</span>
                            </li>
                        </ul>
                    </div>
                    
                    <div class="pt-4 border-t border-gray-700">
                        <a href="#" class="text-purple-500 hover:text-purple-400 flex items-center">
                            <span class="mr-2">Contactar soporte</span>
                        </a>
                    </div>
                </div>
            </aside>

            <!-- Tabla de Pedidos -->
            <section class="flex-1">
                <!-- Formulario de Filtro -->
                <div class="bg-gray-800/30 p-4 rounded-lg mb-4">
                    <form action="{{ url('/mis-pedidos') }}" method="GET" class="flex flex-wrap items-center gap-4">
                        <div>
                            <label for="estado" class="block text-sm text-gray-400 mb-1">Filtrar por estado:</label>
                            <select name="estado" id="estado" class="bg-gray-700 text-white rounded px-3 py-2 border border-gray-600 focus:outline-none focus:border-purple-500">
                                <option value="todos">Todos</option>
                                <option value="pendiente">Pendiente</option>
                                <option value="enviado">Enviado</option>
                                <option value="completado">Completado</option>
                                <option value="cancelado">Cancelado</option>
                            </select>
                        </div>
                        <div class="self-end">
                            <button type="submit" class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded transition-colors">
                                Filtrar
                            </button>
                        </div>
                    </form>
                </div>
                
                <div class="bg-gray-800/30 rounded-lg overflow-x-auto">
                    <table class="w-full min-w-[600px]">
                        <thead>
                            <tr class="bg-gray-700/50">
                                <th class="py-3 px-4 text-left">ID Pedido</th>
                                <th class="py-3 px-4 text-left">Fecha</th>
                                <th class="py-3 px-4 text-left">Total</th>
                                <th class="py-3 px-4 text-left">Estado</th>
                                <th class="py-3 px-4 text-left">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pedidos as $pedido)
                                <tr class="border-t border-gray-700 hover:bg-gray-700/30 transition-colors">
                                    <td class="py-4 px-4">#{{ $pedido->id }}</td>
                                    <td class="py-4 px-4">
                                        {{ $pedido->updated_at ? date('d/m/Y', strtotime($pedido->updated_at)) : 'N/A' }}
                                    </td>
                                    <td class="py-4 px-4 font-bold">{{ $pedido->total }}€</td>
                                    <td class="py-4 px-4">
                                        @if($pedido->estado == 'pendiente')
                                            <span class="px-2 py-1 bg-yellow-500/20 text-yellow-300 rounded-full text-xs">
                                                Pendiente
                                            </span>
                                        @elseif($pedido->estado == 'completado')
                                            <span class="px-2 py-1 bg-green-500/20 text-green-300 rounded-full text-xs">
                                                Completado
                                            </span>
                                        @elseif($pedido->estado == 'cancelado')
                                            <span class="px-2 py-1 bg-red-500/20 text-red-300 rounded-full text-xs">
                                                Cancelado
                                            </span>
                                        @elseif($pedido->estado == 'enviado')
                                            <span class="px-2 py-1 bg-blue-500/20 text-blue-300 rounded-full text-xs">
                                                Enviado
                                            </span>
                                        @else
                                            <span class="px-2 py-1 bg-gray-500/20 text-gray-300 rounded-full text-xs">
                                                {{ ucfirst($pedido->estado) }}
                                            </span>
                                        @endif
                                    </td>
                                    <td class="py-4 px-4 flex">
                                        <a href="/productosPedido/{{ $pedido->id }}" class="text-purple-500 hover:text-purple-400 mr-3">
                                            Ver detalles
                                        </a>
                                        @if($pedido->estado == 'pendiente')
                                            <a href="/cancelar-pedido/{{$pedido->id}}" class="text-red-500 hover:text-red-400">
                                                Cancelar
                                            </a>
                                        @elseif($pedido->estado == 'enviado')
                                            <a href="/confirmar-pedido/{{$pedido->id}}" class="text-green-500 hover:text-green-400">
                                                Confirmar envío
                                            </a>
                                        @endif
                                        <a href="/generarPdf/{{$pedido->id}}" title="Generar factura" class="text-blue-400 hover:text-blue-300 ml-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                            </svg>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="py-6 px-4 text-center text-gray-400">
                                        No se encontraron pedidos con el filtro seleccionado.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </section>
        </div>
    </div>
@endsection