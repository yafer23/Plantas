<?php
// app/models/usuarios.php
class Usuarios extends ActiveRecord
{

    public function initialize()
    {
        $this->validates_email_in("email");

    }
}