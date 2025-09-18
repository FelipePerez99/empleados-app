<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Lista de empleados</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Bootstrap + Bootstrap Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
  <style>
    thead th {
      font-weight: 700;
      text-align: center;
    }
    thead th.text-start,
    tbody td.text-start {
      text-align: left !important;
    }
    thead i { opacity: .85; margin-right: .35rem; }
    .icon-link {
      font-size: 1.3rem;
      color: #212529;
      text-decoration: none;
      display: inline-block;
    }
    .icon-link:hover { color: #0d6efd; }
    .icon-link.delete:hover { color: #dc3545; }
    .table td, .table th {
      vertical-align: middle;
    }
  </style>
</head>
<body class="bg-light">
  <div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
      <h1 class="h4 m-0">Lista de empleados</h1>
      <a class="btn btn-primary" href="?accion=nuevo">
        <i class="bi bi-person-plus me-1"></i> Crear
      </a>
    </div>

    <?php if (!empty($flash)): ?>
      <div class="alert alert-<?= htmlspecialchars($flash[0]) ?> alert-dismissible fade show" role="alert">
        <?= htmlspecialchars($flash[1]) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
      </div>
    <?php endif; ?>

    <div class="table-responsive">
      <table class="table table-hover table-sm align-middle">
        <thead class="table-light">
          <tr class="text-muted">
            <th class="text-start"><i class="bi bi-person-fill"></i>Nombre</th>
            <th class="text-start"><i class="bi bi-at"></i>Email</th>
            <th><i class="bi bi-gender-ambiguous"></i>Sexo</th>
            <th><i class="bi bi-briefcase-fill"></i>Área</th>
            <th><i class="bi bi-envelope-fill"></i>Boletin</th>
            <th>Modificar</th>
            <th>Eliminar</th>
          </tr>
        </thead>
        <tbody>
          <?php if (empty($empleados)): ?>
            <tr>
              <td colspan="7" class="text-center text-muted py-3">No hay empleados registrados.</td>
            </tr>
          <?php else: foreach ($empleados as $e): ?>
            <tr>
              <td class="text-start"><?= htmlspecialchars($e['nombre']) ?></td>
              <td class="text-start"><?= htmlspecialchars($e['correo']) ?></td>
              <td class="text-center"><?= $e['sexo'] === 'M' ? 'Masculino' : 'Femenino' ?></td>
              <td class="text-center"><?= htmlspecialchars($e['area']) ?></td>
              <td class="text-center"><?= ((int)$e['boletin']) === 1 ? 'Sí' : 'No' ?></td>

              <td class="text-center">
                <a href="?accion=editar&id=<?= (int)$e['id'] ?>" class="icon-link" title="Editar">
                  <i class="bi bi-pencil-square"></i>
                </a>
              </td>

              <td class="text-center">
                <a href="?accion=eliminar&id=<?= (int)$e['id'] ?>" 
                   class="icon-link delete" 
                   title="Eliminar"
                   onclick="return confirm('¿Eliminar este empleado?');">
                  <i class="bi bi-trash"></i>
                </a>
              </td>
            </tr>
          <?php endforeach; endif; ?>
        </tbody>
      </table>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
