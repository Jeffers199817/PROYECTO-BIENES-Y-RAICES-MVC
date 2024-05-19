<?php

namespace Controllers;

use Intervention\Image\ImageManagerStatic as Image;
use Model\Propiedad;
use Model\Vendedor;
use MVC\Router;

class PropiedadController
{
    public static function index(Router $router)
    {
        $propiedades = Propiedad::all();

        $vendedores = Vendedor::all();

        // Muestra un mensaje condicional
        $resultado = $_GET['resultado'] ?? null;

        $router->render('/propiedades/admin', [
            'propiedades' => $propiedades,
            'resultado' => $resultado,
            'vendedores' => $vendedores
        ]);
    }

    public static function crear(Router $router)
    {
        $propiedad = new Propiedad();
        $vendedores = Vendedor::all();

        // Arreglo con mensajes de errores

        $errores = Propiedad::getErrores();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Crea una instancia de Propiedad
            $propiedad = new Propiedad($_POST['propiedad']);

            // SUBE LOS ARCHIVOS

            // Generar un nombre único

            $nombreImagen = md5(uniqid(rand(), true)) . '.jpg';

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
            'vendedores' => $vendedores,
            'errores' => $errores
        ]);
    }

    public static function actualizar(Router $router)
    {
        $id = validarORedireccionar('/admin');

        $propiedad = Propiedad::find($id);
        $vendedores = Vendedor::all();

        $errores = Propiedad::getErrores();

        // EJECUTAR EL CODIGO DESPUES DE QUE EL USUARIO ENVIA EL FORMULARIO

        // METODO POST PARA ACTUALIZAR
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // ASIGNAR LOS ATRIBUTOS
            $args = $_POST['propiedad'];
            $propiedad->sincronizar($args);

            $errores = $propiedad->validar();

            // subida de archivos
            // generar un nombre unico
            $nombreImagen = md5(uniqid(rand(), true)) . '.jpg';

            if ($_FILES['propiedad']['tmp_name']['imagen']) {
                $image = Image::make($_FILES['propiedad']['tmp_name']['imagen'])->fit(800, 600);
                $propiedad->setImagen($nombreImagen);
            }

            // ESTE CONDICIÓN TIENE QUE DARSE SOLO SI EL ARREGLO ESTÁ VACIO CASO CONTRARIO NO.

            if (empty($errores)) {
                if ($_FILES['propiedad']['tmp_name']['imagen']) {
                    // Almacenar la imagen
                    $image->save(CARPETA_IMAGENES . $nombreImagen);
                }
                $propiedad->guardar();

                // PARA ENVIAR A LA BASE DE DATOS
            }
        }

        $router->render('propiedades/actualizar', [
            'propiedad' => $propiedad,
            'errores' => $errores,
            'vendedores' => $vendedores
        ]);
    }

    public static function eliminar()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $id = $_POST['id'];
                $id = filter_var($id, FILTER_VALIDATE_INT);

                if ($id) {
                    $tipo = $_POST['tipo'];

                    if (validarTipoContenido($tipo)) {
                              $propiedad = Propiedad::find($id);
                            $propiedad->eliminar();
                        }
                    }

                    // eliminar el archivo
                }
            }
        }

 }
