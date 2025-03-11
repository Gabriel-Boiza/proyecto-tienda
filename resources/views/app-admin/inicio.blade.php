@extends('app-admin.vista_admin')

@section('title', 'Tienda de Teclados Gaming')

@section('contentAdmin')

<div class="flex justify-between items-center mb-6">
    <div>
        <h1 class="text-2xl font-semibold">Vista general</h1>
        <p class="text-gray-500">Bienvenido, {{$nombre}}</p>
    </div>
</div>

<!-- Stats Grid -->
<div class="grid grid-cols-4 gap-6 mb-6">
    <div class="bg-zinc-800/50 border border-zinc-700 rounded-md p-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-gray-400">Total ganado</h3>
            <i data-feather="dollar-sign" class="text-purple-500"></i>
        </div>
        <div class="text-2xl font-bold">{{$totalPedidos}}€</div>
    </div>
    <div class="bg-zinc-800/50 border border-zinc-700 rounded-md p-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-gray-400">Pedidos activos</h3>
            <i data-feather="shopping-cart" class="text-purple-500"></i>
        </div>
        <div class="text-2xl font-bold">{{$pedidosActivos}}</div>
    </div>
    <div class="bg-zinc-800/50 border border-zinc-700 rounded-md p-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-gray-400">Clientes activos</h3>
            <i data-feather="users" class="text-purple-500"></i>
        </div>
        <div class="text-2xl font-bold">{{$clientesActivos}}</div>
    </div>
    <div class="bg-zinc-800/50 border border-zinc-700 rounded-md p-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-gray-400">Conversion Rate</h3>
            <i data-feather="trending-up" class="text-purple-500"></i>
        </div>
        <div class="text-2xl font-bold">4.5%</div>
    </div>
</div>

<!-- Recent Orders -->
<div class="bg-zinc-800/50 border border-zinc-700 rounded-md p-6 mb-6">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-semibold">Pedidos recientes</h2>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="text-gray-400 text-left">
                    <th class="pb-4">Pedido ID</th>
                    <th class="pb-4">Cliente</th>
                    <th class="pb-4">Producto</th>
                    <th class="pb-4">Estado</th>
                    <th class="pb-4">Costo total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pedidos as $pedido)
                <tr class="border-t border-zinc-700">
                    <td class="py-4">{{$pedido->id}}</td>
                    <td class="flex items-center space-x-2 py-4">
                        <span>{{$pedido->cliente->nombre}}</span>
                    </td>
                    <td>
                        @foreach($pedido->productos as $producto)
                        {{$producto->nombre}},
                        @endforeach
                    </td>
                    <td><span class="px-2 py-1 rounded text-xs bg-purple-600">{{$pedido->estado}}</span></td>
                    <td>{{$pedido->total}}€</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Top Products -->
<div id="graficoContainer" data-productos='@json($productos)'>
    <canvas id="graficoCanvas" class=" w-1/2 bg-zinc-800/50 border border-zinc-700 rounded-md p-6">

    </canvas>
</div>



<script src='{{asset("js/app-admin/canvas.js")}}'></script>

@endsection