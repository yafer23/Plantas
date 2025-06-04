<?php

class MetodosController extends AppController{
    public function index(){
        //retorna todos los registros
        $this->metodos= (new metodos_pago())->find();

    }

    public function show($id){
        //retorna un solo registro
        $this->metodo = (new metodos_pago())->find($id);
    }
}