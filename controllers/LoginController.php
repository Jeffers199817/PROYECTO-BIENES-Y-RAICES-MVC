<?php 

namespace Controllers;

use MVC\Router;
use Model\Admin;


class LoginController{

    public static function login(Router $router){

        $errores = [];
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $auth = new Admin($_POST);

            $errores = $auth->validar();
            if(empty($errores)){
                //Verificar el usuario exitste
                $resultado = $auth->existeUsuario();
                
                if(!$resultado){
                    //verificar si el usuario existe
                    $errores = Admin::getErrores();
                }else{

                       //verificar el password

                  $autenticado=  $auth->comprobarPassword($resultado);

                  if($autenticado){ 
                    //Autenticar al usuario
                        $auth->autenticar();
                  }else{

                    //Password incorrecto
                        $errores = Admin::getErrores();
                  }

                }
                

             

                //Autenticar al usuario
            }
            
        }
        $router->render('auth/login',[
            'errores'=>$errores
        ]);
    }

    public static function logout(){
        session_start();
        $_SESSION = [];

        header('Location: /');

    }

    
}