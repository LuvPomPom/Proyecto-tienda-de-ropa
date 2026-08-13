document.addEventListener('DOMContentLoaded', () => {
    const formProducto = document.getElementById('form-producto');
    const tablaProductos = document.getElementById('tabla-productos');

    // 1. Cargar productos en la tabla
    async function cargarProductos() {
        if (!tablaProductos) return;

        try {
            const res = await fetch('/api/productos');
            const productos = await res.json();

            if (productos.length === 0) {
                tablaProductos.innerHTML = `<tr><td colspan="4" style="text-align:center;">No hay productos registrados.</td></tr>`;
                return;
            }

            tablaProductos.innerHTML = productos.map(p => `
                <tr>
                    <td>
                        <img src="${p.imagen ? '/' + p.imagen : 'https://via.placeholder.com/40'}" 
                             width="40" height="40" style="object-fit:cover; border-radius:4px;">
                    </td>
                    <td><strong>${p.nombre}</strong></td>
                    <td>$${parseFloat(p.precio).toFixed(2)}</td>
                    <td>${p.marca_id}</td>
                </tr>
            `).join('');
        } catch (error) {
            console.error('Error al cargar lista:', error);
        }
    }

    // 2. Guardar producto con foto
    if (formProducto) {
        formProducto.addEventListener('submit', async (e) => {
            e.preventDefault();

            // Usamos FormData para enviar el archivo de imagen
            const formData = new FormData();
            formData.append('nombre', document.getElementById('nombre').value.trim());
            formData.append('precio', document.getElementById('precio').value);
            formData.append('marca_id', document.getElementById('marca_id').value);

            const fileInput = document.getElementById('imagen');
            if (fileInput && fileInput.files[0]) {
                formData.append('imagen', fileInput.files[0]);
            }

            try {
                const response = await fetch('/api/productos', {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json'
                        // NOTA: No agregamos 'Content-Type' aquí, FormData lo configura solo
                    },
                    body: formData
                });

                const data = await response.json();

                if (response.ok && data.success) {
                    alert('¡Producto guardado exitosamente!');
                    formProducto.reset();
                    cargarProductos();
                } else {
                    alert('Error al guardar: ' + (data.message || 'Verifica los datos.'));
                }
            } catch (error) {
                console.error('Error enviando datos:', error);
                alert('Ocurrió un error al conectar con el servidor.');
            }
        });
    }

    // Cargar la lista al iniciar
    cargarProductos();
});