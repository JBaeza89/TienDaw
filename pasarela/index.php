<?php
require("config.php");
$cod_comercio = $_REQUEST["cod_comercio"] ?? 0;
$cod_pedido = $_REQUEST["cod_pedido"] ?? 0;
$importe = $_REQUEST["importe"] ?? 0;
$concepto = $_REQUEST["concepto"] ?? "Desconocido";
$comercio = $comercios[$cod_comercio];

if (!isset($comercio)) {
    die("Código de comercio desconocido");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/mini.css/3.0.1/mini-default.min.css">
    <title>Pasarela de pago</title>
</head>

<body class="container">
    <h1>Simulación de pasarela de pago.</h1>
    <h2><?= $comercio["nombre"] ?></h2>
    Se ha recibido una solicitud de pago
    <ul>
        <li>Código de pedido: <?= $cod_pedido ?></li>
        <li>Concepto: <?= $concepto ?></li>
        <li>Importe: <?= $importe ?> </li>
    </ul>
    <br>
    <br>
    <form action="accion.php" method="POST">
        <input type="hidden" name="cod_comercio" value="<?=$cod_comercio?>">
        <input type="hidden" name="cod_pedido" value="<?=$cod_pedido?>">
        <input type="hidden" name="importe" value="<?=$importe?>">
        Selecciona una acción a simular:<br>
        <button class="button primary" type="submit" name="pago" value="ok">Pago ok</button>
        <button class="button" type="submit" name="pago" value="nook">Pago no completado</button>
        <button class="button secondary" type="submit" name="pago" value="cancelado">Cancelado por el usuario</button>
    </form>
</body>

</html>