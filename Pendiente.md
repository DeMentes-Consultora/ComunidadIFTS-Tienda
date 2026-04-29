Tienda ComunidadIFTS

Bueno mi idea es la siguiente:

quiero que el proyecto de tiendaComunidadIFTS sea a parte con base de datos independiente .La comunicacion con la tienda debe ser por intermedio de JWT.


que voy a vender?
1.- productos relacionasdos a los institutos que conforman la comunidad,llaveros ,gorro,estampas para mochila,mates, remeras,ect.
quien compuede comprar?
2.- los alumnos registrados de cualquier institucion.
como pagan?
3.- por mercado pago o transferencia.
manejamos envios?
4.- si
que estock manejamos?
5.- stock real.
como lo manejamos?
6.- Por intermedio de una tabla sencilla que muestre los siguientes campos: N°-foto-nombre producto-precio final-costo-ganancia(donde colocamos el porcentaje que le vamos a agregar al costo para crear el precio final)-unidades (cantidades en stock)-detalle(al hacer click en este boton se abre un modal con los datos del proveedor de este producto) y que tengo arriva una barra de busqueda con filtros.
como manejamos el loguin?
7.- Que este conectado el loguin con comunidadIFTS para que los usuarios no tengan que volver a conectarse.
8.- hagamoslo bien.


Quiero que sea con angular y php ,siguiendo la estructura de carpetas y la logica del proyecto como por ejemplo, con componentes reutilizables(en una carpeta componentes),con una carpeta model(donde estaran todoas la consultas sql),una carpeta services(donde estara por ejemplo la coneccion con cloudinary) y lo mismo con el frontend.Con clases,getters y setters  y que te parece si implementamos en el frontend signals?.

API (controladores)
mira yo tengo pensado esto: quiero que la vista o endpoint donde esta la tabla que me muestra lo que te detalle antes sea casi la estructura principal de todo el admin.O sea, sobre la tabla esten varios botones para realizar acciones de ABM, porveedores,productos, otro que te lleve al endpoint de stock,que despues veremos que funciones puede hacer.