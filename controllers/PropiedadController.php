<?php

namespace Controllers;

use MVC\Router;
use Model\Propiedad;
use Model\Vendedor;
use Intervention\Image\ImageManagerStatic as Image;

class PropiedadController{


    public static function index(Router $router){

        $propiedades = Propiedad::all();
        //Muestra un mensaje condicional
        $resultado = $_GET['resultado'] ?? null;

        $router->render('/propiedades/admin',[
            'propiedades'=>$propiedades,
            'resultado' =>$resultado
            
            ]) ;
    }



    public static function crear(Router $router){
        $propiedad = new Propiedad();    
        $vendedores = Vendedor::all();

        //Arreglo con mensajes de errores

        $errores = Propiedad::getErrores() ;

        
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Crea una instancia de Propiedad
    $propiedad = new Propiedad($_POST['propiedad']);

    // SUBE LOS ARCHIVOS

    // Generar un nombre único

    $nombreImagen = md5(uniqid(rand(), true)) . ".jpg";

    // SETEA LA IMAGEN

    // REALIZA UN RESIXE CON INTERFECTION IMAGE
    if ($_FILES['propiedad']['tmp_name']['imagen']) {
        $image = Image::make($_FILES['propiedad']['tmp_name']['imagen'])->fit(800, 600);
        $propiedad->setImagen($nombreImagen);
    }
    // VALIDAMOS
    $errores = $propiedad->validar();

    // ESTE CONDICIÓN TIENE QUE DARSE SOLO SI EL ARREGLO ESTÁ VACIO CASO CONTRARIO NO.


    if (empty($errores)) {
        
      

        // CREANDO LA CARPETA PARA SUBIR IMAGENES

        if (!is_dir(CARPETA_IMAGENES)) {
            mkdir(CARPETA_IMAGENES);
        }

        // GUARDA LA IMAGEN EN EL SERVIDOR
        
        $image->save(CARPETA_IMAGENES . $nombreImagen);

        // PARA ENVIAR A LA BASE DE DATOS
       
           $propiedad->guardar();
        // mensaje de exito
       
       
    }
}

        $router->render('propiedades/crear', [
            'propiedad' => $propiedad,
            'vendedores'=> $vendedores,
            'errores'=> $errores
        ]);
    }

    public static function actualizar()
    {
        echo "Actualizar Propiedad";
    }
}