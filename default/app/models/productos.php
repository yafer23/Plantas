<?php

class Productos extends ActiveRecord{
    public function initialize() {
        $this->validates_presence_of("nombre", [
            "message" => "Debes ingresar un nombre"
        ]);

        $this->validates_length_of("nombre", "in: 5:40", [
            "too_short" => "El nombre debe tener al menos 5 caracteres",
            "too_long" => "El nombre debe tener máximo 40 caracteres"
        ]);

        $this->validates_numericality_of("precio");
        $this->validates_numericality_of("stock");
    }
}