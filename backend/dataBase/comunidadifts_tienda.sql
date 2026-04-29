-- Base de datos: comunidadifts-tienda

CREATE DATABASE IF NOT EXISTS comunidadifts_tienda CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE comunidadifts_tienda;

-- Tabla proveedor
CREATE TABLE proveedor (
    id_proveedor INT AUTO_INCREMENT PRIMARY KEY,
    fotoPerfil TEXT NULL,
    fotoPerfil_url VARCHAR(512) NULL,
    fotoPerfil_public_id VARCHAR(255) NULL,
    nombreProveedor VARCHAR(255) NOT NULL,
    direccion VARCHAR(255) NULL,
    altura VARCHAR(20) NULL,
    localidad VARCHAR(100) NULL,
    barrio VARCHAR(100) NULL,
    telefono VARCHAR(50) NULL,
    email VARCHAR(100) NULL,
    habilitado TINYINT(1) NOT NULL DEFAULT 1,
    cancelado TINYINT(1) NOT NULL DEFAULT 0,
    idCreate TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    idUpdate TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Tabla producto
CREATE TABLE producto (
    id_producto INT AUTO_INCREMENT PRIMARY KEY,
    id_proveedor INT NOT NULL,
    fotoProducto TEXT NULL,
    fotoProducto_url VARCHAR(512) NULL,
    fotoProducto_public_id VARCHAR(255) NULL,
    nombreProducto VARCHAR(255) NOT NULL,
    descripcionProducto TEXT NULL,
    costo DECIMAL(10,2) NOT NULL,
    ganancia DECIMAL(5,2) NOT NULL,
    precioFinal DECIMAL(10,2) NOT NULL,
    habilitado TINYINT(1) NOT NULL DEFAULT 1,
    cancelado TINYINT(1) NOT NULL DEFAULT 0,
    idCreate TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    idUpdate TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (id_proveedor) REFERENCES proveedor(id_proveedor)
        ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB;

-- Tabla stock
CREATE TABLE stock (
    id_stock INT AUTO_INCREMENT PRIMARY KEY,
    id_producto INT NOT NULL,
    cantidad INT NOT NULL DEFAULT 0,
    habilitado TINYINT(1) NOT NULL DEFAULT 1,
    cancelado TINYINT(1) NOT NULL DEFAULT 0,
    idCreate TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    idUpdate TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (id_producto) REFERENCES producto(id_producto)
        ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB;

-- Tabla orden
CREATE TABLE orden (
    id_orden INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT NOT NULL,
    fecha DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    numeroDeOrden VARCHAR(20) NOT NULL UNIQUE,
    habilitado TINYINT(1) NOT NULL DEFAULT 1,
    cancelado TINYINT(1) NOT NULL DEFAULT 0,
    idCreate TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    idUpdate TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Tabla detalle_orden
CREATE TABLE detalle_orden (
    id_detalle_orden INT AUTO_INCREMENT PRIMARY KEY,
    id_orden INT NOT NULL,
    id_producto INT NOT NULL,
    cantidad INT NOT NULL,
    precio_final DECIMAL(10,2) NOT NULL,
    habilitado TINYINT(1) NOT NULL DEFAULT 1,
    cancelado TINYINT(1) NOT NULL DEFAULT 0,
    idCreate TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    idUpdate TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (id_orden) REFERENCES orden(id_orden)
        ON UPDATE CASCADE ON DELETE CASCADE,
    FOREIGN KEY (id_producto) REFERENCES producto(id_producto)
        ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB;

-- Tabla envio
CREATE TABLE envio (
    id_envio INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT NOT NULL,
    id_orden INT NOT NULL,
    direccion VARCHAR(255) NOT NULL,
    altura VARCHAR(20) NULL,
    cod_post VARCHAR(20) NULL,
    localidad VARCHAR(100) NULL,
    barrio VARCHAR(100) NULL,
    habilitado TINYINT(1) NOT NULL DEFAULT 1,
    cancelado TINYINT(1) NOT NULL DEFAULT 0,
    idCreate TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    idUpdate TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (id_orden) REFERENCES orden(id_orden)
        ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE=InnoDB;

-- NOTA: id_usuario es referencia lógica al usuario de ComunidadIFTS, no FK física.
