@extends('welcome')

@section('content')

<div class="bg-gray-900 py-8">
    <div class="container mx-auto px-4">
        <h1 class="text-3xl font-bold flex items-center gap-3">
            <svg class="w-8 h-8 text-purple-500" fill="currentColor" viewBox="0 0 24 24">
                <path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
            </svg>
            Carrito de Compras
        </h1>
    </div>
</div>

<div class="container mx-auto px-4 py-12">
    @if(count($carrito) > 0)
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
            @foreach($carrito as $item)
                <div class="bg-white p-4 rounded-lg shadow-md">
                    <img src="{{ asset('storage/'.$item->producto->imagen) }}" alt="{{ $item->producto->nombre }}" class="w-full h-48 object-cover rounded-md mb-4">
                    <h3 class="text-xl font-semibold text-gray-800">{{ $item->producto->nombre }}</h3>
                    <p class="text-gray-600">{{ $item->producto->descripcion }}</p>
                    <div class="flex items-center justify-between mt-4">
                        <span class="text-lg font-semibold text-gray-900">${{ number_format($item->producto->precio, 2) }}</span>
                        <div class="flex items-center gap-2">
                            <span class="text-gray-500">Cantidad: </span>
                            <input type="number" min="1" value="{{ $item->cantidad }}" class="w-12 p-1 border rounded-md text-center">
                        </div>
                    </div>
                    <button class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 mt-4 rounded-lg w-full">Eliminar</button>
                </div>
            @endforeach
        </div>

        <div class="flex justify-between items-center bg-gray-800 p-4 rounded-lg text-white">
            <span class="text-lg font-semibold">Total:</span>
            <span class="text-2xl font-bold">${{ number_format($total, 2) }}</span>
        </div>

        <div class="mt-8 flex justify-end">
            <a href="{{ route('checkout') }}" class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg">Proceder a la compra</a>
        </div>
    @else
        <div class="text-center py-16">
            <div class="bg-gray-800/50 rounded-full w-20 h-20 mx-auto flex items-center justify-center mb-6">
                <svg class="w-10 h-10 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                          d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                </svg>
            </div>
            <h3 class="text-xl font-bold mb-2">Tu carrito está vacío</h3>
            <p class="text-gray-400 mb-6">Explora nuestros productos y añádelos a tu carrito</p>
            <a href="/" class="bg-purple-600 hover:bg-purple-700 px-6 py-3 rounded-lg inline-flex items-center gap-2">
                Explorar Productos
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                </svg>
            </a>
        </div>
    @endif
</div>

<script src="{{ asset('js/user/generarVistaCarrito.js') }}"></script>
<script>
    const isLoggedIn = {!! json_encode(auth()->check()) !!};
</script>

@endsection
