<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VOGA STORE</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>
<body>

    <header class="navbar">
        <a href="/" class="logo"><strong>VOGA STORE</strong></a>

        <ul class="nav-links">
            <li><a href="{{ url('/categoria/todas') }}" class="cat-link">TODOS</a></li>
            <li><a href="{{ url('/categoria/deportivos') }}" class="cat-link">DEPORTIVOS</a></li>
            <li><a href="{{ url('/categoria/urbanos') }}" class="cat-link">URBANOS</a></li>
            <li><a href="{{ url('/categoria/formales') }}" class="cat-link">FORMALES</a></li>
        </ul>

        <div class="nav-actions">
            <div class="search-box">
                <input type="text" id="search-input" placeholder="Buscar..." autocomplete="off">
                <button type="button"><i class="fa-solid fa-magnifying-glass"></i></button>
            </div>
            <div class="user-actions">
                @auth
                    {{-- Si inició sesión: Mostramos su nombre, enlace de admin si aplica y botón de logout --}}
                    @if(Auth::user()->rol_id == 1)
                        <a href="{{ route('admin.dashboard') }}" title="Panel Admin"><i class="fa-solid fa-user-gear"></i></a>
                    @endif

                    <span style="font-size: 0.9rem; font-weight: bold;">{{ Auth::user()->nombre }}</span>

                    <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" title="Cerrar Sesión" style="background: none; border: none; cursor: pointer; color: inherit;">
                            <i class="fa-solid fa-right-from-bracket"></i>
                        </button>
                    </form>
                @else
                    {{-- Si es visitante: Mostramos el icono para ir al Login --}}
                    <a href="{{ route('login') }}" title="Mi Cuenta"><i class="fa-regular fa-user"></i></a>
                @endauth
                <div class="cart-trigger" id="open-cart" title="Carrito">
                   <a href="{{ url('/carrito') }}"> <i class="fa-solid fa-bag-shopping"></i>
                     </a>
                </div>
            </div>
        </div>
    </header>


    <section class="products-section" id="catalogo">
        <h3 class="section-title">Catálogo de Calzado</h3>

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
                    No hay calzado disponible en esta categoría.
                </p>
            @endforelse
        </div>
    </section>

    <div class="modal" id="product-modal">
        <div class="modal-content">
            <span class="close-modal" id="close-product-modal">&times;</span>
            <div id="modal-detail-body"></div>
        </div>
    </div>



    <script src="{{ asset('js/api.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>
</body>
</html>