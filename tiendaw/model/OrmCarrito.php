<?php
namespace model;
use \dawfony\Klasto;

class OrmCarrito {

    public function estaEnElCarrito($user, $id_articulo) {
        $bd = Klasto::getInstance();
        $params = [$user, $id_articulo];
        $sql = "SELECT id_articulo FROM carro WHERE usuario = ? AND id_articulo = ?";
        if ($bd->queryOne($sql, $params)) {
            return true;
        } else {
            return false;
        }
    }

    public function annadirAlCarrito($user, $id_articulo) {
        $bd = Klasto::getInstance();
        $params = [$user, $id_articulo];
        $sql = "INSERT INTO carro(usuario, id_articulo, cantidad) VALUES(?, ?, 1)";
        return $bd->execute($sql, $params);
    }

    public function contarArticulosCarrito($user) {
        $params = [$user];
        $sql = "SELECT COUNT(*) as cuenta FROM carro WHERE usuario = ?";
        return Klasto::getInstance()->queryOne($sql, $params)["cuenta"];
    }

    public function obtenerArticulos($user) {
        $bd = Klasto::getInstance();
        $params = [$user];
        $sql = "SELECT carro.id_articulo, articulos.nombre, carro.cantidad, articulos.precio
        FROM carro
        INNER JOIN articulos ON carro.id_articulo = articulos.id_articulo 
        WHERE carro.usuario = ?";
        return $bd->query($sql, $params, "model\ArticuloCarro");
    }

    public function obtenerArticulo($user, $id_articulo) {
        $bd = Klasto::getInstance();
        $params = [$user, $id_articulo];
        $sql = "SELECT carro.id_articulo, articulos.nombre, carro.cantidad, articulos.precio
        FROM carro
        INNER JOIN articulos ON carro.id_articulo = articulos.id_articulo 
        WHERE carro.usuario = ? AND carro.id_articulo = ?";
        return $bd->queryOne($sql, $params, "model\ArticuloCarro");
    }  
    
    public function obtenerCosteCarrito($articulos = null, $user = null) {
        if ($articulos == null) {
            $articulos = $this->obtenerArticulos($user);
        }
        $precioTotal = 0;
        foreach ($articulos as $articulo) {
            $precioTotal += $articulo->obtenerPrecioTotal();
        }
        return $precioTotal;
    }

    public function aumentarCantidad($user, $id_articulo, $cantidad) {
        $bd = Klasto::getInstance();
        $params = [$cantidad, $user, $id_articulo];
        $sql = "UPDATE carro SET cantidad = ? WHERE usuario = ? AND id_articulo = ?";
        return $bd->execute($sql, $params);
    }

    public function eliminarArticulo($user, $id_articulo) {
        $bd = Klasto::getInstance();
        $params = [$user, $id_articulo];
        $sql = "DELETE FROM carro WHERE usuario = ? AND id_articulo = ?";
        return $bd->execute($sql, $params);
    }

    public function vaciarCarrito($user) {
        $bd = Klasto::getInstance();
        $params = [$user];
        $sql = "DELETE FROM carro WHERE usuario = ?";
        return $bd->execute($sql, $params);
    }
}