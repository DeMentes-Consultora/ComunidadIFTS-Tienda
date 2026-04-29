<?php
// config/jwt.php
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

function encode_jwt(array $payload): string {
    $secret = $_ENV['JWT_SECRET'];
    return JWT::encode($payload, $secret, 'HS256');
}

function decode_jwt(string $jwt): array {
    $secret = $_ENV['JWT_SECRET'];
    return (array) JWT::decode($jwt, new Key($secret, 'HS256'));
}
