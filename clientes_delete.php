<?php
include 'funciones.php';

$config = include 'config.php';

$resultado = [
  'error' => false,
  'mensaje' => ''
];

try {
  $dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
  $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);

  $id_cliente = $_GET['id_cliente'];

  $consultaSQL = "DELETE FROM Clientes WHERE id_cliente =" . $id_cliente;

  $sentencia = $conexion->prepare($consultaSQL);
  $sentencia->execute();

  header("Location: clientes_read.php");

} catch (PDOException $error) {
  $resultado['error'] = true;
  $resultado['mensaje'] = $error->getMessage();
}
?>

<?php require "templates/header.php"; ?>

<div class="container mt-2">
  <div class="alert alert-danger">
    <?= $resultado['mensaje'] ?>
  </div>
</div>

<?php require "templates/footer.php"; ?>
