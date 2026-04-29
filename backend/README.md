# Backend Tienda ComunidadIFTS

Estructura basada en el backend de ComunidadIFTS.

## Carpetas principales
- api/: Endpoints de la API REST
- config/: Configuración y utilidades
- models/: Modelos y consultas SQL
- services/: Servicios externos (Cloudinary, MercadoPago, etc.)
- vendor/: Dependencias Composer
- logs/: Archivos de log

## Variables de entorno
Ver `.env.example` para configuración inicial.

## Endpoints

### Autenticación
Todos los endpoints requieren JWT en el header:

    Authorization: Bearer <token>

### Roles
- 1: Admin (acceso total)
- 2, 3: Ventas (solo endpoints de venta)

### /api/producto.php
- GET: Listar productos o ver detalle (?id=ID)
- POST: Crear producto *(solo admin)*
- PUT: Editar producto *(solo admin)*
- PATCH: Suspender/reactivar *(solo admin)*
- Filtros: nombre, id_proveedor, precio_min, precio_max, solo_habilitados

### /api/proveedor.php
- GET: Listar proveedores o ver detalle (?id=ID)
- POST: Crear proveedor *(solo admin)*
- PUT: Editar proveedor *(solo admin)*

### /api/stock.php
- GET: Ver stock de producto (?id_producto=ID)
- PUT: Actualizar cantidad *(solo admin)*

### /api/orden.php
- GET: Listar órdenes o ver detalle (?id=ID)

### /api/envio.php
- GET: Ver envío de una orden (?id_orden=ID)

### /api/detalle_orden.php
- GET: Ver detalles de una orden (?id_orden=ID)

---

## Logs
Las acciones administrativas (crear/editar producto) quedan registradas en logs/admin.log.

---

## Ejemplo de uso

    curl -H "Authorization: Bearer <token>" http://localhost/ComunidadIFTS-Tienda/backend/api/producto.php

---

## Errores comunes
- 401: Token no enviado o inválido
- 403: Acceso denegado por rol
- 400: Datos inválidos
- 500: Error interno
