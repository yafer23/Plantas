<?php

class PagosController extends AppController{
    // Listar los pagos realizados
    public function index(){

    }

    /*
     * /pagos/nuevo                 // Listar los clientes
     * /cliente_id para mostrar ventas adeudadas
     *
     */
    public function nuevo($cliente_id = null) {
        $this->cliente = null;
        $this->ventas = null;
//        $this->clientes = (new Clientes())->find();
        $this->clientes = (new Clientes())->find("id IN (SELECT clientes_id FROM ventas WHERE por_pagar > 0 AND status = 'finalizada')");

        // Si se envía desde el formulario (GET cliente)
        if (Input::hasGet("cliente")) {
            $cliente_id = Input::get("cliente");
            Redirect::toAction("nuevo/{$cliente_id}");
            return;
        }

        // Si se accede directamente por URL con cliente_id
        if ($cliente_id !== null) {
            $this->cliente = (new Clientes())->find($cliente_id);

            if ($this->cliente !== null) {
                $this->ventas = (new Ventas())->por_pagar($cliente_id);

                // Si no tiene ventas pendientes, mostrar flash y regresar
                if (empty($this->ventas)) {
                    Flash::info('<span style="color: #007bff; font-weight: bold;">El cliente <span style="color: #000;">' . $this->cliente->nombre . '</span> no tiene ventas pendientes de pago.</span>');
                    Redirect::toAction("nuevo");
                    return;
                }
            }
        }
    }
    public function finalizar($cliente_id){
        $this->cliente = (new Clientes())->find($cliente_id);
        $ventas = Input::get("ventas");

        $this->ventas_a_pagar = [];
        $this->total_a_abonar = 0;

        foreach ($ventas as $venta_id => $monto) {
            if (is_numeric($monto) && $monto > 0) {
                $venta = (new Ventas())->find($venta_id);
                if (!$venta) continue;

                $antes = $venta->por_pagar;
                $abono = min($monto, $antes); // Nunca pagar más de lo adeudado
                $adeudo = $antes - $abono;

                // Registrar en pagos_items
                $pago_item = new PagosItems();
                $pago_item->pago_id = null; // Si tienes un ID de pago general, colócalo aquí
                $pago_item->venta_id = $venta_id;
                $pago_item->antes = $antes;
                $pago_item->monto_pagado = $abono;
                $pago_item->adeudo = $adeudo;
                $pago_item->save();

                // Actualizar la venta
                $venta->por_pagar = $adeudo;
                $venta->save();

                // Para mostrar en la vista
                $venta->a_abonar = $abono;
                $this->total_a_abonar += $abono;
                $this->ventas_a_pagar[] = $venta;
            }
        }

        // Registrar en pagos
        $pagos = new Pagos();
        $pagos->cliente_id = $cliente_id;
        $pagos->metodo_pago_id = 1;
        $pagos->total = $this->total_a_abonar;
        $pagos->save();

//        Flash::info("<script>
//                Swal.fire({
//                    toast: false,          // centrado
//                    position: 'center',    // posición centrada
//                    icon: 'success',
//                    title: '¡Abono registrado con éxito!',
//                    showConfirmButton: false,
//                    timer: 2000,
//                    timerProgressBar: true,
//                    background: 'rgba(40,167,69,0.8)', // verde con transparencia
//                    color: 'white'
//                });
//            </script>");
//
//        return Redirect::toAction("nuevo/{$cliente_id}"); // o a donde quieras mostrar el mensaje

        $this->mostrar_alerta = true; // Para usarlo en la vista


    }


}