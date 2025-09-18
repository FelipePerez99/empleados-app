<?php
declare(strict_types=1);

namespace App\Services;

class EmpleadoServicio {
    
    public function validarEmpleado(array $data): array {
        $errores = [];

        $nombre = trim((string)($data['nombre'] ?? ''));
        $correo = trim((string)($data['correo'] ?? ''));
        $sexo = (string)($data['sexo'] ?? '');
        $area_id = $data['area_id'] ?? null;
        $descripcion = trim((string)($data['descripcion'] ?? ''));

        if ($nombre === '') $errores['nombre'] = 'El nombre es obligatorio.';
        if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) $errores['correo'] = 'Correo inválido.';
        if (!in_array($sexo, ['M','F'], true)) $errores['sexo'] = 'Seleccione el sexo.';
        if (!is_numeric($area_id)) $errores['area_id'] = 'Seleccione un área.';
        if ($descripcion === '') $errores['descripcion'] = 'La descripción es obligatoria.';

        return $errores;
    }
}
