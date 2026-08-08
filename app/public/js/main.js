// Variable global para almacenar los productos cargados desde Supabase
let productosLista = [];
let carrito = JSON.parse(localStorage.getItem('cart_items')) || [];

document.addEventListener('DOMContentLoaded', () => {
    cargarProductosDesdeAPI();
    actualizarCarritoUI();
    initFiltros();
    initCartEvents();
});

// 1. CARGAR PRODUCTOS DESDE LA API DE LARAVEL / SUPABASE
async function cargarProductosDesdeAPI(busqueda = '') {
    try {
        const url = busqueda 
            ? `/api/productos?buscar=${encodeURIComponent(busqueda)}`
            : '/api/productos';

        const response = await fetch(url);
        if (!response.ok) throw new Error('Error al conectar con la API');

        const datos = await response.json();

        // Mapeo corregido: evalúa correctamente el id_producto aunque sea 0
        productosLista = datos.map(p => ({
            id: p.id_producto !== undefined && p.id_producto !== null ? p.id_producto : p.id,
            nombre: p.nombre || 'Sin nombre',
            precio: parseFloat(p.precio) || 0,
            imagen: (p.imagen && p.imagen !== 'NULL' && p.imagen.trim() !== '') 
                ? p.imagen 
                : 'https://images.unsplash.com/photo-1521572267360-ee0c2909d518?w=300', // Imagen por defecto
            categoria: 'todas',
            descripcion: p.nombre || '',
            talles: ['Único']
        }));

        renderProductos(productosLista);
    } catch (error) {
        console.error('Error cargando productos:', error);
    }
}

// RENDERIZAR TARJETAS EN EL HTML
function renderProductos(lista) {
    const container = document.getElementById('products-container');
    if (!container) return;
    
    container.innerHTML = '';

    if (lista.length === 0) {
        container.innerHTML = `<p style="grid-column: 1/-1; text-align: center; color: #64748b; padding: 40px 0; font-size: 1.1rem;">No se encontraron productos que coincidan con la búsqueda.</p>`;
        return;
    }

    lista.forEach(prod => {
        const card = document.createElement('div');
        card.className = 'product-card';
        card.innerHTML = `
            <img src="${prod.imagen}" alt="${prod.nombre}" onclick="abrirModalDetalle(${prod.id})">
            <div class="product-info">
                <h3 onclick="abrirModalDetalle(${prod.id})">${prod.nombre}</h3>
                <span class="product-price">$${prod.precio}</span>
                <button class="btn-add" onclick="agregarAlCarrito(${prod.id})">Agregar al Carrito</button>
            </div>
        `;
        container.appendChild(card);
    });
}

// INICIALIZAR FILTROS Y BÚSQUEDA
function initFiltros() {
    const searchInput = document.getElementById('search-input');
    const categorySelect = document.getElementById('category-filter');
    const priceRange = document.getElementById('price-range');
    const priceVal = document.getElementById('price-val');

    let timeoutBusqueda = null;

    // Búsqueda en la API con Debounce (300ms)
    if (searchInput) {
        searchInput.addEventListener('input', (e) => {
            clearTimeout(timeoutBusqueda);
            timeoutBusqueda = setTimeout(() => {
                const termino = e.target.value.trim();
                cargarProductosDesdeAPI(termino);
            }, 300);
        });
    }

    // Filtros de categoría y rango de precio
    function filtrarLocal() {
        const categoria = categorySelect ? categorySelect.value : 'todas';
        const precioMax = priceRange ? parseFloat(priceRange.value) : Infinity;

        if (priceVal && priceRange) {
            priceVal.textContent = precioMax;
        }

        const filtrados = productosLista.filter(p => {
            const coincideCat = categoria === 'todas' || p.categoria === categoria;
            const coincidePrecio = isNaN(precioMax) || p.precio <= precioMax;
            return coincideCat && coincidePrecio;
        });

        renderProductos(filtrados);
    }

    if (categorySelect) categorySelect.addEventListener('change', filtrarLocal);
    if (priceRange) priceRange.addEventListener('input', filtrarLocal);
}

// 2. MODAL DETALLE DE PRODUCTO
function abrirModalDetalle(id) {
    const prod = productosLista.find(p => p.id === id);
    if (!prod) return;

    const modal = document.getElementById('product-modal');
    const body = document.getElementById('modal-detail-body');

    if (!modal || !body) return;

    body.innerHTML = `
        <div style="display: flex; gap: 20px; flex-wrap: wrap;">
            <img src="${prod.imagen}" style="width: 150px; height: 150px; object-fit: cover; border-radius: 8px;">
            <div style="flex: 1;">
                <h2>${prod.nombre}</h2>
                <p style="color: #64748b; margin: 8px 0;">${prod.descripcion}</p>
                <p style="font-size: 20px; font-weight: bold; color: #0284c7;">$${prod.precio}</p>
                <div style="margin: 15px 0;">
                    <label><strong>Talle:</strong></label>
                    <select id="modal-talle" style="margin-left: 10px; padding: 5px;">
                        ${prod.talles.map(t => `<option value="${t}">${t}</option>`).join('')}
                    </select>
                </div>
                <button class="btn-checkout" onclick="agregarAlCarrito(${prod.id}); cerrarModal('product-modal');">Agregar al Carrito</button>
            </div>
        </div>
    `;
    modal.style.display = 'flex';
}

function cerrarModal(id) {
    const modal = document.getElementById(id);
    if (modal) modal.style.display = 'none';
}

// 3. LÓGICA DEL CARRITO & LOCALSTORAGE
function agregarAlCarrito(id) {
    const prod = productosLista.find(p => p.id === id);
    if (!prod) return;

    const existe = carrito.find(item => item.id === id);

    if (existe) {
        existe.cantidad++;
    } else {
        carrito.push({ ...prod, cantidad: 1 });
    }

    guardarYActualizarCarrito();
}

function cambiarCantidad(id, cambio) {
    const item = carrito.find(i => i.id === id);
    if (!item) return;

    item.cantidad += cambio;
    if (item.cantidad <= 0) {
        carrito = carrito.filter(i => i.id !== id);
    }
    guardarYActualizarCarrito();
}

function guardarYActualizarCarrito() {
    localStorage.setItem('cart_items', JSON.stringify(carrito));
    actualizarCarritoUI();
}

function actualizarCarritoUI() {
    const container = document.getElementById('cart-items-container');
    const cartCount = document.getElementById('cart-count');
    const cartTotal = document.getElementById('cart-total');

    if (!container) return;

    container.innerHTML = '';
    let total = 0;
    let totalItems = 0;

    carrito.forEach(item => {
        total += item.precio * item.cantidad;
        totalItems += item.cantidad;

        const div = document.createElement('div');
        div.className = 'cart-item';
        div.innerHTML = `
            <img src="${item.imagen}">
            <div style="flex:1;">
                <strong>${item.nombre}</strong>
                <div>$${item.precio}</div>
                <div class="cart-controls">
                    <button onclick="cambiarCantidad(${item.id}, -1)">-</button>
                    <span>${item.cantidad}</span>
                    <button onclick="cambiarCantidad(${item.id}, 1)">+</button>
                </div>
            </div>
        `;
        container.appendChild(div);
    });

    if (cartCount) cartCount.textContent = totalItems;
    if (cartTotal) cartTotal.textContent = `$${total}`;
}

// 4. EVENTOS DE EVENT LISTENERS Y CHECKOUT
function initCartEvents() {
    const drawer = document.getElementById('cart-drawer');
    const openCartBtn = document.getElementById('open-cart');
    const closeCartBtn = document.getElementById('close-cart');
    const closeProductModalBtn = document.getElementById('close-product-modal');
    const closeCheckoutBtn = document.getElementById('close-checkout');
    const checkoutBtn = document.getElementById('checkout-btn');
    const checkoutForm = document.getElementById('checkout-form');

    if (openCartBtn && drawer) {
        openCartBtn.addEventListener('click', () => drawer.classList.add('open'));
    }
    if (closeCartBtn && drawer) {
        closeCartBtn.addEventListener('click', () => drawer.classList.remove('open'));
    }
    if (closeProductModalBtn) {
        closeProductModalBtn.addEventListener('click', () => cerrarModal('product-modal'));
    }
    if (closeCheckoutBtn) {
        closeCheckoutBtn.addEventListener('click', () => cerrarModal('checkout-modal'));
    }

    if (checkoutBtn) {
        checkoutBtn.addEventListener('click', () => {
            if (carrito.length === 0) return alert('El carrito está vacío.');
            if (drawer) drawer.classList.remove('open');
            const checkoutModal = document.getElementById('checkout-modal');
            if (checkoutModal) checkoutModal.style.display = 'flex';
        });
    }

    if (checkoutForm) {
        checkoutForm.addEventListener('submit', (e) => {
            e.preventDefault();
            alert('¡Pago procesado con éxito! Gracias por tu compra.');
            carrito = [];
            guardarYActualizarCarrito();
            cerrarModal('checkout-modal');
        });
    }
}