<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $producto->nombre ?? 'Detalle' }} - VOGA Store</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>
<body>

    <header class="navbar">
        <a href="{{ url('/') }}" class="logo"><strong>VOGA STORE</strong></a>
        <a href="{{ url('/') }}">← SEGUIR COMPRANDO</a>
    </header>

    <main class="products-section" style="display: flex; gap: 30px; flex-wrap: wrap;">
        <div style="flex: 1; min-width: 280px;">
            @if(isset($producto->imagen) && $producto->imagen)
                <img src="{{ asset($producto->imagen) }}" alt="{{ $producto->nombre }}" style="width: 100%;">
            @endif
        </div>

        <div style="flex: 1; min-width: 280px;">
            <p>{{ $producto->categoria->nombre ?? 'Categoría' }}</p>
            <h1>{{ $producto->nombre ?? 'Producto' }}</h1>
            <h2>$ {{ isset($producto->precio) ? number_format($producto->precio, 0, ',', '.') : '0' }}</h2>
            <button class="btn-buy" id="btn-agregar" onclick="agregarAlCarrito({{ $producto->id_producto ?? 0 }})">AÑADIR AL CARRITO</button>
        </div>
    </main>

    <script src="{{ asset('js/api.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>
    <script src="{{ asset('js/cart.js') }}"></script>
</body>
</html>