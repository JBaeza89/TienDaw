<?php
require 'vendor/autoload.php';
require 'cargarconfig.php';

use NoahBuscher\Macaw\Macaw;

session_start();

Macaw::get($URL_PATH . '/', "controller\ArticulosController@listado");

Macaw::get($URL_PATH . '/(:any)', "controller\ArticulosController@listado");

Macaw::get($URL_PATH . '/api/descripcion/(:any)', "controller\ApiController@descripcion");

Macaw::get($URL_PATH . '/api/carrito/(:any)/(:any)', "controller\ApiController@carrito");

Macaw::get($URL_PATH . '/carrito', "controller\CarritoController@carrito");

Macaw::get($URL_PATH . '/api/aumentar/(:any)/(:any)', "controller\ApiController@aumentado");

Macaw::get($URL_PATH . '/api/eliminar/(:any)/(:any)', "controller\ApiController@eliminado");

Macaw::post($URL_PATH . '/pedido', "controller\PedidoController@pedido");

Macaw::get($URL_PATH . '/api/informa', "controller\ApiController@informa");

Macaw::get($URL_PATH . '/carrito/r', "controller\PedidoController@retorno");


Macaw::error(function () {
    echo '404 :: Not Found';
});

Macaw::dispatch();
