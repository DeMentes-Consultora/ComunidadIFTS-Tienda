# Plan de trabajo (Ask → Plan → Agent)

## Objetivo
Desarrollar y mantener la Tienda ComunidadIFTS con control, trazabilidad y continuidad entre equipos/PCs.

## Flujo recomendado
1. **Ask (aclarar requerimiento)**
   - Precisar la funcionalidad o cambio a implementar.
   - Confirmar alcance, archivos afectados y criterio de éxito.

2. **Plan (3-6 pasos concretos)**
   - Desglosar la tarea en pasos verificables.
   - Definir validaciones mínimas (pruebas, logs, revisión manual).

3. **Agent (implementación end-to-end)**
   - Aplicar cambios en código.
   - Ejecutar validaciones.
   - Entregar resumen final y próximos pasos.

## Criterio de salida
- Requisito implementado según alcance acordado.
- Cambios verificados (sin romper lo existente).
- Entrega con resumen breve y acciones siguientes.

## Notas para continuidad
- Mantener este archivo actualizado con cada nueva funcionalidad.
- Adjuntar historial de conversación para sincronización entre PCs.

---

## Reglas y recomendaciones para el equipo
- Mantener la estructura y lógica de ComunidadIFTS para facilitar soporte y migraciones.
- Documentar cada nueva funcionalidad o bugfix en el historial y el plan.
- Usar logs para toda acción administrativa relevante (crear, editar, eliminar, suspender, reactivar, etc).
- Validar siempre los roles y JWT antes de exponer datos sensibles.
- Probar endpoints con datos reales y casos límite.
- Actualizar el README y este plan con cada cambio mayor.
- Si se trabaja en equipo, asignar responsables y dejar constancia de cambios.
- Sincronizar archivos de historial y plan antes y después de cada sesión de trabajo.

## Ejemplo de ciclo de trabajo
1. Leer el historial y el plan antes de comenzar.
2. Definir el objetivo de la sesión (Ask).
3. Desglosar en pasos concretos (Plan).
4. Implementar y validar (Agent).
5. Documentar lo realizado y actualizar historial/plan.
6. Sincronizar archivos en la nueva PC o repositorio.
