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
        <nav>
            <a href="/">Salir</a>
        </nav>
    </aside>


    <main>
        <h1>Gestión de Productos</h1>

       


        <h2>Crear Nuevo Producto</h2>
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


        <hr style="margin: 30px 0;">

        @if(session('success'))
            <p style="color: green;">{{ session('success') }}</p>
        @endif

        <!-- TABLA DE EDICIÓN Y ACTUALIZACIÓN DE PRECIOS -->
        <h2>Productos Existentes</h2>
        @php
            $productosExistentes = \App\Models\Producto::all();
        @endphp


        <table border="1" cellpadding="8" style="width: 100%; border-collapse: collapse; margin-top: 10px;">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Precio ($)</th>
                    <th>Stock</th>
                    <th>Categoría</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                @foreach($productosExistentes as $prod)
                @php $formId = 'form-update-' . $prod->id_producto; @endphp


                <!-- Formulario independiente fuera del tr -->
                <form id="{{ $formId }}" action="{{ route('productos.update', $prod->id_producto) }}" method="POST">
                    @csrf
                    @method('PUT')
                </form>


                <tr>
                    <td>
                        <input type="text" name="nombre" value="{{ $prod->nombre }}" form="{{ $formId }}" required>
                    </td>
                    <td>
                        <input type="number" step="0.01" name="precio" value="{{ $prod->precio }}" form="{{ $formId }}" required style="width: 90px;">
                    </td>
                    <td>
                        <input type="number" name="stock" value="{{ $prod->stock }}" form="{{ $formId }}" required style="width: 70px;">
                    </td>
                    <td>
                        <select name="categoria_id" form="{{ $formId }}" required>
                            <option value="1" {{ $prod->categoria_id == 1 ? 'selected' : '' }}>Deportivos</option>
                            <option value="2" {{ $prod->categoria_id == 2 ? 'selected' : '' }}>Urbanos</option>
                            <option value="3" {{ $prod->categoria_id == 3 ? 'selected' : '' }}>Formales</option>
                        </select>
                    </td>
                    <td>
                        <button type="submit" form="{{ $formId }}">Actualizar</button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </main>


</body>
</html>

