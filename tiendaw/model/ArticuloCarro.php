<?php
namespace model;
class ArticuloCarro {

    public $id_articulo;
    public $nombre;
    public $cantidad;
    public $precio;
    
    public function obtenerPrecioTotal() {
        return $this->cantidad * $this->precio;
    }
}