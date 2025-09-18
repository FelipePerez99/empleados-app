<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Config\Database;

class AreaRepositorio {
    public function __construct(private Database $db) {}

    public function listarAreas(): array {
        $sql = "SELECT id, nombre FROM areas ORDER BY nombre";
        return $this->db->pdo()->query($sql)->fetchAll();
    }
}
