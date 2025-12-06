<?php
include 'funciones.php';

csrf();
if (isset($_POST['submit']) && !hash_equals($_SESSION['csrf'], $_POST['csrf'])) {
  die();
}

$error = false;
$config = include 'config.php';

try {
  // base de datos
  $dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
  $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);


  $consultaSQL = "
      SELECT 
        vp.id_venta,
        p.nombre AS producto,
        vp.cantidad,
        p.precio
      FROM venta_productos vp
      INNER JOIN productos p ON p.id_producto = vp.id_producto
      ORDER BY vp.id_venta ASC
  ";


  $sentencia = $conexion->prepare($consultaSQL);
  $sentencia->execute();

  
  $venta_productos = $sentencia->fetchAll();

} catch (PDOException $error) {
  $error = $error->getMessage();
}
?>

<!--  HTML -->
<?php include "templates/header.php"; ?>

<?php
// Si hay error lo mostraremos en esta etiqueta
if ($error) {
?>
  <div class="container mt-2">
    <div class="row">
      <div class="col-md-12">
        <div class="alert alert-danger" role="alert">
          <?= $error ?>
        </div>
      </div>
    </div>
  </div>
<?php
}
?>

<!-- tabla con los resultados -->
<div class="container">

  <div class="row justify-content-end">
    <div class="col-md-6">
      <h2 class="mt-3" style="font-size:40px;">Productos Vendidos 🔩🛠️</h2>
    </div>

    <div class="col-md-6 text-end">
      <!-- Botón -->
      <button class="btn btn-secondary mt-4" disabled>
  Auto-generado por el registro de ventas
</button>

    </div>
  </div>

  <div class="row">
    <div class="col-md-12">

      <table class="table">
        <thead>
          <tr> <!-- Columnas de la tabla -->
            <th style="color: green;">ID Venta</th>
            <th>Producto</th>
            <th>Cantidad</th>
            <th style="color: red;">Subtotal 💵</th>
          </tr>
        </thead>

        <tbody>
          <?php
          
          if ($venta_productos && $sentencia->rowCount() > 0) {

            foreach ($venta_productos as $fila) {

              // Convertir precio en número válido
              $precio = floatval(str_replace(['$', ','], '', $fila["precio"]));

              // Calcular subtotal
              $subtotal = $precio * intval($fila["cantidad"]);
          ?>
              <tr> 
                <td style="font-weight:bold;"><?= escapar($fila["id_venta"]); ?></td>
                <td><?= escapar($fila["producto"]); ?></td>
                <td><?= escapar($fila["cantidad"]); ?></td>
                <td>$<?= number_format($subtotal, 2); ?></td>
              </tr>

          <?php
            }
          } else {
          ?>
            <tr>
              <td colspan="4" class="text-center">
                <p class="alert alert-warning">No hay registros disponibles</p>
              </td>
            </tr>
          <?php
          }
          ?>
        <tbody>
      </table>

    </div>
  </div>
</div>
<body style=" background-color:#f5f7fa";>
<?php include "templates/footer.php"; ?>
