<?php

class VentasController extends AppController {

    public function index() {
        // Retorna todos los registros de ventas
        $this->ventas = (new Ventas())->find();
    }

    public function show($id) {
        // Retorna una sola venta
        $this->venta = (new Ventas())->find($id);

        // Cargar el cliente
        $cliente = (new Clientes())->find($this->venta->clientes_id);
        $this->venta->cliente_nombre = $cliente ? $cliente->nombre : 'Desconocido';

        // Cargar el metodo de pago asociado
        $metodoPago = (new metodos_pago())->find($this->venta->metodos_pago_id);
        $this->venta->metodo_pago_nombre = $metodoPago ? $metodoPago->nombre : 'No registrado';
    }

    /*
     * cliente = X (selección de cliente)
     */
    public function nueva($cliente_id = null) {
        // Obtener CLIENTES, PRODUCTOS y METODOS de la base de datos
        $this->clientes     = (new Clientes())->find();
        $this->productos    = (new Productos())->find();
        $this->metodos_pago = (new metodos_pago())->find();
        $this->cliente      = null;
        $this->venta        = null;
        $this->items        = [];

        // Si no se ha recibido el ID del cliente
        if (!$cliente_id && Input::hasGet("cliente")) {
            // Ir a "nueva" con el cliente especificado en el parámetro GET
            return Redirect::toAction("nueva/" . Input::get("cliente"));
        }
        // Si no se ha recibido el ID del cliente y se ha enviado un cliente desde form (POST)
        if (!$cliente_id && Input::hasPost("cliente_id")) {
            // Asignar el ID del cliente enviado por POST a la variable $cliente_id
            $cliente_id = Input::post("cliente_id");
        }
        // Si aún no hay ID de cliente, termina la ejecución para mostrar el selector de cliente
        if (!$cliente_id) {
            return; // Muestra el select de cliente
        }

        // Cargar la información del cliente con el ID del select
        $this->cliente = (new Clientes())->find($cliente_id);
        $vm = new Ventas(); // Obtener el carrito de ese cliente, o crear uno nuevo si no existe
        $this->venta  = $vm->get_carrito($cliente_id) ?: $vm->crear($cliente_id);
        // Obtener los items de la venta
        $this->items  = $this->venta->getItems();


        // Post para AGREGAR PRODUCTO
        if (isset($_POST["agregar_producto"])) {
            $p = (new Productos())->find(Input::post("producto_id"));
            $c = (int) Input::post("cantidad");
            $this->venta->add_item($p, $c);

            Flash::info("<script>
                Swal.fire({
                    toast: false,          // centrado
                    position: 'center',    // posición centrada 
                    icon: 'success',
                    title: 'Producto agregado al carrito',
                    showConfirmButton: false,
                    timer: 2000,
                    timerProgressBar: true,
                    background: 'rgba(40,167,69,0.8)', // verde con transparencia
                    color: 'white'
                });
            </script>");

            return Redirect::toAction("nueva/{$cliente_id}");
        }

        // Post para GUARDAR VENTA
        if (isset($_POST["guardar_venta"])) {

            // Validación para que se haya elegido un metodo de pago
            $mpId = Input::post("metodo_pago_id");
            if (!$mpId) {
                Flash::error("Selecciona un método de pago.");
                return;
            }
            $m = (new metodos_pago())->find($mpId);
            if (!$m) {
                Flash::error("Método de pago inválido.");
                return;
            }

            // Mapeo “nombre” -> PUE o PPD (Según el select del formulario)
            $map = [
                'Efectivo' => 'PUE',
                'Credito' => 'PPD',
            ];

            // Asignar los campos sobre el objeto $this->venta
            $this->venta->metodos_pago_id = $mpId;

            // Si el metodo de pago no está en el array, 'PUE' por defecto
            $this->venta->forma_pago = $map[ $m->nombre ] ?? 'PUE';

            $this->venta->set_finalizar();
            Flash::valid("<script>
                Swal.fire({
                    icon: 'success',
                    title: '¡Éxito!',
                    text: 'Venta guardada correctamente.',
                    confirmButtonColor: '#28a745'
                });
            </script>");

            // Redirige a la vista (Ticket de esa venta)
            return Redirect::toAction("show/{$this->venta->id}");
        }
    }






}
