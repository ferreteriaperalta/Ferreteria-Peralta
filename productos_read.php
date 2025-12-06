<?php
include 'funciones.php';
csrf();
$config = include 'config.php';
$error=false;

try{
  $dsn='mysql:host='.$config['db']['host'].';dbname='.$config['db']['name'];
  $conexion=new PDO($dsn,$config['db']['user'],$config['db']['pass'],$config['db']['options']);

  $consultaSQL="
  SELECT p.id_producto, p.nombre, p.descripcion, p.precio, p.cantidad,
         pr.nombre AS proveedor
  FROM productos p
  INNER JOIN proveedores pr ON p.id_proveedor = pr.id_proveedor";

  $sentencia=$conexion->prepare($consultaSQL);
  $sentencia->execute();

  $productos=$sentencia->fetchAll();
}catch(PDOException $error){
  $error=$error->getMessage();
}
?>
<?php include "templates/header.php"; ?>
<div class="container">

  <h2 class="mt-3" style="font-size:40px;">Lista De Productos 📦</h2>
  <table class="table table-striped mt-3">

    <thead>
      <tr><th style="color: green;">ID</th><th>Producto</th><th>Descripción</th><th style="color:#9E1818";>Precio</th><th>Cantidad</th><th style="width: 25%;">Proveedor</th>
</tr>
    </thead>
    <tbody>

      <?php foreach($productos as $fila): ?>
      <tr>
        <td style="font-weight:bold;"><?= $fila["id_producto"]; ?></td>
        <td><?= $fila["nombre"]; ?></td>
        <td><?= $fila["descripcion"]; ?></td>
        <td>$<?= $fila["precio"]; ?></td>
        <td><?= $fila["cantidad"]; ?></td>
        <td><?= $fila["proveedor"]; ?></td>
         <td>          
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>
<body style=" background-color:#f5f7fa";>
<?php include "templates/footer.php"; ?>