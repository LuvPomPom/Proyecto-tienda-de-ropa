<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tienda de Ropa</title>

    <!-- FontAwesome CDN Directo -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

    <!-- CSS desde la carpeta public -->
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>
<body>

    <header class="navbar">
        <a href="/" class="logo">
            <svg width="220" height="70" viewBox="0 0 220 70" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M25 20L35 45H29L25 34L21 45H15L25 20Z" fill="#111111"/>
                <path d="M25 26L22.5 33H27.5L25 26Z" fill="#FFFFFF"/>
                <path d="M38 20H43V45H38V20Z" fill="#777777"/>
                <text x="65" y="42" font-family="Montserrat, Helvetica, sans-serif" font-size="28" font-weight="300" letter-spacing="8" fill="#111111">VOGA</text>
                <text x="67" y="52" font-family="Montserrat, Helvetica, sans-serif" font-size="8" font-weight="500" letter-spacing="4" fill="#777777">STORE</text>
            </svg>
        </a>

        <ul class="nav-links">
            <li><a href="{{ url('/categoria/todas') }}" class="cat-link">TODAS</a></li>
            <li><a href="{{ url('/categoria/mujer') }}" class="cat-link">MUJER</a></li>
            <li><a href="{{ url('/categoria/hombre') }}" class="cat-link">HOMBRE</a></li>
            <li><a href="{{ url('/categoria/calzado') }}" class="cat-link">CALZADO</a></li>
            <li><a href="{{ url('/categoria/accesorios') }}" class="cat-link">ACCESORIOS</a></li>
            <li><a href="{{ url('/categoria/sale') }}" class="sale cat-link">SALE</a></li>
        </ul>

        <div class="nav-actions">
            <div class="search-box">
                <input type="text" id="search-input" placeholder="Buscar..." autocomplete="off">
                <button type="button"><i class="fa-solid fa-magnifying-glass"></i></button>
            </div>
            <div class="user-actions">
                <a href="/login" title="Mi Cuenta"><i class="fa-regular fa-user"></i></a>
                <div class="cart-trigger" id="open-cart" title="Carrito">
                    <i class="fa-solid fa-bag-shopping"></i>
                    <span id="cart-count" class="cart-badge">0</span>
                </div>
            </div>
        </div>
    </header>

    <section class="filter-bar">
        <div class="filter-wrapper">
            <div class="filter-item">
                <label for="category-filter">CATEGORÍA:</label>
                <select id="category-filter">
                    <option value="todas">TODAS</option>
                    <option value="hombre">HOMBRE</option>
                    <option value="mujer">MUJER</option>
                    <option value="calzado">CALZADO</option>
                    <option value="ropa">ROPA</option>
                    <option value="accesorios">ACCESORIOS</option>
                </select>
            </div>
        </div>
    </section>

    <section class="products-section" id="catalogo">
        <h3 class="section-title">Novedades y Destacados</h3>

        <div class="products-grid" id="products-container">
            @forelse($productos as $producto)
                <div class="product-card">
                    <div class="product-img">
                        <img src="{{ asset($producto->imagen ?? 'imgs/placeholder.png') }}" alt="{{ $producto->nombre }}">
                    </div>
                    <div class="product-info">
                        <h4>{{ $producto->nombre }}</h4>
                        <div class="price-container">
                            <span class="price">${{ number_format($producto->precio, 0, ',', '.') }}</span>
                        </div>
                        <button class="btn-buy">AGREGAR AL CARRITO</button>
                    </div>
                </div>
            @empty
                <p style="grid-column: 1/-1; text-align: center; padding: 40px;">
                    No hay productos disponibles en esta categoría.
                </p>
            @endforelse
        </div>
    </section>

    <!-- Modales y Drawer del Carrito -->
    <div class="modal" id="product-modal">
        <div class="modal-content">
            <span class="close-modal" id="close-product-modal">&times;</span>
            <div id="modal-detail-body"></div>
        </div>
    </div>

    <div class="cart-drawer" id="cart-drawer">
        <div class="cart-header">
            <h3>TU CARRITO</h3>
            <span class="close-cart-btn" id="close-cart">&times;</span>
        </div>
        <div class="cart-items" id="cart-items-container"></div>
        <div class="cart-footer">
            <div class="total-row">
                <span>TOTAL:</span>
                <span id="cart-total">$0</span>
            </div>
            <button class="btn-checkout" id="checkout-btn">FINALIZAR COMPRA</button>
        </div>
    </div>

    <div class="modal" id="checkout-modal">
        <div class="modal-content">
            <span class="close-modal" id="close-checkout">&times;</span>
            <h2 style="font-weight: 900; margin-bottom: 15px;">DATOS DE ENVÍO Y PAGO</h2>
            <form id="checkout-form">
                <div class="form-group">
                    <label>Nombre Completo</label>
                    <input type="text" required placeholder="Ej: Juan Pérez">
                </div>
                <div class="form-group">
                    <label>Dirección de Envío</label>
                    <input type="text" required placeholder="Ej: Av. 18 de Julio 1234">
                </div>
                <div class="form-group">
                    <label>Teléfono</label>
                    <input type="tel" required placeholder="Ej: 099 123 456">
                </div>
                <div class="form-group">
                    <label>Método de Pago</label>
                    <select id="payment-method">
                        <option value="tarjeta">Tarjeta de Crédito / Débito</option>
                        <option value="mercadopago">Mercado Pago</option>
                    </select>
                </div>
                <button type="submit" class="btn-buy" style="width: 100%; margin-top: 15px;">CONFIRMAR Y PAGAR</button>
            </form>
        </div>
    </div>

    <!-- Scripts desde la carpeta public -->
    <script src="{{ asset('js/api.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>
</body>
</html>