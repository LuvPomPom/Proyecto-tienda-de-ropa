<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VOGA STORE</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>


<body>
     <main>
        <h1>Envios, pruebita</h1>


    <form id="form-envio" action="{{ route('envios.store') }}" method="POST">
    @csrf


    <label for="nombre">Nombre</label>
    <input type="text" id="nombre" name="nombre" required> <br>


    <label for="apellido">Apellido</label>
    <input type="text" id="apellido" name="apellido" required> <br>


    <label for="cedula">Cédula de identidad</label>
    <input type="text" id="cedula" name="cedula" required> <br>


    <label for="fec_nac">Fecha de nacimiento</label>
    <input type="date" id="fec_nac" name="fec_nac" required> <br>


    <label for="telf">Teléfono</label>
    <input type="text" id="telf" name="telf" required> <br>


    <label for="direc">Dirección</label>
    <input type="text" id="direc" name="direc" required> <br>


    <button type="submit">Confirmar envío</button>


    </form>
    </main>


</body>
</html>
