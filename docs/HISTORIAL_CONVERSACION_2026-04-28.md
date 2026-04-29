# HISTORIAL DE CONVERSACIÓN - ComunidadIFTS Tienda

Este archivo almacena el resumen de la conversación y decisiones clave del proyecto para facilitar la continuidad en diferentes PCs o equipos.

---

## Última actualización: 28/04/2026

### Resumen de la sesión
- Proyecto creado siguiendo estructura y lógica de ComunidadIFTS.
- Backend en PHP POO, endpoints REST, JWT y roles.
- Base de datos independiente, comunicación por JWT.
- ABM de productos, proveedores, stock, órdenes, envíos.
- Filtros avanzados y lógica de suspensión/reactivación de productos.
- Control de acceso por rol (admin, ventas).
- Logs de acciones administrativas implementados.
- Documentación de endpoints y ejemplos de uso en README.

### Decisiones clave
- No duplicar datos de usuario, solo referenciar id_usuario.
- Suspensión lógica de productos (no borrado físico).
- Centralizar validación de roles en config/auth.php.
- Registrar logs de acciones críticas en backend/logs/admin.log.

### Próximos pasos sugeridos
- Agregar logs a más endpoints críticos.
- Iniciar frontend Angular.
- Sincronizar este historial y plan en cada nueva PC antes de continuar.

---

## Cómo usar este historial
1. Copia este archivo y el plan de trabajo a la nueva PC.
2. Lee el resumen y revisa los últimos cambios antes de continuar.
3. Continúa el desarrollo siguiendo el plan y actualiza ambos archivos al finalizar cada sesión.

---

## Consideraciones técnicas y buenas prácticas
- Usar Composer para dependencias PHP.
- Mantener la estructura de carpetas y namespaces igual a ComunidadIFTS para facilitar mantenimiento y migraciones.
- Documentar endpoints y cambios relevantes en el README y en este historial.
- Realizar commits frecuentes y descriptivos.
- Proteger archivos sensibles (.env, claves) y no subirlos a repositorios públicos.
- Sincronizar siempre este historial y el plan antes de continuar en otra PC.
- Probar endpoints con herramientas como Postman o curl.
- Mantener logs limpios y rotar si crecen demasiado.
- Actualizar este historial con cada decisión importante, bug crítico o cambio de alcance.

## Checklist de migración/sincronización
- [ ] Copiar `plan-agentAskPlan.prompt.md` y `HISTORIAL_CONVERSACION_YYYY-MM-DD.md` a la nueva PC.
- [ ] Copiar `.env` y revisar variables de entorno.
- [ ] Instalar dependencias con `composer install`.
- [ ] Verificar permisos de carpetas (logs, vendor, etc).
- [ ] Probar conexión a la base de datos.
- [ ] Validar endpoints críticos (login, productos, stock, ventas).
- [ ] Revisar logs de acciones administrativas.
- [ ] Leer este historial antes de continuar.

---

## Contacto y soporte
- Documentar dudas o bloqueos en este archivo para continuidad.
- Si se detecta un bug o cambio de alcance, dejar constancia aquí antes de modificar código.
