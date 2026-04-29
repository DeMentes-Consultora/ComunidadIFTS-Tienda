<?php
namespace App\Models;

use PDO;

class DetalleOrden
{
    private PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function getByOrden(int $id_orden): array
    {
        $stmt = $this->db->prepare("SELECT * FROM detalle_orden WHERE id_orden = ? AND cancelado = 0");
        $stmt->execute([$id_orden]);
        return $stmt->fetchAll();
    }
}
