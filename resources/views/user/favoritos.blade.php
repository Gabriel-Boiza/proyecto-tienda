@extends('welcome')

@section('content')

<div class="bg-gray-900 py-8">
    <div class="container mx-auto px-4">
        <h1 class="text-3xl font-bold flex items-center gap-3">
            <svg class="w-8 h-8 text-purple-500" fill="currentColor" viewBox="0 0 24 24">
                <path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
            </svg>
            Lista de Deseos
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
                      d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
            </svg>
        </div>
        <h3 class="text-xl font-bold mb-2">Tu lista de deseos está vacía</h3>
        <p class="text-gray-400 mb-6">Explora nuestro catálogo y guarda tus productos favoritos</p>
        <a href="/" class="bg-purple-600 hover:bg-purple-700 px-6 py-3 rounded-lg inline-flex items-center gap-2">
            Explorar Productos
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
            </svg>
        </a>
    </div>
</div>


<script src="{{ asset('js/user/generarVistaFavs.js') }}"></script>

@endsection