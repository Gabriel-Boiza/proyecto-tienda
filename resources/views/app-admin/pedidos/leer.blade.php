@extends('app-admin.vista_admin')

@section('title', 'Historial de Pedidos')

@section('contentAdmin')
<div class="flex-1 p-6">
    <div class="flex justify-between items-center mb-6 productos-header">
        <h1 class="text-xl font-bold">Historial de Pedidos</h1>
    </div>

    <!-- Search and Filter Section -->
    <div class="mb-6 space-y-4">
        <!-- Search bar -->
        <div class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-4">
            <input type="text"
                id="searchInput"
                placeholder="Buscar pedidos..."
                class="w-full sm:flex-1 bg-zinc-800 rounded-md px-4 py-2 text-gray-300"
                aria-label="Buscar pedidos por ID"> {{-- Added aria-label --}}

            <!-- Status Dropdown -->
            <select id="statusFilter"
                class="w-full sm:w-auto bg-zinc-800 rounded-md px-4 py-2 text-gray-300"
                aria-label="Filtrar pedidos por estado"> {{-- Added aria-label --}}
                <option value="">Todos los estados</option>
                <option value="pendiente">Pendiente</option>
                <option value="enviado">Enviado</option>
                <option value="entregado">Entregado</option>
                <option value="cancelado">Cancelado</option>
            </select>
        </div>
    </div>

    <!-- Orders Table - Desktop View (hidden on small screens) -->
    <div class="hidden md:block bg-zinc-800/50 rounded-lg overflow-hidden productos-table">
        <table id="tabla-pedidos" class="w-full">
            <thead>
                <tr class="text-left text-gray-400 border-b border-zinc-700">
                    <th class="p-4">ID</th>
                    <th class="p-4">Fecha</th>
                    <th class="p-4">Fecha envio</th>
                    <th class="p-4">Total</th>
                    <th class="p-4">Estado</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pedidos as $pedido)
                <tr class="border-b border-zinc-700 hover:bg-zinc-700/50">
                    <td class="p-4">{{ $pedido['id'] }}</td>
                    <td class="p-4">{{ $pedido['created_at'] ? date('d/m/Y', strtotime($pedido['created_at'])) : 'N/A' }}</td>
                    <td class="p-4">{{ $pedido->fecha_envio ? : 'N/A' }}</td>
                    <td class="p-4">{{ number_format($pedido['total'], 2) }} €</td>
                    <td class="p-4">
                        <form action="pedidos/{{$pedido->id}}" method="POST" class="m-0">
                            @csrf
                            @method('PUT')
                            <select
                                name="estado"
                                class="estado-pedido bg-zinc-700 text-white border border-zinc-600 rounded px-2 py-1 text-sm w-full"
                                onchange="form.submit()"
                                aria-label="Actualizar estado del pedido {{ $pedido['id'] }}"> {{-- Added aria-label --}}
                            >
                                <option value="pendiente" {{ $pedido['estado'] == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                                <option value="enviado" {{ $pedido['estado'] == 'enviado' ? 'selected' : '' }}>Enviado</option>
                                <option value="entregado" {{ $pedido['estado'] == 'entregado' ? 'selected' : '' }}>Entregado</option>
                                <option value="cancelado" {{ $pedido['estado'] == 'cancelado' ? 'selected' : '' }}>Cancelado</option>
                            </select>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Orders Cards - Mobile View (visible only on small screens) -->
    <div class="md:hidden space-y-4">
        @foreach($pedidos as $pedido)
        <div class="bg-zinc-800/50 rounded-lg p-4 space-y-3">
            <div class="flex justify-between items-center">
                <span class="font-bold">Pedido #{{ $pedido['id'] }}</span>
                <span class="text-sm">{{ number_format($pedido['total'], 2) }} €</span>
            </div>

            <div class="grid grid-cols-2 gap-2 text-sm">
                <div>
                    <p class="text-gray-400">Fecha:</p>
                    <p>{{ $pedido['created_at'] ? date('d/m/Y', strtotime($pedido['created_at'])) : 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-gray-400">Fecha envío:</p>
                    <p>{{ $pedido->fecha_envio ? : 'N/A' }}</p>
                </div>
            </div>

            <div>
                <p class="text-gray-400 mb-1">Estado:</p>
                <form action="pedidos/{{$pedido->id}}" method="POST" class="m-0">
                    @csrf
                    @method('PUT')
                    <select
                        name="estado"
                        class="estado-pedido bg-zinc-700 text-white border border-zinc-600 rounded px-2 py-1 text-sm w-full"
                        onchange="form.submit()"
                        aria-label="Actualizar estado del pedido {{ $pedido['id'] }}"> {{-- Added aria-label --}}
                    >
                        <option value="pendiente" {{ $pedido['estado'] == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                        <option value="enviado" {{ $pedido['estado'] == 'enviado' ? 'selected' : '' }}>Enviado</option>
                        <option value="entregado" {{ $pedido['estado'] == 'entregado' ? 'selected' : '' }}>Entregado</option>
                        <option value="cancelado" {{ $pedido['estado'] == 'cancelado' ? 'selected' : '' }}>Cancelado</option>
                    </select>
                </form>
            </div>
        </div>
        @endforeach
    </div>
</div>

<script src="{{ asset('js/app-admin/pedidos.js') }}"></script>
@endsection