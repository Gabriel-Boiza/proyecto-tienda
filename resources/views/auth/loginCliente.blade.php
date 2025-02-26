<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Periféricos</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900 min-h-screen flex items-center justify-center">
    <div class="max-w-md w-full bg-gray-800 rounded-lg shadow-xl p-8">
        <div class="mb-8 text-center">
            <h2 class="text-3xl font-bold text-purple-500 mb-2">Bienvenido</h2>
            <p class="text-gray-400">Ingresa a tu cuenta de PePeriféricos</p>
        </div>
        
        <form action="requestLoginCliente" method="POST" class="space-y-6">
        @csrf
            
            <div>
                <label for="email" class="block text-sm font-medium text-gray-300 mb-2">
                    Correo electrónico
                </label>
                <input 
                    type="email" 
                    name="email" 
                    id="email" 
                    required
                    class="w-full px-4 py-3 rounded-lg bg-gray-700 border border-gray-600 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition duration-200"
                    placeholder="tucorreo@ejemplo.com"
                >
            </div>
            
            <div>
                <label for="password" class="block text-sm font-medium text-gray-300 mb-2">
                    Contraseña
                </label>
                <input 
                    type="password" 
                    name="password" 
                    id="password" 
                    required
                    class="w-full px-4 py-3 rounded-lg bg-gray-700 border border-gray-600 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition duration-200"
                    placeholder="••••••••"
                >
            </div>
            
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <input type="checkbox" id="remember" class="h-4 w-4 text-purple-500 focus:ring-purple-500 border-gray-600 rounded bg-gray-700">
                    <label for="remember" class="ml-2 block text-sm text-gray-300">
                        Recordarme
                    </label>
                </div>
                
                <a href="#" class="text-sm text-purple-400 hover:text-purple-300">
                    ¿Olvidaste tu contraseña?
                </a>
            </div>
            
            <button 
                type="submit"
                class="w-full bg-purple-600 hover:bg-purple-700 text-white font-bold py-3 px-4 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 focus:ring-offset-gray-800 transition duration-200"
            >
                Iniciar sesión
            </button>
        </form>
        @if ($errors->any())
            <div class="text-red-500 text-sm">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif


        
        <p class="mt-6 text-center text-sm text-gray-400">
            ¿No tienes una cuenta?
            <a href="#" class="text-purple-400 hover:text-purple-300 font-medium">
                Regístrate aquí
            </a>
        </p>
    </div>
</body>
</html>