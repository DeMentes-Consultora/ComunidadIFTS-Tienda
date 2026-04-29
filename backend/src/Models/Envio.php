<?php
namespace App\Models;

use PDO;

class Envio
{
    private PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function getByOrden(int $id_orden): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM envio WHERE id_orden = ? AND cancelado = 0");
        $stmt->execute([$id_orden]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public function create(array $data): bool
    {
        $stmt = $this->db->prepare("INSERT INTO envio (id_usuario, id_orden, direccion, altura, cod_post, localidad, barrio, habilitado, cancelado, idCreate, idUpdate) VALUES (?, ?, ?, ?, ?, ?, ?, 1, 0, NOW(), NOW())");
        return $stmt->execute([
            $data['id_usuario'],
            $data['id_orden'],
            $data['direccion'],
            $data['altura'],
            $data['cod_post'],
            $data['localidad'],
            $data['barrio']
        ]);
    }
}
