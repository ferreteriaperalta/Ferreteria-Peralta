<?php
include 'funciones.php';

csrf();
if (isset($_POST['submit']) && !hash_equals($_SESSION['csrf'], $_POST['csrf'])) {
  die();
}

if (isset($_POST['submit'])) {
  $resultado = [
    'error' => false,
    'mensaje' => 'El cliente ' . escapar($_POST['nombre']) . ' ha sido agregado con éxito'
  ];

  $config = include 'config.php';

  try {
    $dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
    $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);

    $cliente = [
      "nombre" => $_POST['nombre'],
      "direccion" => $_POST['direccion'],
      "telefono" => $_POST['telefono'],
      "correo" => $_POST['correo']
    ];

    $consultaSQL = "INSERT INTO Clientes (nombre, direccion, telefono, correo)
                    VALUES (:" . implode(", :", array_keys($cliente)) . ")";

    $sentencia = $conexion->prepare($consultaSQL);
    $sentencia->execute($cliente);

  } catch (PDOException $error) {
    $resultado['error'] = true;
    $resultado['mensaje'] = $error->getMessage();
  }
}

include 'templates/header.php';
?>

<!--  ESTILOS  -->
<style>
.contenido-crud {
    background-color: #ffffff;
    border-radius: 12px;
    padding: 25px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}
</style>

<?php if (isset($resultado)) : ?>
  <div class="container mt-3">
    <div class="alert alert-<?= $resultado['error'] ? 'danger' : 'success' ?>">
      <?= $resultado['mensaje'] ?>
    </div>
  </div>
<?php endif; ?>

<div class="container contenido-crud mt-4">
  <h2 class="mb-4">Crear Cliente ✍️👤</h2>
  <hr>

  <form method="post">

    <div class="form-group">
      <label>Nombre</label>
      <input type="text" name="nombre" class="form-control" required>
    </div>

    <div class="form-group">
      <label>Dirección</label>
      <input type="text" name="direccion" class="form-control">
    </div>

    <div class="form-group">
      <label>Teléfono</label>
      <input type="text" name="telefono" class="form-control">
    </div>

    <div class="form-group">
      <label>Correo</label>
      <input type="email" name="correo" class="form-control">
    </div>

    <br>
    <input name="csrf" type="hidden" value="<?= escapar($_SESSION['csrf']); ?>">
    <input type="submit" name="submit" class="btn btn-primary" value="Enviar">
    <a class="btn btn-secondary" href="clientes_read.php">Regresar</a>

  </form>
</div>

<?php include 'templates/footer.php'; ?>
