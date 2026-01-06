# 📝 Products API

API RESTful desarrollada en **Laravel 12** con arquitectura hexagonal, autenticación con **Sanctum** y documentación.

Permite gestionar: **productos**, **divisas** y **precios de productos en distintas monedas**.

---

## 🛠 Requisitos

-   PHP ≥ 8.3
-   Composer
-   MySQL o cualquier base de datos soportada por Laravel
-   Node.js y npm (opcional para assets)

---

## 1️⃣ Instalación

```bash
# Clonar el repositorio
git clone <url-del-repo>
cd products-api

# Instalar dependencias PHP
composer install

# Copiar archivo de entorno
cp .env.example .env

# Generar key de aplicación
php artisan key:generate

# Configurar base de datos en .env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=products
DB_USERNAME=root
DB_PASSWORD=secret

# Ejecutar migraciones
php artisan migrate

# Limpiar caché
php artisan config:clear
php artisan cache:clear
```

## 2️⃣ Autenticación

```bash
La API utiliza Laravel Sanctum para autenticación basada en tokens.

2.1 Login

Ruta: POST /api/v1/login

Headers:

Accept: application/json
Content-Type: application/json


Request Body:

{
    "email": "user@example.com",
    "password": "password"
}


Response:

{
    "token": "eyJ0eXAiOiJKV1QiLCJh..."
}


Uso del token para llamadas autenticadas:

Authorization: Bearer <token>
Accept: application/json
Content-Type: application/json
```

## 3️⃣ Endpoints de la API

```bash
3.1 Productos
Método	Ruta	Descripción
GET	/api/v1/products	Listar todos los productos
POST	/api/v1/products	Crear un nuevo producto
GET	/api/v1/products/{id}	Obtener un producto por ID
PUT	/api/v1/products/{id}	Actualizar un producto
DELETE	/api/v1/products/{id}	Eliminar un producto

Ejemplo POST /api/v1/products:

{
    "name": "Producto 1",
    "description": "Descripción del producto",
    "price": 100.50,
    "currency_id": 1,
    "tax_cost": 10.5,
    "manufacturing_cost": 50.0
}


Ejemplo PUT /api/v1/products/{id}:

{
    "name": "Producto Actualizado",
    "description": "Nueva descripción",
    "price": 110.00,
    "currency_id": 1,
    "tax_cost": 11.0,
    "manufacturing_cost": 55.0
}

3.2 Divisas (Currencies)
Método	Ruta	Descripción
GET	/api/v1/currencies	Listar todas las divisas
POST	/api/v1/currencies	Crear una nueva divisa
GET	/api/v1/currencies/{id}	Obtener una divisa por ID
PUT	/api/v1/currencies/{id}	Actualizar una divisa
DELETE	/api/v1/currencies/{id}	Eliminar una divisa

Ejemplo POST /api/v1/currencies:

{
    "name": "Dólar",
    "symbol": "$",
    "exchange_rate": 1.0
}


Ejemplo PUT /api/v1/currencies/{id}:

{
    "name": "Euro",
    "symbol": "€",
    "exchange_rate": 0.9
}

3.3 Precios de Productos (Product Prices)
Método	Ruta	Descripción
GET	/api/v1/products/{id}/prices	Listar precios del producto
POST	/api/v1/products/{id}/prices	Crear un precio para el producto
DELETE	/api/v1/products/{id}/prices/{price}	Eliminar un precio del producto

Ejemplo POST /api/v1/products/{id}/prices:

{
    "currency_id": 2,
    "price": 120.0
}


Ejemplo DELETE /api/v1/products/{id}/prices/{price}:
No se necesita body, solo el ID en la ruta.

```

## 4️⃣ Notas

Todos los endpoints requieren autenticación con token Bearer después de login.

Los headers Accept y Content-Type deben ser application/json en todas las peticiones.

Las respuestas y errores se devuelven en formato JSON.

La arquitectura hexagonal separa Controladores, Casos de Uso y Repositorios para facilitar mantenimiento y pruebas.

## 5️⃣ Ejecución del proyecto

Iniciar servidor Laravel:

php artisan serve

La API estará disponible en: http://127.0.0.1:8000

## 5️⃣ Pruebas

```bash
    php artisan test
```
