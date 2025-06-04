<?php

class PagosItems extends ActiveRecord {

    public function initialize() {
        $this->belongs_to('venta', 'model: Ventas', 'fk: venta_id');
    }

}
