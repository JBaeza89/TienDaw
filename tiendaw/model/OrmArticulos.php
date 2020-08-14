<?php
namespace model;
use \dawfony\Klasto;


class OrmArticulos {
    
    public function obtenerArticulos($page) {
        global $config;
        $limit = $config["obj_per_page"];
        $offset = ($page -1) * $limit;
        $articulos = Klasto::getInstance()->query(
            "SELECT `id_articulo`, `nombre`, `descripcion`, `precio`, `imagen`"
                . " FROM `articulos`"
                . " ORDER BY `precio` ASC"
                . " LIMIT $limit OFFSET $offset",
            [],
            "model\Articulo"
        );
        return $articulos;
    }

    public function obtenerArticulo($id_articulo) {
        $bd = Klasto::getInstance();
        $params = [$id_articulo];
        $sql = "SELECT descripcion, nombre FROM articulos WHERE id_articulo = ?";
        return $bd->queryOne($sql, $params);
    }

    public function contarTodosLosArticulos() {
        return Klasto::getInstance()->queryOne("SELECT count(*) as cuenta FROM `articulos`")["cuenta"];
    }

    public function totalArticulosCarrito($user) {
        $params = [$user];
        $sql = "SELECT COUNT(*) as cuenta FROM carro WHERE usuario = ?";
        return Klasto::getInstance()->queryOne($sql, $params)["cuenta"];
    }
}