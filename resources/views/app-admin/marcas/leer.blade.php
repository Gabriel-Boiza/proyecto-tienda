@extends('app-admin.vista_admin')

@section('title', 'Tienda de Teclados Gaming')

@section('contentAdmin')

<div class="flex-1 flex flex-col items-center justify-center p-6">
    <h1 class="text-center text-xl font-bold mb-6">Gestión de marcas</h1>
    <form method="POST" id="formulario" class="flex justify-center w-full max-w-[60%] mb-2">
        <input 
            name="nombre_categoria" 
            id="generarInput" 
            type="text" 
            placeholder="Nombre de la marca" 
            class="w-[70%] p-2 rounded-md bg-zinc-800 text-gray-300 placeholder-gray-400"
        >
        <input 
            type="submit" 
            class="w-[25%] p-2 bg-purple-600 hover:bg-purple-700 text-white rounded-md ml-5" 
            value="+ Generar"
        >
    </form>

    <div id="container" class="bg-zinc-800/50 rounded-lg w-full max-w-[60%]"> </div>
</div>
<script src="{{ asset('js/app-admin/generarMarcas.js') }}"></script>

@endsection