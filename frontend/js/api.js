// Definimos una constante con la dirección base de nuestro servidor Backend en Laravel
const API_URL = 'http://localhost:8000/api';

// Declaramos una función "asíncrona" (async) porque conectarse a un servidor toma un tiempo y no queremos congelar la página mientras esperamos
async function getProductos() {
    
    // Abrimos un bloque 'try' (intentar): aquí va el código que intentaremos ejecutar
    try {
        
        // Hacemos una petición HTTP a la API usando 'fetch'. 'await' hace que el código espere la respuesta del servidor antes de avanzar a la siguiente línea
        const response = await fetch(`${API_URL}/productos`);
        
        // Comprobamos si el servidor nos respondió con un estado de error (por ejemplo, error 404 o 500)
        if (!response.ok) throw new Error('Error al conectar con el backend');
        
        // Convertimos la respuesta del servidor (que viene en texto plano) a formato JSON/Objeto de JavaScript y la devolvemos
        return await response.json();
        
    // Si algo falla dentro del 'try' (ejemplo: el servidor está apagado o no hay internet), el código salta inmediatamente al bloque 'catch'
    } catch (error) {
        
        // Imprimimos el detalle del error en la consola del navegador (F12) para saber qué falló
        console.error('API Error:', error);
        
        // Devolvemos una lista vacía [] para que la página web no se rompa y pueda seguir funcionando aunque no haya productos
        return [];
    }
}