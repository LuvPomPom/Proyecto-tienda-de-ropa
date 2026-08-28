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

// 3. FILTROS Y BÚSQUEDA
function initFiltros() {
    const searchInput = document.getElementById('search-input');
    const categorySelect = document.getElementById('category-filter');
    const priceRange = document.getElementById('price-range');
    let timer;

    searchInput?.addEventListener('input', e => {
        clearTimeout(timer);
        timer = setTimeout(() => cargarProductosDesdeAPI(e.target.value.trim()), 300);
    });

    const filtrar = () => {
        const cat = categorySelect?.value || 'todas';
        const maxPrice = priceRange ? parseFloat(priceRange.value) : Infinity;
        const priceVal = document.getElementById('price-val');
        if (priceVal && priceRange) priceVal.textContent = maxPrice;

        renderProductos(productosLista.filter(p => (cat === 'todas' || p.categoria === cat) && (isNaN(maxPrice) || p.precio <= maxPrice)));
    };

    categorySelect?.addEventListener('change', filtrar);
    priceRange?.addEventListener('input', filtrar);
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

// 5. GESTIÓN DEL CARRITO
function agregarAlCarrito(id) {
    const prod = productosLista.find(p => p.id === id);
    if (!prod) return;
    const item = carrito.find(i => i.id === id);
    item ? item.cantidad++ : carrito.push({ ...prod, cantidad: 1 });
    guardarYActualizarCarrito();
}

function cambiarCantidad(id, cambio) {
    const item = carrito.find(i => i.id === id);
    if (!item) return;
    item.cantidad += cambio;
    if (item.cantidad <= 0) carrito = carrito.filter(i => i.id !== id);
    guardarYActualizarCarrito();
}

function guardarYActualizarCarrito() {
    localStorage.setItem('cart_items', JSON.stringify(carrito));
    actualizarCarritoUI();
}

function actualizarCarritoUI() {
    const container = document.getElementById('cart-items-container') || document.getElementById('carrito-contenedor');
    const cartCount = document.getElementById('cart-count');
    const cartTotal = document.getElementById('cart-total') || document.getElementById('carrito-total');
    const badge = document.querySelector('.cart-badge');

    if (!container) return;

    let total = 0, totalItems = 0;

    if (!carrito.length) {
        container.innerHTML = `<p style="text-align: center; color: #666; padding: 20px;">Tu carrito está vacío.</p>`;
    } else {
        container.innerHTML = carrito.map(item => {
            total += item.precio * item.cantidad;
            totalItems += item.cantidad;
            return `
                <div class="cart-item">
                    <img src="${item.imagen}">
                    <div style="flex:1;">
                        <strong>${item.nombre}</strong>
                        <div>$${item.precio.toLocaleString('es-AR')}</div>
                        <div class="cart-controls">
                            <button onclick="cambiarCantidad(${item.id}, -1)">-</button>
                            <span>${item.cantidad}</span>
                            <button onclick="cambiarCantidad(${item.id}, 1)">+</button>
                        </div>
                    </div>
                </div>
            `;
        }).join('');
    }

    if (cartCount) cartCount.textContent = totalItems;
    if (badge) badge.textContent = totalItems;
    if (cartTotal) cartTotal.textContent = `$${total.toLocaleString('es-AR')}`;
}

function initCartEvents() {
    const drawer = document.getElementById('cart-drawer');
    document.getElementById('open-cart')?.addEventListener('click', () => drawer?.classList.add('open'));
    document.getElementById('close-cart')?.addEventListener('click', () => drawer?.classList.remove('open'));
}