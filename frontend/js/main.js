// DATOS MOCK DE PRODUCTOS DE PRUEBA
const productosMock = [
    { id: 1, nombre: 'Remera Algodón Básica', precio: 890, categoria: 'ropa', imagen: 'https://images.unsplash.com/photo-1521572267360-ee0c2909d518?w=300', descripcion: 'Remera 100% algodón, suave y fresca.', talles: ['S', 'M', 'L', 'XL'] },
    { id: 2, nombre: 'Zapatillas Urbanas', precio: 3490, categoria: 'calzado', imagen: 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=300', descripcion: 'Zapatillas cómodas para uso diario.', talles: ['38', '39', '40', '41', '42'] },
    { id: 3, nombre: 'Campera de Jean', precio: 2990, categoria: 'ropa', imagen: 'https://images.unsplash.com/photo-1576995853123-5a10305d93c0?w=300', descripcion: 'Campera de jean clásica con corte moderno.', talles: ['M', 'L'] },
    { id: 4, nombre: 'Lentes de Sol', precio: 1200, categoria: 'accesorios', imagen: 'https://images.unsplash.com/photo-1511499767150-a48a237f0083?w=300', descripcion: 'Protección UV400 con marco resistente.', talles: ['Único'] }
];

let carrito = JSON.parse(localStorage.getItem('cart_items')) || [];

document.addEventListener('DOMContentLoaded', () => {
    renderProductos(productosMock);
    actualizarCarritoUI();
    initFiltros();
    initCartEvents();
});

// 1. RENDERIZAR PRODUCTOS Y FILTROS EN TIEMPO REAL
function renderProductos(lista) {
    const container = document.getElementById('products-container');
    container.innerHTML = '';

    if (lista.length === 0) {
        container.innerHTML = `<p style="grid-column: 1/-1; text-align: center; color: #64748b;">No se encontraron productos.</p>`;
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

function initFiltros() {
    const searchInput = document.getElementById('search-input');
    const categorySelect = document.getElementById('category-filter');
    const priceRange = document.getElementById('price-range');
    const priceVal = document.getElementById('price-val');

    function filtrar() {
        const texto = searchInput.value.toLowerCase();
        const categoria = categorySelect.value;
        const precioMax = parseFloat(priceRange.value);

        priceVal.textContent = precioMax;

        const filtrados = productosMock.filter(p => {
            const coincideNombre = p.nombre.toLowerCase().includes(texto);
            const coincideCat = categoria === 'todas' || p.categoria === categoria;
            const coincidePrecio = p.precio <= precioMax;
            return coincideNombre && coincideCat && coincidePrecio;
        });

        renderProductos(filtrados);
    }

    searchInput.addEventListener('input', filtrar);
    categorySelect.addEventListener('change', filtrar);
    priceRange.addEventListener('input', filtrar);
}

// 2. MODAL DETALLE DE PRODUCTO
function abrirModalDetalle(id) {
    const prod = productosMock.find(p => p.id === id);
    if (!prod) return;

    const modal = document.getElementById('product-modal');
    const body = document.getElementById('modal-detail-body');

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
    document.getElementById(id).style.display = 'none';
}

// 3. LÓGICA DEL CARRITO & LOCALSTORAGE
function agregarAlCarrito(id) {
    const prod = productosMock.find(p => p.id === id);
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

    cartCount.textContent = totalItems;
    cartTotal.textContent = `$${total}`;
}

// 4. EVENTOS DE EVENT LISTENERS Y CHECKOUT
function initCartEvents() {
    const drawer = document.getElementById('cart-drawer');
    document.getElementById('open-cart').addEventListener('click', () => drawer.classList.add('open'));
    document.getElementById('close-cart').addEventListener('click', () => drawer.classList.remove('open'));
    document.getElementById('close-product-modal').addEventListener('click', () => cerrarModal('product-modal'));
    document.getElementById('close-checkout').addEventListener('click', () => cerrarModal('checkout-modal'));

    document.getElementById('checkout-btn').addEventListener('click', () => {
        if (carrito.length === 0) return alert('El carrito está vacío.');
        drawer.classList.remove('open');
        document.getElementById('checkout-modal').style.display = 'flex';
    });

    document.getElementById('checkout-form').addEventListener('submit', (e) => {
        e.preventDefault();
        alert('¡Pago procesado con éxito! Gracias por tu compra.');
        carrito = [];
        guardarYActualizarCarrito();
        cerrarModal('checkout-modal');
    });
}