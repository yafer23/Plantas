<?php

class EmpleadosController extends AppController{
    public function index(){
        //retorna todos los registros
        $this->empleados = (new Empleados())->find();
    }

    // Retorna un solo registro
    public function show($id) {
        // Encuentra al empleado
        $empleado = (new Empleados())->find_first($id);

        if (!$empleado) {
            Flash::error("Empleado no encontrado");
            return Redirect::to("empleados/");
        }

        // Calcular estadísticas
        $estadisticas = $empleado->getEstadisticasVentas();

        // Enviar datos a la vista
        $this->empleado = $empleado;
        $this->estadisticas = $estadisticas;
    }

    public function registrar(){
        //Preguntar si se envio el formulario
        if(Input::hasPost('cliente')){
            $cliente = new Clientes(Input::post('cliente'));

            //Se crea el registro
            if($cliente->create()){
//                Flash::valid("Cliente registrado");
                Flash::valid("<script>
                    Swal.fire({
                        icon: 'success',
                        title: '¡Éxito!',
                        text: 'Cliente registrado correctamente',
                        confirmButtonColor: '#28a745'
                    });
                </script>");
                Input::delete();
            }else{
//                Flash::error("Cliente no registrado");
                Flash::error("<script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'No se pudo registrar el cliente. Verifica los datos.',
                        confirmButtonColor: '#d33'
                    });
                </script>");
            }
        }
    }
}