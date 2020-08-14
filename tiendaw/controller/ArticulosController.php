<?php
namespace controller;
use \model\OrmArticulos;
class ArticulosController extends Controller {

    public function listado($page = 1) {
        global $URL_PATH;
        global $config; 
        $user = $_COOKIE["PHPSESSID"];       
        $comprando = true;
        $title = "TienDAW";
        $orm = new OrmArticulos;
        $articulos = $orm->obtenerArticulos($page);
        $numeroArticulos = $orm->totalArticulosCarrito($user);
        $numPaginas = ceil($orm->contarTodosLosArticulos() / $config["obj_per_page"]);
        echo \dawfony\Ti::render("view/ListadoView.phtml", compact('title','articulos', 'numeroArticulos',
        'numPaginas', 'page', 'user', 'comprando'));
    }
}