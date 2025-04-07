<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acceso No Autorizado</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-danger text-white">Acceso No Autorizado</div>
                    <div class="card-body">
                        <p>No tienes permisos para acceder a esta sección.</p>
                        
                        @auth
                            <div class="alert alert-info">
                                <p>Has iniciado sesión como: <strong>{{ auth()->user()->name }}</strong></p>
                                <p>Tu rol es: <strong>{{ auth()->user()->role->name ?? 'Sin rol asignado' }}</strong></p>
                            </div>
                            
                            <div class="d-flex gap-2">
                                <a href="{{ route('dashboard') }}" class="btn btn-primary">Volver al Dashboard</a>
                                
                                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-outline-danger">Cerrar Sesión</button>
                                </form>
                            </div>
                        @else
                            <div class="alert alert-warning">
                                <p>No has iniciado sesión.</p>
                            </div>
                            <div class="d-flex gap-2">
                                <a href="{{ route('login') }}" class="btn btn-primary">Iniciar Sesión</a>
                                <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary">Ir al Inicio</a>
                            </div>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
