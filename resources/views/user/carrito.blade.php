@extends('welcome')

@section('content')

<div class="bg-gray-900 py-8">
    <div class="container mx-auto px-4">
        <h1 class="text-3xl font-bold flex items-center gap-3">
            <svg class="w-8 h-8 text-purple-500" fill="currentColor" viewBox="0 0 24 24">
                <path d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
            </svg>
            Carrito
        </h1>
    </div>
</div>


<div class="container mx-auto px-4 py-12">
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
       
    </div>

   
    <div class="space-y-6">
       
    </div>

    <div class="hidden text-center py-16">
        <div class="bg-gray-800/50 rounded-full w-20 h-20 mx-auto flex items-center justify-center mb-6">
            <svg class="w-10 h-10 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                    d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
            </svg>
        </div>
        <h3 class="text-xl font-bold mb-2">Tu carrito está vacío</h3>
        <p class="text-gray-400 mb-6">Explora nuestro catálogo y añade tus productos al carrito</p>
        <a href="/" class="bg-purple-600 hover:bg-purple-700 px-6 py-3 rounded-lg inline-flex items-center gap-2">
            Explorar Productos
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
            </svg>
        </a>
    </div>
</div>

@if(session('cliente_id'))
    <script src="{{ asset('js/user/generarVistaCarritoLogueado.js') }}"></script>
@else
    <script src="{{ asset('js/user/generarVistaCarrito.js') }}"></script>
@endif
@endsection