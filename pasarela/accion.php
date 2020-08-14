<?php
require("config.php");
$cod_comercio = $_REQUEST["cod_comercio"] ?? 0;
$cod_pedido = $_REQUEST["cod_pedido"] ?? 0;
$importe = $_REQUEST["importe"] ?? 0;
$pago = $_REQUEST["pago"] ?? "nook";
$comercio = $comercios[$cod_comercio];

$url = $comercio["url_pingback_informa"] . "?"
    . "cod_pedido=$cod_pedido"
    . "&importe=$importe"
    . "&estado=$pago"
    . "&cod_operacion=" . rand();

/* file_get_contents puede hacer peticiones http get sencillas.
   Interacciones más complejas requerirían otra estrategia
 */
$pingback_response = file_get_contents($url);


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
    <h3 class="bordered">El resultado de la operación ha sido <?=$pago?></h3>
<hr>
En este punto, la pasarela informa al usuario del estado del pago, e informa también mediante
una comunicación http al servidor de la tienda del estado del pago, usando la api pactada<br>
Al final de la página hay un botón que llevará de nuevo al cliente a la tienda.
<hr>        
    La peticción http get enviada al servidor de la tienda:
    <code>
        <pre><?= $url ?></pre></code>
    La respuesta del servidor de la tienda:
    <code>
        <pre><?= htmlspecialchars($pingback_response) ?></pre></code>

    <br>
    <br>
    <a class="button" href="<?= $comercio["url_retorno"] . '?cod_pedido=' . $cod_pedido?>">Volver a la tienda</a>
    </form>
</body>

</html>
