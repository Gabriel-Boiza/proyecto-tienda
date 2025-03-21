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

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Elementos del DOM
        const cube = document.getElementById('cube');
        const target = document.getElementById('target');
        const gameContainer = document.getElementById('game-container');
        const timerElement = document.getElementById('timer');
        const timerBar = document.getElementById('timer-bar');
        const startButton = document.getElementById('start-button');
        const resetButton = document.getElementById('reset-button');
        const timeSelect = document.getElementById('time-select');
        const resultsDiv = document.getElementById('results');
        const cubesPlacedElement = document.getElementById('cubes-placed');
        const totalTimeElement = document.getElementById('total-time');
        const scoreElement = document.getElementById('score');
        const playAgainButton = document.getElementById('play-again');
        
        // Variables del juego
        let timerInterval;
        let timeRemaining = 30;
        let maxTime = 30;
        let cubesPlaced = 0;
        let gameActive = false;
        let isDragging = false;
        let offsetX, offsetY;
        
        // Inicializar el temporizador
        timerElement.textContent = timeSelect.value;
        maxTime = parseInt(timeSelect.value);
        
        // Scroll suave
        document.getElementById('scrollToGame').addEventListener('click', function() {
            const juego = document.getElementById('juego');
            
            if (juego) {
                window.scrollTo({
                    top: juego.offsetTop - 80,
                    behavior: 'smooth'
                });
            }
        });
        
        document.getElementById('scrollToControls').addEventListener('click', function() {
            const instrucciones = document.getElementById('instrucciones');
            
            if (instrucciones) {
                window.scrollTo({
                    top: instrucciones.offsetTop - 80,
                    behavior: 'smooth'
                });
            }
        });
        
        // Obtener dimensiones del contenedor
        const getContainerDimensions = () => {
            return {
                width: gameContainer.clientWidth,
                height: gameContainer.clientHeight
            };
        };
        
        // Posicionar elemento en una posición aleatoria
        const positionRandomly = (element) => {
            const { width, height } = getContainerDimensions();
            const elementWidth = element.offsetWidth;
            const elementHeight = element.offsetHeight;
            
            const maxX = width - elementWidth;
            const maxY = height - elementHeight;
            
            const randomX = Math.floor(Math.random() * maxX);
            const randomY = Math.floor(Math.random() * maxY);
            
            element.style.left = randomX + 'px';
            element.style.top = randomY + 'px';
        };
        
        // Generar nuevo objetivo y cubo
        const generateNewRound = () => {
            if (!gameActive) return;
            
            // Posicionar objetivo y cubo aleatoriamente
            positionRandomly(target);
            positionRandomly(cube);
            
            // Mostrar elementos
            target.style.display = 'block';
            cube.style.display = 'block';
        };
        
        // Verificar si el cubo está en el objetivo
        const checkCubeInTarget = () => {
            const cubeRect = cube.getBoundingClientRect();
            const targetRect = target.getBoundingClientRect();
            
            // Verificar si el centro del cubo está dentro del objetivo
            const cubeCenterX = cubeRect.left + cubeRect.width / 2;
            const cubeCenterY = cubeRect.top + cubeRect.height / 2;
            
            return (
                cubeCenterX >= targetRect.left &&
                cubeCenterX <= targetRect.right &&
                cubeCenterY >= targetRect.top &&
                cubeCenterY <= targetRect.bottom
            );
        };
        
        // Actualizar barra de progreso
        const updateTimerBar = () => {
            const percentage = (timeRemaining / maxTime) * 100;
            timerBar.style.width = percentage + '%';
        };
        
        // Iniciar el juego
        const startGame = () => {
            // Reiniciar variables
            maxTime = parseInt(timeSelect.value);
            timeRemaining = maxTime;
            cubesPlaced = 0;
            gameActive = true;
            
            // Actualizar UI
            timerElement.textContent = timeRemaining;
            updateTimerBar();
            startButton.disabled = true;
            resetButton.disabled = false;
            timeSelect.disabled = true;
            resultsDiv.style.display = 'none';
            
            // Cambiar estilos de botones
            startButton.classList.add('bg-gray-700', 'cursor-not-allowed', 'text-gray-400');
            startButton.classList.remove('bg-purple-600', 'hover:bg-purple-700', 'shadow-lg', 'shadow-purple-600/30', 'hover:scale-105');
            
            resetButton.classList.remove('bg-gray-700', 'cursor-not-allowed', 'text-gray-400');
            resetButton.classList.add('bg-red-600', 'hover:bg-red-700', 'text-white', 'hover:scale-105', 'shadow-lg', 'shadow-red-600/30');
            
            // Generar primer objetivo y cubo
            generateNewRound();
            
            // Iniciar temporizador
            timerInterval = setInterval(() => {
                timeRemaining--;
                timerElement.textContent = timeRemaining;
                updateTimerBar();
                
                if (timeRemaining <= 0) {
                    endGame();
                }
            }, 1000);
        };
        
        // Finalizar el juego
        const endGame = () => {
            clearInterval(timerInterval);
            gameActive = false;
            
            // Ocultar elementos
            cube.style.display = 'none';
            target.style.display = 'none';
            
            // Restaurar estilos de botones
            startButton.disabled = false;
            timeSelect.disabled = false;
            resetButton.disabled = true;
            
            startButton.classList.remove('bg-gray-700', 'cursor-not-allowed', 'text-gray-400');
            startButton.classList.add('bg-purple-600', 'hover:bg-purple-700', 'shadow-lg', 'shadow-purple-600/30', 'hover:scale-105');
            
            resetButton.classList.add('bg-gray-700', 'cursor-not-allowed', 'text-gray-400');
            resetButton.classList.remove('bg-red-600', 'hover:bg-red-700', 'text-white', 'hover:scale-105', 'shadow-lg', 'shadow-red-600/30');
            
            // Mostrar resultados
            cubesPlacedElement.textContent = cubesPlaced;
            totalTimeElement.textContent = maxTime;
            
            // Calcular puntuación (cubos colocados × 100 ÷ tiempo en segundos)
            const score = Math.round((cubesPlaced * 100) / maxTime);
            scoreElement.textContent = score;
            
            resultsDiv.style.display = 'block';
            
            // Scroll a resultados
            window.scrollTo({
                top: resultsDiv.offsetTop - 100,
                behavior: 'smooth'
            });
        };
        
        // Reiniciar el juego
        const resetGame = () => {
            clearInterval(timerInterval);
            
            // Ocultar elementos
            cube.style.display = 'none';
            target.style.display = 'none';
            
            // Reiniciar variables
            timeRemaining = maxTime;
            cubesPlaced = 0;
            gameActive = false;
            
            // Actualizar UI
            timerElement.textContent = timeRemaining;
            updateTimerBar();
            
            startButton.disabled = false;
            resetButton.disabled = true;
            timeSelect.disabled = false;
            resultsDiv.style.display = 'none';
            
            // Restaurar estilos de botones
            startButton.classList.remove('bg-gray-700', 'cursor-not-allowed', 'text-gray-400');
            startButton.classList.add('bg-purple-600', 'hover:bg-purple-700', 'shadow-lg', 'shadow-purple-600/30', 'hover:scale-105');
            
            resetButton.classList.add('bg-gray-700', 'cursor-not-allowed', 'text-gray-400');
            resetButton.classList.remove('bg-red-600', 'hover:bg-red-700', 'text-white', 'hover:scale-105', 'shadow-lg', 'shadow-red-600/30');
        };
        
        // Event Listeners
        startButton.addEventListener('click', startGame);
        resetButton.addEventListener('click', resetGame);
        playAgainButton.addEventListener('click', function() {
            resetGame();
            startGame();
        });
        
        timeSelect.addEventListener('change', () => {
            timerElement.textContent = timeSelect.value;
            maxTime = parseInt(timeSelect.value);
        });
        
        // Funcionalidad de drag and drop
        cube.addEventListener('mousedown', (e) => {
            if (!gameActive) return;
            
            isDragging = true;
            
            // Calcular el offset del mouse relativo al cubo
            const cubeRect = cube.getBoundingClientRect();
            offsetX = e.clientX - cubeRect.left;
            offsetY = e.clientY - cubeRect.top;
            
            cube.style.cursor = 'grabbing';
        });
        
        document.addEventListener('mousemove', (e) => {
            if (!isDragging) return;
            
            // Calcular la nueva posición
            const gameRect = gameContainer.getBoundingClientRect();
            const newLeft = e.clientX - gameRect.left - offsetX;
            const newTop = e.clientY - gameRect.top - offsetY;
            
            // Limitar al contenedor
            const maxX = gameRect.width - cube.offsetWidth;
            const maxY = gameRect.height - cube.offsetHeight;
            
            const boundedLeft = Math.max(0, Math.min(newLeft, maxX));
            const boundedTop = Math.max(0, Math.min(newTop, maxY));
            
            // Aplicar la nueva posición
            cube.style.left = boundedLeft + 'px';
            cube.style.top = boundedTop + 'px';
        });
        
        document.addEventListener('mouseup', () => {
            if (!isDragging) return;
            
            isDragging = false;
            cube.style.cursor = 'grab';
            
            // Verificar si el cubo está en el objetivo
            if (checkCubeInTarget()) {
                cubesPlaced++;
                generateNewRound();
            }
        });
        
        // Soporte para pantallas táctiles
        cube.addEventListener('touchstart', (e) => {
            if (!gameActive) return;
            e.preventDefault();
            
            isDragging = true;
            
            const touch = e.touches[0];
            const cubeRect = cube.getBoundingClientRect();
            offsetX = touch.clientX - cubeRect.left;
            offsetY = touch.clientY - cubeRect.top;
        });
        
        document.addEventListener('touchmove', (e) => {
            if (!isDragging) return;
            e.preventDefault();
            
            const touch = e.touches[0];
            const gameRect = gameContainer.getBoundingClientRect();
            const newLeft = touch.clientX - gameRect.left - offsetX;
            const newTop = touch.clientY - gameRect.top - offsetY;
            
            const maxX = gameRect.width - cube.offsetWidth;
            const maxY = gameRect.height - cube.offsetHeight;
            
            const boundedLeft = Math.max(0, Math.min(newLeft, maxX));
            const boundedTop = Math.max(0, Math.min(newTop, maxY));
            
            cube.style.left = boundedLeft + 'px';
            cube.style.top = boundedTop + 'px';
        });
        
        document.addEventListener('touchend', () => {
            if (!isDragging) return;
            
            isDragging = false;
            
            if (checkCubeInTarget()) {
                cubesPlaced++;
                generateNewRound();
            }
        });
    });
</script>

@endsection