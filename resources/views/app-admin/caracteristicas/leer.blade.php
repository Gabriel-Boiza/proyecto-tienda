@extends('app-admin.vista_admin')

@section('title', 'Gestión de Características')

@section('contentAdmin')

<div class="flex-1 flex flex-col items-center justify-center p-6">
    <h1 class="admin-title text-center">Gestión de características</h1>
    <form method="POST" id="formulario" class="flex flex-col md:flex-row justify-center w-full md:max-w-[60%] mb-2">
        @csrf
        <div class="w-full mb-2 md:mb-0">
            <input
                name="caracteristica"
                id="generarInput"
                type="text"
                placeholder="Nombre de la característica"
                class="admin-input w-full md:w-[70%]" {{-- Corrected width classes --}}
                aria-label="Nombre de la nueva característica" {{-- Added aria-label --}}
            >
            @error('caracteristica')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>
        <input
            type="submit"
            class="admin-button w-full md:w-[25%] md:ml-5"
            value="+ Generar"
            aria-label="Crear nueva característica" {{-- Added aria-label --}}
        >
    </form>

    <div id="container" class="admin-container w-full md:max-w-[60%]"> {{-- Adjusted width for consistency --}}
        {{-- Characteristics will be loaded here by JavaScript --}}
    </div>
</div>
<script src="{{ asset('js/app-admin/crudCaracteristicas.js') }}"></script>

@endsection