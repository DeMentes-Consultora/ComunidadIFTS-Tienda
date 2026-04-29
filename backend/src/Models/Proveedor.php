<?php
namespace App\Models;

use PDO;

class Proveedor {
    public function create(array $data): int
    {
        $stmt = $this->db->prepare("INSERT INTO proveedor (fotoPerfil_url, fotoPerfil_public_id, nombreProveedor, direccion, altura, localidad, barrio, telefono, email, habilitado, cancelado, idCreate, idUpdate) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 1, 0, NOW(), NOW())");
        $stmt->execute([
            $data['fotoPerfil_url'],
            $data['fotoPerfil_public_id'],
            $data['nombreProveedor'],
            $data['direccion'],
            $data['altura'],
            $data['localidad'],
            $data['barrio'],
            $data['telefono'],
            $data['email']
        ]);
        return (int)$this->db->lastInsertId();
    }

    public function update(array $data): bool
    {
        $stmt = $this->db->prepare("UPDATE proveedor SET fotoPerfil_url = ?, fotoPerfil_public_id = ?, nombreProveedor = ?, direccion = ?, altura = ?, localidad = ?, barrio = ?, telefono = ?, email = ?, idUpdate = NOW() WHERE id_proveedor = ? AND cancelado = 0");
        return $stmt->execute([
            $data['fotoPerfil_url'],
            $data['fotoPerfil_public_id'],
            $data['nombreProveedor'],
            $data['direccion'],
            $data['altura'],
            $data['localidad'],
            $data['barrio'],
            $data['telefono'],
            $data['email'],
            $data['id_proveedor']
        ]);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare("UPDATE proveedor SET cancelado = 1, idUpdate = NOW() WHERE id_proveedor = ?");
        return $stmt->execute([$id]);
    }
    private PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function getAll(): array
    {
        $stmt = $this->db->query("SELECT * FROM proveedor WHERE cancelado = 0");
        return $stmt->fetchAll();
    }

    public function getById(int $id): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM proveedor WHERE id_proveedor = ? AND cancelado = 0");
        $stmt->execute([$id]);
        $row = $stmt->fetch();
        return $row ?: null;
    }
}
