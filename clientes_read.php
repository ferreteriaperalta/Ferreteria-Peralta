<?php
include 'funciones.php';
csrf();
$config = include 'config.php';

$error = false;

try {
  $dsn = 'mysql:host='.$config['db']['host'].';dbname='.$config['db']['name'];
  $conexion = new PDO($dsn,$config['db']['user'],$config['db']['pass'],$config['db']['options']);

  $consultaSQL = "SELECT * FROM clientes";
  $sentencia = $conexion->prepare($consultaSQL);
  $sentencia->execute();

  $clientes = $sentencia->fetchAll();

} catch(PDOException $error){
  $error = $error->getMessage();
}
?>

<?php include "templates/header.php"; ?>
<div class="container">

  <div class="d-flex justify-content-between mt-3">
    <h2 style="font-size:40px;">Lista De Clientes 🙋</h2>
<a href="clientes_create.php" class="btn btn-primary">Crear Cliente</a>


</style>

  </div>
  <?php if($error): ?>
    <div class="alert alert-danger mt-3"><?= $error ?></div>
  <?php endif; ?>
  <table class="table table-striped mt-3">
    <thead>
      <tr style= "text-align:justify;">
        <th style="color: green;">ID</th><th>Nombre</th><th>Dirección</th><th>Teléfono</th><th>Correo</th><th>Acciones</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach($clientes as $fila): ?>
        <tr>
          <td style="font-weight:bold;"><?= $fila["id_cliente"]; ?></td>
          <td><?= $fila["nombre"]; ?></td>
          <td><?= $fila["direccion"]; ?></td>
          <td><?= $fila["telefono"]; ?></td>
          <td><?= $fila["correo"]; ?></td>
          <td>
            <a href="clientes_update.php?id_cliente=<?= $fila["id_cliente"] ?>"> <b style= "color:#1C1473;"> ✏️Editar</a></b>|
            <a href="clientes_delete.php?id_cliente=<?= $fila["id_cliente"] ?>" onclick="return confirm('¿Eliminar cliente?')"><b style= "color:#AB1111;">🗑️Eliminar</a></b>|
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>
<body style=" background-color:#f5f7fa";>
<?php include "templates/footer.php"; ?>