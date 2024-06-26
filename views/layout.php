<?php


session_start();

if (!isset($_SESSION)) {
    session_start();
}

$auth = $_SESSION['login'] ?? false;

if (!isset($inicio)) {
    $inicio = false;
}
?> 


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienes Raices</title>
    <link rel="stylesheet" href="../build/css/app.css">

</head>

<body>

    <header class=" header <?php echo $inicio ? 'inicio': '';?>">
        <div class="contenedor contenido-header">
            <div class="barra">
                <a href="/index.php">
                    <img src = "/build/img/logo.svg"    alt=" Logotipo de Bienes y Raices.">
                </a>

                <div class="mobile-menu">
                    <img src="/build/img/barras.svg" alt="icono menu responsive">
                </div>

                <div class="derecha">
                    <img class="dark-mode-boton" src="/build/img/dark-mode.svg">

               
 
                <nav class="navegacion">
                    <a href="/nosotros">Nosotros</a>
                    <a href="/propiedades">Anuncios</a>
                    <a href="/blog">Blog</a>
                    <a href="/contacto">Contacto</a>

                    <?php if(!$auth):?>
                    <a href="/login">Iniciar Sesión </a>
                    <?php endif;?>.

                    <?php if($auth): ?>
                        <a href="/logout"> Cerrar Sesión</a>
                        <?php endif;?>
                   </nav>
                </div>
            </div><!--Cierre barra-->

            <?php
            if ($inicio) {

                echo "<h1>Venta de Casas y Departamentos Exclusivos de Lujo</h1>";
            }
             ?>
        </div>
    </header> <!--FIN DE HEADER-->





    <?php echo $contenido; ?>


    

    <footer class="footer seccion">

        <div class="contenedor contenedor-footer">
            <nav class="navegacion">
                <a href="nosotros.php">Nosotros</a>
                <a href="anuncios.php">Anuncios</a>
                <a href="blog.php">Blog</a>
                <a href="contacto.php">Contacto</a>

            </nav>



            <p class="copyright">El contenido de este sitio web, incluidos textos, imágenes, gráficos y otros elementos,
                está protegido por las leyes de
                propiedad intelectual y no puede ser reproducido, distribuido, transmitido, exhibido, publicado o
                transmitido sin el
                permiso previo por escrito de MILENYUM-BIRA <?php echo date('Y');?> &copy;</p>
        </div>

    </footer><!--FIN DE FOOTER-->



    <script src="../build/js/bundle.min.js">

    </script><!--FIN DE JAVASCRIPT-->



</body>

</html>




