<?php
// Inicializa variables de sesión para re-render
$old = $_SESSION['old'] ?? [];
unset($_SESSION['old']);

// Garantiza que existan las variables aunque vengan nulas
if (!isset($errores) || !is_array($errores)) $errores = [];
if (!isset($empleado)) $empleado = null;
?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title><?= $empleado ? 'Editar empleado' : 'Crear empleado' ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">
  <div class="container py-4">
    <h1 class="h3 mb-3"><?= $empleado ? 'Editar empleado' : 'Crear empleado' ?></h1>

    <!-- Banda informativa -->
    <div class="alert alert-info">Los campos con asteriscos (*) son obligatorios</div>

    <form id="formEmpleado" action="?accion=guardar" method="post" class="mt-3">
      <?php if (!empty($empleado?->id)): ?>
        <input type="hidden" name="id" value="<?= (int)$empleado->id ?>">
      <?php endif; ?>

      <!-- Nombre -->
      <div class="row mb-3">
        <label class="col-sm-3 col-form-label fw-bold text-end">Nombre completo *</label>
        <div class="col-sm-6">
          <input type="text" name="nombre" class="form-control <?= isset($errores['nombre']) ? 'is-invalid' : '' ?>"
                 placeholder="Nombre completo del empleado"
                 value="<?= htmlspecialchars($old['nombre'] ?? ($empleado->nombre ?? '')) ?>">
          <?php if (isset($errores['nombre'])): ?>
            <div class="invalid-feedback"><?= $errores['nombre'] ?></div>
          <?php endif; ?>
        </div>
      </div>

      <!-- Correo -->
      <div class="row mb-3">
        <label class="col-sm-3 col-form-label fw-bold text-end">Correo electrónico *</label>
        <div class="col-sm-6">
          <input type="email" name="correo" class="form-control <?= isset($errores['correo']) ? 'is-invalid' : '' ?>"
                 placeholder="Correo electrónico"
                 value="<?= htmlspecialchars($old['correo'] ?? ($empleado->correo ?? '')) ?>">
          <?php if (isset($errores['correo'])): ?>
            <div class="invalid-feedback"><?= $errores['correo'] ?></div>
          <?php endif; ?>
        </div>
      </div>

      <!-- Sexo -->
      <div class="row mb-3">
        <label class="col-sm-3 col-form-label fw-bold text-end">Sexo *</label>
        <div class="col-sm-6">
          <?php $sexoSel = $old['sexo'] ?? ($empleado ? $empleado->sexo : ''); ?>
          <div class="form-check">
            <input class="form-check-input <?= isset($errores['sexo']) ? 'is-invalid' : '' ?>" type="radio" name="sexo" value="M" <?= $sexoSel==='M'?'checked':'' ?>>
            <label class="form-check-label">Masculino</label>
          </div>
          <div class="form-check">
            <input class="form-check-input <?= isset($errores['sexo']) ? 'is-invalid' : '' ?>" type="radio" name="sexo" value="F" <?= $sexoSel==='F'?'checked':'' ?>>
            <label class="form-check-label">Femenino</label>
          </div>
        </div>
      </div>

      <!-- Área -->
      <div class="row mb-3">
        <label class="col-sm-3 col-form-label fw-bold text-end">Área *</label>
        <div class="col-sm-6">
          <?php $areaSel = (int)($old['area_id'] ?? ($empleado->area_id ?? 0)); ?>
          <select name="area_id" class="form-select <?= isset($errores['area_id']) ? 'is-invalid' : '' ?>">
            <option value="">Seleccione…</option>
            <?php foreach ($areas as $a): ?>
              <option value="<?= (int)$a['id'] ?>" <?= $areaSel === (int)$a['id'] ? 'selected' : '' ?>>
                <?= htmlspecialchars($a['nombre']) ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>
      </div>

      <!-- Descripción -->
      <div class="row mb-3">
        <label class="col-sm-3 col-form-label fw-bold text-end">Descripción *</label>
        <div class="col-sm-6">
          <textarea name="descripcion" class="form-control <?= isset($errores['descripcion']) ? 'is-invalid' : '' ?>"
                    placeholder="Descripción de la experiencia del empleado"
                    rows="3"><?= htmlspecialchars($old['descripcion'] ?? ($empleado->descripcion ?? '')) ?></textarea>
        </div>
      </div>

      <!-- Boletín -->
      <div class="row mb-3">
        <div class="offset-sm-3 col-sm-6">
          <?php
            $chkBoletin = isset($old['boletin']) || ($empleado && (int)$empleado->boletin === 1);
          ?>
          <div class="form-check">
            <input class="form-check-input" type="checkbox" id="boletin" name="boletin" <?= $chkBoletin ? 'checked' : '' ?>>
            <label class="form-check-label" for="boletin">Deseo recibir boletín informativo</label>
          </div>
        </div>
      </div>

      <!-- Roles -->
      <div class="row mb-3">
        <label class="col-sm-3 col-form-label fw-bold text-end">Roles *</label>
        <div class="col-sm-6">
          <?php
            $rolesSel = $old['roles'] ?? ($empleado ? $empleado->roles : []);
            $rolesSel = array_map('intval', (array)$rolesSel);
          ?>
          <?php foreach ($roles as $r): ?>
            <?php $checked = in_array((int)$r['id'], $rolesSel, true) ? 'checked' : ''; ?>
            <div class="form-check">
              <input class="form-check-input" type="checkbox" name="roles[]" value="<?= (int)$r['id'] ?>" <?= $checked ?>>
              <label class="form-check-label"><?= htmlspecialchars($r['nombre']) ?></label>
            </div>
          <?php endforeach; ?>
        </div>
      </div>

      <!-- Botón Guardar -->
      <div class="row">
        <div class="offset-sm-3 col-sm-6">
          <button type="submit" class="btn btn-primary">Guardar</button>
        </div>
      </div>
    </form>
  </div>

  <script>
document.getElementById('formEmpleado')?.addEventListener('submit', function(e){
  const f = e.target;
  const errores = [];

  f.correo.value = f.correo.value.trim();

  if (!f.nombre.value.trim()) errores.push('El nombre es obligatorio.');
  if (!f.correo.checkValidity()) errores.push('Correo inválido.');
  if (!['M','F'].includes(f.sexo.value)) errores.push('Seleccione el sexo.');
  if (!f.area_id.value) errores.push('Seleccione un área.');
  if (!f.descripcion.value.trim()) errores.push('La descripción es obligatoria.');

  if (errores.length) {
    e.preventDefault();
    alert(errores.join('\n'));
  }
});
</script>
</body>
</html>
