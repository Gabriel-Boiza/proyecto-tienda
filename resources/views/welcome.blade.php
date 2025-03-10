<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PePeriféricos - Gaming Peripherals</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">

</head>
<body class="bg-gray-900 text-white" x-data="{ mobileMenu: false }">
    <!-- Navigation -->
    @include('user.componentes.header')

    <main>
        @yield('content')
    </main>


    @include('user.componentes.footer')

    
    