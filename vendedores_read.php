<?php
include 'funciones.php';
csrf();
$config = include 'config.php';
$error=false;

try{
  $dsn='mysql:host='.$config['db']['host'].';dbname='.$config['db']['name'];
  $conexion=new PDO($dsn,$config['db']['user'],$config['db']['pass'],$config['db']['options']);

  $consultaSQL="SELECT * FROM vendedores";
  $sentencia=$conexion->prepare($consultaSQL);
  $sentencia->execute();

  $vendedores=$sentencia->fetchAll();
}catch(PDOException $error){
  $error=$error->getMessage();
}
?>
<?php include "templates/header.php"; ?>
<div class="container">
  <h2 class="mt-3"style="font-size:40px;">Lista De Vendedores🧑‍💼</h2>
  <table class="table table-striped mt-3">
    <thead><tr><th style="color: green;">ID</th><th>Nombre</th></tr></thead>
    <tbody>
      <?php foreach($vendedores as $fila): ?>
      <tr>
        <td style="font-weight:bold;"><?= $fila["id_vendedor"]; ?></td>
        <td><?= $fila["nombre"]; ?></td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>
<body style="background-color:#f5f7fa";>
<?php include "templates/footer.php"; ?>