@extends('app-admin.vista_admin')

@section('title', 'Editar Cupón')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/app-admin/cupones.css') }}">
@endsection

@section('contentAdmin')
<div class="flex-1 p-6">
    <div class="mb-6">
        <h1 class="text-xl font-bold">Editar Cupón</h1>
        <p class="text-gray-400">Actualice la información del cupón de descuento</p>
    </div>
    
    <div class="bg-zinc-800/50 rounded-lg p-6">
        <form action="{{ route('cupones.update', $cupon->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')
            
            <!-- Mensaje de error -->
            @if ($errors->any())
            <div class="bg-red-500/30 border border-red-500 text-red-200 px-4 py-3 rounded relative mb-6" role="alert">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Código del Cupón -->
                <div>
                    <label for="codigo" class="block text-sm font-medium text-gray-300 mb-2">Código del Cupón</label>
                    <input type="text" 
                           name="codigo" 
                           id="codigo" 
                           value="{{ old('codigo', $cupon->codigo) }}" 
                           class="w-full bg-zinc-700 border border-zinc-600 rounded-md px-4 py-2 text-gray-300 focus:outline-none focus:ring-2 focus:ring-purple-500"
                           required>
                    <p class="text-xs text-gray-400 mt-1">El código que los clientes usarán para aplicar el descuento.</p>
                </div>
                
                <!-- Porcentaje de Descuento -->
                <div>
                    <label for="descuento" class="block text-sm font-medium text-gray-300 mb-2">Descuento (%)</label>
                    <input type="number" 
                           name="descuento" 
                           id="descuento" 
                           value="{{ old('descuento', $cupon->descuento) }}" 
                           min="0" 
                           max="100" 
                           step="0.01"
                           class="w-full bg-zinc-700 border border-zinc-600 rounded-md px-4 py-2 text-gray-300 focus:outline-none focus:ring-2 focus:ring-purple-500"
                           required>
                    <p class="text-xs text-gray-400 mt-1">Porcentaje de descuento que aplicará el cupón.</p>
                </div>
            </div>
            
            <!-- Botones -->
            <div class="flex justify-end gap-4 mt-6">
                <a href="{{ route('cupones.index') }}" class="px-4 py-2 bg-zinc-700 text-gray-300 rounded-md hover:bg-zinc-600">
                    Cancelar
                </a>
                <button type="submit" class="px-4 py-2 bg-purple-600 text-white rounded-md hover:bg-purple-700">
                    Actualizar Cupón
                </button>
            </div>
        </form>
    </div>
</div>
@endsection