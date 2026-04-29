<?php
// api/producto.php

require_once __DIR__ . '/../config/cors.php';
require_once __DIR__ . '/../config/database.php';

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../config/auth.php';
$cloudinaryPath = __DIR__ . '/../services/CloudinaryService.php';
if (file_exists($cloudinaryPath)) {
    require_once $cloudinaryPath;
}
require_once __DIR__ . '/../src/Utils/Logger.php';
$payload = requireRole([1]);
$logger = new \App\Utils\Logger(__DIR__ . '/../logs/admin.log');

use App\Models\Producto;

header('Content-Type: application/json');

try {
    $db = getPDO();
    $productoModel = new Producto($db);

    switch ($_SERVER['REQUEST_METHOD']) {
        case 'GET':
            if (isset($_GET['suspendidos'])) {
                $productos = $productoModel->getSuspendidos();
                echo json_encode(['success' => true, 'data' => $productos]);
                break;
            }
            if (isset($_GET['id'])) {
                $producto = $productoModel->getById((int)$_GET['id']);
                echo json_encode(['success' => true, 'data' => $producto]);
                break;
            }
            // Filtros: nombre, proveedor, precio_min, precio_max, solo_habilitados
            $filtros = [
                'nombre' => $_GET['nombre'] ?? null,
                'id_proveedor' => isset($_GET['id_proveedor']) ? (int)$_GET['id_proveedor'] : null,
                'precio_min' => isset($_GET['precio_min']) ? (float)$_GET['precio_min'] : null,
                'precio_max' => isset($_GET['precio_max']) ? (float)$_GET['precio_max'] : null,
                'solo_habilitados' => isset($_GET['solo_habilitados']) ? (bool)$_GET['solo_habilitados'] : false
            ];
            $productos = $productoModel->buscar($filtros);
            echo json_encode(['success' => true, 'data' => $productos]);
            break;
        case 'POST':
            $data = $_POST;
            if (!$data || !isset($data['costo']) || !isset($data['ganancia'])) {
                http_response_code(400);
                echo json_encode(['success' => false, 'message' => 'Datos inválidos, falta costo o ganancia']);
                break;
            }
            $fotoUrl = '';
            $fotoPublicId = '';
            if (isset($_FILES['fotoProducto']) && class_exists('CloudinaryService')) {
                $cloudinary = new CloudinaryService('productos');
                $uploadResult = $cloudinary->uploadFromFileArray($_FILES['fotoProducto'], 'productos');
                if ($uploadResult['success']) {
                    $fotoUrl = $uploadResult['url'];
                    $fotoPublicId = $uploadResult['public_id'] ?? '';
                } else {
                    http_response_code(500);
                    echo json_encode(['success' => false, 'message' => 'Error al subir imagen', 'error' => $uploadResult['message']]);
                    break;
                }
            }
            $data['fotoProducto_url'] = $fotoUrl;
            $data['fotoProducto_public_id'] = $fotoPublicId;
            $data['precioFinal'] = $data['costo'] + ($data['costo'] * $data['ganancia'] / 100);
            $id = $productoModel->create($data);
            $logger->log('CREAR_PRODUCTO', $payload['id_usuario'] ?? 'N/A', json_encode(['id_producto'=>$id, 'data'=>$data]));
            echo json_encode(['success' => true, 'id_producto' => $id]);
            break;
        case 'PUT':
            $data = $_POST;
            if (!$data || !isset($data['id_producto']) || !isset($data['costo']) || !isset($data['ganancia'])) {
                http_response_code(400);
                echo json_encode(['success' => false, 'message' => 'Datos inválidos, falta id_producto, costo o ganancia']);
                break;
            }
            $productoActual = $productoModel->getById((int)$data['id_producto']);
            $fotoUrl = $productoActual['fotoProducto_url'] ?? '';
            $fotoPublicId = $productoActual['fotoProducto_public_id'] ?? '';
            if (isset($_FILES['fotoProducto']) && class_exists('CloudinaryService')) {
                $cloudinary = new CloudinaryService('productos');
                if (!empty($fotoUrl)) {
                    $cloudinary->deleteByUrl($fotoUrl);
                }
                $uploadResult = $cloudinary->uploadFromFileArray($_FILES['fotoProducto'], 'productos');
                if ($uploadResult['success']) {
                    $fotoUrl = $uploadResult['url'];
                    $fotoPublicId = $uploadResult['public_id'] ?? '';
                } else {
                    http_response_code(500);
                    echo json_encode(['success' => false, 'message' => 'Error al subir imagen', 'error' => $uploadResult['message']]);
                    break;
                }
            }
            $data['fotoProducto_url'] = $fotoUrl;
            $data['fotoProducto_public_id'] = $fotoPublicId;
            $data['precioFinal'] = $data['costo'] + ($data['costo'] * $data['ganancia'] / 100);
            $ok = $productoModel->update($data);
            $logger->log('EDITAR_PRODUCTO', $payload['id_usuario'] ?? 'N/A', json_encode(['id_producto'=>$data['id_producto'], 'data'=>$data]));
            echo json_encode(['success' => $ok]);
            break;
        // ...otros métodos como PATCH, DELETE, etc. aquí...
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
