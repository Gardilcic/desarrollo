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
        <link rel="icon" type="image/png" href="libs/img/logo.png" />

        <link href="libs/css/bootstrap.css" rel="stylesheet">
        <link href="libs/css/bootstrap-responsive.css" rel="stylesheet">

        <link data-jsfiddle="common" rel="stylesheet" media="screen" href="libs/css/jquery.handsontable.full.css">
        <link data-jsfiddle="common" rel="stylesheet" media="screen" href="libs/css/glDatePicker.default.css">
        <link data-jsfiddle="common" rel="stylesheet" media="screen" href="libs/css/ui-lightness/jquery-ui-1.10.3.custom.css">
        
        <link data-jsfiddle="common" rel="stylesheet" media="screen" href="libs/css/showLoading.css">

        <!--[if lt IE 9]>
          <script src="libs/js/html5shiv.js"></script>
        <![endif]-->	

    </head>

    <body>

        <?php include('libs/php/encabezado.php'); ?>        
        
        
        <div class="container">            

            <legend>Consulta de Registro de datos</legend>

            <div class="alert mensajes" style="display: none;">
                <button type="button" class="close" onclick="$('.alert').hide()">&times;</button>
                <strong>Aviso! </strong><span id="mensaje"></span>
            </div>


            <br /><div style="float: left; padding-top: 7px; width: 150px;">Desde la Fecha </div><input type="text" id="fechainicial" value="01/06/2013" />            
            &nbsp;Hasta : <input type="text" id="fechafinal" value="06/06/2013" /> <a id="btn-generar" class="btn btn-success"><i class="icon-file icon-white"></i> Generar Periodos</a>
            <div id="grilla" ></div>

            <p style="padding: 10px; text-align: right;">
                <a id="btnReporte" class="btn btn-success"><i class="icon-file icon-white"></i> Obtener Reporte en PDF</a>
            </p>
            
            <p><span style="position: relative; float:left; height: 15px; width: 40px; background-color: LimeGreen; margin: 0px 5px;"></span> Data ingreso en la fecha programada.</p>
            <p><span style="position: relative; float:left; height: 15px; width: 40px; background-color: red; margin: 0px 5px;"></span> Dato ingresado <b>atrazado</b> y/o modificado respecto a la fecha programada.</p>
            <p><span style="position: relative; float:left; height: 15px; width: 40px; background-color: gray; margin: 0px 5px;"></span> Dato ingresado sin fecha de calendario asignada.</p>                
            <p><span style="position: relative; float:left; height: 15px; width: 40px; background-color: black; margin: 0px 5px;"></span> Dato ingresado atrazado sin fecha de calendario asignada.</p>                

        </div> <!-- /container -->

        <?php include('libs/php/piepagina.php'); ?>  
        <script data-jsfiddle="common" src="libs/js/jquery.handsontable.full.js"></script>
        <script data-jsfiddle="common" src="libs/js/jquery-ui-1.10.3.custom.min.js"></script>
        <script data-jsfiddle="common" src="libs/js/glDatePicker.js"></script>
        <script data-jsfiddle="common" src="libs/js/numeral.js"></script>
        
        <script data-jsfiddle="common" src="libs/js/jquery.showLoading.js"></script>

        <script type="text/javascript" src="controlador/rpt_registro_dato.js"></script>

    </body></html>