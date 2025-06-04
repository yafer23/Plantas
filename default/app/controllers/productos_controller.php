<?php

class ProductosController extends AppController{
    public function index(){
        //retorna todos los registros
        $this->productos = (new Productos())->find();

    }

    public function show($id){
        //retorna un solo registro
        $this->producto = (new Productos())->find($id);
    }

    public function registrar(){
        //Preguntar si se envio el formulario
        if(Input::hasPost('producto')){
            $producto = new Productos(Input::post('producto'));

            //Se crea el registro
            if($producto->create()){
//                Flash::valid("Producto registrado");
                Flash::valid("<script>
                    Swal.fire({
                        icon: 'success',
                        title: '¡Éxito!',
                        text: 'Producto registrado correctamente',
                        confirmButtonColor: '#28a745'
                    });
                </script>");
                Input::delete();
            }else{
//                Flash::error("Producto no registrado");
                Flash::error("<script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'No se pudo registrar el producto. Verifica los datos.',
                        confirmButtonColor: '#d33'
                    });
                </script>");
            }
        }
    }

    public function subir(){
        View::select(null);
        View::template(null);
        echo json_encode($_FILES);
    }





}