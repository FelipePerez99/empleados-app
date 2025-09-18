<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Config\Database;

class RolRepositorio {
    public function __construct(private Database $db) {}

    public function listarRoles(): array {
        $sql = "SELECT id, nombre FROM roles ORDER BY id";
        return $this->db->pdo()->query($sql)->fetchAll();
    }
}
