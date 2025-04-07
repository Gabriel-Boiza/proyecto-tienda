<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">My Application</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    @auth
                        <li class="nav-item">
                            <span class="nav-link">Welcome, {{ auth()->user()->name }}</span>
                        </li>
                        <li class="nav-item">
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-link nav-link">Logout</button>
                            </form>
                        </li>
                    @else
                        <li class="nav-item">
                            <a href="{{ route('login') }}" class="nav-link">Login</a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>
    
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">User Dashboard</div>
                    <div class="card-body">
                        @auth
                            <h4>Welcome to your dashboard!</h4>
                            <p>Your role is: {{ auth()->user()->role->name ?? 'No role assigned' }}</p>
                            
                            <div class="row mt-4">
                                <div class="col-md-4">
                                    <div class="card mb-3">
                                        <div class="card-body text-center">
                                            <h5 class="card-title">Profile</h5>
                                            <p class="card-text">Manage your account information</p>
                                            <a href="#" class="btn btn-primary">View Profile</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card mb-3">
                                        <div class="card-body text-center">
                                            <h5 class="card-title">Settings</h5>
                                            <p class="card-text">Configure your preferences</p>
                                            <a href="#" class="btn btn-primary">Settings</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card mb-3">
                                        <div class="card-body text-center">
                                            <h5 class="card-title">Activity</h5>
                                            <p class="card-text">View your recent activity</p>
                                            <a href="#" class="btn btn-primary">View Activity</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @else
                            <p>You are not logged in.</p>
                            <a href="{{ route('login') }}" class="btn btn-primary">Login</a>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
