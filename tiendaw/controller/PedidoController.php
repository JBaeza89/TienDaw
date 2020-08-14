<?php
namespace controller;
use \model\OrmCarrito;
use \model\OrmPedido;
class PedidoController extends Controller {

    public function pedido() {
        global $URL_PATH;
        $cliente = $_POST["nombre"];
        $_SESSION["usuario"] = $cliente;
        $orm = new OrmCarrito;
        $user = $_COOKIE["PHPSESSID"];
        $articulos = $orm->obtenerArticulos($user);
        $coste = $articulos == null? 0 : $orm->obtenerCosteCarrito($articulos); 
        if ($coste == 0) {
            header("Location: $URL_PATH");
            return;
        }
        $orm = new OrmPedido;
        $id_pedido = $orm->hacerPedido($articulos, $cliente, $coste);
        $concepto = "Pago pedido nº $id_pedido";
        header("Location: http://localhost/tienda/pasarela-simulacion/index.php?cod_comercio=2222&cod_pedido=$id_pedido&importe=$coste&concepto=$concepto");
    }

    public function retorno() {
        $orm = new OrmCarrito;
        $user = $_COOKIE["PHPSESSID"];
        $title = "TienDAW";
        $comprando = false;
        $estado = (new OrmPedido)->obtenerEstado($_SESSION["usuario"]);
        if ($estado == 1) {
            $orm->vaciarCarrito($user);
        } else {
            (new OrmPedido)->eliminarPedido($_SESSION["usuario"]);
        }
        $articulos = $orm->obtenerArticulos($user);
        $costeCarrito = $articulos == null? 0 : $orm->obtenerCosteCarrito($articulos);        
        $numeroArticulos = $orm->contarArticulosCarrito($user);        
        echo \dawfony\Ti::render("view/CarritoView.phtml", compact('title','articulos', 'costeCarrito',
        'user', 'comprando', 'numeroArticulos', 'estado'));
    }
}