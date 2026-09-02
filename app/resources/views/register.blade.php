<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro</title>
</head>
<body>
    <h2>Crear Cuenta</h2>
    <form action="{{ route('register.post') }}" method="POST">
        @csrf
        <input type="text" name="nombre" placeholder="Nombre" required><br><br>
        <input type="email" name="email" placeholder="Correo" required><br><br>
        <input type="password" name="password" placeholder="Contraseña" required><br><br>
        <button type="submit">Registrarse</button>
    </form>
    <p><a href="{{ route('login') }}">¿Ya tenés cuenta? Iniciar sesión</a></p>
</body>
</html>