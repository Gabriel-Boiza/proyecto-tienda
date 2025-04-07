<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editor Dashboard</title>
</head>
<body>
    <h1>Editor Dashboard</h1>
    <p>Welcome to the editor dashboard!</p>
    
    @auth
        <p>You are logged in as: {{ auth()->user()->name }}</p>
        <p>Your role is: {{ auth()->user()->role->name }}</p>
        
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit">Logout</button>
        </form>
    @endauth
</body>
</html>