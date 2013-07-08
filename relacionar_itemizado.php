<?php 
    session_start();
    include('libs/php/valida_pagina_usuario.php');
    $_SESSION["Imagenes"]="";
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
        <link href="libs/css/jquery.tablesorter.pager.css" rel="stylesheet">
        <link href="libs/css/theme.bootstrap.css" rel="stylesheet">
        
        <link rel="stylesheet" href="libs/css/jqx.base.css" type="text/css" />    
        
        <!--[if lt IE 9]>
          <script src="../assets/js/html5shiv.js"></script>
        <![endif]-->	

    </head>
    <style>
        .jqx-grid-cell-selected {
            background-color: #b1dbc4 !important;
        }
        .jqx-grid-cell-hover{ 
            background-color: #d3f0e0 !important
        ;
    </style>
    <body>

        <?php include('./libs/php/encabezado.php'); ?>

        
        
        <div class="container">
                        
            <div style="position: relative; float: left;">
                <!--legend>Relacionar de : Itemizado PMO</legend-->
                <p class="text-success"><b>Itemizado PMO</b></p>
                <div class="form-horizontal">
                    <div class="control-group">
                        <label class="control-label" style="text-align: left; width: 100px;" for="versiones">Versión </label>
                        <div class="controls" style="margin-left: 50px;" >
                            <select id="versiones">
                                <option>Selecciones</option>
                            </select>
                        </div>
                    </div>                 
                    <div class="control-group">
                        <label class="control-label" style="text-align: left; width: 100px;" for="subproyectos">Sub-Proyecto </label>
                        <div class="controls" style="margin-left: 50px;" >
                            <select id="subproyectos">
                                <option>Selecciones</option>
                            </select>
                        </div>
                    </div>                 
                </div>
                <div id="itemizadopmo"></div>
            </div>
            
            <div style="position: relative; float: left; margin-left: 30px; padding-bottom: 10px; ">
                <!--legend>A : Itemizado Proyecto</legend-->
                <p class="text-success"><b>Items de Proyecto actualmente relacionados al Itemizado PMO</b></p>                
                <div id="itemizadoproyecto_relacionados"></div>
            </div>
            
            <div style="position: relative; float: left; margin-left: 30px; width: 700px;">
                
                <div style="position: relative; float: left; width: 700px; padding-bottom: 10px;">
                    <span class="text-success"><b>Items de Proyecto sin relacionar con el Itemizado PMO</b></span>
                    <span style="float: right;">
                        <a id="btnSubir" class="btn btn-success" ><i class="icon-arrow-up icon-white" ></i> Subir</a> 
                        <a id="btnBajar" class="btn btn-warning" ><i class="icon-arrow-down icon-white" ></i> Bajar</a>
                    </span>
                </div>
                <div style="position: relative; float: left; ">
                    <div id="itemizadoproyecto" ></div>
                </div>
                
            </div>

            <!-- DIALOGO MODAL : ELIMINAR -->
            <div id="dlgEliminar" class="modal hide fade" tabindex="-1" role="dialog">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h3 id="myModalLabel">Confirmaci&oacute;n : Eliminar Registro</h3>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" id="form_eliminar">  
                        <div class="alert mmensajes" style="display:none;">
                            <button type="button" class="close" onclick="$('.alert').hide()">&times;</button>
                            <strong>Mensaje : </strong><span id="mmensaje"></span>
                        </div>
                        <p>Esta seguro que desea borrar este registro del sistema ?</p>		
                        <input type="hidden" class="input-xlarge" id="mIdRegistro">        
                    </form>
                </div>
                <div class="modal-footer">
                    <button id="btnEliminarCancelar" class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
                    <button id="btnEliminarAceptar" class="btn btn-danger">Eliminar</button>
                </div>
            </div>
            <!-- FIN DIALOGO MODAL : ELIMINAR -->


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
        
        
        <script type="text/javascript" src="controlador/relacionar_itemizado.js"></script>

    </body></html>