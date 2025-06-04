<?php

class detalles_ventas extends ActiveRecord{

    public function initialize(){
        $this->belongs_to('Venta', 'model: Ventas', 'fk: ventas_id');
        $this->belongs_to('producto', 'model: Productos', 'fk: productos_id');
    }

    public function after_save(){
        $this->getVenta()->set_total();
    }

    public function before_save(){
        $producto = (new Productos())->find($this->productos_id);
        $this->importe = $this->unitario * $this->cantidad;
        $this->descripcion = $producto->nombre;
    }


}