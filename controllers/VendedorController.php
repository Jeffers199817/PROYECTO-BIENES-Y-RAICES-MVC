<?php 

namespace Controllers;

use MVC\Router;
use Model\Vendedor;



class VendedorController
{


    public static function crear(Router $router)
    {
        $errores = Vendedor::getErrores();

        $vendedor = new Vendedor();



        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            //crear una nueva instancia 

            $vendedor = new Vendedor($_POST['vendedor']);
            //VALIDAR QUE NO HAYA CAMPOS VACIOS

            $errores = $vendedor->validar();

            // no hay errores 

            if (empty($errores)) {
                $vendedor->guardar();


            }
        }


        $router->render('vendedores/crear', [
            'errores' => $errores,
            'vendedor' => $vendedor
        ]);
    }


    public static function actualizar(Router $router)
    {
        $errores = Vendedor::getErrores();
        $id = validarORedireccionar('/admin');



        // obtener datos del vendedor a actualizar 
        $vendedor = Vendedor::find($id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            //ASIGNAR LOS VALORES

            $args = $_POST['vendedor'];

            //SINCRONIZAR OBJETO EN MEMORIA

            $vendedor->sincronizar($args);

            //VALIDACIÓN 

            $errores = $vendedor->validar();

            if (empty($errores)) {
                $vendedor->guardar();

            }
        }

        $router->render('vendedores/actualizar', [
            'errores' => $errores,
            'vendedor' => $vendedor
        ]);
    }



    public static function eliminar()
    {
        if($_SERVER['REQUEST_METHOD']== 'POST'){
            //validar el tyipo a eliminar
            $tipo = $_POST['tipo'];
            //validar el id

            $id = $_POST['id'];
            $id = filter_var($id, FILTER_VALIDATE_INT);

            if($id){ 
                //calida el tipo a elimianr

                $tipo = $_POST['tipo'];

                if(validarTipoContenido($tipo)){
                    $vendedor = Vendedor::find($id);
                    $vendedor->eliminar();
                }
            }

        }







    }
} 