// --- MANEJO DEL CARRITO EN EL CLIENTE ---

// 1. Función para LEER el carrito guardado en el navegador
function obtenerCarrito() {
    // Buscamos en 'localStorage' el dato bajo la clave 'carrito'.
    // Como localStorage guarda TODO como texto, usamos JSON.parse() para convertir ese texto de vuelta a una lista/array de JavaScript.
    // El operador '|| []' significa: "si no hay nada guardado aún (da null), devuelve una lista vacía []".
    return JSON.parse(localStorage.getItem('carrito')) || [];
}

// 2. Función para AGREGAR un nuevo producto al carrito
function agregarAlCarrito(producto) {
    // Primero obtenemos la lista de productos que ya estaban guardados
    const carrito = obtenerCarrito();
    
    // Metemos el nuevo producto al final de la lista
    carrito.push(producto);
    
    // Guardamos la lista actualizada en localStorage.
    // Usamos JSON.stringify() porque localStorage SOLO acepta texto plano, así que convertimos la lista a formato de texto JSON.
    localStorage.setItem('carrito', JSON.stringify(carrito));
    
    // Llamamos a la función que actualiza el numerito del ícono en la pantalla
    actualizarContadorCarrito();
}

// 3. Función para ACTUALIZAR el número que se ve sobre el ícono del carrito
function actualizarContadorCarrito() {
    // Leemos cuántos productos hay en la lista actualmente
    const carrito = obtenerCarrito();
    
    // Buscamos en el HTML el ícono de la bolsa de compras usando su clase de FontAwesome (.fa-bag-shopping)
    const badge = document.querySelector('.fa-bag-shopping');
    
    // Si el ícono existe en la página actual...
    if (badge) {
        // Le cambiamos el atributo 'data-count' con la cantidad total de productos (carrito.length),
        // esto es lo que usa tu CSS para mostrar el globito con el número.
        badge.setAttribute('data-count', carrito.length);
    }
}