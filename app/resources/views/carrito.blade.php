<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito de Compras - VOGA Store</title>

    <!-- FontAwesome para Íconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- CSS desde la carpeta public -->
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>
<body>

    <header class="navbar">
        <a href="{{ url('/') }}" class="logo">
            <svg width="220" height="70" viewBox="0 0 220 70" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M25 20L35 45H29L25 34L21 45H15L25 20Z" fill="#111111"/>
                <path d="M25 26L22.5 33H27.5L25 26Z" fill="#FFFFFF"/>
                <path d="M38 20H43V45H38V20Z" fill="#777777"/>
                <text x="65" y="42" font-family="Montserrat, Helvetica, sans-serif" font-size="28" font-weight="300" letter-spacing="8" fill="#111111">VOGA</text>
                <text x="67" y="52" font-family="Montserrat, Helvetica, sans-serif" font-size="8" font-weight="500" letter-spacing="4" fill="#777777">STORE</text>
            </svg>
        </a>
        <a href="{{ url('/') }}" style="font-weight: 700; font-size: 13px; text-decoration: none; color: #111;">← VOLVER A LA TIENDA</a>
    </header>

    <main class="products-section" style="max-width: 1000px; margin: 40px auto; padding: 0 20px;">
        <h2 class="section-title">Tu Carrito de Compras</h2>
        
        <div id="carrito-contenedor">
            <p style="text-align: center; padding: 40px; color: #666;">Tu carrito está vacío actualmente.</p>
        </div>

        <div style="margin-top: 30px; text-align: right;" id="carrito-resumen">
            <h3 style="font-size: 20px; font-weight: 800;">Total: <span id="carrito-total">$ 0</span></h3>
            <br>
            <button class="btn-adidas" onclick="checkout()" style="cursor: pointer; display: inline-flex; align-items: center; gap: 10px;">
                FINALIZAR COMPRA <i class="fa-solid fa-arrow-right"></i>
            </button>
        </div>
    </main>

    <!-- Scripts desde la carpeta public -->
    <script src="{{ asset('js/api.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>
    <script src="{{ asset('js/cart.js') }}"></script>
</body>
</html>