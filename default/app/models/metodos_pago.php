<?php

class metodos_pago extends ActiveRecord{
    public function initialize() {
        /*
        * Nombre de la relacion
        * Nombre de la clase del modelo con quien se relaciona
        * Nombre de la columna de relacion
        * getVentas
        */
        $this->has_many('ventas', 'model: Ventas', 'fk: metodos_pago_id');
    }
}