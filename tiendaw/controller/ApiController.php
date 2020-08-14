<?php

namespace controller;

use \model\OrmArticulos;
use \model\OrmCarrito;
use \model\OrmPedido;

class ApiController extends Controller
{

    public function descripcion($id_articulo)
    {
        header('Content-type: application/json');
        $orm = new OrmArticulos;
        $articulo = $orm->obtenerArticulo($id_articulo);
        echo json_encode($articulo);
    }

    public function carrito($user, $id_articulo)
    {
        header('Content-type: application/json');
        $orm = new OrmCarrito;
        $res["estabaAnnadido"] = $orm->estaEnElCarrito($user, $id_articulo);
        if (!$res["estabaAnnadido"]) {
            $orm->annadirAlCarrito($user, $id_articulo);
        }
        $res["cuenta"] = $orm->contarArticulosCarrito($user);
        echo json_encode($res);
    }

    public function aumentado($user, $id_articulo)
    {
        header('Content-type: application/json');
        $orm = new OrmCarrito;
        $articulo = $orm->obtenerArticulo($user, $id_articulo);
        $articulo->cantidad++;
        $orm->aumentarCantidad($user, $id_articulo, $articulo->cantidad);
        $res = [
            "cantidad" => $articulo->cantidad, "precio" => number_format($articulo->obtenerPrecioTotal() / 100, 2),
            "total" => number_format($orm->obtenerCosteCarrito(null, $user) / 100, 2)
        ];
        echo json_encode($res);
    }

    public function eliminado($user, $id_articulo)
    {
        header('Content-type: application/json');
        $orm = new OrmCarrito;
        $orm->eliminarArticulo($user, $id_articulo);
        $res["cuenta"] = $orm->contarArticulosCarrito($user);
        $res["total"] = number_format($orm->obtenerCosteCarrito(null, $user) / 100, 2);
        echo json_encode($res);
    }

    public function informa()
    {
        header('Content-type: application/json');
        $orm = new OrmPedido;
        $id_pedido = $_REQUEST["cod_pedido"];
        $importe = $_REQUEST["importe"];
        $estado = $_REQUEST["estado"];
        $cod_operacion = $_REQUEST["cod_operacion"];
        $orm->actualizarInformacion($estado , $id_pedido);
        $msg = "Servidor de la tienda informado";
        echo json_encode($msg);
    }
}
