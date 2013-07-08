<?php 
    session_start();
    include('libs/php/valida_pagina_usuario.php');
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta content="es-pe" http-equiv="Content-Language">
        <meta charset="utf-8">
        <title>Gardilcic :: SIGP</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="author" content="">
        <link rel="icon" type="image/png" href="libs/img/icono.png" />
        
        <link href="libs/css/bootstrap.css" rel="stylesheet">
        <link href="libs/css/bootstrap-responsive.css" rel="stylesheet">
        
        <link data-jsfiddle="common" rel="stylesheet" media="screen" href="libs/css/jquery.handsontable.full.css">
        
        <!--[if lt IE 9]>
          <script src="../assets/js/html5shiv.js"></script>
        <![endif]-->	
		<script type="text/javascript">
    	
		function popup_obj() {
		window.open("adm_help_obj.php?url="+location.pathname, "SIGP - Ayuda", "directories=no, menubar =no,status=no,toolbar=no,location=no,scrollbars=no,fullscreen=no,height=450,width=350,left=200,top=200")
		}
		
		function popup_det() {
			window.open("adm_help_det.php?url="+location.pathname, "SIGP - Ayuda", "directories=no, menubar =no,status=no,toolbar=no,location=no,scrollbars=no,fullscreen=no,height=450,width=350,left=200,top=200")
		}
		
		function popup_doc() {
			window.open("adm_help_archivo.php?url="+location.pathname, "SIGP - Ayuda", "directories=no, menubar =no,status=no,toolbar=no,location=no,scrollbars=no,fullscreen=no,height=150,width=150,left=200,top=200")
		}

	</script>
    </head>

    <body>

        <?php include('./libs/php/encabezado.php'); ?>        
        
        <div class="container">
            
            <legend>Carga masiva de Actividades</legend>
            
            <div class="alert mensajes" style="display: none;">
                <button type="button" class="close" onclick="$('.alert').hide()">&times;</button>
                <strong>Aviso! </strong><span id="mensaje"></span>
            </div>
            
            Seleccione un Subproyecto : 
            <select id="subproyectos" class="input-xlarge">                
            </select>
            
            <div id="grilla" ></div>
            <p style="padding: 10px; text-align: right;">
                <a id="btn-guardar" class="btn btn-success"><i class="icon-file icon-white"></i> Grabar Actividades</a>
            </p>
            <p>* Puede dejar en blanco el campo : Itemizado de subproyecto y clasificación, podra ingresarlo más adelante.</p>

        </div> <!-- /container -->

        <?php include('libs/php/piepagina.php'); ?>         
        <script data-jsfiddle="common" src="libs/js/jquery.handsontable.full.js"></script>
        <script type="text/javascript" src="libs/js/numeral.js"></script>
        <script type="text/javascript" src="controlador/actividades.js"></script>
        
        <script type="text/javascript" src="controlador/jquery.actividad.js"></script>

    </body>
</html>