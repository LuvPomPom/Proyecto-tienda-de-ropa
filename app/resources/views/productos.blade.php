<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $producto->nombre ?? 'Detalle del producto' }} - VOGA Store</title>

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
        <a href="{{ url('/') }}" style="font-weight: 700; font-size: 13px; text-decoration: none; color: #111;">← SEGUIR COMPRANDO</a>
    </header>

    <main class="products-section" style="display: flex; gap: 40px; flex-wrap: wrap; max-width: 1200px; margin: 40px auto; padding: 0 20px;">
        <div style="flex: 1; min-width: 300px; background: #f5f5f5; min-height: 400px; display: flex; align-items: center; justify-content: center; border-radius: 4px; overflow: hidden;">
            @if(isset($producto->imagen) && $producto->imagen)
                <img src="{{ asset($producto->imagen) }}" alt="{{ $producto->nombre }}" style="width: 100%; height: 100%; object-fit: cover;">
            @else
                <i class="fa-regular fa-image" style="font-size: 80px; color: #ccc;"></i>
            @endif
        </div>

        <div style="flex: 1; min-width: 300px;">
            <p style="color: #767677; text-transform: uppercase; font-size: 12px; font-weight: 600;" id="prod-categoria">
                {{ $producto->categoria->nombre ?? 'Categoría' }}
            </p>
            <h1 style="font-size: 28px; text-transform: uppercase; margin: 10px 0; font-weight: 800;" id="prod-nombre">
                {{ $producto->nombre ?? 'Nombre del Producto' }}
            </h1>
            <h2 style="font-size: 22px; font-weight: 900; margin-bottom: 20px;" id="prod-precio">
                $ {{ isset($producto->precio) ? number_format($producto->precio, 0, ',', '.') : '0' }}
            </h2>
            
            <p style="line-height: 1.6; color: #333; margin-bottom: 30px;" id="prod-descripcion">
                {{ $producto->descripcion ?? 'Descripción detallada del producto disponible en la tienda.' }}
            </p>

            <button class="btn-adidas" style="width: 100%; justify-content: center; cursor: pointer;" id="btn-agregar" data-id="{{ $producto->id_producto ?? '' }}">
                AÑADIR AL CARRITO <i class="fa-solid fa-bag-shopping" style="margin-left: 8px;"></i>
            </button>
        </div>
    </main>

    <!-- Scripts desde la carpeta public -->
    <script src="{{ asset('js/api.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>
    <script src="{{ asset('js/cart.js') }}"></script>
</body>
</html>