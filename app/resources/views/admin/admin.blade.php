<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body>

    <aside>
        <h2>Admin Panel</h2>
        <nav>
            <a href="/">Salir</a>
        </nav>
    </aside>

    <main>
        <h1>Gestión de Productos</h1>

        <form id="form-producto" action="{{ route('productos.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="text" name="nombre" placeholder="Nombre (ej: Nike Air Max)" required>
            <input type="number" name="precio" step="0.01" placeholder="Precio" required>
            <input type="number" name="stock" placeholder="Stock" required>
            
            <select name="categoria_id" required>
                <option value="">Categoría</option>
                <option value="1">Deportivos</option>
                <option value="2">Urbanos</option>
                <option value="3">Formales</option>
            </select>

            <input type="file" name="imagen" accept="image/*">
            <button type="submit">Guardar Producto</button>
        </form>

</body>
</html>