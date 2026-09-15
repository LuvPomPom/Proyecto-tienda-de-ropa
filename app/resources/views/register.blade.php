<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro</title>
    <link rel="stylesheet" href="{{ asset('css/register.css') }}">
</head>

<body>
<header class="navbar">
    <a href="/" class="logo"><strong>VOGA STORE</strong></a>
</header>

<div class=panel-altura>
<div class=panel>
    <h2>Crear Cuenta</h2>
    <form action="{{ route('register.post') }}" method="POST">    <!-- field-validation -->
        @csrf
        <input type="text" name="nombre" placeholder="Nombre" required><br><br>
        <input type="email" name="email" placeholder="Correo" required><br><br>
        <input type="password" name="password" placeholder="Contraseña" required><br><br>
        <button type="submit" class="btn">Registrarse</button>
    </form>
    <p style="text-align: center;"><a href="{{ route('login') }}">¿Ya tenés cuenta? Iniciar sesión</a></p>

</div>
</div>
</body>
</html>