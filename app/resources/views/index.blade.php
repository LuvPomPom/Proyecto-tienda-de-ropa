<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tienda de Ropa</title>

    @vite(['resources/css/styles.css', 'resources/js/api.js', 'resources/js/main.js'])
</head>
<body>

    <div class="top-banner">
        ¡BIENVENIDOS A LA TIENDA OFICIAL!
    </div>

    <div class="sub-header">
        <a href="#">ayuda</a>
        <a href="#">envíos y devoluciones</a>
        <span><img src="https://flagcdn.com/w20/uy.png" class="flag-icon" alt="Uruguay"></span>
    </div>

    <header class="navbar">
        <a href="index.html" class="logo">
            <svg height="32" viewBox="0 0 50 32" fill="black">
                <rect x="0" y="18" width="8" height="14" transform="skewX(-25)"></rect>
                <rect x="14" y="9" width="8" height="23" transform="skewX(-25)"></rect>
                <rect x="28" y="0" width="8" height="32" transform="skewX(-25)"></rect>
            </svg>
        </a>

        <ul class="nav-links">
            <li><a href="#" class="cat-link" data-category="todas">TODAS</a></li>
            <li><a href="#" class="cat-link" data-category="mujer">MUJER</a></li>
            <li><a href="#" class="cat-link" data-category="hombre">HOMBRE</a></li>
            <li><a href="#" class="cat-link" data-category="calzado">CALZADO</a></li>
            <li><a href="#" class="cat-link" data-category="accesorios">ACCESORIOS</a></li>
            <li><a href="#" class="sale cat-link" data-category="sale">SALE</a></li>
        </ul>

        <div class="nav-actions">
            <div class="search-box">
                <input type="text" id="search-input" placeholder="Buscar..." autocomplete="off">
                <button type="button"><i class="fa-solid fa-magnifying-glass"></i></button>
            </div>
            <div class="user-actions">
                <a href="admin/login.html" title="Mi Cuenta"><i class="fa-regular fa-user"></i></a>
                <a href="#" title="Favoritos"><i class="fa-regular fa-heart"></i></a>
                <div class="cart-trigger" id="open-cart" title="Carrito">
                    <i class="fa-solid fa-bag-shopping"></i>
                    <span id="cart-count" class="cart-badge">0</span>
                </div>
            </div>
        </div>
    </header>

    <section class="hero">
        <div class="hero-container">
            <div class="hero-left">
                <h2>SALE</h2>
                <p>LLEVATE HASTA UN 50% OFF EN EL CATÁLOGO SELECCIONADO.</p>
                <a href="#catalogo" class="btn-adidas">
                    COMPRAR AHORA <i class="fa-solid fa-arrow-right"></i>
                </a>
            </div>

            <div class="hero-right">
                <div class="big-text">HASTA</div>
                <div class="percentage">50%</div>
                <div class="off-text">OFF</div>
            </div>
        </div>
    </section>

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
            <div class="filter-item">
                <label for="price-range">PRECIO MÁXIMO: $ <span id="price-val">10000</span></label>
                <input type="range" id="price-range" min="500" max="10000" step="100" value="10000">
            </div>
        </div>
    </section>

    <section class="products-section" id="catalogo">
        <h3 class="section-title">Novedades y Destacados</h3>

        <div class="products-grid" id="products-container">
        </div>
    </section>

    <!-- ======================================================== -->
    <!-- SECCIÓN DE PRUEBA LEANDRO: FORMULARIO POST A SUPABASE    -->
    <!-- ======================================================== -->
    <section style="max-width: 600px; margin: 40px auto; padding: 25px; border: 2px dashed #000; background: #fafafa; text-align: center;">
        <h3 style="margin-bottom: 15px; font-weight: 800; font-size: 1.2rem; text-transform: uppercase;">
            🧪 Prueba Backend $\rightarrow$ Supabase
        </h3>

        @if(session('mensaje'))
            <div style="background-color: #d4edda; color: #155724; padding: 10px; border-radius: 4px; margin-bottom: 15px; font-weight: bold;">
                {{ session('mensaje') }}
            </div>
        @endif

        <form action="/guardar-dato" method="POST" style="display: flex; flex-direction: column; gap: 12px;">
            @csrf
            
            <label for="nombre" style="font-weight: 600; text-align: left;">Ingrese un nombre/producto de prueba:</label>
            <input type="text" id="nombre" name="nombre" placeholder="Ej: Remera de prueba" required style="padding: 10px; border: 1px solid #ccc; font-size: 14px;">

            <button type="submit" class="btn-adidas" style="cursor: pointer; padding: 12px; background: #000; color: #fff; font-weight: bold; border: none; text-transform: uppercase;">
                Guardar en Supabase
            </button>
        </form>
    </section>
    <!-- ======================================================== -->

    <div class="modal" id="product-modal">
        <div class="modal-content">
            <span class="close-modal" id="close-product-modal">&times;</span>
            <div id="modal-detail-body">
            </div>
        </div>
    </div>

    <div class="cart-drawer" id="cart-drawer">
        <div class="cart-header">
            <h3>TU CARRITO</h3>
            <span class="close-cart-btn" id="close-cart">&times;</span>
        </div>
        <div class="cart-items" id="cart-items-container">
        </div>
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

    <a href="https://wa.me/59800000000" class="whatsapp-btn" target="_blank" title="Contactar por WhatsApp">
        <i class="fa-brands fa-whatsapp"></i>
    </a>

</body>
</html>