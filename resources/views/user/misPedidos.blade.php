@extends('welcome')

@section('title', 'Mis Pedidos - Tienda de Teclados Gaming')

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
                            @foreach($pedidos as $pedido)
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
                                        @else
                                            <span class="px-2 py-1 bg-gray-500/20 text-gray-300 rounded-full text-xs">
                                                {{ ucfirst($pedido->estado) }}
                                            </span>
                                        @endif
                                    </td>
                                    <td class="py-4 px-4">
                                        <a href="/productosPedido/{{ $pedido->id }}" class="text-purple-500 hover:text-purple-400 mr-3">
                                            Ver detalles
                                        </a>
                                        @if($pedido->estado == 'pendiente')
                                            <a href="/cancelar-pedido/{{$pedido->id}}" class="text-red-500 hover:text-red-400">
                                                Cancelar
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </section>
        </div>
    </div>
@endsection
