<?php

class Empleados extends ActiveRecord{

    public function initialize() {
        /*
        * Nombre de la relacion
        * Nombre de la clase del modelo con quien se relaciona
        * Nombre de la columna de relacion
        * getVentas
        */
        $this->has_many('ventas', 'model: Ventas', 'fk: empleados_id');
    }

    public function getEstadisticasVentas() {
        $ventas = (new Ventas())->find("conditions: empleados_id = {$this->id} AND status = 'finalizada'");

        $total = 0;
        $cantidad = count($ventas);

        foreach ($ventas as $venta) {
            $total += $venta->total;
        }

        return [
            'total_compras' => $total,
            'numero_compras' => $cantidad
        ];
    }


}