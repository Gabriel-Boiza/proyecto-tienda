@extends('welcome')

@section('content')

<!-- Hero con gradiente animado -->
<div class="relative w-full h-screen overflow-hidden bg-gradient-animate">
    <!-- Efecto de partículas/líneas -->
    <div class="absolute inset-0 pattern-overlay"></div>
    
    <div class="absolute inset-0 bg-black/60"></div>
    
    <!-- Logo flotante grande -->
    <div class="absolute inset-0 flex items-center justify-center">
        <h1 class="text-9xl font-extrabold text-white opacity-5 select-none tracking-widest">TIMECHALLENGE</h1>
    </div>
    
    <div class="relative container mx-auto px-4 py-24 flex items-center h-full">
        <div class="max-w-3xl">
            <span class="inline-block px-4 py-1 bg-purple-600/30 text-purple-300 rounded-full mb-4 border border-purple-500/20 text-sm font-medium">DESAFÍO CONTRARRELOJ</span>
            <h1 class="text-5xl font-bold mb-6 text-white">Juego de Drag and Drop</h1>
            <p class="text-xl mb-8 text-gray-200">
                Arrastra los cubos a los objetivos antes de que se acabe el tiempo. Pon a prueba tus reflejos y precisión.
            </p>
            <div class="flex flex-wrap gap-4">
                <button id="scrollToGame" class="bg-purple-600 hover:bg-purple-700 px-8 py-3 rounded-lg font-bold transform hover:scale-105 transition-all duration-200 text-white shadow-lg shadow-purple-600/30">
                    Jugar ahora
                </button>
                <button id="scrollToControls" class="bg-transparent hover:bg-white/10 border border-purple-400 px-8 py-3 rounded-lg font-bold transform hover:scale-105 transition-all duration-200 text-white">
                    Ver instrucciones
                </button>
            </div>
        </div>
    </div>
    
    <!-- Scroll indicator -->
    <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 animate-bounce">
        <svg class="w-6 h-6 text-white/70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
        </svg>
    </div>
</div>

<style>
    .bg-gradient-animate {
        background: linear-gradient(-45deg, rgb(132, 21, 223), rgb(36, 80, 201), rgb(126, 47, 187), rgb(30, 64, 175));
        background-size: 400% 400%;
        animation: gradient 15s ease infinite;
    }
    
    @keyframes gradient {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }
    
    .pattern-overlay {
        background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
    }
    
    #game-container {
        position: relative;
        width: 100%;
        height: 400px;
        margin: 0 auto;
        border: 2px solid rgba(107, 33, 168, 0.5);
        overflow: hidden;
        border-radius: 0.75rem;
        background-color: rgb(31, 41, 55);
        box-shadow: 0 10px 25px -5px rgba(107, 33, 168, 0.3);
    }
    
    #cube {
        position: absolute;
        width: 50px;
        height: 50px;
        background-color: #3498db;
        cursor: grab;
        z-index: 10;
        border-radius: 5px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        display: none;
        transition: transform 0.1s;
    }
    
    #cube:active {
        cursor: grabbing;
        transform: scale(1.05);
    }
    
    #target {
        position: absolute;
        width: 60px;
        height: 60px;
        border: 2px dashed rgb(216, 50, 132);
        border-radius: 5px;
        z-index: 5;
        display: none;
    }
    
    #results {
        display: none;
    }
</style>

<!-- Instrucciones del juego -->
<div id="instrucciones" class="container mx-auto px-4 py-16">
    <h2 class="text-3xl font-bold mb-8 relative inline-block">
        Instrucciones
        <span class="absolute -bottom-2 left-0 w-1/2 h-1 bg-gradient-to-r from-purple-600 to-blue-600"></span>
    </h2>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <div class="bg-gray-800 rounded-xl p-6 border border-gray-700/50 hover:-translate-y-1 transition-transform duration-300">
            <div class="bg-purple-600/10 w-16 h-16 rounded-full mb-4 flex items-center justify-center">
                <svg class="w-8 h-8 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
            </div>
            <h3 class="text-lg font-semibold mb-2">Selecciona el tiempo</h3>
            <p class="text-gray-400">Elige cuánto tiempo quieres para el desafío: 10 segundos, 30 segundos, 1 minuto o 2 minutos.</p>
        </div>
        <div class="bg-gray-800 rounded-xl p-6 border border-gray-700/50 hover:-translate-y-1 transition-transform duration-300">
            <div class="bg-purple-600/10 w-16 h-16 rounded-full mb-4 flex items-center justify-center">
                <svg class="w-8 h-8 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5M7.188 2.239l.777 2.897M5.136 7.965l-2.898-.777M13.95 4.05l-2.122 2.122m-5.657 5.656l-2.12 2.122"></path>
                </svg>
            </div>
            <h3 class="text-lg font-semibold mb-2">Arrastra el cubo</h3>
            <p class="text-gray-400">Arrastra el cubo azul hacia el área objetivo marcada con líneas punteadas. Se irán generando nuevos objetivos.</p>
        </div>
        <div class="bg-gray-800 rounded-xl p-6 border border-gray-700/50 hover:-translate-y-1 transition-transform duration-300">
            <div class="bg-purple-600/10 w-16 h-16 rounded-full mb-4 flex items-center justify-center">
                <svg class="w-8 h-8 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                </svg>
            </div>
            <h3 class="text-lg font-semibold mb-2">Obtén tu puntuación</h3>
            <p class="text-gray-400">Cuando finalice el tiempo, verás tu puntuación basada en el número de cubos colocados correctamente.</p>
        </div>
    </div>
</div>

<!-- Juego -->
<div id="juego" class="container mx-auto px-4 py-8">
    <h2 class="text-3xl font-bold mb-8 relative inline-block">
        Juego de Drag and Drop
        <span class="absolute -bottom-2 left-0 w-1/2 h-1 bg-gradient-to-r from-purple-600 to-blue-600"></span>
    </h2>
    
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        <!-- Panel de control -->
        <div class="bg-gray-800 rounded-xl p-6 border border-gray-700/50">
            <h3 class="text-xl font-semibold mb-4">Controles</h3>
            
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-400 mb-2">Selecciona el tiempo:</label>
                <select id="time-select" class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2 text-white focus:outline-none focus:ring-2 focus:ring-purple-600">
                    <option value="10">10 segundos</option>
                    <option value="30" selected>30 segundos</option>
                    <option value="60">60 segundos</option>
                    <option value="120">2 minutos</option>
                </select>
            </div>
            
            <div class="flex flex-col gap-3">
                <button id="start-button" class="bg-purple-600 hover:bg-purple-700 px-6 py-3 rounded-lg font-bold transform hover:scale-105 transition-all duration-200 text-white shadow-lg shadow-purple-600/30">
                    Iniciar Juego
                </button>
                <button id="reset-button" disabled class="bg-gray-700 px-6 py-3 rounded-lg font-bold transition-all duration-200 text-gray-400 cursor-not-allowed">
                    Reiniciar
                </button>
            </div>
            
            <div class="mt-6">
                <h4 class="text-lg font-medium mb-2">Tiempo restante:</h4>
                <div class="bg-gray-700 rounded-lg overflow-hidden">
                    <div id="timer-bar" class="bg-gradient-to-r from-purple-600 to-blue-600 h-4 w-full transition-all duration-1000"></div>
                </div>
                <div id="timer-container" class="mt-2 text-center">
                    <span id="timer" class="text-2xl font-bold">30</span> segundos
                </div>
            </div>
        </div>
        
        <!-- Área de juego -->
        <div class="lg:col-span-2">
            <div id="game-container">
                <div id="target"></div>
                <div id="cube"></div>
            </div>
        </div>
    </div>
    
    <!-- Resultados -->
    <div id="results" class="bg-gray-800 rounded-xl p-6 border border-gray-700/50 max-w-3xl mx-auto">
        <h3 class="text-2xl font-bold mb-6 text-center">Resultados</h3>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            <div class="bg-gray-700/50 rounded-xl p-4 text-center">
                <h4 class="text-sm text-gray-400 mb-1">Cubos colocados</h4>
                <p id="cubes-placed" class="text-3xl font-bold text-purple-400">0</p>
            </div>
            <div class="bg-gray-700/50 rounded-xl p-4 text-center">
                <h4 class="text-sm text-gray-400 mb-1">Tiempo total</h4>
                <p id="total-time" class="text-3xl font-bold text-blue-400">0</p>
                <span class="text-sm text-gray-400">segundos</span>
            </div>
            <div class="bg-gray-700/50 rounded-xl p-4 text-center">
                <h4 class="text-sm text-gray-400 mb-1">Puntuación</h4>
                <p id="score" class="text-3xl font-bold text-green-400">0</p>
                <span class="text-sm text-gray-400">puntos</span>
            </div>
        </div>
        
        <button id="play-again" class="w-full bg-purple-600 hover:bg-purple-700 px-6 py-3 rounded-lg font-bold transform hover:scale-105 transition-all duration-200 text-white shadow-lg shadow-purple-600/30">
            Jugar de nuevo
        </button>
    </div>
</div>

<script src="{{asset('js/user/game.js')}}"></script>

@endsection