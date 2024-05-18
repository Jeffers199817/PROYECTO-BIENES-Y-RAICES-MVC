<?php

namespace Model;
class Vendedor extends ActiveRecord{
protected static $tabla = 'vendedores';
  protected static $columnasDB = ['id', 'nombre', 'apellido', 'telefono'];


    public $id;
    public $nombre;
    public $apellido;
    public $telefono;

  
     public function __construct($args = [])
    {
        $this->id = $args['id'] ?? '';
        $this->nombre = $args['nombre'] ?? '';
        $this->apellido = $args['apellido'] ?? '';
        $this->telefono = $args['telefono'] ?? '';
       
    }

  public function validar()
  {
    if (!$this->nombre) {
      self::$errores[] = 'El nombre es obligatorio';
    }
    if (!$this->apellido) {
      self::$errores[] = 'El apellido es obligatorio';
    }
    if (!$this->telefono) {
      self::$errores[] =  "El teléfono es obligatorio y debe tener al menos 10 números";
    }else if(!preg_match('/^[0-9]{10}$/',$this->telefono)){
      self::$errores[] = 'No es un número de teléfono válido, debe tener 10 números';
    }

    return self::$errores;
  }

}