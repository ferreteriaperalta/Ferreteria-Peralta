<?php
include 'funciones.php';
csrf();
$config = include 'config.php';
$error=false;

try{
  $dsn='mysql:host='.$config['db']['host'].';dbname='.$config['db']['name'];
  $conexion=new PDO($dsn,$config['db']['user'],$config['db']['pass'],$config['db']['options']);

  $consultaSQL="
  SELECT v.id_venta, v.fecha, v.total, v.metodo_pago,
         c.nombre AS cliente,
         ve.nombre AS vendedor
  FROM ventas v
  INNER JOIN clientes c ON v.id_cliente = c.id_cliente
  INNER JOIN vendedores ve ON v.id_vendedor = ve.id_vendedor";

  $sentencia=$conexion->prepare($consultaSQL);
  $sentencia->execute();

  $ventas=$sentencia->fetchAll();
}catch(PDOException $error){
  $error=$error->getMessage();
}
?>
<?php include "templates/header.php"; ?>
<div class="container">
<h2 class="mt-3"style="font-size:40px;">Lista de Ventas💰</h2>
<table class="table table-striped mt-3">
  <thead>
    <tr><th style="color: green;">ID Venta</th><th>Fecha</th><th style="color:#9E1818";>Total</th><th>Método Pago</th><th>Cliente</th><th>Vendedor</th></tr>
    

  </thead>
  <tbody>
    <?php foreach($ventas as $fila): ?>
    <tr>
      <td style="font-weight:bold;"><?= $fila["id_venta"]; ?></td>
      <td><?= $fila["fecha"]; ?></td>
      <td>$<?= $fila["total"]; ?></td>
      <td><?= $fila["metodo_pago"]; ?></td>
      <td><?= $fila["cliente"]; ?></td>
      <td><?= $fila["vendedor"]; ?></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>
</div>
<body style=" background-color:#f5f7fa";>
<?php include "templates/footer.php"; ?>