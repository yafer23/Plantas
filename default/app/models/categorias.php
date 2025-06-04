<?php

class Categorias extends ActiveRecord{

    public function getProductos() {
        $producto = new Productos();
        return $producto->find("categorias_id = $this->id");
    }


}