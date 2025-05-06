<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>
    <div>
        <h2>Iniciar Sesión</h2>
        
        @if($errors->any())
            <div style="color: red;">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ url('/login') }}">
            @csrf
            <div>
                <label for="nick">Usuario:</label>
                <input type="text" id="nick" name="nick" value="{{ old('nick') }}" required>
            </div>
            <div>
                <label for="pass">Contraseña:</label>
                <input type="password" id="pass" name="pass" required>
            </div>
            <button type="submit">Iniciar Sesión</button>
        </form>
    </div>       
</body>
</html>
