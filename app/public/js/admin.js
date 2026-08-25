document.addEventListener('DOMContentLoaded', () => {
    const formProducto = document.getElementById('form-producto');
    const tablaProductos = document.getElementById('tabla-productos');

    // 1. Cargar productos
    async function cargarProductos() {
        if (!tablaProductos) return;

        try {
            const res = await fetch('/api/productos');
            const productos = await res.json();

            if (!productos.length) {
                tablaProductos.innerHTML = `<tr><td colspan="5" style="text-align:center;">No hay productos registrados.</td></tr>`;
                return;
            }

            tablaProductos.innerHTML = productos.map(p => `
                <tr>
                    <td>
                        <img src="${p.imagen ? '/' + p.imagen : 'https://via.placeholder.com/40'}" 
                             width="40" height="40" style="object-fit:cover; border-radius:4px;">
                    </td>
                    <td><strong>${p.nombre}</strong></td>
                    <td>$${Number(p.precio).toFixed(2)}</td>
                    <td>${p.stock ?? 0}</td>
                    <td><button onclick="eliminarProducto(${p.id_producto})" class="btn-danger"><i class="fa-solid fa-trash"></i></button></td>
                </tr>
            `).join('');
        } catch (error) {
            console.error('Error al cargar lista:', error);
        }
    }

    // 2. Guardar producto
    if (formProducto) {
        formProducto.addEventListener('submit', async (e) => {
            e.preventDefault();

            // new FormData toma automáticamente todos los inputs con atributo name=""
            const formData = new FormData(formProducto);

            try {
                const response = await fetch('/api/productos', {
                    method: 'POST',
                    headers: { 'Accept': 'application/json' },
                    body: formData
                });

                const data = await response.json();

                if (response.ok && data.success) {
                    alert('¡Producto guardado exitosamente!');
                    formProducto.reset();
                    cargarProductos();
                } else {
                    alert('Error: ' + (data.message || 'Verifica los datos enviados.'));
                }
            } catch (error) {
                console.error('Error enviando datos:', error);
                alert('Ocurrió un error al conectar con el servidor.');
            }
        });
    }

    cargarProductos();
});