<?php
// api/detalle_orden.php

require_once __DIR__ . '/../config/cors.php';
require_once __DIR__ . '/../config/database.php';

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../config/auth.php';
requireRole([1,2,3]);

use App\Models\DetalleOrden;

header('Content-Type: application/json');

try {
    $db = getPDO();
    $detalleOrdenModel = new DetalleOrden($db);

    switch ($_SERVER['REQUEST_METHOD']) {
        case 'GET':
            if (isset($_GET['id_orden'])) {
                $detalles = $detalleOrdenModel->getByOrden((int)$_GET['id_orden']);
                echo json_encode(['success' => true, 'data' => $detalles]);
            } else {
                http_response_code(400);
                echo json_encode(['success' => false, 'message' => 'Falta id_orden']);
            }
            break;
        // Aquí puedes agregar POST para agregar productos a la orden
        default:
            http_response_code(405);
            echo json_encode(['success' => false, 'message' => 'Método no permitido']);
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
