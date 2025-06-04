<?php

class formbs{
    protected static function attrsdefaut($attrs, $defaults)
    {
        foreach ($defaults as $k => $v) {
            if (isset($attrs[$k])) {
                if (strpos($attrs[$k], $v) === false) {
                    $attrs[$k] .= ' '.$v;
                }
            } else {
                $attrs[$k] = $v;
            }
        }
        return $attrs;
    }

    //echo Formbs::btn_regresar();
    public static function btn_regresar($text = "Regresar", $attrs = []) {
        $text = " " . $text;
        $attrs = Formbs::attrsdefaut($attrs, ["class" => "btn btn-outline-success", "onclick" => "window.history.back(); return false;"]);
        return Form::button($text, $attrs);
    }

    // Formbs::btn_aceptar("Guardar")
    public static function btn_aceptar($text = "Guardar", $attrs = []){
        $text = " ".$text;
        $attrs = Formbs::attrsdefaut($attrs, ["class" => "btn btn-success"]);
        return Form::submit($text, $attrs);
    }

    //echo Formbs::btn_cancelar();
    public static function btn_cancelar($text = "Cancelar", $attrs = []) {
        $text = " " . $text;
        $attrs = Formbs::attrsdefaut($attrs, ["class" => "btn btn-danger"]);
        return Form::submit($text, $attrs);
    }

    //echo Formbs::btn_limpiar();
    public static function btn_limpiar($text = "Limpiar", $attrs = []) {
        $text = " " . $text;
        $attrs = Formbs::attrsdefaut($attrs, ["class" => "btn btn-warning", "type" => "reset"]);
        return Form::reset($text, $attrs);
    }

    //echo Formbs::btn_buscar();
    public static function btn_buscar($text = "Buscar", $attrs = []) {
        $text = "🔍 " . $text;
        $attrs = Formbs::attrsdefaut($attrs, ["class" => "btn btn-info"]);
        return Form::submit($text, $attrs);
    }
    // Input de texto
    //echo Formbs::input_text('nombre');
    public static function input_text($name, $value = "", $attrs = []) {
        $attrs = Formbs::attrsdefaut($attrs, ["class" => "form-control", "placeholder" => "Ingrese texto"]);
        return Form::text($name, $value, $attrs);
    }
    // Input de Correo Electronico
    //echo Formbs::input_email('correo');
    public static function input_email($name, $value = "", $attrs = []) {
        $attrs = Formbs::attrsdefaut($attrs, ["class" => "form-control", "placeholder" => "Ingrese su correo electrónico"]);
        return Form::email($name, $value, $attrs);
    }
    // Input te contraseña
    //echo Formbs::input_password('contrasena');
    public static function input_password($name, $attrs = []) {
        $attrs = Formbs::attrsdefaut($attrs, ["class" => "form-control", "placeholder" => "Ingrese su contraseña"]);
        return Form::password($name, $attrs);
    }

    // Input te fecha
    //echo Formbs::input_date('fecha_nacimiento');
    public static function input_date($name, $value = "", $attrs = []) {
        $attrs = Formbs::attrsdefaut($attrs, ["class" => "form-control", "placeholder" => "Seleccione una fecha"]);
        return Form::date($name, $value, $attrs);
    }

}