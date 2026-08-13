<!--Muestra la foto ampliada, selección de talle, color y botón de comprar-->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalle del producto</title>

    @vite(['resources/css/styles.css', 'resources/js/api.js', 'resources/js/main.js', 'resources/js/cart.js'])
</head>
<body>

    <header class="navbar">
        <a href="index.html" class="logo">
            <svg height="32" viewBox="0 0 50 32" fill="black">
                <rect x="0" y="18" width="8" height="14" transform="skewX(-25)"></rect>
                <rect x="14" y="9" width="8" height="23" transform="skewX(-25)"></rect>
                <rect x="28" y="0" width="8" height="32" transform="skewX(-25)"></rect>
            </svg>
        </a>
        <a href="index.html" style="font-weight: 700; font-size: 13px;">← SEGUIR COMPRANDO</a>
    </header>

    <main class="products-section" style="display: flex; gap: 40px; flex-wrap: wrap;">
        <div style="flex: 1; min-width: 300px; background: #f5f5f5; height: 400px; display: flex; align-items: center; justify-content: center;">
            <i class="fa-regular fa-image" style="font-size: 80px; color: #ccc;"></i>
        </div>

        <div style="flex: 1; min-width: 300px;">
            <p style="color: #767677; text-transform: uppercase; font-size: 12px;" id="prod-categoria">Categoría</p>
            <h1 style="font-size: 28px; text-transform: uppercase; margin: 10px 0;" id="prod-nombre">Nombre del Producto</h1>
            <h2 style="font-size: 22px; font-weight: 900; margin-bottom: 20px;" id="prod-precio">$ 0</h2>
            
            <p style="line-height: 1.6; color: #333; margin-bottom: 30px;" id="prod-descripcion">
                Descripción detallada del producto disponible en la tienda.
            </p>

            <button class="btn-adidas" style="width: 100%; justify-content: center;" id="btn-agregar">
                AÑADIR AL CARRITO <i class="fa-solid fa-bag-shopping"></i>
            </button>
        </div>
    </main>

   
</body>
</html>