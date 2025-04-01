@extends('welcome')

@section('title', 'Editar perfil')

@section('content')
    <div class="max-w-4xl mx-auto px-4 py-8">
        <h1 class="text-2xl font-bold text-gray-400 mb-6">Editar perfil</h1>

        <div class="bg-gray-800/30 p-6 rounded-lg shadow-lg">
            <form action="/updatePerfil/{{$cliente->id}}" method="POST" class="space-y-6">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="nombre" class="block text-sm font-medium mb-1">Nombre</label>
                        <input type="text" name="nombre" id="nombre" value="{{ $cliente->nombre }}" class="w-full px-3 py-2 border border-gray-700 rounded-md bg-gray-900 text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div>
                        <label for="apellido" class="block text-sm font-medium mb-1">Apellido</label>
                        <input type="text" name="apellido" id="apellido" value="{{ $cliente->apellido }}" class="w-full px-3 py-2 border border-gray-700 rounded-md bg-gray-900 text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>


                    <div>
                        <label for="telefono" class="block text-sm font-medium mb-1">Teléfono</label>
                        <input type="text" name="telefono" id="telefono" value="{{ $cliente->telefono }}" class="w-full px-3 py-2 border border-gray-700 rounded-md bg-gray-900 text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div class="md:col-span-2">
                        <label for="direccion" class="block text-sm font-medium mb-1">Dirección</label>
                        <input type="text" name="direccion" id="direccion" value="{{ $cliente->direccion }}" class="w-full px-3 py-2 border border-gray-700 rounded-md bg-gray-900 text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div>
                        <label for="ciudad" class="block text-sm font-medium mb-1">Ciudad</label>
                        <input type="text" name="ciudad" id="ciudad" value="{{ $cliente->ciudad }}" class="w-full px-3 py-2 border border-gray-700 rounded-md bg-gray-900 text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div>
                        <label for="codigo_postal" class="block text-sm font-medium mb-1">Código Postal</label>
                        <input type="text" name="codigo_postal" id="codigo_postal" value="{{ $cliente->codigo_postal }}" class="w-full px-3 py-2 border border-gray-700 rounded-md bg-gray-900 text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div class="md:col-span-2">
                        <label for="pais" class="block text-sm font-medium mb-1">País</label>
                        <input type="text" name="pais" id="pais" value="{{ $cliente->pais }}" class="w-full px-3 py-2 border border-gray-700 rounded-md bg-gray-900 text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>

                <div class="flex justify-end space-x-4 pt-4">
                    <a href="/perfil">
                        Cancelar
                    </a>
                    <button type="submit" class="button">
                        Guardar cambios
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection