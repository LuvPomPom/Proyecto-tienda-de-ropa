let productosLista = [], carrito = JSON.parse(localStorage.getItem('cart_items')) || [];

document.addEventListener('DOMContentLoaded', () => {
    cargarProductosDesdeAPI();
    actualizarCarritoUI();
    initFiltros();
    initCartEvents();
});

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

