<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="{{ asset('js/app-admin/generarCategorias.js') }}"></script>
</head>
<body class="bg-zinc-900 text-white p-8">
    <div class="flex">
        @include('app-admin.componentes.panel_admin')
        <main class="flex-1 flex flex-col items-center justify-center p-6">
            <h1 class="text-center text-2xl mb-4">Gestión categorías</h1>
            <form method="POST" id="formulario" class="flex justify-center w-full max-w-[60%] mb-2">
                <input name="nombre_categoria" id="generarInput" type="text" placeholder="Nombre de la categoria" 
                class="w-[70%] p-2 border rounded-md bg-slate-800 border-slate-700 placeholder-white">
                <input type="submit" class="w-[25%] p-2 text-white bg-purple-600 border rounded-md ml-5" value="+ Generar">
            </form>

            <div id="container"> </div>
        </main>

    </div>
</body>
</html>