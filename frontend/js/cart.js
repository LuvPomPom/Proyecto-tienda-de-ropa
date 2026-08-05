// Manejo del carrito en el cliente
function obtenerCarrito() {
    return JSON.parse(localStorage.getItem('carrito')) || [];
}

function agregarAlCarrito(producto) {
    const carrito = obtenerCarrito();
    carrito.push(producto);
    localStorage.setItem('carrito', JSON.stringify(carrito));
    actualizarContadorCarrito();
}

function actualizarContadorCarrito() {
    const carrito = obtenerCarrito();
    const badge = document.querySelector('.fa-bag-shopping');
    if (badge) {
        badge.setAttribute('data-count', carrito.length);
    }
}