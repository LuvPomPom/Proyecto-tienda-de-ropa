let productosLista = [], carrito = JSON.parse(localStorage.getItem('cart_items')) || [];

document.addEventListener('DOMContentLoaded', () => {  //event listener security
    cargarProductosDesdeAPI();
});

async function cargarProductosDesdeAPI() {    //no screen freeze
    try {
        if (!res.ok) throw new Error();
        const datos = await res.json();    // JSON-JS

        productosLista = datos.map(p => ({     //itera..
            id: p.id_producto ?? p.id,
            nombre: p.nombre || 'Sin nombre',
            precio: parseFloat(p.precio) || 0, //text to float
            imagen: p.imagen ? (p.imagen.startsWith('http') || p.imagen.startsWith('/') ? p.imagen : `/${p.imagen}`) : 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=400', //img route
            categoria: p.categoria_id ? p.categoria_id.toString() : 'todas',    //id to text
        }));

        renderProductos(productosLista);
    } catch (e) { console.error('Error al cargar:', e); }
}

