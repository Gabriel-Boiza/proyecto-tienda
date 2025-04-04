@extends('welcome')

@section('content')


<div class="mt-16 gap-16 flex flex-col items-center w-full  ">
    <div class="w-full flex flex-col px-8 lg:px-24">
        <h2 class="text-2xl md:text-3xl font-bold mb-8">Instrucciones</h2>

        <div class="grid w-full h-auto grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3 lg:gap-16 lg:h-48 ">
            
            <article class="card col-2">
                <h5 class="card-titulo">Recoge el cubo!</h5>
                <p class="card-descripcion">Mantén pulsado click izquierdo mientras mueves el ratón para arrastrar el cubo por la pantalla.</p>
            </article>

            <article class="card">
                <h5 class="card-titulo">El objetivo aparecerá aleatoriamente</h5>
                <p class="card-descripcion">Debes poner el cubo en partes aleatorias del área de juego que se generarán aleatoriamente. ¡Llega hasta 5!</p>
            </article>

            <article class="card">
                <h5 class="card-titulo">Consigue tu cupón</h5>
                <p class="card-descripcion">Al terminar ganarás un cupón de descuento aleatorio para tu proximo pedido.</p>
            </article>
        </div>
    </div>

    <div class="relative w-full px-8 lg:px-24">
        <h2 class="text-2xl md:text-3xl font-bold mb-8">Juego</h2>
        <div id="score-container" class="mb-4 text-center">
            <span class="text-xl font-semibold">Puntuación: </span>
            <span id="puntuacion" class="text-2xl font-bold text-green-500">0</span>
        </div>
        <div id="escenario" class="w-full h-40 sm:h-48 md:h-56 lg:h-64 xl:h-72 2xl:h-80 rounded-lg shadow-sm bg-gray-800 border-gray-300"></div>
    </div>
</div>

<dialog id="dialog">
<h2 class="text-3xl font-bold mb-4">¡Felicidades!</h2>
        <p class="text-2xl" id="dialog-descripcion">Has ganado el cupón de descuento: </p>
        <form method="dialog">
            <button class="button">
                Cerrar
            </button>
        </form>
</dialog>

<script src="{{asset('js/user/game.js')}}"></script>

@endsection