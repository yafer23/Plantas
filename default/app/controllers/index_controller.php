<?php

/**
 * Controller por defecto si no se usa el routes
 *
 */
class IndexController extends AppController{

    public function index(){
        $this -> title = "Inicio";
        $this -> subtitle = "Dashboard";

    }
}
