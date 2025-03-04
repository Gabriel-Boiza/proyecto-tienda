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

    <div class="bg-zinc-800/50 rounded-lg p-4 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            <div>
                <p class="text-gray-400 text-sm">Email</p>
                <p>{{ $cliente->email }}</p>
            </div>
            <div>
                <p class="text-gray-400 text-sm">Teléfono</p>
                <p>{{ $cliente->telefono }}</p>
            </div>
            <div>
                <p class="text-gray-400 text-sm">Dirección</p>
                <p>{{ $cliente->direccion }}, {{ $cliente->ciudad }}, {{ $cliente->codigo_postal }}, {{ $cliente->pais }}</p>
            </div>
        </div>
    </div>

    <div class="bg-zinc-800/50 rounded-lg overflow-hidden">
        <table id="tabla-pedidos" class="w-full">
            <thead>
                <tr class="text-left text-gray-400 border-b border-zinc-700">
                    <th class="p-4">ID</th>
                    <th class="p-4">Fecha</th>
                    <th class="p-4">Total</th>
                    <th class="p-4">Estado</th>
                </tr>
            </thead>
            <tbody>
                @foreach($cliente['pedidos'] as $pedido)
                <tr class="border-b border-zinc-700 hover:bg-zinc-700/50">
                    <td class="p-4">{{ $pedido->id }}</td>
                    <td class="p-4">{{ $pedido['created_at'] ? date('d/m/Y', strtotime($pedido['created_at'])) : 'N/A' }}</td>
                    <td class="p-4">{{ number_format($pedido->total, 2) }} €</td>
                    <td class="p-4">
                        <form action="/pedidos/{{$pedido->id}}" method="POST" class="m-0">
                            @csrf
                            @method('PUT')
                            <select 
                                name="estado"
                                class="estado-pedido bg-zinc-700 text-white border border-zinc-600 rounded px-2 py-1 text-sm w-full"
                                onchange="this.form.submit()" > <!-- Cuando cambia algun valor se envia el formulario -->

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
</div>
@endsection