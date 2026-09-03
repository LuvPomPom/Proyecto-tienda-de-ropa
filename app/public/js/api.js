const API_URL = 'http://localhost:8000/api';

async function getProductos() {

    try {
       
        const response = await fetch(`${API_URL}/productos`);
        
        if (!response.ok) throw new Error('Error al conectar con el backend');
        
        return await response.json();
        
    } catch (error) {
        console.error('API Error:', error);
        
        return [];
    }
}