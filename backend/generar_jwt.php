<?php
// generar_jwt.php
require_once __DIR__ . '/vendor/autoload.php';
use Firebase\JWT\JWT;

$payload = [
    "id_usuario" => 1, // Cambia por el id real si lo necesitas
    "rol" => 1,        // 1=admin, 2/3=ventas
    "exp" => time() + 3600 // 1 hora de validez
];

$secret = "2537218625386721/tienda@IFTS-Tienda";
$jwt = JWT::encode($payload, $secret, 'HS256');
echo $jwt . "\n";
