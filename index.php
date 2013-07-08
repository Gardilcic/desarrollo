<?php
    session_start();
    if (isset($_SESSION['usuario'])) {
        header('Location: adm_usuarios.php');
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta content="es-pe" http-equiv="Content-Language">
        <meta charset="utf-8">
        <title>Gardilcic :: SIGP Usuario: <?php echo $_SESSION['nombre'] ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="author" content="">
        <link rel="icon" type="image/png" href="libs/img/logo.png" />
        <link href="libs/css/bootstrap.css" rel="stylesheet">
        <link href="libs/css/bootstrap-responsive.css" rel="stylesheet">
        <link href="libs/css/jquery.tablesorter.pager.css" rel="stylesheet">
        <link href="libs/css/theme.bootstrap.css" rel="stylesheet">
        <!--[if lt IE 9]>
          <script src="libs/js/html5shiv.js"></script>
        <![endif]-->	

    </head>

    <body>
        <?php
        require_once('libs/php/encabezado_login.php');
        ?>
        <div style="margin:0 auto; width:500px; margin-top:75px;">

            <div class="alert mensajes" style="display: none;">
                <button type="button" class="close" onclick="$('.alert').hide()">&times;</button>
                <strong>Aviso! </strong><span id="mensaje"></span>
            </div>

            <form name="login" method="post" onSubmit="return false;">
                <table border="0" style="margin: 0 auto; text-align: center;">
                    <tr>
                        <td>
                            <img alt="" src="libs/img/i_logo.png" />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <span class="text-left"><h5>Nombre de usuario</h5></span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input type="text" name="nombre_usuario" id="nombre_usuario" size="13" value="" />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <span class="text-left"><h5>Contrase&ntilde;a</h5></span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input type="password" name="clave_usuario" id="clave_usuario" size="13" value="" />
                        </td>
                    </tr>
                    <tr>
                        <td>
                    <center>
                        <input type="submit" name="btn_entrar" id="btn_entrar" value="Ingresar" class="btn" />
                    </center>
                    </td>
                    </tr>
                </table>
            </form>
        </div>
    </body>
    <?php include('libs/php/piepagina.php'); ?> 
    <script type="text/javascript" src="controlador/usuarios_login.js"></script>
</html>
