<!DOCTYPE html>
<html>
<head>
    <title>Dashboard de Administrador</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">Panel de Administración</a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <span class="nav-link">Administrador: {{ Auth::user()->name }}</span>
                    </li>
                    <li class="nav-item">
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-link nav-link">Cerrar Sesión</button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Panel de Administración</div>
                    <div class="card-body">
                        <p>¡Bienvenido al panel de administración!</p>
                        <p>Como administrador, tienes acceso completo al sistema.</p>
                        
                        <div class="mt-4">
                            <h5>Opciones de Administrador:</h5>
                            <ul>
                                <li>Gestionar usuarios</li>
                                <li>Configurar sistema</li>
                                <li>Ver estadísticas</li>
                                <li>Administrar roles</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>