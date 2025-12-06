<?php
include 'funciones.php';

csrf();
if (isset($_POST['submit']) && !hash_equals($_SESSION['csrf'], $_POST['csrf'])) {
    die();
}

$config = include 'config.php';

$resultado = [
    'error' => false,
    'mensaje' => ''
];

if (!isset($_GET['id_cliente'])) {
    $resultado['error'] = true;
    $resultado['mensaje'] = 'El cliente no existe';
}

if (isset($_POST['submit'])) {
    try {
        $dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
        $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);

        $cliente = [
            "id_cliente" => $_GET['id_cliente'],
            "nombre"     => $_POST['nombre'],
            "direccion"  => $_POST['direccion'],
            "telefono"   => $_POST['telefono'],
            "correo"     => $_POST['correo']
        ];

        $consultaSQL = "UPDATE Clientes SET
            nombre = :nombre,
            direccion = :direccion,
            telefono = :telefono,
            correo = :correo
            WHERE id_cliente = :id_cliente";

        $consulta = $conexion->prepare($consultaSQL);
        $consulta->execute($cliente);

    } catch (PDOException $error) {
        $resultado['error'] = true;
        $resultado['mensaje'] = $error->getMessage();
    }
}

try {
    $dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
    $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);

    $id_cliente = $_GET['id_cliente'];

    $consultaSQL = "SELECT * FROM Clientes WHERE id_cliente = " . $id_cliente;

    $sentencia = $conexion->prepare($consultaSQL);
    $sentencia->execute();

    $cliente = $sentencia->fetch(PDO::FETCH_ASSOC);

    if (!$cliente) {
        $resultado['error'] = true;
        $resultado['mensaje'] = 'No se ha encontrado el cliente';
    }

} catch (PDOException $error) {
    $resultado['error'] = true;
    $resultado['mensaje'] = $error->getMessage();
}
?>

<?php require "templates/header.php"; ?>

<?php if ($resultado['error']) : ?>
    <div class="container mt-2">
        <div class="alert alert-danger" role="alert">
            <?= $resultado['mensaje'] ?>
        </div>
    </div>
<?php endif; ?>

<?php if (isset($_POST['submit']) && !$resultado['error']) : ?>
    <div class="container mt-2">
        <div class="alert alert-success" role="alert">
            El cliente ha sido actualizado correctamente
        </div>
    </div>
<?php endif; ?>

<?php if (isset($cliente) && $cliente) : ?>
<div class="container">
    <h2 class="mt-4">Editando el cliente <?= escapar($cliente['nombre']) ?></h2>
    <hr>

    <form method="post">

        <div class="form-group">
            <label>Nombre</label>
            <input class="form-control" type="text" name="nombre" value="<?= escapar($cliente['nombre']) ?>">
        </div>

        <div class="form-group">
            <label>Dirección</label>
            <input class="form-control" type="text" name="direccion" value="<?= escapar($cliente['direccion']) ?>">
        </div>

        <div class="form-group">
            <label>Teléfono</label>
            <input class="form-control" type="text" name="telefono" value="<?= escapar($cliente['telefono']) ?>">
        </div>

        <div class="form-group">
            <label>Correo</label>
            <input class="form-control" type="email" name="correo" value="<?= escapar($cliente['correo']) ?>">
        </div>

        <br>

        <input type="hidden" name="csrf" value="<?= escapar($_SESSION['csrf']) ?>">
        <input type="submit" name="submit" class="btn btn-primary" value="Actualizar">
        <a href="clientes_read.php" class="btn btn-primary">Regresar</a>

    </form>
</div>
<?php endif; ?>

<?php require "templates/footer.php"; ?>
