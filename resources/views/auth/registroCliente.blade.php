@extends('welcome')

@section(section: 'content')    
<main class="flex items-center justify-center py-8">
        <div class="max-w-3xl w-full bg-gray-800 rounded-lg shadow-xl p-8 mx-4">
            <div class="mb-6 text-center">
                <h2 class="text-2xl font-bold text-white mb-2">Crea tu cuenta</h2>
                <p class="text-gray-400">Completa tu información para comenzar</p>
            </div>
            @if ($errors->any())
                <div class="bg-red-500 text-white p-3 rounded-lg mb-4">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form class="space-y-4 w-full" action="registradoCliente" method="POST">
                @csrf
                <div class="flex space-x-4">
                    <div class="w-1/2">
                        <label for="nombre" class="block text-sm font-medium text-gray-300 mb-1">
                            Nombre
                        </label>
                        <input 
                            type="text" 
                            name="nombre" 
                            id="nombre" 
                            class="w-full px-4 py-3 rounded-lg bg-gray-700 border border-gray-600 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition duration-200"
                            placeholder="Ingresa tu nombre"
                        >
                    </div>
                    <div class="w-1/2">
                        <label for="apellido" class="block text-sm font-medium text-gray-300 mb-1">
                            Apellido
                        </label>
                        <input 
                            type="text" 
                            name="apellido" 
                            id="apellido" 
                            class="w-full px-4 py-3 rounded-lg bg-gray-700 border border-gray-600 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition duration-200"
                            placeholder="Ingresa tu apellido"
                        >
                    </div>
                </div>
                
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-300 mb-1">
                        Correo electrónico
                    </label>
                    <input 
                        type="email" 
                        name="email" 
                        id="email" 
                        class="w-full px-4 py-3 rounded-lg bg-gray-700 border border-gray-600 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition duration-200"
                        placeholder="tu@email.com"
                    >
                </div>
                
                <div>
                    <label for="contraseña" class="block text-sm font-medium text-gray-300 mb-1">
                        Contraseña
                    </label>
                    <input 
                        type="password" 
                        name="contraseña" 
                        id="contraseña" 
                        class="w-full px-4 py-3 rounded-lg bg-gray-700 border border-gray-600 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition duration-200"
                        placeholder="Crea una contraseña segura"
                    >
                </div>
                
                <div>
                    <label for="teléfono" class="block text-sm font-medium text-gray-300 mb-1">
                        Teléfono (Opcional)
                    </label>
                    <input 
                        type="tel" 
                        name="teléfono" 
                        id="teléfono" 
                        class="w-full px-4 py-3 rounded-lg bg-gray-700 border border-gray-600 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition duration-200"
                        placeholder="Ingresa tu número de teléfono"
                    >
                </div>
                
                <div>
                    <label for="dirección" class="block text-sm font-medium text-gray-300 mb-1">
                        Dirección (Opcional)
                    </label>
                    <input 
                        type="text" 
                        name="dirección" 
                        id="dirección" 
                        class="w-full px-4 py-3 rounded-lg bg-gray-700 border border-gray-600 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition duration-200"
                        placeholder="Ingresa tu dirección"
                    >
                </div>
                
                <div class="flex space-x-4">
                    <div class="w-1/3">
                        <label for="ciudad" class="block text-sm font-medium text-gray-300 mb-1">
                            Ciudad (Opcional)
                        </label>
                        <input 
                            type="text" 
                            name="ciudad" 
                            id="ciudad" 
                            class="w-full px-4 py-3 rounded-lg bg-gray-700 border border-gray-600 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition duration-200"
                            placeholder="Tu ciudad"
                        >
                    </div>
                    <div class="w-1/3">
                        <label for="codigo_postal" class="block text-sm font-medium text-gray-300 mb-1">
                            Código Postal (Opcional)
                        </label>
                        <input 
                            type="text" 
                            name="codigo_postal" 
                            id="codigo_postal" 
                            class="w-full px-4 py-3 rounded-lg bg-gray-700 border border-gray-600 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition duration-200"
                            placeholder="Código postal"
                        >
                    </div>
                    <div class="w-1/3">
                        <label for="pais" class="block text-sm font-medium text-gray-300 mb-1">
                            País (Opcional)
                        </label>
                        <input
                            type="text"
                            id="pais"
                            name="pais"
                            placeholder="País"
                            class="w-full px-4 py-3 rounded-lg bg-gray-700 border border-gray-600 text-white focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition duration-200 appearance-none"
                        >
                    </div>
                </div>
                
                <button 
                    type="submit"
                    class="w-full bg-purple-600 hover:bg-purple-700 text-white font-bold py-3 px-4 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 focus:ring-offset-gray-800 transition duration-200 mt-4"
                >
                    Crear Cuenta
                </button>
            </form>
            @if(session('success'))
                <div class="bg-green-500 text-white p-3 rounded-lg mb-4">
                    {{ session('success') }}
                </div>
            @endif
        </div>
    </main>
@endsection
