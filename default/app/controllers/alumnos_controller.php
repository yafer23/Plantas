<?php
class  AlumnosController extends AppController
{
    public function index(){

    }
    public function ver($id = 90){
        $alumnos[80] = "wuicho";
        $alumnos[90] = "wuicho2";
        $this->nombre=$alumnos[$id];

    }
    public function accion(){

    }

}