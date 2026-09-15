<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>
<body>
<header class="navbar">
    <a href="/" class="logo"><strong>VOGA STORE</strong></a>
</header>

<div class=panel-altura>
<div class=panel>
    <h2>Iniciar Sesión</h2>
    
    @if($errors->any())
        <p style="color:red;">{{ $errors->first() }}</p>
    @endif

    <form action="{{ route('login.post') }}" method="POST">       <!-- maped URL -->
        @csrf
        <input type="email" name="email" placeholder="Correo" required><br><br>
        <input type="password" name="password" placeholder="Contraseña" required><br><br>

        <button type="submit" class="btn">Ingresar</button>

    </form>
    

    <p style="text-align: center;"><a href="{{ route('register') }}">¿No tenés cuenta? Registrate</a></p> 

</div>
</div>

</body>
</html>