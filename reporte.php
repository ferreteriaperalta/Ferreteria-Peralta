<?php
include 'funciones.php';

csrf();
if (isset($_POST['submit']) && !hash_equals($_SESSION['csrf'], $_POST['csrf'])) {
  die();
}

$error = false;
$config = include 'config.php';

$filtro_cliente = $_POST['cliente'] ?? '';
$filtro_fecha   = $_POST['fecha'] ?? '';
$filtro_pago    = $_POST['pago'] ?? '';
$filtro_vendedor= $_POST['vendedor'] ?? '';

try {

  $dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
  $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);

  // BASE DE LA CONSULTA
  $consultaSQL = "
    SELECT v.id_venta, v.fecha, v.total, v.metodo_pago,
           c.nombre AS cliente, ve.nombre AS vendedor
    FROM ventas v
    INNER JOIN clientes c ON v.id_cliente = c.id_cliente
    INNER JOIN vendedores ve ON v.id_vendedor = ve.id_vendedor
    WHERE 1=1
  ";

  // FILTROS DINÁMICOS
  if ($filtro_cliente != '') {
    $consultaSQL .= " AND c.nombre LIKE :cliente";
  }

  if ($filtro_fecha != '') {
    $consultaSQL .= " AND v.fecha = :fecha";
  }

  if ($filtro_pago != '') {
    $consultaSQL .= " AND v.metodo_pago = :pago";
  }

  if ($filtro_vendedor != '') {
    $consultaSQL .= " AND ve.nombre LIKE :vendedor";
  }

  $consultaSQL .= " ORDER BY v.fecha DESC";

  $sentencia = $conexion->prepare($consultaSQL);

  if ($filtro_cliente != '') {
    $sentencia->bindValue(':cliente', "%$filtro_cliente%");
  }

  if ($filtro_fecha != '') {
    $sentencia->bindValue(':fecha', $filtro_fecha);
  }

  if ($filtro_pago != '') {
    $sentencia->bindValue(':pago', $filtro_pago);
  }

  if ($filtro_vendedor != '') {
    $sentencia->bindValue(':vendedor', "%$filtro_vendedor%");
  }

  $sentencia->execute();
  $reporte = $sentencia->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
  $error = $e->getMessage();
}
?>

<?php include "templates/header.php"; ?>

<div class="container mt-4">

  <h2 class="mb-3">📊 Reporte General de Ventas</h2>

  <!-- FILTROS -->
  <form method="post" class="row g-3 mb-4">

    <div class="col-md-3">
      <input type="text" name="cliente" class="form-control" placeholder="Cliente"
             value="<?= escapar($filtro_cliente) ?>">
    </div>

    <div class="col-md-2">
      <input type="date" name="fecha" class="form-control"
             value="<?= escapar($filtro_fecha) ?>">
    </div>

    <div class="col-md-2">
      <select name="pago" class="form-control">
        <option value="">Método de pago</option>
        <option value="Efectivo" <?= $filtro_pago=='Efectivo'?'selected':'' ?>>Efectivo</option>
        <option value="Tarjeta" <?= $filtro_pago=='Tarjeta'?'selected':'' ?>>Tarjeta</option>
        <option value="Transferencia" <?= $filtro_pago=='Transferencia'?'selected':'' ?>>Transferencia</option>
      </select>
    </div>

    <div class="col-md-3">
      <input type="text" name="vendedor" class="form-control" placeholder="Vendedor"
             value="<?= escapar($filtro_vendedor) ?>">
    </div>

    <div class="col-md-2 d-grid">
      <input type="hidden" name="csrf" value="<?= escapar($_SESSION['csrf']) ?>">
      <button type="submit" name="submit" class="btn btn-primary">🔍 Filtrar</button>
    </div>

  </form>

  <!-- TABLA -->
  <div class="table-responsive">
    <table class="table table-striped">
      <thead class="table-dark">
        <tr>
          <th>ID Venta</th>
          <th>Fecha</th>
          <th>Total</th>
          <th>Método de Pago</th>
          <th>Cliente</th>
          <th>Vendedor</th>
        </tr>
      </thead>
      <tbody>

      <?php if (!empty($reporte)): ?>
        <?php foreach ($reporte as $fila): ?>
          <tr>
            <td><?= escapar($fila['id_venta']) ?></td>
            <td><?= escapar($fila['fecha']) ?></td>
            <td>$<?= number_format($fila['total'], 2) ?></td>
            <td><?= escapar($fila['metodo_pago']) ?></td>
            <td><?= escapar($fila['cliente']) ?></td>
            <td><?= escapar($fila['vendedor']) ?></td>
          </tr>
        <?php endforeach; ?>
      <?php else: ?>
        <tr>
          <td colspan="6" class="text-center alert alert-warning m-0">
            No se encontraron resultados
          </td>
        </tr>
      <?php endif; ?>

      </tbody>
    </table>
  </div>

</div>

<?php include "templates/footer.php"; ?>
