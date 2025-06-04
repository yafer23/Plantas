<?php

class Clientes extends ActiveRecord
{

    public function initialize()
    {
        /*
        * Nombre de la relacion
        * Nombre de la clase del modelo con quien se relaciona
        * Nombre de la columna de relacion
        * getVentas
        */
        $this->has_many('ventas', 'model: Ventas', 'fk: clientes_id');

        $this->validates_presence_of("nombre", ["message" => "Debes ingresar un nombre"]);
        $this->validates_presence_of("email", ["message" => "Debes ingresar un correo"]);
        $this->validates_presence_of("telefono", ["message" => "Debes ingresar un correo"]);
    }

    // el credito que tiene
    public function linea_credito()
    {
        return ($this->credito + $this->adeudo);
    }

    public function update_credito()
    {
        $sql = "UPDATE clientes c SET adeudo = (SELECT SUM(por_pagar) 
											FROM ventas v 
											WHERE v.cliente_id = c.id 
													AND por_pagar > 0 
													AND STATUS = 'finalizada') 
						WHERE c.id = {$this->id}";
        (new Clientes())->sql($sql);
    }

    public function saveWithImagen($data)
    {
        //Inicia la transacción
        $this->begin();
        //Intenta crear el usuario con los datos pasados
        if ($this->save($data)) {
            //Intenta subir y actualizar la foto
            if ($this->updateImagen()) {
                //Se confirma la transacción
                $this->commit();
                return true;
            }
        }

        //Si algo falla se regresa la transacción
        $this->rollback();
        return false;
    }

    /**
     * Sube y actualiza la foto del usuario.
     *
     * @return boolean|null
     */
    public function updateImagen() {
        //Intenta subir la foto que viene en el campo 'imagen'
        if ($imagen = $this->uploadImagen('image')) {
            //Modifica el campo photo del usuario y lo intenta actualizar
            $this->imagen = $imagen;
            return $this->update();
        }
    }

    /**
     * Sube la foto y retorna el nombre del archivo generado.
     *
     * @param string $imageField Nombre de archivo recibido por POST
     * @return string|false
     */
    public function uploadImagen($imageField){
        //Usamos el adapter 'image'
        $file = Upload::factory($imageField, 'image');
        //le asignamos las extensiones a permitir
        $file->setExtensions(array('jpg', 'png', 'gif', 'jpeg'));
        $file->setPath('img/clientes');

        if (!is_writable('img/clientes')) {
            Flash::error('La carpeta img/clientes no tiene permisos de escritura.');
            return false;
        }

        //Intenta subir el archivo
        if ($file->isUploaded()) {
            //Lo guarda usando un nombre de archivo aleatorio y lo retorna.
            return $file->saveRandom();

            //Guardar con nombre de cliente
        }
        //Si falla al subir
        return false;
    }
}
