<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PePeriféricos</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/css/app.css', 'resources/css/inicio.css', 'resources/css/game.css'])



</head>
<body class="flex flex-col min-h-screen bg-gray-900 text-white">
    <!-- Navigation -->
    @include('user.componentes.header')

    <main class="flex-grow">
        @yield('content')
    </main>
    @include('user.componentes.footer')
    
        <!--Start of Tawk.to Script-->
 <!--   <script type="text/javascript">
    var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
    (function(){
    var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
    s1.async=true;
    s1.src='https://embed.tawk.to/67d2a21a3a7b24190be9844e/1im7cidp9';
    s1.charset='UTF-8';
    s1.setAttribute('crossorigin','*');
    s0.parentNode.insertBefore(s1,s0);
    })();
    </script>
     End of Tawk.to Script-->  
</body>