@extends('welcome')

@section('title', 'Perfil de cliente')

@section('content')
    <div class="max-w-4xl mx-auto px-4 py-8">
        <h1 class="text-2xl font-bold text-gray-400 mb-6">Perfil de cliente</h1>

        <div class="bg-gray-800/30 p-6 rounded-lg shadow-lg">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-semibold">Información Personal</h2>
                <a href="/editPerfil/{{$cliente->id}}" class="button">
                    Editar perfil
                </a>
            </div>
            
            <div class="space-y-4">
                <p><strong>Nombre:</strong> {{ $cliente->nombre }} {{ $cliente->apellido }}</p>
                <p><strong>Email:</strong> {{ $cliente->email }}</p>
                <p><strong>Teléfono:</strong> {{ $cliente->telefono }}</p>
                <p><strong>Dirección:</strong> {{ $cliente->direccion }}</p>
                <p><strong>Ciudad:</strong> {{ $cliente->ciudad }}</p>
                <p><strong>Código Postal:</strong> {{ $cliente->codigo_postal }}</p>
                <p><strong>País:</strong> {{ $cliente->pais }}</p>
                <p class="text-sm text-gray-500">Cuenta creada el {{ date('d-m-Y', strtotime($cliente->created_at)) }}</p>
            </div>
        </div>
    </div>
@endsection