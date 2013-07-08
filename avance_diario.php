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
        <link href="libs/css/jquery.tablesorter.pager.css" rel="stylesheet">
        <link href="libs/css/theme.bootstrap.css" rel="stylesheet">

        <link rel="stylesheet" href="libs/css/jqx.base.css" type="text/css" />    

        <!--[if lt IE 9]>
          <script src="../assets/js/html5shiv.js"></script>
        <![endif]-->	

        <style>
            .resaltado{
                background-color: beige;
            }
            .resaltado:hover{
                background-color: white;
            }

        </style>

    </head>

    <body>

        <?php include('./libs/php/encabezado.php'); ?>

        <div class="container">
            <legend>Ingreso del Avance Diario</legend>

            <p style="text-align:right;"></p>

            <form class="form-inline" id="form_nuevo">  
                <div class="alert mensajes" style="display:none;">
                    <button type="button" class="close" onclick="$('.alert').hide()">&times;</button>
                    <strong>Warning!</strong><span id="mensaje"></span>
                </div>

                <label class="control-label" for="perfiles">Seleccione : </label>  

                <select id="turnos" class="input-small">
                    <option value="1">Turno</option>
                    <option value="2">Dia</option>
                </select>
                <select id="turnos" class="input-xxlarge">
                    <option value="1">Fortificacion de tunel de la calle 11</option>
                    <option value="2">Fortificacion de tunel de la calle 13</option>
                </select>
                <a class='btn btn-success' href='#dlgAgregar' data-toggle='modal'><i class='icon-file icon-white'></i>Ver Planning</a>
            </form>

            <div id='jqxWidget'>
                <div id="jqxgrid"></div>
                <div style="font-size: 12px; font-family: Verdana, Geneva, 'DejaVu Sans', sans-serif; margin-top: 30px;">
                    <div id="cellbegineditevent"></div>
                    <div style="margin-top: 10px;" id="cellendeditevent"></div>
                </div>
            </div>

        </div> <!-- /container -->

        <?php include('libs/php/piepagina.php'); ?>  

        <script type="text/javascript" src="libs/js/jqwidgets/jqxcore.js"></script>
        <script type="text/javascript" src="libs/js/jqwidgets/jqxdata.js"></script> 
        <script type="text/javascript" src="libs/js/jqwidgets/jqxbuttons.js"></script>
        <script type="text/javascript" src="libs/js/jqwidgets/jqxscrollbar.js"></script>
        <script type="text/javascript" src="libs/js/jqwidgets/jqxmenu.js"></script>
        <script type="text/javascript" src="libs/js/jqwidgets/jqxgrid.js"></script>
        <script type="text/javascript" src="libs/js/jqwidgets/jqxgrid.edit.js"></script>  
        <script type="text/javascript" src="libs/js/jqwidgets/jqxgrid.selection.js"></script> 
        <script type="text/javascript" src="libs/js/jqwidgets/jqxgrid.filter.js"></script> 
        <script type="text/javascript" src="libs/js/jqwidgets/jqxlistbox.js"></script>
        <script type="text/javascript" src="libs/js/jqwidgets/jqxdropdownlist.js"></script>
        <script type="text/javascript" src="libs/js/jqwidgets/jqxcheckbox.js"></script>
        <script type="text/javascript" src="libs/js/jqwidgets/jqxcalendar.js"></script>
        <script type="text/javascript" src="libs/js/jqwidgets/jqxnumberinput.js"></script>
        <script type="text/javascript" src="libs/js/jqwidgets/jqxdatetimeinput.js"></script>
        <script type="text/javascript" src="libs/js/jqwidgets/globalization/globalize.js"></script>
        <script type="text/javascript" src="generatedata.js"></script>

        <script type="text/javascript" src="controlador/avance_diario.js"></script>

        <script type="text/javascript">


        </script>


    </body></html>