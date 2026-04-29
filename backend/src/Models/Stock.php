<?php
namespace App\Models;

use PDO;

class Stock
{
    private PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function getByProducto(int $id_producto): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM stock WHERE id_producto = ? AND cancelado = 0");
        $stmt->execute([$id_producto]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public function updateCantidad(int $id_producto, int $cantidad): bool
    {
        $stmt = $this->db->prepare("UPDATE stock SET cantidad = ? WHERE id_producto = ? AND cancelado = 0");
        return $stmt->execute([$cantidad, $id_producto]);
    }
}
