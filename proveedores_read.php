<?php
include 'funciones.php';
csrf();
$config = include 'config.php';

$error=false;

try{
  $dsn='mysql:host='.$config['db']['host'].';dbname='.$config['db']['name'];
  $conexion=new PDO($dsn,$config['db']['user'],$config['db']['pass'],$config['db']['options']);

  $consultaSQL="SELECT * FROM proveedores";
  $sentencia=$conexion->prepare($consultaSQL);
  $sentencia->execute();

  $proveedores=$sentencia->fetchAll();
}catch(PDOException $error){
  $error=$error->getMessage();
}
?>
<?php include "templates/header.php"; ?>
<div class="container">
  <h2 class="mt-3"style="font-size:40px;">Lista De Proveedores 🚚</h2>
  <table class="table table-striped mt-3">
    <thead><tr><th style="color: green;">ID</th><th>Nombre</th><th>Dirección</th><th>Contacto</th></tr></thead>
    <tbody>
      <?php foreach($proveedores as $fila): ?>
      <tr>
        <td style="font-weight:bold;"><?= $fila["id_proveedor"]; ?></td>
        <td><?= $fila["nombre"]; ?></td>
        <td><?= $fila["direccion"]; ?></td>
        <td><?= $fila["contacto"]; ?></td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>
<body style=" background-color:#f5f7fa";>
<?php include "templates/footer.php"; ?>