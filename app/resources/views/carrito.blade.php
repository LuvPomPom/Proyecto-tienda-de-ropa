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

        {{-- Mensajes de estado (Stock, etc.) --}}
        @if(session('error'))
            <div style="color: red; margin-bottom: 15px;">
                {{ session('error') }}
            </div>
        @endif

        @if(session('success'))
            <div style="color: green; margin-bottom: 15px;">
                {{ session('success') }}
            </div>
        @endif

        <div id="carrito-contenedor">
            @forelse($carrito as $id => $item)
                <div class="cart-item" style="display: flex; align-items: center; justify-content: space-between; padding: 15px 0; border-bottom: 1px solid #eee;">
                    
                    {{-- Imagen y Detalles --}}
                    <div style="display: flex; align-items: center; gap: 15px;">
                        <img src="{{ asset($item['imagen'] ?? 'imgs/productos/1.jpg') }}" alt="{{ $item['nombre'] }}" style="width: 70px; height: 70px; object-fit: cover; border-radius: 4px;">
                        <div>
                            <h4 style="margin: 0 0 5px 0;">{{ $item['nombre'] }}</h4>
                            <p style="margin: 0; color: #666;">Precio: ${{ number_format($item['precio'], 0, ',', '.') }}</p>
                        </div>
                    </div>

                    {{-- Botones de Cantidad (+ / -) --}}
                    <div style="display: flex; align-items: center; gap: 10px;">
                        <form action="{{ route('carrito.cantidad', $id) }}" method="POST" style="margin:0;">
                            @csrf
                            <input type="hidden" name="operacion" value="restar">
                            <button type="submit" style="padding: 2px 8px; cursor: pointer;">-</button>
                        </form>

                        <span style="font-weight: bold;">{{ $item['cantidad'] }}</span>

                        <form action="{{ route('carrito.cantidad', $id) }}" method="POST" style="margin:0;">
                            @csrf
                            <input type="hidden" name="operacion" value="sumar">
                            <button type="submit" style="padding: 2px 8px; cursor: pointer;">+</button>
                        </form>
                    </div>

                    {{-- Subtotal --}}
                    <div>
                        <strong style="font-size: 1.1em;">${{ number_format($item['precio'] * $item['cantidad'], 0, ',', '.') }}</strong>
                    </div>
                </div>
            @empty
                <p>Tu carrito está vacío.</p>
            @endforelse
        </div>

        <div id="carrito-resumen" style="margin-top: 20px; text-align: right;">
            <h3>Total: <span id="carrito-total">$ {{ number_format($total, 0, ',', '.') }}</span></h3>
            
            @if(!empty($carrito))
                <a href="{{ route('envios') }}">
                    <button class="btn-buy" style="margin-top: 10px;">FINALIZAR COMPRA</button>
                </a>
            @endif
        </div>
    </main>

</body>
</html>