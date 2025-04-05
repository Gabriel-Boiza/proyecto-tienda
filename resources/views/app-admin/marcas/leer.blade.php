@extends('app-admin.vista_admin')

@section('title', 'Gestión de Marcas') {{-- Changed title for consistency --}}

@section('contentAdmin')

<div class="flex-1 flex flex-col items-center justify-center p-6">
    <h1 class="text-center admin-title">Gestión de marcas</h1>
    <form method="POST" id="formulario" class="flex flex-col md:flex-row justify-center w-full md:max-w-[60%] mb-2">
        @csrf
        <div class="w-full mb-2 md:mb-0">

            <input
                name="nombre_marca" {{-- Corrected name attribute --}}
                id="generarInput"
                type="text"
                placeholder="Nombre de la marca"
                class="admin-input w-full md:w-[70%]" {{-- Adjusted width for responsiveness --}}
                aria-label="Nombre de la nueva marca" {{-- Added aria-label --}}
            >
            @error('nombre_marca')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>
        <input
            type="submit"
            class="admin-button w-full md:w-[25%] md:ml-5"
            value="+ Generar"
            aria-label="Crear nueva marca" {{-- Added aria-label --}}
        >
    </form>

    <div id="container" class="admin-container w-full md:max-w-[60%]"> {{-- Adjusted width for consistency --}}
        {{-- Brands will be loaded here by JavaScript --}}
    </div>
</div>
<script src="{{ asset('js/app-admin/generarMarcas.js') }}"></script>

@endsection