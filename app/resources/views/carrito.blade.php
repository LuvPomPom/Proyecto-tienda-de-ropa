<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito - VOGA Store</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>
<body>


    <header class="navbar">
        <a href="{{ url('/') }}" class="logo"><strong>VOGA STORE</strong></a>
        <a href="{{ url('/') }}">← VOLVER A LA TIENDA</a>
    </header>


    <main class="products-section">
        <h2>Tu Carrito</h2>
       
        <div id="carrito-contenedor">
            <p>Cargando productos...</p>
        </div>


        <div id="carrito-resumen" style="margin-top: 20px; text-align: right;">
            <h3>Total: <span id="carrito-total">$ 0</span></h3>
           <a href="{{ url('/envios') }}"> <button class="btn-buy"style="margin-top: 10px;">FINALIZAR COMPRA</button> </a>
        </div>
    </main>


    <script src="{{ asset('js/api.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>
</body>
</html>
