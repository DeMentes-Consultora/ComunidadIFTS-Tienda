<?php
// config/auth.php
require_once __DIR__ . '/jwt.php';

function requireRole(array $rolesPermitidos): array {
    $headers = getallheaders();
    if (!isset($headers['Authorization'])) {
        http_response_code(401);
        echo json_encode(['success' => false, 'message' => 'Token no enviado']);
        exit;
    }
    $jwt = str_replace('Bearer ', '', $headers['Authorization']);
    try {
        $payload = decode_jwt($jwt);
        if (!isset($payload['rol'])) {
            http_response_code(403);
            echo json_encode(['success' => false, 'message' => 'Rol no presente en el token']);
            exit;
        }
        if (!in_array($payload['rol'], $rolesPermitidos)) {
            http_response_code(403);
            echo json_encode(['success' => false, 'message' => 'Acceso denegado para este rol']);
            exit;
        }
        return $payload;
    } catch (Exception $e) {
        http_response_code(401);
        echo json_encode(['success' => false, 'message' => 'Token inválido: ' . $e->getMessage()]);
        exit;
    }
}
