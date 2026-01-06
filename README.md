# 📝 Products API

API RESTful desarrollada en **Laravel 12** con arquitectura hexagonal, autenticación con **Sanctum** y documentación **Swagger**.

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

# Instalar L5-Swagger
composer require "darkaonline/l5-swagger"

# Publicar configuración de L5-Swagger
php artisan vendor:publish --provider "L5Swagger\L5SwaggerServiceProvider"

# Limpiar caché
php artisan config:clear
php artisan cache:clear

# Generar documentación Swagger
php artisan l5-swagger:generate

```
