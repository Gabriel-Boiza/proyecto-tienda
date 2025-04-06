@extends('app-admin.vista_admin')

@section('title', 'Lista de Cupones')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/app-admin/cupones.css') }}">
@endsection

@section('contentAdmin')
<div class="flex-1 p-6">
    <div class="flex flex-col sm:flex-row justify-between items-center mb-6 cupones-header">
        <h1 class="text-xl font-bold mb-4 sm:mb-0">Lista de Cupones</h1>
        <a href="{{ route('cupones.create') }}" class="bg-purple-600 text-white px-4 py-2 rounded-md inline-block hover:bg-purple-700 btn-add-cupon w-full sm:w-auto text-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block mr-1 -mt-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
              <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
            </svg>
            Añadir Cupón
        </a>
    </div>
    
    <!-- Search Section -->
    <div class="mb-6 space-y-4">
        <div class="flex flex-col md:flex-row space-y-4 md:space-y-0 md:space-x-4">
            <label for="searchInput" class="sr-only">Buscar cupones</label>
            <input type="text" 
                   id="searchInput" 
                   placeholder="Buscar cupones..." 
                   aria-label="Buscar cupones por código" 
                   class="w-full md:flex-1 bg-zinc-800 rounded-md px-4 py-2 text-gray-300 search-input">
        </div>
    </div>
    
    <!-- Cupones Table -->
    <div class="bg-zinc-800/50 rounded-lg overflow-x-auto cupones-table">
        <table id="tabla-cupones" class="w-full" aria-label="Tabla de cupones registrados">
            <thead>
                <tr class="text-left text-gray-400 border-b border-zinc-700">
                    <th scope="col" class="p-4">ID</th>
                    <th scope="col" class="p-4">Código</th>
                    <th scope="col" class="p-4">Descuento (%)</th>
                    <th scope="col" class="p-4">Acciones</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>
<script src="{{ asset('js/app-admin/generarTablasCupones.js') }}"></script>
@endsection