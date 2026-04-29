<?php
// api/stock.php

require_once __DIR__ . '/../config/cors.php';
require_once __DIR__ . '/../config/database.php';

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../config/auth.php';
requireRole([1]);

use App\Models\Stock;

header('Content-Type: application/json');

try {
    $db = getPDO();
    $stockModel = new Stock($db);

    switch ($_SERVER['REQUEST_METHOD']) {
        case 'GET':
            if (isset($_GET['id_producto'])) {
                $stock = $stockModel->getByProducto((int)$_GET['id_producto']);
                echo json_encode(['success' => true, 'data' => $stock]);
            } else {
                http_response_code(400);
                echo json_encode(['success' => false, 'message' => 'Falta id_producto']);
            }
            break;
        case 'PUT':
            $data = json_decode(file_get_contents('php://input'), true);
            if (!$data || !isset($data['id_producto']) || !isset($data['cantidad'])) {
                http_response_code(400);
                echo json_encode(['success' => false, 'message' => 'Datos inválidos o faltan campos']);
                break;
            }
            $ok = $stockModel->updateCantidad((int)$data['id_producto'], (int)$data['cantidad']);
            echo json_encode(['success' => $ok]);
            break;
        default:
            http_response_code(405);
            echo json_encode(['success' => false, 'message' => 'Método no permitido']);
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
