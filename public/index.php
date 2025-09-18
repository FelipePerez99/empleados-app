<?php
require_once __DIR__ . '/../src/Config/Database.php';

use App\Config\Database;

$db = new Database();

echo "<h1>¡Conexión exitosa!</h1>";

try {
  $pdo = $db->pdo();
  echo "<p>Conectado a la base de datos empleados_db correctamente.</p>";
} catch (Exception $e) {
  echo "<p style='color:red;'>Error: " . $e->getMessage() . "</p>";
}
