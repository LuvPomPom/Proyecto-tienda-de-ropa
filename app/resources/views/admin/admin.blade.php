<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración</title>

@vite([
    'resources/css/admin.css',
    'resources/js/admin.js'
])
</head>
<body>

    <div class="admin-container">
        <aside class="sidebar">
            <h2>Admin Panel</h2>
            <nav>
                <a href="/admin" class="active"><i class="fa-solid fa-box"></i> Productos</a>
                <a href="#"><i class="fa-solid fa-list-check"></i> Categorías</a>
                <a href="#"><i class="fa-solid fa-cart-shopping"></i> Pedidos</a>
                <a href="/" class="logout"><i class="fa-solid fa-right-from-bracket"></i> Salir</a>
            </nav>
        </aside>

        <main class="main-content">
            <header class="topbar">
                <h1>Gestión de Productos</h1>
                <span class="user-badge"><i class="fa-solid fa-user-shield"></i> Administrador</span>
            </header>

            <div class="content-grid">
                
                <section class="card form-card">
                    <h2><i class="fa-solid fa-plus"></i> Nuevo Producto</h2>
                    <form id="form-producto">
                        <div class="input-group">
                            <label for="nombre">Nombre del Producto</label>
                            <input type="text" id="nombre" placeholder="Ej: Zapatillas Adidas" required>
                        </div>

                        <div class="input-row">
                            <div class="input-group">
                                <label for="precio">Precio ($)</label>
                                <input type="number" id="precio" step="0.01" placeholder="2990" required>
                            </div>
                            <div class="input-group">
                                <label for="stock">Stock</label>
                                <input type="number" id="stock" placeholder="15" required>
                            </div>
                        </div>

                        <div class="input-row">

    <div class="input-group">
        <label for="marca_id">Marca</label>

        <select id="marca_id" required>
            <option value="">Seleccionar marca</option>
            <option value="1">Nike</option>
            <option value="2">Adidas</option>
            <option value="3">Rebook</option>
        </select>
    </div>

    <div class="input-group">
        <label for="categoria_id">Categoría</label>

        <select id="categoria_id" required>
            <option value="">Seleccionar categoría</option>
            <option value="1">Hombre</option>
            <option value="2">Mujer</option>
            <option value="3">Unisex</option>
            <option value="4">Calzado</option>
            <option value="5">Ropa</option>
            <option value="6">Accesorios</option>
        </select>
    </div>

</div>

                        <div class="input-group">
                            <label for="imagen">Imagen del Producto</label>
                            <input type="file" id="imagen" accept="image/*">
                        </div>

                        <button type="submit" class="btn-primary">
                            <i class="fa-solid fa-floppy-disk"></i> Guardar Producto
                        </button>
                    </form>
                </section>

                <section class="card table-card">
                    <h2><i class="fa-solid fa-list"></i> Inventario Actual</h2>
                    <div class="table-responsive">
                        <table>
                            <thead>
                                <tr>
                                    <th>Imagen</th>
                                    <th>Nombre</th>
                                    <th>Precio</th>
                                    <th>Stock</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td colspan="5" style="text-align: center; color: #64748b; padding: 20px;">
                                        Cargando productos...
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </section>

            </div>
        </main>
    </div>

</body>
</html>