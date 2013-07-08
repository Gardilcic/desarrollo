<?php 
    session_start();
    //include('libs/php/valida_pagina_usuario.php');
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
        <link rel="icon" type="image/png" href="libs/img/logo.png" />
        
        <link href="libs/css/bootstrap.css" rel="stylesheet">
        <link href="libs/css/bootstrap-responsive.css" rel="stylesheet">
        
        <link data-jsfiddle="common" rel="stylesheet" media="screen" href="libs/css/jquery.handsontable.full.css">
        <link data-jsfiddle="common" rel="stylesheet" media="screen" href="libs/css/glDatePicker.default.css">
        <link data-jsfiddle="common" rel="stylesheet" media="screen" href="libs/css/ui-lightness/jquery-ui-1.10.3.custom.css">
        
        <!--[if lt IE 9]>
          <script src="libs/js/html5shiv.js"></script>
        <![endif]-->	

    </head>

    <body>

        <?php include('libs/php/encabezado.php'); ?>

        <div class="container">            
            
            <legend>Carga masiva de Calendario</legend>
            
            <div style="position: relative; float: left; width: 45%;">
                <div class="alert mensajes" style="display: none;">
                    <button type="button" class="close" onclick="$('.alert').hide()">&times;</button>
                    <strong>Aviso! </strong><span id="mensaje"></span>
                </div>

                <br /><div style="float: left; padding-top: 7px; width: 150px;">Calendario : </div><select id="calendarios" class="input-xlarge"></select>
                <br /><div style="float: left; padding-top: 7px; width: 150px;">Fecha Inicial</div><input type="text" id="fechainicial" value="01/01/2013" />            
                <br /><div style="float: left; padding-top: 7px; width: 150px;">Fecha Final</div><input type="text" id="fechafinal" value="31/12/2013" />
                <br />
                    <div style="float: left; padding-top: 7px; width: 150px;">Rango o Periodo </div>
                    <select id="intervalo">
                        <option value="1">Intervalo de tiempo cada </option>
                        <option value="2">Todos los meses el dia </option>                    
                    </select>
                    <input type="text" class="input-small" id="rango" placeholder="Ej. 15 - Todos los dias 15 del año" />
                <br />
                    <div style="float: left; padding-top: 7px; width: 150px;"></div>    
                    <a id="btn-generar" class="btn btn-success"><i class="icon-file icon-white"></i> Generar Periodos</a>
            </div>
            
            <div style="position: relative; float: left; width: 45%;">
                <div id="grilla" ></div>
                <p style="padding: 10px; text-align: right;">
                    <a id="btnGuardar" class="btn btn-success"><i class="icon-file icon-white"></i> Grabar Detalle</a>
                </p>
                <p>* Puede dejar en blanco el campo : Itemizado de subproyecto y clasificación, podra ingresarlo más adelante.</p>         
            </div>
            
              


        </div> <!-- /container -->

        <?php include('libs/php/piepagina.php'); ?>  
        <script data-jsfiddle="common" src="libs/js/jquery.handsontable.full.js"></script>
        <script data-jsfiddle="common" src="libs/js/jquery-ui-1.10.3.custom.min.js"></script>
        <script data-jsfiddle="common" src="libs/js/glDatePicker.js"></script>
        
        <script type="text/javascript" src="controlador/calendario_detalle.js"></script>

    </body></html>