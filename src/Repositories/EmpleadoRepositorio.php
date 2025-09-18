<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Config\Database;
use App\Models\Empleado;

class EmpleadoRepositorio {
    public function __construct(private Database $db) {}

    public function todos(): array {
        $sql = "SELECT e.*, a.nombre AS area 
                FROM empleados e 
                JOIN areas a ON a.id = e.area_id
                ORDER BY e.id DESC";
        return $this->db->pdo()->query($sql)->fetchAll();
    }


    public function buscar(int $id): ?Empleado {
        $pdo = $this->db->pdo();
        $stmt = $pdo->prepare("SELECT * FROM empleados WHERE id = ?");
        $stmt->execute([$id]);
        $fila = $stmt->fetch();
        if (!$fila) return null;

        $rolesStmt = $pdo->prepare("SELECT rol_id FROM empleado_rol WHERE empleado_id = ?");
        $rolesStmt->execute([$id]);
        $roles = array_column($rolesStmt->fetchAll(), 'rol_id');

        return new Empleado(
            (int) $fila['id'],
            $fila['nombre'],
            $fila['correo'],
            $fila['sexo'],
            (int) $fila['area_id'],
            (int) $fila['boletin'],
            $fila['descripcion'],
            array_map('intval', $roles)
        );
    }
}
