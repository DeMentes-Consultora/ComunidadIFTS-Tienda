<?php
namespace App\Models;

use PDO;


class Producto {
    private PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function getSuspendidos(): array
    {
        $stmt = $this->db->query("SELECT * FROM producto WHERE cancelado = 1");
        return $stmt->fetchAll();
    }

    public function reactivar(int $id): bool
    {
        $stmt = $this->db->prepare("UPDATE producto SET habilitado = 1, cancelado = 0, idUpdate = NOW() WHERE id_producto = ?");
        return $stmt->execute([$id]);
    }

    public function suspender(int $id): bool
    {
        $stmt = $this->db->prepare("UPDATE producto SET habilitado = 0, cancelado = 1, idUpdate = NOW() WHERE id_producto = ?");
        return $stmt->execute([$id]);
    }


    public function getAll(): array
    {
        $stmt = $this->db->query("SELECT * FROM producto WHERE cancelado = 0");
        return $stmt->fetchAll();
    }

    public function getById(int $id): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM producto WHERE id_producto = ? AND cancelado = 0");
        $stmt->execute([$id]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public function create(array $data): int
    {
        $stmt = $this->db->prepare("INSERT INTO producto (id_proveedor, fotoProducto_url, fotoProducto_public_id, nombreProducto, descripcionProducto, costo, ganancia, precioFinal, habilitado, cancelado, idCreate, idUpdate) VALUES (?, ?, ?, ?, ?, ?, ?, ?, 1, 0, NOW(), NOW())");
        $stmt->execute([
            $data['id_proveedor'],
            $data['fotoProducto_url'],
            $data['fotoProducto_public_id'],
            $data['nombreProducto'],
            $data['descripcionProducto'],
            $data['costo'],
            $data['ganancia'],
            $data['precioFinal']
        ]);
        return (int)$this->db->lastInsertId();
    }

    public function update(array $data): bool
    {
        $stmt = $this->db->prepare("UPDATE producto SET id_proveedor = ?, fotoProducto_url = ?, fotoProducto_public_id = ?, nombreProducto = ?, descripcionProducto = ?, costo = ?, ganancia = ?, precioFinal = ?, idUpdate = NOW() WHERE id_producto = ? AND cancelado = 0");
        return $stmt->execute([
            $data['id_proveedor'],
            $data['fotoProducto_url'],
            $data['fotoProducto_public_id'],
            $data['nombreProducto'],
            $data['descripcionProducto'],
            $data['costo'],
            $data['ganancia'],
            $data['precioFinal'],
            $data['id_producto']
        ]);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare("UPDATE producto SET cancelado = 1, idUpdate = NOW() WHERE id_producto = ?");
        return $stmt->execute([$id]);
    }


    /**
     * Buscar productos con filtros avanzados
     * @param array $filtros
     * @return array
     */
    public function buscar(array $filtros): array
    {
        $sql = "SELECT * FROM producto WHERE cancelado = 0";
        $params = [];
        if (!empty($filtros['nombre'])) {
            $sql .= " AND nombreProducto LIKE ?";
            $params[] = '%' . $filtros['nombre'] . '%';
        }
        if (!empty($filtros['id_proveedor'])) {
            $sql .= " AND id_proveedor = ?";
            $params[] = $filtros['id_proveedor'];
        }
        if (!empty($filtros['precio_min'])) {
            $sql .= " AND precioFinal >= ?";
            $params[] = $filtros['precio_min'];
        }
        if (!empty($filtros['precio_max'])) {
            $sql .= " AND precioFinal <= ?";
            $params[] = $filtros['precio_max'];
        }
        if (!empty($filtros['solo_habilitados'])) {
            $sql .= " AND habilitado = 1";
        }
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }
}
