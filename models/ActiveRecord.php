<?php

namespace Model;

class ActiveRecord{
// BASE DE DATOS

    protected static $db;
    protected static $columnasDB = [];

    protected static $tabla = '';
    // ERRORES
    protected static $errores = [];

    // Definir la conexion a la BD

    public static function setDB($database)
    {
        self::$db = $database;
    }

   

    public function guardar()
    {
        // Condición para crear un nuevo objeto
        if (isset($this->id) && $this->id != '') {
            // actualizar
            $this->actualizar();
        } else {
            // creando un nuevo registro
            $this->crear();
        }
    }

    public function crear()
    {
        // SANITIZAR LOS DATOS

        $atributos = $this->sanitizarAtributos();

        /* $string = join(',', array_keys($atributos));
        $string = join(',', array_values($atributos)); */

        // INSERTAR EN LA BASE DE DATOS

        $query = ' INSERT INTO '. static::$tabla.' ( ';
        $query .= join(', ', array_keys($atributos));
        $query .= " ) VALUES (' ";
        $query .= join("', '", array_values($atributos));
        $query .= " ') ";

        $resultado = self::$db->query($query);

        if ($resultado)
            // redireccionar al usuario6
            header('Location: /admin?resultado=1');
    }

    public function actualizar()
    {
        // Sanitizar los datos

        $atributos = $this->sanitizarAtributos();

        $valores = [];

        foreach ($atributos as $key => $value) {
            $valores[] = "{$key}='{$value}'";
        }

        $query = 'UPDATE '. static::$tabla.' SET ';
        $query .= join(', ', $valores);
        $query .= " WHERE id = '" . self::$db->escape_string($this->id) . "' ";
        $query .= ' LIMIT 1 ';

        $resultado = self::$db->query($query);

        if ($resultado) {
            // redireccionar al usuario6
            header('Location: /admin?resultado=2');
        }
    }

    //ELIMINAR UN REGISTRO 

    public function eliminar(){
       
        $query = "DELETE FROM ". static::$tabla. " WHERE id =  ". self::$db->escape_string($this->id) . " LIMIT 1";
        $resultado = self::$db->query($query);

        if ($resultado){

            $this->borrarImagen();
            header('location: /admin?resultado=3');
        }
    }




    // Identificar y unir los atributos de la    BD
    public function atributos()
    {
        $atributos = [];
        foreach (static::$columnasDB as $columna) {
            if ($columna === 'id')
                continue;
            $atributos[$columna] = $this->$columna;
        }

        return $atributos;
    }

    public function sanitizarAtributos()
    {
        $atributos = $this->atributos();
        $sanitizado = [];

        foreach ($atributos as $key => $value) {
            $sanitizado[$key] = self::$db->escape_string($value);
        }
        return $sanitizado;
    }

    // SUBIDA DE ARCHIVOS IMAGEN

    public function setImagen($imagen)
    {
        // Elimina la imagen previa
        if (isset($this->id)) {
            // Comprobar si existe el archivo
           $this->borrarImagen();
            }
        
        // Asignar al atributo de imagen el nombre de la imagen
        if ($imagen) {
            $this->imagen = $imagen;
        }
    }

    //ELIMINAR ARCHIVO

    public function borrarImagen(){

         $existeArchivo = file_exists(CARPETA_IMAGENES . $this->imagen);
            if ($existeArchivo) {
                unlink(CARPETA_IMAGENES . $this->imagen);
    }
 }

    // VALIDACIÓN

    public static function getErrores()
    {
        return static::$errores;
    }

    public function validar()
    {

        static::$errores = [];
        return static::$errores;
    }

    // Lista todas las propiedades

    public static function all()
    {
        $query = "SELECT*FROM " . static::$tabla;

       
        $resultado = self::consultarSQL($query);
        return $resultado;
    }


    //Obtiene determinado número de registros
    public static function get($cantidad)
    {
        $query = "SELECT*FROM " . static::$tabla. " LIMIT " . $cantidad;

       
        $resultado = self::consultarSQL($query);
        return $resultado;
    }



    // Buscar un registro por su ID
    public static function find($id)
    {
        $query = "SELECT*FROM " .static::$tabla." WHERE id = $id";

        $resultado = self::consultarSQL($query);

        return array_shift($resultado);
    }

    public static function consultarSQL($query)
    {
        // CONSULTAR LA BASE DE DATOS
        $resultado = self::$db->query($query);

        // ITERAR LOS RESULTADOS
        $array = [];
        while ($registro = $resultado->fetch_assoc()) {
            $array[] = static::crearObjeto($registro);
        }
        // LIBERAR LA MEMORIA

        $resultado->free();

        // RETORNAR LOS RESULTADOS

        return $array;
    }

    protected static function crearObjeto($registro)
    {
        $objeto = new static;

        foreach ($registro as $key => $value) {
            if (property_exists($objeto, $key)) {
                $objeto->$key = $value;
            }
        }
        return $objeto;
    }

    // sincroniza el objeto en memoria con los cambios realizados por el usuario

    public function sincronizar($args = [])
    {
        foreach ($args as $key => $value) {
            if (property_exists($this, $key) && !is_null($value)) {
                $this->$key = $value;
            }
        }
    }

}