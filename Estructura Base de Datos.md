ESTRUCTURA PARA BASE DE DATOS

Nombre de base de datos: comunidadifts-tienda
Tablas:
nombre de tabla: producto
campos: id_producto (PK)
        id_proveedor (FK a proveedor)
        fotoProducto
        nombreProducto
        descripcionProducto
        costo
        ganancia(en porcentaje)
        precioFinal (seria el resultado del costo + el porcntaje de ganancia agregado)

nombre de la tabla: proveedor
campos: id_proveedor (PK)
        fotoPerfil
        nombreProveedor
        direccion
        altura
        localidad
        barrio
        telefono
        email

nombre de la tabla: stock
campos: id_stock (PK)
        id_producto (FK a producto)
        cantidad

nombre de la tabla: orden
campos: id_orden (PK)
        id_usuario (FK a usuario)
        fecha/hora ()
        numeroDeOrden(deberia crear un numero de orden automatico o que sea autoincremenmtal pero con varios ceros por delante por ejemplo: 0000-00001...)

nombre de la tabla: envio
campos: id_envio (PK)
        id_usuario (FK a usuario)
        id_orden (FK a orden)
        direccion
        altura
        cod_post
        localidad
        barrio

nombre de la tabla: detalle_orden
campos: id_detalle_orden (PK)
        id_orden (FK a orden)
        id_producto (FK a producto)
        cantidad
        precio_final (el precio del producto al momento de la compra)

aclaracion: en todas las tablas agrega habilitado=1 (por defacto)
                                       cancelado=0 (por defecto)
                                       idCreate
                                       idUpdate
 

