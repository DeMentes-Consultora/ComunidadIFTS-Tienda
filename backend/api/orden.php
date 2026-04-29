<?php
// api/orden.php

require_once __DIR__ . '/../config/cors.php';
require_once __DIR__ . '/../config/database.php';

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../config/auth.php';
requireRole([1,2,3]);

use App\Models\Orden;

header('Content-Type: application/json');

try {
    $db = getPDO();
    $ordenModel = new Orden($db);

    switch ($_SERVER['REQUEST_METHOD']) {
        case 'GET':
            if (isset($_GET['id'])) {
                $orden = $ordenModel->getById((int)$_GET['id']);
                echo json_encode(['success' => true, 'data' => $orden]);
            } else {
                $ordenes = $ordenModel->getAll();
                echo json_encode(['success' => true, 'data' => $ordenes]);
            }
            break;
        // Aquí puedes agregar POST para crear orden y otros métodos
        default:
            http_response_code(405);
            echo json_encode(['success' => false, 'message' => 'Método no permitido']);
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
