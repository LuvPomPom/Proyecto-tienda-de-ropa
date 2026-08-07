// Proteger vista: Si no hay token guardado, redirige al Login
if (!localStorage.getItem('admin_token')) {
    window.location.href = 'login.html';
}

// Lógica para cerrar sesión
document.addEventListener('DOMContentLoaded', () => {
    const logoutBtn = document.querySelector('.logout');
    if (logoutBtn) {
        logoutBtn.addEventListener('click', (e) => {
            e.preventDefault();
            if (confirm('¿Cerrar sesión?')) {
                localStorage.removeItem('admin_token');
                window.location.href = 'login.html';
            }
        });
    }
});

// Configuración base de la URL de tu Backend en Laravel
const API_URL = '127.0.0.1:5500/admin/admin.html#';

// Escuchamos el evento 'DOMContentLoaded' para asegurarnos de que el HTML esté cargado antes de ejecutar JS
document.addEventListener('DOMContentLoaded', () => {
    cargarProductosAdmin();
    configurarFormulario();
});

// ==========================================
// 1. OBTENER Y MOSTRAR PRODUCTOS EN LA TABLA
// ==========================================
async function cargarProductosAdmin() {
    const tbody = document.querySelector('tbody');
    
    try {
        // Hacemos la petición GET a Laravel
        const response = await fetch(`${API_URL}/productos`);
        const productos = await response.json();

        // Limpiamos el mensaje de "Cargando..." del tbody
        tbody.innerHTML = '';

        // Si la base de datos está vacía
        if (productos.length === 0) {
            tbody.innerHTML = `
                <tr>
                    <td colspan="5" style="text-align: center; color: #64748b; padding: 20px;">
                        No hay productos registrados en el sistema.
                    </td>
                </tr>
            `;
            return;
        }

        // Recorremos la lista de productos e insertamos cada fila en el tbody
        productos.forEach(producto => {
            // Evaluamos si el producto tiene una imagen guardada o mostramos una por defecto
            const imagenPath = producto.imagen_url 
                ? `http://localhost:8000${producto.imagen_url}` 
                : 'https://via.placeholder.com/50';

            const fila = document.createElement('tr');
            fila.innerHTML = `
                <td>
                    <img src="${imagenPath}" alt="${producto.nombre}" class="img-thumb">
                </td>
                <td><strong>${producto.nombre}</strong></td>
                <td>$${producto.precio}</td>
                <td><span class="badge stock-ok">${producto.stock} unid.</span></td>
                <td class="actions">
                    <button class="btn-icon edit" onclick="editarProducto(${producto.id})" title="Editar">
                        <i class="fa-solid fa-pen-to-square"></i>
                    </button>
                    <button class="btn-icon delete" onclick="eliminarProducto(${producto.id})" title="Eliminar">
                        <i class="fa-solid fa-trash"></i>
                    </button>
                </td>
            `;
            tbody.appendChild(fila);
        });

    } catch (error) {
        console.error('Error al conectar con la API:', error);
        tbody.innerHTML = `
            <tr>
                <td colspan="5" style="text-align: center; color: #ef4444; padding: 20px;">
                    <i class="fa-solid fa-triangle-exclamation"></i> Error al conectar con el servidor.
                </td>
            </tr>
        `;
    }
}

// ==========================================
// 2. ENVIAR FORMULARIO DE NUEVO PRODUCTO
// ==========================================
function configurarFormulario() {
    const form = document.getElementById('form-producto');

    form.addEventListener('submit', async (e) => {
        e.preventDefault(); // Evitamos que la página se recargue

        // Capturamos los campos del formulario
        const nombre = document.getElementById('nombre').value;
        const precio = document.getElementById('precio').value;
        const stock = document.getElementById('stock').value;
        const categoria = document.getElementById('categoria').value;
        const imagenInput = document.getElementById('imagen');

        // Usamos FormData porque enviamos texto e imagen (archivo binario) juntos
        const formData = new FormData();
        formData.append('nombre', nombre);
        formData.append('precio', precio);
        formData.append('stock', stock);
        formData.append('categoria', categoria);
        
        // Si el usuario seleccionó un archivo de imagen, lo adjuntamos
        if (imagenInput.files[0]) {
            formData.append('imagen', imagenInput.files[0]);
        }

        try {
            // Petición POST enviando los datos a Laravel
            const response = await fetch(`${API_URL}/productos`, {
                method: 'POST',
                body: formData // Importante: FormData ajusta automáticamente los Headers de la petición
            });

            if (response.ok) {
                alert('¡Producto guardado exitosamente!');
                form.reset(); // Limpia los inputs del formulario
                cargarProductosAdmin(); // Actualiza la tabla para mostrar el producto recién guardado
            } else {
                alert('No se pudo guardar el producto. Revisa los datos.');
            }
        } catch (error) {
            console.error('Error en el formulario:', error);
            alert('Error de conexión con el backend.');
        }
    });
}

// ==========================================
// 3. ACCIONES DE TABLA (Eliminar / Editar)
// ==========================================
async function eliminarProducto(id) {
    if (confirm('¿Estás seguro de que deseas eliminar este producto?')) {
        try {
            const response = await fetch(`${API_URL}/productos/${id}`, {
                method: 'DELETE'
            });

            if (response.ok) {
                cargarProductosAdmin(); // Recarga la tabla limpia
            } else {
                alert('No se pudo eliminar el producto.');
            }
        } catch (error) {
            console.error('Error al eliminar:', error);
        }
    }
}

function editarProducto(id) {
    console.log('Editar producto ID:', id);
    // Próxima implementación: Cargar datos en el formulario para modificar
}

// Funcionalidad para el botón Salir
const logoutBtn = document.querySelector('.logout');
if (logoutBtn) {
    logoutBtn.addEventListener('click', (e) => {
        e.preventDefault();
        if (confirm('¿Deseas cerrar sesión en el panel de administración?')) {
            // Cuando agreguen autenticación con tokens, se limpian aquí (localStorage.clear())
            window.location.href = '../frontend/index.html'; // Ajusta la ruta a tu tienda
        }
    });
}