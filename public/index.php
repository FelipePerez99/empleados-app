<?php
declare(strict_types=1);

// Autoloader PSR-4
spl_autoload_register(function ($class) {
    $prefix = 'App\\';
    $baseDir = __DIR__ . '/../src/';
    if (strncmp($prefix, $class, strlen($prefix)) !== 0) return;
    $relative = substr($class, strlen($prefix));
    $file = $baseDir . str_replace('\\', '/', $relative) . '.php';
    if (file_exists($file)) require $file;
});

use App\Config\Database;
use App\Repositories\{EmpleadoRepositorio, AreaRepositorio, RolRepositorio};
use App\Services\EmpleadoServicio;
use App\Controllers\EmpleadoControlador;

session_start();

$db            = new Database();
$empleadoRepo  = new EmpleadoRepositorio($db);
$areaRepo      = new AreaRepositorio($db);
$rolRepo       = new RolRepositorio($db);
$servicio      = new EmpleadoServicio();

$controlador   = new EmpleadoControlador($db, $empleadoRepo, $areaRepo, $rolRepo, $servicio);

$accion = $_GET['accion'] ?? 'listar';

try {
    switch ($accion) {
        case 'listar':
            $controlador->mostrarListado();
            break;
        case 'nuevo':
            $controlador->mostrarFormularioNuevo();
            break;
        case 'editar':
            $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
            $controlador->mostrarFormularioEditar($id);
            break;
        case 'guardar':
            $controlador->guardar($_POST);
            break;
        case 'eliminar':
            $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
            $controlador->eliminar($id);
            break;
        default:
            http_response_code(404);
            echo "Página no encontrada";
            break;
    }
} catch (\Throwable $t) {
    http_response_code(500);
    echo "<h3>Error:</h3><pre>" . htmlspecialchars($t->getMessage()) . "</pre>";
}