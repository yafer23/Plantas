<?php

class ClientesController extends AppController{
    public function index(){
        //retorna todos los registros
        $this->clientes = (new Clientes())->find();

    }

    public function show($id){
        //retorna un solo registro
        $this->cliente = (new Clientes())->find($id);
        //traer ventas
        $this->ventas = (new Ventas())->find("conditions: clientes_id = $id");
    }

    public function registrar(){
        // Preguntar si se envió el formulario
        if(Input::hasPost('cliente')) {
            $cliente = new Clientes(Input::post('cliente'));

            if ($cliente->saveWithImagen(Input::post('cliente'))) {
                Flash::valid("<script>
                Swal.fire({
                    icon: 'success',
                    title: '¡Éxito!',
                    text: 'Cliente registrado correctamente',
                    confirmButtonColor: '#28a745'
                });
            </script>");
                Input::delete();
            } else {
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