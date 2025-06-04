<?php

class Ventas extends ActiveRecord{
    public function initialize() {
        /*
        * Nombre de la relacion
        * Nombre de la clase del modelo con quien se relaciona
        * Nombre de la columna de relacion
        * getVendedor
        */

        $this->has_many('pagos', 'model: metodos_pago', 'fk: metodos_pago_id');
        $this->has_many('empleado', 'model: Empleados', 'fk: empleados_id');

        $this->belongs_to('vendedor', 'model: Empleados', 'fk: empleados_id');
        $this->belongs_to('metodo', 'model: metodos_pago', 'fk: metodos_pago_id');

        $this->belongs_to('cliente', 'model: Clientes', 'fk: clientes_id');

        $this->has_many('Items', 'model: detalles_ventas', 'fk: ventas_id');
        $this->has_many('abonos', 'model: PagosItems', 'fk: venta_id');
    }

    public function getItems() {
        // Obtiene todos los items asociados a esta venta
        return (new detalles_ventas())->find("conditions: ventas_id = {$this->id}");
    }

//    public function get_carrito($cliente_id){
//        return (new Ventas())->find("conditions: clientes_id = {$cliente_id} AND status = 'carrito'")[0];
//    }
    public function get_carrito($cliente_id){
        $ventas = (new Ventas())->find("conditions: clientes_id = {$cliente_id} AND status = 'carrito'");
        return count($ventas) > 0 ? $ventas[0] : null;
    }


    public function crear($cliente_id){
        $venta = (new Ventas());
        $venta->clientes_id = $cliente_id;
        $venta->status = "carrito";
        $venta->total       = 0;
        $venta->por_pagar   = 0;
        $venta->save();
        return $venta;
    }

    public function add_item($producto, $cantidad) {
        if ($this->status === "carrito") {
            $cantidad = (int)$cantidad; // ← fuerza que sea entero

            // Verificar si ya existe ese producto en esta venta
            $item = (new detalles_ventas())->find_first("ventas_id = {$this->id} AND productos_id = {$producto->id}");

            if ($item) {
                $item->cantidad += $cantidad;
                $item->importe = $item->cantidad * $item->unitario;
            } else {
                $item = new detalles_ventas();
                $item->ventas_id = $this->id;
                $item->productos_id = $producto->id;
                $item->cantidad = $cantidad;
                $item->unitario = $producto->precio;
                $item->descuento = 0.00;
                $item->importe = $cantidad * $producto->precio;
            }

            $item->save();
        }
    }

//    public function set_finalizar(){
//        $this->activo = false;
//        $this->status = "finalizada";
//        if ($this->forma_pago === "PPD"){
//            $this->por_pagar = $this->total;
//        }
//
//        $this->set_total(); // esto ya hace save()
//        if ($this->forma_pago === "PPD") {
//            $this->por_pagar = $this->total;
//        }
//        $this->getCliente()->update_credito();
//        $this->save(); // guarda por_pagar y status finalizada
//    }



    // Valida que el credito de la venta sea suficiente
    // PUE: Contado  PPD: Credito
    public function venta_valida(){
        if($this->forma_pago === "PPD"){
            $credito_suficiente = ($this->total < $this->getCliente()->credito) ? 1 : 0;
            return $credito_suficiente;
        }
        return true;
    }

    public function set_total(){
        //   $this->total = $this->getItems()->sum('importe');
        $this->total =(new detalles_ventas())->sum("importe", "conditions: ventas_id = {$this->id}");
//        $this->save();
    }

    public function set_finalizar(){
        $this->set_total(); // Calcular antes de guardar

        if ($this->forma_pago === "PPD"){
            $this->por_pagar = $this->total;
        }
        $this->status = "finalizada";

        $st = $this->save();
    }

    public function por_pagar($cliente_id){
        return (new Ventas())->find("clientes_id = {$cliente_id}
                                          AND por_pagar > 0
                                          AND status = 'finalizada'
                                          ");
    }

    public function getCantidadProductos() {
        return (new detalles_ventas())->sum('cantidad', "conditions: ventas_id = {$this->id}");
    }

    public function getDetalles() {
        return (new detalles_ventas())->find("conditions: ventas_id = {$this->id}");
    }





}