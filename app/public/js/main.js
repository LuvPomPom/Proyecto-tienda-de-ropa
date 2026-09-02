let productosLista = [], carrito = JSON.parse(localStorage.getItem('cart_items')) || [];

document.addEventListener('DOMContentLoaded', () => {
    cargarProductosDesdeAPI();
    actualizarCarritoUI();
    initFiltros();
    initCartEvents();
});

// 1. CARGA Y NORMALIZACIÓN DE PRODUCTOS
async function cargarProductosDesdeAPI(busqueda = '') {
    try {
        const res = await fetch(`/api/productos${busqueda ? `?buscar=${encodeURIComponent(busqueda)}` : ''}`);
        if (!res.ok) throw new Error();
        const datos = await res.json();

        productosLista = datos.map(p => ({
            id: p.id_producto ?? p.id,
            nombre: p.nombre || 'Sin nombre',
            precio: parseFloat(p.precio) || 0,
            imagen: p.imagen ? (p.imagen.startsWith('http') || p.imagen.startsWith('/') ? p.imagen : `/${p.imagen}`) : 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=400',
            categoria: p.categoria_id ? p.categoria_id.toString() : 'todas',
            descripcion: p.nombre || ''
        }));

        renderProductos(productosLista);
    } catch (e) { console.error('Error al cargar:', e); }
}

// 2. RENDERIZADO DE TIENDA
function renderProductos(lista) {
    const container = document.getElementById('products-container');
    if (!container) return;

    if (!lista.length) {
        container.innerHTML = `<p style="grid-column: 1/-1; text-align: center; color: #64748b; padding: 40px 0;">No hay productos.</p>`;
        return;
    }

    container.innerHTML = lista.map(p => `
        <div class="product-card">
            <div class="product-img"><img src="${p.imagen}" alt="${p.nombre}" onclick="abrirModalDetalle(${p.id})"></div>
            <div class="product-info">
                <h4 onclick="abrirModalDetalle(${p.id})">${p.nombre}</h4>
                <div class="price-container"><span class="price">$${p.precio.toLocaleString('es-AR')}</span></div>
                <button class="btn-buy" onclick="agregarAlCarrito(${p.id})">Agregar al Carrito</button>
            </div>
        </div>
    `).join('');
}

// 4. MODALES
function abrirModalDetalle(id) {
    const prod = productosLista.find(p => p.id === id);
    const modal = document.getElementById('product-modal');
    const body = document.getElementById('modal-detail-body');
    if (!prod || !modal || !body) return;

    body.innerHTML = `
        <div style="display: flex; gap: 20px; flex-wrap: wrap;">
            <img src="${prod.imagen}" style="width: 150px; height: 150px; object-fit: cover; border-radius: 8px;">
            <div style="flex: 1;">
                <h2>${prod.nombre}</h2>
                <p style="color: #64748b; margin: 8px 0;">${prod.descripcion}</p>
                <p style="font-size: 20px; font-weight: bold;">$${prod.precio.toLocaleString('es-AR')}</p>
                <button class="btn-checkout" style="margin-top: 15px;" onclick="agregarAlCarrito(${prod.id}); cerrarModal('product-modal');">Agregar al Carrito</button>
            </div>
        </div>
    `;
    modal.style.display = 'flex';
}

const cerrarModal = id => { const m = document.getElementById(id); if (m) m.style.display = 'none'; };

