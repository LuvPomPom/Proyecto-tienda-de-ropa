document.addEventListener('DOMContentLoaded', () => {
    const formProducto = document.getElementById('form-producto');
    const tablaProductos = document.getElementById('tabla-productos');

    async function cargarProductos() {
        if (!tablaProductos) return;
        try {
            const res = await fetch('/api/productos');
            const productos = await res.json();

            if (!productos.length) {
                tablaProductos.innerHTML = `<tr><td colspan="4">Sin productos.</td></tr>`;
                return;
            }

            tablaProductos.innerHTML = productos.map(p => `
                <tr>
                    <td><img src="${p.imagen ? '/' + p.imagen : ''}" width="40" height="40"></td>
                    <td>${p.nombre}</td>
                    <td>$${p.precio}</td>
                    <td>${p.stock ?? 0}</td>
                </tr>
            `).join('');
        } catch (error) {
            console.error('Error:', error);
        }
    }

    if (formProducto) {
        formProducto.addEventListener('submit', async (e) => {
            e.preventDefault();
            try {
                const response = await fetch('/api/productos', {
                    method: 'POST',
                    headers: { 'Accept': 'application/json' },
                    body: new FormData(formProducto)
                });

                if (response.ok) {
                    alert('Producto guardado');
                    formProducto.reset();
                    cargarProductos();
                } else {
                    alert('Error al guardar');
                }
            } catch (error) {
                alert('Error de conexión');
            }
        });
    }

    cargarProductos();
});