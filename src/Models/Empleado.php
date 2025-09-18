<?php
declare(strict_types=1);

namespace App\Models;

class Empleado {
    public ?int $id;
    public string $nombre;
    public string $correo;
    public string $sexo;
    public int $area_id;
    public int $boletin;
    public string $descripcion;
    /** @var int[] */
    public array $roles = [];

    public function __construct(
        ?int $id,
        string $nombre,
        string $correo,
        string $sexo,
        int $area_id,
        int $boletin,
        string $descripcion,
        array $roles = []
    ) {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->correo = $correo;
        $this->sexo = $sexo;
        $this->area_id = $area_id;
        $this->boletin = $boletin;
        $this->descripcion = $descripcion;
        $this->roles = $roles;
    }
}
