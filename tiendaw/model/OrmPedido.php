<?php
namespace model;
use \dawfony\Klasto;

class OrmPedido {

    public function obtenerIdUltimoPedido($cliente) {
        $bd = Klasto::getInstance();
        $sql = "SELECT id_pedido FROM pedidos WHERE cliente = ? ORDER BY fecha DESC LIMIT 1";
        $params = [$cliente];
        return $bd->queryOne($sql, $params)["id_pedido"];
    }

    public function articulosPorPedido($articulos, $id_pedido) {
        $bd = Klasto::getInstance();
        foreach ($articulos as $articulo) {
            $sql = "INSERT INTO articulosxpedido(id_articulo, id_pedido, cantidad) VALUES(?, ?, ?)";
            $params = [$articulo->id_articulo, $id_pedido, $articulo->cantidad];
            $bd->execute($sql, $params);
        }
    }

    public function hacerPedido($articulos, $cliente, $coste) {
        $bd = Klasto::getInstance();
        $bd->startTransaction();
        $fecha = date('Y-m-d H:i:s');
        $params = [$cliente, $coste, $fecha];
        $sql = "INSERT INTO pedidos(cliente, preciototal, fecha, esta_pagado) VALUES(?, ?, ?, 0)";
        $bd->execute($sql, $params);
        $id_pedido = $this->obtenerIdUltimoPedido($cliente);
        $this->articulosPorPedido($articulos, $id_pedido);
        $bd->commit();
        return $id_pedido;
    }

    public function actualizarInformacion($estado, $id_pedido) {
        $bd = Klasto::getInstance();
        switch ($estado) {
            case "ok":
                $cod = 1;
                break;
            case "nook":
                $cod = 2;
                break;
            default:
                $cod = 0;
        }
        $sql = "UPDATE pedidos SET esta_pagado = ? WHERE id_pedido = ?";        
        $params = [$cod, $id_pedido];
        $bd->execute($sql, $params);
    }

    public function obtenerEstado($cliente) {
        $bd = Klasto::getInstance();
        $sql = "SELECT esta_pagado FROM pedidos WHERE cliente = ? ORDER BY fecha DESC LIMIT 1";
        $params = [$cliente];
        return $bd->queryOne($sql, $params)["esta_pagado"];
    }

    private function eliminarArticulosxpedido($id_pedido) {
        $bd = Klasto::getInstance();
        $sql = "DELETE FROM articulosxpedido WHERE id_pedido = ?";
        $params = [$id_pedido];
        $bd->execute($sql, $params);
    }

    public function eliminarPedido($cliente) {
        $bd = Klasto::getInstance();
        $id_pedido = $this->obtenerIdUltimoPedido($cliente);
        $this->eliminarArticulosxpedido($id_pedido);
        $params = [$id_pedido];
        $sql = "DELETE FROM pedidos WHERE id_pedido = ?";
        $bd->execute($sql, $params);
    }
}