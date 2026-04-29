<?php
// api/proveedor.php

require_once __DIR__ . '/../config/cors.php';
require_once __DIR__ . '/../config/database.php';

require_once __DIR__ . '/../vendor/autoload.php';

$cloudinaryPath = __DIR__ . '/../services/CloudinaryService.php';
if (file_exists($cloudinaryPath)) {
    require_once $cloudinaryPath;
}
require_once __DIR__ . '/../config/auth.php';
requireRole([1]);

use App\Models\Proveedor;

header('Content-Type: application/json');

try {
    $db = getPDO();
    $proveedorModel = new Proveedor($db);

    switch ($_SERVER['REQUEST_METHOD']) {
        case 'GET':
            if (isset($_GET['id'])) {
                $proveedor = $proveedorModel->getById((int)$_GET['id']);
                echo json_encode(['success' => true, 'data' => $proveedor]);
            } else {
                $proveedores = $proveedorModel->getAll();
                echo json_encode(['success' => true, 'data' => $proveedores]);
            }
            break;
        case 'POST':
            $data = $_POST;
            if (!$data) {
                http_response_code(400);
                echo json_encode(['success' => false, 'message' => 'Datos inválidos']);
                break;
            }
            $fotoUrl = '';
            $fotoPublicId = '';
            if (isset($_FILES['fotoPerfil']) && class_exists('CloudinaryService')) {
                $cloudinary = new CloudinaryService('proveedores');
                $uploadResult = $cloudinary->uploadFromFileArray($_FILES['fotoPerfil'], 'proveedores');
                if ($uploadResult['success']) {
                    $fotoUrl = $uploadResult['url'];
                    $fotoPublicId = $uploadResult['public_id'] ?? '';
                } else {
                    http_response_code(500);
                    echo json_encode(['success' => false, 'message' => 'Error al subir imagen', 'error' => $uploadResult['message']]);
                    break;
                }
            }
            $data['fotoPerfil_url'] = $fotoUrl;
            $data['fotoPerfil_public_id'] = $fotoPublicId;
            $id = $proveedorModel->create($data);
            echo json_encode(['success' => true, 'id_proveedor' => $id]);
            break;
        case 'PUT':
            $data = $_POST;
            if (!$data || !isset($data['id_proveedor'])) {
                http_response_code(400);
                echo json_encode(['success' => false, 'message' => 'Datos inválidos o falta id_proveedor']);
                break;
            }
            $proveedorActual = $proveedorModel->getById((int)$data['id_proveedor']);
            $fotoUrl = $proveedorActual['fotoPerfil_url'] ?? '';
            $fotoPublicId = $proveedorActual['fotoPerfil_public_id'] ?? '';
            if (isset($_FILES['fotoPerfil']) && class_exists('CloudinaryService')) {
                $cloudinary = new CloudinaryService('proveedores');
                if (!empty($fotoUrl)) {
                    $cloudinary->deleteByUrl($fotoUrl);
                }
                $uploadResult = $cloudinary->uploadFromFileArray($_FILES['fotoPerfil'], 'proveedores');
                if ($uploadResult['success']) {
                    $fotoUrl = $uploadResult['url'];
                    $fotoPublicId = $uploadResult['public_id'] ?? '';
                } else {
                    http_response_code(500);
                    echo json_encode(['success' => false, 'message' => 'Error al subir imagen', 'error' => $uploadResult['message']]);
                    break;
                }
            }
            $data['fotoPerfil_url'] = $fotoUrl;
            $data['fotoPerfil_public_id'] = $fotoPublicId;
            $ok = $proveedorModel->update($data);
            echo json_encode(['success' => $ok]);
            break;
        case 'DELETE':
            $data = json_decode(file_get_contents('php://input'), true);
            if (!$data || !isset($data['id_proveedor'])) {
                http_response_code(400);
                echo json_encode(['success' => false, 'message' => 'Falta id_proveedor']);
                break;
            }
            $ok = $proveedorModel->delete((int)$data['id_proveedor']);
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
