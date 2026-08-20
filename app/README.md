# 🛍️ AI VOGA STORE — E-Commerce Web Application

![Laravel](https://img.shields.io/badge/Laravel-13.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-8.4-777BB4?style=for-the-badge&logo=php&logoColor=white)
![PostgreSQL](https://img.shields.io/badge/PostgreSQL-Supabase-4169E1?style=for-the-badge&logo=postgresql&logoColor=white)
![Bootstrap](https://img.shields.io/badge/Bootstrap-5.3-7952B3?style=for-the-badge&logo=bootstrap&logoColor=white)
![JavaScript](https://img.shields.io/badge/JavaScript-ES6+-F7DF1E?style=for-the-badge&logo=javascript&logoColor=black)

**AI VOGA STORE** es una plataforma e-commerce moderna desarrollada con **Laravel 13**, **PHP 8.4** y una base de datos **PostgreSQL alojada en Supabase**. El sistema cuenta con un catálogo dinámico filtrable por categorías, filtrado de productos por rango de precio y búsqueda en tiempo real, junto con un panel de administración interactivo para la gestión centralizada de inventario y cargas multimedia.

---

## 🛠️ Tecnologías Utilizadas

### Backend
* **PHP**: 8.4.24
* **Framework**: Laravel 13.23.0
* **Base de Datos**: PostgreSQL / Cloud-hosted en Supabase (`pgsql` driver)
* **ORM**: Eloquent ORM

### Frontend
* **Plantillado**: Blade Templates
* **Estilos**: CSS Custom & Bootstrap 5
* **Interactividad**: JavaScript ES6+ (Fetch API, manipulación asíncrona del DOM)
* **Tipografías e Iconos**: Google Fonts / SVG Icons

---

## 🚀 Características Principales

### 🏪 Tienda (Frontoffice)
* **Navegación Dinámica por Categorías**: Filtrado directo desde la URL (`/categoria/{nombre}`) mediante traducción limpia a IDs numéricos de base de datos (`Hombre`, `Mujer`, `Unisex`, `Calzado`, `Ropa`, `Accesorios`).
* **Buscador en Tiempo Real / API Filter**: Búsqueda insensible a mayúsculas/minúsculas mediante la función `LOWER()` de PostgreSQL.
* **Banner 'SALE' Condicional**: Ajuste dinámico en la vista Blade (`@if`) para ocultar el hero banner en secciones específicas.
* **Gestión de Placeholders de Imágenes**: Fallback automático (`?? 'imgs/placeholder.png'`) cuando un producto no cuenta con imagen asociada.

### 🛡️ Panel de Administración (Backoffice)
* **Gestión de Inventario**: Interfaz para dar de alta nuevos productos asociando nombre, precio, marca, categoría, stock e imagen.
* **Procesamiento de Archivos Multimedia**: Asignación automática de nombres basados en la clave primaria (`id_producto.ext`) y almacenamiento estructurado en `public/imgs/productos/`.
* **Carga Asíncrona (AJAX / Fetch API)**: Consumo en segundo plano de la API `/api/productos` para renderizado dinámico del inventario.