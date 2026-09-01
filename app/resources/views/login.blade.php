<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
</head>
<body>
    <h2>Iniciar Sesión</h2>
    
    @if($errors->any())
        <p style="color:red;">{{ $errors->first() }}</p>
    @endif

    <form action="{{ route('login.post') }}" method="POST">
        @csrf
        <input type="email" name="email" placeholder="Correo" required><br><br>
        <input type="password" name="password" placeholder="Contraseña" required><br><br>
        <button type="submit">Ingresar</button>
    </form>
    <p><a href="{{ route('register') }}">¿No tenés cuenta? Registrarse</a></p>
</body>
</html>