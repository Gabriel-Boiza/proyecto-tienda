<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TechAdmin Dashboard</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite('resources/css/app.css')
</head>
<body class="bg-zinc-900 text-white p-8">
    <div class="flex min-h-screen">

        @include('app-admin.componentes.panel_admin')

        <main class="flex-1 p-6">
            @yield('contentAdmin')
        </main>
    </div>
</body>
</html>