@extends('app-admin.vista_admin')

@section('title', 'Historial de Pedidos')

@section('contentAdmin')
<div class="flex-1 p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-xl font-bold">Historial de Pedidos - {{ $cliente['nombre'] }} {{ $cliente['apellido'] }}</h1>
        <a href="{{ route('clientes.index') }}" class="bg-gray-600 text-white px-4 py-2 rounded-md inline-block hover:bg-gray-700">
            Volver a Clientes
        </a>
    </div>

    <!-- Client Info Card -->
    <div class="bg-zinc-800/50 rounded-lg p-4 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            <div>
                <p class="text-gray-400 text-sm">Email</p>
                <p>{{ $cliente['email'] }}</p>
            </div>
            <div>
                <p class="text-gray-400 text-sm">Teléfono</p>
                <p>{{ $cliente['telefono'] }}</p>
            </div>
            <div>
                <p class="text-gray-400 text-sm">Dirección</p>
                <p>{{ $cliente['direccion'] }}, {{ $cliente['ciudad'] }}, {{ $cliente['codigo_postal'] }}, {{ $cliente['pais'] }}</p>
            </div>
        </div>
    </div>

    <!-- Orders Table -->
    <div class="bg-zinc-800/50 rounded-lg overflow-hidden">
        <table id="tabla-pedidos" class="w-full">
            <thead>
                <tr class="text-left text-gray-400 border-b border-zinc-700">
                    <th class="p-4">ID</th>
                    <th class="p-4">Fecha</th>
                    <th class="p-4">Total</th>
                    <th class="p-4">Estado</th>
                    <th class="p-4">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($cliente['pedidos'] as $pedido)
                <tr class="border-b border-zinc-700 hover:bg-zinc-700/50">
                    <td class="p-4">{{ $pedido['id'] }}</td>
                    <td class="p-4">{{ $pedido['created_at'] ? date('d/m/Y', strtotime($pedido['created_at'])) : 'N/A' }}</td>
                    <td class="p-4">{{ number_format($pedido['total'], 2) }} €</td>
                    <td class="p-4">
                        <form action="" method="POST" class="m-0">
                            @csrf
                            @method('PUT')
                            <select 
                                name="estado"
                                class="estado-pedido bg-zinc-700 text-white border border-zinc-600 rounded px-2 py-1 text-sm w-full"
                                onchange="this.form.submit()"
                            >
                                <option value="pendiente" {{ $pedido['estado'] == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                                <option value="enviado" {{ $pedido['estado'] == 'enviado' ? 'selected' : '' }}>Enviado</option>
                                <option value="entregado" {{ $pedido['estado'] == 'entregado' ? 'selected' : '' }}>Entregado</option>
                                <option value="cancelado" {{ $pedido['estado'] == 'cancelado' ? 'selected' : '' }}>Cancelado</option>
                            </select>
                        </form>
                    </td>
                    <td class="p-4">
                        <div class="flex space-x-2">
                            <a href="{{ route('pedidos.show', $pedido['id']) }}" title="Ver detalles del pedido" class="text-blue-400 hover:text-blue-300">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
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
@endsection