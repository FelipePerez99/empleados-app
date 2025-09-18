<?php
declare(strict_types=1);

namespace App\Config;

use PDO;
use PDOException;

class Database {
  private string $host;
  private string $db;
  private string $user;
  private string $pass;
  private string $charset = 'utf8mb4';
  private ?PDO $pdo = null;

  public function __construct(
    string $host = '127.0.0.1',
    string $db = 'empleados_db',
    string $user = 'root',
    string $pass = ''
  ) {
    $this->host = $host; $this->db = $db; $this->user = $user; $this->pass = $pass;
  }

  public function pdo(): PDO {
    if ($this->pdo === null) {
      $dsn = "mysql:host={$this->host};dbname={$this->db};charset={$this->charset}";
      $opts = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
      ];
      try { $this->pdo = new PDO($dsn, $this->user, $this->pass, $opts); }
      catch (PDOException $e) { throw new \RuntimeException('DB connection failed: '.$e->getMessage()); }
    }
    return $this->pdo;
  }
}
