<!DOCTYPE html>               <!-- ¿Para qué sirve? > Es la portada principal de la tienda (/). Aquí mostramos el Banner gigante promocional (Hero Banner) con la oferta "50% OFF" y una pequeña selección de productos destacados para llamar la atención del cliente apenas entra al sitio. -->
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Tienda de Ropa') }}</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif

    <style>
        /* RESET & BASE */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
        }

        body {
            background-color: #fff;
            color: #000;
        }

        a {
            text-decoration: none;
            color: inherit;
        }

        /* 1. TOP ANNOUNCEMENT BAR */
        .top-banner {
            background-color: #000;
            color: #fff;
            text-align: center;
            padding: 8px 10px;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 1.5px;
            text-transform: uppercase;
        }

        /* 2. SECONDARY HEADER */
        .sub-header {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            gap: 15px;
            padding: 6px 40px;
            font-size: 11px;
            color: #363738;
        }

        .sub-header a:hover {
            text-decoration: underline;
        }

        .flag-icon {
            width: 16px;
            height: auto;
            vertical-align: middle;
        }

        /* 3. MAIN NAVBAR */
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 40px 15px 40px;
            border-bottom: 1px solid #ebedee;
            position: sticky;
            top: 0;
            background-color: #fff;
            z-index: 1000;
        }

        .logo img {
            height: 40px;
            display: block;
        }

        .nav-links {
            display: flex;
            list-style: none;
            gap: 25px;
        }

        .nav-links li a {
            font-size: 14px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            padding-bottom: 4px;
        }

        .nav-links li a:hover {
            border-bottom: 2px solid #000;
        }

        .nav-links li a.sale {
            color: #d3122a;
        }

        .nav-actions {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .search-box {
            position: relative;
            background-color: #eceff1;
            display: flex;
            align-items: center;
            padding: 6px 12px;
            border-radius: 2px;
        }

        .search-box input {
            border: none;
            background: transparent;
            outline: none;
            font-size: 13px;
            width: 180px;
        }

        .search-box button {
            background: none;
            border: none;
            cursor: pointer;
            font-size: 14px;
        }

        .user-actions {
            display: flex;
            gap: 18px;
            font-size: 18px;
        }

        .user-actions a:hover {
            color: #666;
        }

        /* 4. HERO BANNER */
        .hero {
            position: relative;
            width: 100%;
            height: 480px;
            background: linear-gradient(135deg, #e62334 0%, #b80012 100%);
            color: #fff;
            display: flex;
            align-items: center;
            overflow: hidden;
        }

        .hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 50%;
            height: 100%;
            background: radial-gradient(circle, rgba(255,255,255,0.2) 0%, rgba(255,255,255,0) 70%);
            transform: skewX(-20deg);
        }

        .hero-container {
            width: 100%;
            max-width: 1300px;
            margin: 0 auto;
            padding: 0 50px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: relative;
            z-index: 2;
        }

        .hero-left {
            max-width: 450px;
        }

        .hero-left h2 {
            font-size: 42px;
            font-weight: 900;
            font-style: italic;
            letter-spacing: 1px;
            margin-bottom: 15px;
        }

        .hero-left p {
            font-size: 14px;
            font-weight: 600;
            letter-spacing: 0.5px;
            margin-bottom: 25px;
            text-transform: uppercase;
            line-height: 1.4;
        }

        .btn-adidas {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            background-color: #fff;
            color: #000;
            padding: 14px 22px;
            font-size: 13px;
            font-weight: 700;
            letter-spacing: 2px;
            text-transform: uppercase;
            border: 1px solid #000;
            transition: all 0.2s ease;
        }

        .btn-adidas:hover {
            color: #767677;
            border-color: #767677;
        }

        .hero-right {
            text-align: right;
        }

        .hero-right .big-text {
            font-size: 70px;
            font-weight: 900;
            line-height: 0.9;
            text-transform: uppercase;
        }

        .hero-right .percentage {
            font-size: 180px;
            font-weight: 900;
            line-height: 0.8;
            letter-spacing: -5px;
        }

        .hero-right .off-text {
            font-size: 40px;
            font-weight: 900;
            letter-spacing: 2px;
        }

        /* 5. SECCIÓN DE PRODUCTOS (NUEVO) */
        .products-section {
            max-width: 1300px;
            margin: 50px auto;
            padding: 0 40px;
        }

        .section-title {
            font-size: 24px;
            font-weight: 900;
            text-transform: uppercase;
            margin-bottom: 25px;
            letter-spacing: 1px;
        }

        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
            gap: 25px;
        }

        .product-card {
            border: 1px solid #ebedee;
            background: #fff;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            position: relative;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .product-card:hover {
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            transform: translateY(-3px);
        }

        .product-badge {
            position: absolute;
            top: 10px;
            left: 10px;
            background: #000;
            color: #fff;
            font-size: 10px;
            font-weight: 700;
            padding: 4px 8px;
            text-transform: uppercase;
            z-index: 10;
        }

        .product-img {
            width: 100%;
            height: 280px;
            background-color: #f5f5f5;
            overflow: hidden;
        }

        .product-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .product-info {
            padding: 15px;
        }

        .product-info h4 {
            font-size: 14px;
            font-weight: 700;
            text-transform: uppercase;
            margin-bottom: 6px;
            color: #000;
        }

        .product-info p.category {
            font-size: 12px;
            color: #767677;
            margin-bottom: 10px;
            text-transform: uppercase;
        }

        .product-info .price-container {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 15px;
        }

        .product-info .price {
            font-size: 16px;
            font-weight: 800;
        }

        .product-info .old-price {
            font-size: 14px;
            color: #767677;
            text-decoration: line-through;
        }

        .btn-buy {
            display: block;
            text-align: center;
            background-color: #000;
            color: #fff;
            padding: 12px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: background 0.2s ease;
        }

        .btn-buy:hover {
            background-color: #333;
        }

        /* 6. BOTÓN FLOTANTE WHATSAPP */
        .whatsapp-btn {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background-color: #25d366;
            color: #fff;
            width: 50px;
            height: 50px;
            border-radius: 5px;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 30px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.3);
            z-index: 9999;
            transition: transform 0.2s;
        }

        .whatsapp-btn:hover {
            transform: scale(1.05);
        }

        @media (max-width: 900px) {
            .nav-links, .sub-header { display: none; }
            .hero-container { flex-direction: column; text-align: center; justify-content: center; }
            .hero-right { margin-top: 20px; text-align: center; }
            .hero-right .percentage { font-size: 100px; }
            .hero-left h2 { font-size: 30px; }
            .products-section { padding: 0 20px; }
        }
    </style>
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
        <a href="/" class="logo">
            <svg height="32" viewBox="0 0 50 32" fill="black">
                <rect x="0" y="18" width="8" height="14" transform="skewX(-25)"></rect>
                <rect x="14" y="9" width="8" height="23" transform="skewX(-25)"></rect>
                <rect x="28" y="0" width="8" height="32" transform="skewX(-25)"></rect>
            </svg>
        </a>

        <ul class="nav-links">
            <li><a href="#">MUJER</a></li>
            <li><a href="#">HOMBRE</a></li>
            <li><a href="#">NIÑOS</a></li>
            <li><a href="#">DEPORTES</a></li>
            <li><a href="#">NOVEDADES</a></li>
            <li><a href="#" class="sale">SALE</a></li>
        </ul>

        <div class="nav-actions">
            <form action="#" method="GET" class="search-box">
                <input type="text" name="query" placeholder="Buscar" autocomplete="off">
                <button type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
            </form>
            <div class="user-actions">
                <a href="/login" title="Mi Cuenta"><i class="fa-regular fa-user"></i></a>
                <a href="#" title="Favoritos"><i class="fa-regular fa-heart"></i></a>
                <a href="{{ url('/carrito') }}" title="Carrito"> <i class="fa-solid fa-bag-shopping"></i> </a>
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

    <section class="products-section" id="catalogo">
        <h3 class="section-title">Novedades y Destacados</h3>

        <div class="products-grid">
            
            <div class="product-card">
                <span class="product-badge">Novedad</span>
                <div class="product-img">
                    <img src="https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=500" alt="Calzado Deportivo">
                </div>
                <div class="product-info">
                    <p class="category">Calzado Hombre</p>
                    <h4>Zapatillas Running Pro</h4>
                    <div class="price-container">
                        <span class="price">$ 4.590</span>
                        <span class="old-price">$ 5.990</span>
                    </div>
                    <a href="#" class="btn-buy">Ver Detalle</a>
                </div>
            </div>

            <div class="product-card">
                <span class="product-badge" style="background: #d3122a;">-30% OFF</span>
                <div class="product-img">
                    <img src="https://images.unsplash.com/photo-1521572267360-ee0c2909d518?w=500" alt="Camiseta">
                </div>
                <div class="product-info">
                    <p class="category">Ropa Hombre</p>
                    <h4>Camiseta Sport Classic</h4>
                    <div class="price-container">
                        <span class="price">$ 1.890</span>
                    </div>
                    <a href="#" class="btn-buy">Ver Detalle</a>
                </div>
            </div>

            <div class="product-card">
                <div class="product-img">
                    <img src="https://images.unsplash.com/photo-1556905055-8f358a7a47b2?w=500" alt="Canguro / Hoodie">
                </div>
                <div class="product-info">
                    <p class="category">Ropa Mujer</p>
                    <h4>Hoodie Oversize Black</h4>
                    <div class="price-container">
                        <span class="price">$ 3.290</span>
                    </div>
                    <a href="#" class="btn-buy">Ver Detalle</a>
                </div>
            </div>

            <div class="product-card">
                <span class="product-badge">Popular</span>
                <div class="product-img">
                    <img src="https://images.unsplash.com/photo-1584735935682-2f2b69dff9d2?w=500" alt="Mochila">
                </div>
                <div class="product-info">
                    <p class="category">Accesorios</p>
                    <h4>Mochila Urban Backpack</h4>
                    <div class="price-container">
                        <span class="price">$ 2.190</span>
                    </div>
                    <a href="#" class="btn-buy">Ver Detalle</a>
                </div>
            </div>

        </div>
    </section>

    <a href="https://wa.me/59800000000" class="whatsapp-btn" target="_blank" title="Contactar por WhatsApp">
        <i class="fa-brands fa-whatsapp"></i>
    </a>

</body>
</html>
