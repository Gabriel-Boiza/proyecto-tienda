@extends('app-admin.vista_admin')

@section('title', 'Gestión de Categorías')

@section('contentAdmin')

<div class="flex-1 flex flex-col items-center justify-center p-6">
    <h1 class="admin-title text-center">Gestión categorías</h1>
    <form method="POST" id="formulario" class="flex justify-center w-full max-w-[60%] mb-2">
        @csrf
        <div class="w-full">
            <input 
                name="nombre_categoria" 
                id="generarInput" 
                type="text" 
                placeholder="Nombre de la categoria" 
                class="admin-input w-[70%]"
            >
            @error('nombre_categoria')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>
        <input 
            type="submit" 
            class="admin-button w-[25%] ml-5" 
            value="+ Generar"
        >
    </form>

    <div id="container" class="admin-container w-full max-w-[60%]"> </div>
</div>
<script src="{{ asset('js/app-admin/generarCategorias.js') }}"></script>

@endsection