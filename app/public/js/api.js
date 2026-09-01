const API_URL = 'http://localhost:8000/api';

// Declaramos una función "asíncrona" (async) porque conectarse a un servidor toma un tiempo y no queremos congelar la página mientras esperamos
async function getProductos() {

    try {
        // Hacemos una petición HTTP a la API usando 'fetch'. 'await' hace que el código espere la respuesta del servidor antes de avanzar a la siguiente línea
        const response = await fetch(`${API_URL}/productos`);
        
        if (!response.ok) throw new Error('Error al conectar con el backend');
        
        // Convertimos la respuesta del servidor (que viene en texto plano) a formato JSON/Objeto de JavaScript y la devolvemos
        return await response.json();
        
    } catch (error) {
        console.error('API Error:', error);
        
        // devolver lista vacia
        return [];
    }
}