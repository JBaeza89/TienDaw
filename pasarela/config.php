<?php
/*
 * Configura esta pasarela ficticia con un código de tienda, y la dirección
 * 
 * En una pasarela bancaria de verdad, nos dan los datos de acceso para nuestra app
 * despues de firmar el contrato e informamos de las URLS con algún tipo de app de configuración.
 */

$comercios = [
    1111 => // El código del comercio
    [
        "nombre" => "Alidaw. Todo barato. Comercio de ejemplo",
        "url_pingback_informa" => "http://localhost/tutienda/informa",
        "url_retorno" => "http://localhost/tutienda/retorno"
    ],
    2222 => // El código del comercio
    [
        "nombre" => "TienDAW",
        "url_pingback_informa" => "http://localhost/tienda/tiendaw/api/informa",
        "url_retorno" => "http://localhost/tienda/tiendaw/carrito/r"
    ], 
    // esa coma tras el último elemento de array no es error sintáctico en PHP7
];
