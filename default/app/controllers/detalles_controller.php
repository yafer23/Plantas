<?php

class DetallesController extends AppController{
    public function index(){
        //retorna todos los registros
        $this->detalles_ventas= (new detalles_ventas())->find();

    }

    public function show($id){
        //retorna un solo registro
        $this->detalle_venta = (new detalles_ventas())->find($id);
        $this->producto = (new Productos())->find($id);
    }
}