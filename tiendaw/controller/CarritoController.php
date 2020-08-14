<?php
namespace controller;
use \model\OrmCarrito;
class CarritoController extends Controller {

    public function carrito() {
        $orm = new OrmCarrito;
        $user = $_COOKIE["PHPSESSID"];
        $title = "TienDAW";
        $comprando = false;
        $articulos = $orm->obtenerArticulos($user);
        $costeCarrito = $articulos == null? 0 : $orm->obtenerCosteCarrito($articulos);        
        $numeroArticulos = $orm->contarArticulosCarrito($user);                
        echo \dawfony\Ti::render("view/CarritoView.phtml", compact('title','articulos', 'costeCarrito',
        'user', 'comprando', 'numeroArticulos'));
    }

    
}