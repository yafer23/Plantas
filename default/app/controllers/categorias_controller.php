<?php

class CategoriasController extends AppController{
    public function index(){
        //retorna todos los registros
        $this->categorias = (new Categorias())->find();
    }

    public function show($id){
        //retorna un solo registro
        $this->categoria = (new Categorias())->find($id);
    }
}