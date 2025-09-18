<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Repositories\{EmpleadoRepositorio, AreaRepositorio, RolRepositorio};
use App\Services\EmpleadoServicio;
use App\Config\Database;

class EmpleadoControlador
{
    public function __construct(
        private Database $db,
        private EmpleadoRepositorio $empleadoRepo,
        private AreaRepositorio $areaRepo,
        private RolRepositorio $rolRepo,
        private EmpleadoServicio $servicio
    ) {}

    public function mostrarListado(): void
    {
        $empleados = $this->empleadoRepo->listarEmpleados();
        $flash = $this->tomarFlash();
        include __DIR__ . '/../../views/empleado/lista.php';
    }

    public function mostrarFormularioNuevo(): void
    {
        $empleado = null;
        $areas = $this->areaRepo->listarAreas();
        $roles = $this->rolRepo->listarRoles();
        $errores = $_SESSION['errores'] ?? [];
        unset($_SESSION['errores']);
        include __DIR__ . '/../../views/empleado/formulario.php';
    }

    public function mostrarFormularioEditar(int $id): void
    {
        $empleado = $this->empleadoRepo->obtenerEmpleadoPorId($id);
        if (!$empleado) {
            $this->ponerFlash('warning', 'El empleado no existe.');
            $this->redirigir('?accion=listar');
            return;
        }
        $areas = $this->areaRepo->listarAreas();
        $roles = $this->rolRepo->listarRoles();
        $errores = $_SESSION['errores'] ?? [];
        unset($_SESSION['errores']);
        include __DIR__ . '/../../views/empleado/formulario.php';
    }

    public function guardar(array $post): void
    {
        $errores = $this->servicio->validarEmpleado($post);
        if ($errores) {
            $_SESSION['errores'] = $errores;
            $_SESSION['old']     = $post;
            $destino = !empty($post['id'])
                ? '?accion=editar&id=' . (int)$post['id']
                : '?accion=nuevo';
            $this->redirigir($destino);
            return;
        }

        $pdo = $this->db->pdo();
        $pdo->beginTransaction();

        try {
            if (!empty($post['id'])) {
                $stmt = $pdo->prepare("UPDATE empleados 
                    SET nombre=?, correo=?, sexo=?, area_id=?, boletin=?, descripcion=? 
                    WHERE id=?");
                $stmt->execute([
                    trim($post['nombre']),
                    trim($post['correo']),
                    $post['sexo'],
                    (int)$post['area_id'],
                    isset($post['boletin']) ? 1 : 0,
                    trim($post['descripcion']),
                    (int)$post['id']
                ]);

                $pdo->prepare("DELETE FROM empleado_rol WHERE empleado_id=?")
                    ->execute([(int)$post['id']]);
                if (!empty($post['roles'])) {
                    $ins = $pdo->prepare("INSERT INTO empleado_rol (empleado_id, rol_id) VALUES (?, ?)");
                    foreach ($post['roles'] as $rolId) {
                        $ins->execute([(int)$post['id'], (int)$rolId]);
                    }
                }

                $this->ponerFlash('success', 'Empleado actualizado correctamente.');
            } else {
                $stmt = $pdo->prepare("INSERT INTO empleados 
                    (nombre, correo, sexo, area_id, boletin, descripcion) 
                    VALUES (?,?,?,?,?,?)");
                $stmt->execute([
                    trim($post['nombre']),
                    trim($post['correo']),
                    $post['sexo'],
                    (int)$post['area_id'],
                    isset($post['boletin']) ? 1 : 0,
                    trim($post['descripcion'])
                ]);
                $nuevoId = (int)$pdo->lastInsertId();

                if (!empty($post['roles'])) {
                    $ins = $pdo->prepare("INSERT INTO empleado_rol (empleado_id, rol_id) VALUES (?, ?)");
                    foreach ($post['roles'] as $rolId) {
                        $ins->execute([$nuevoId, (int)$rolId]);
                    }
                }

                $this->ponerFlash('success', 'Empleado creado correctamente.');
            }

            $pdo->commit();
        } catch (\Throwable $t) {
            $pdo->rollBack();
            $this->ponerFlash('danger', 'Error al guardar: ' . $t->getMessage());
        }

        $this->redirigir('?accion=listar');
    }

    public function eliminar(int $id): void
    {
        if ($id > 0) {
            $this->db->pdo()->prepare("DELETE FROM empleados WHERE id=?")->execute([$id]);
            $this->ponerFlash('success', 'Empleado eliminado correctamente.');
        }
        $this->redirigir('?accion=listar');
    }

    private function ponerFlash(string $tipo, string $msg): void
    {
        $_SESSION['flash'] = [$tipo, $msg];
    }

    private function tomarFlash(): ?array
    {
        $f = $_SESSION['flash'] ?? null;
        unset($_SESSION['flash']);
        return $f;
    }

    private function redirigir(string $url): void
    {
        header('Location: ' . $url);
        exit;
    }
}
