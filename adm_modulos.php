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

        <?php include('libs/php/encabezado.php'); ?>

        <div class="container">
            <legend>Mantenedor de M&oacute;dulos</legend>

            <p style="text-align:right;">
                <a class='btn btn-warning' href='#dlgOrdenar' data-toggle='modal'>
                    <i class='icon-refresh icon-white'></i> Ordenar M&oacute;dulos
                </a>&nbsp;
                <a class='btn btn-success' href='#dlgAgregar' data-toggle='modal'>
                    <i class='icon-file icon-white'></i> Agregar M&oacute;dulo
                </a>
            </p>
            <!--TABLA DE BUSCADORES-->
            <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered table-hover" id="example">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody id="tabla_body">
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="7" class="pager form-horizontal tablesorter-pager" data-column="0" style="">
                            <button class="btn first disabled"><i class="icon-step-backward"></i></button>
                            <button class="btn prev disabled"><i class="icon-arrow-left"></i></button>
                            <span class="pagedisplay">1 - 10 / 29 (50)</span> <!-- this can be any element, including an input -->
                            <button class="btn next"><i class="icon-arrow-right"></i></button>
                            <button class="btn last"><i class="icon-step-forward"></i></button>
                            <select class="pagesize input-mini" title="Select page size">
                                <option selected="selected" value="10">10</option>
                                <option value="20">20</option>
                                <option value="30">30</option>
                                <option value="40">40</option>
                            </select>
                            <select class="pagenum input-mini" title="Select page number"><option>1</option><option>2</option><option>3</option></select>
                        </th>
                    </tr>
                </tfoot>

            </table>
            <!--FIN BUSCADORES-->

            <!-- DIALOGO MODAL : NUEVO -->
            <div id="dlgAgregar" class="modal hide fade" tabindex="-1" role="dialog">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h3 id="myModalLabel">Nuevo m&oacute;dulo</h3>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" id="form_nuevo">  
                        <div class="alert mensajes" style="display:none;">
                            <button type="button" class="close" onclick="$('.alert').hide()">&times;</button>
                            <strong>CUIDADO!</strong><span id="mensaje"></span>
                        </div>
                        <fieldset>  
                            <div class="control-group">  
                                <label class="control-label" for="perfiles">Nombre</label>  
                                <div class="controls">  
                                    <input type="text" class="input-xlarge" id="Nuevo_nombre" placeholder="Nuevo Módulo">	            
                                </div>  
                            </div>
                            <div class="control-group">  
                                <label class="control-label" for="colores">Color</label>  
                                <div class="controls">  
                                    <input type="color" class="input-large" id="colores" placeholder="Color del Módulo" value="#f2f2f2">	            
                                </div>  
                            </div>
                            <div class="control-group">  
                                <label class="control-label" for="NuevoNombre">Estado.</label>  
                                <div class="controls">
                                    <select id="Nuevo_estado"></select>
                                    <!--p class="help-block"></p-->  
                                </div>
                            </div>
                        </fieldset>
                    </form>  
                </div>
                <div class="modal-footer">
                    <button id="btnNuevoCancelar" class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
                    <button id="btnNuevoAceptar" class="btn btn-primary">Guardar</button>
                </div>
            </div>
            <!-- FIN DIALOGO MODAL : NUEVO-->

            <!-- DIALOGO MODAL : MODIFICAR-->
            <div id="dlgModificar" class="modal hide fade" tabindex="-1" role="dialog">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h3 id="myModalLabel">Modificar m&oacute;dulo</h3>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" id="form_nuevo">  
                        <div class="alert mmensajes" style="display:none;">
                            <button type="button" class="close" onclick="$('.alert').hide()">&times;</button>
                            <strong>Warning!</strong><span id="mmensaje"></span>
                        </div>
                        <fieldset>
                            <div class="control-group">  
                                <label class="control-label" for="perfiles">Nombre</label>  
                                <div class="controls">  
                                    <input type="hidden" id="mid">
                                    <input type="text" class="input-xlarge" id="mNuevo_nombre" placeholder="Nuevo Módulo">	            
                                </div>  
                            </div>
                            <div class="control-group">  
                                <label class="control-label" for="mcolores">Color</label>  
                                <div class="controls">  
                                    <input type="color" class="input-large" id="mcolores" placeholder="Color del Módulo" value="#f2f2f2">	            
                                </div>  
                            </div>
                            <div class="control-group">  
                                <label class="control-label" for="NuevoNombre">Estado.</label>  
                                <div class="controls">
                                    <select id="mNuevo_estado"></select>
                                    <!--p class="help-block"></p-->  
                                </div>
                            </div>
                        </fieldset>  
                    </form>  
                </div>
                <div class="modal-footer">
                    <button id="btnEditarCancelar" class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
                    <button id="btnEditarAceptar" class="btn btn-primary">Guardar</button>
                </div>
            </div>
            <!-- FIN DIALOGO MODAL : MODIFICAR USUARIO -->

            <!-- DIALOGO MODAL : ELIMINAR USUARIO -->
            <div id="dlgEliminar" class="modal hide fade" tabindex="-1" role="dialog">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h3 id="myModalLabel">Confirmacion : Eliminar Usuario</h3>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" id="form_nuevo">  
                        <div class="alert mmensajes" style="display:none;">
                            <button type="button" class="close" onclick="$('.alert').hide()">&times;</button>
                            <strong>Warning!</strong><span id="mmensaje"></span>
                        </div>
                        <p>Esta seguro que desea borrar este registro del sistema ?</p>		        
                    </form>  
                </div>
                <div class="modal-footer">
                    <button id="btnEliminarCancelar" class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
                    <button id="btnEliminarAceptar" class="btn btn-danger">Eliminar</button>
                </div>
            </div>
            <!-- FIN DIALOGO MODAL : ELIMINAR USUARIO -->

            <!-- DIALOGO MODAL : ORDENAR -->
            <div id="dlgOrdenar" class="modal hide fade" tabindex="-1" role="dialog">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h3 id="myModalLabel">Ordenar m&oacute;dulos</h3>
                </div>
                <div class="modal-body">
                    
                        <div class="alert mensajes" style="display:none;">
                            <button type="button" class="close" onclick="$('.alert').hide()">&times;</button>
                            <strong>Aviso!</strong><span id="mensaje"></span>
                        </div>
                        <p>Haga clic sobre cada item (sin soltar) mueva el menu de arriba hacia abajo según el orden que prefiera: </p>
                        <ul id="listado-modulos">
                            <li>Item 1</li>
                            <li>Item 1</li>
                            <li>Item 1</li>
                            <li>Item 1</li>
                            <li>Item 1</li>
                            <li>Item 1</li>
                            <li>Item 1</li>
                        </ul>
                        
                    
                </div>
                <div class="modal-footer">
                    <button id="btnNuevoCancelar" class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
                    <button id="btnNuevoOrden" class="btn btn-primary">Guardar</button>
                </div>
            </div>
            <!-- FIN DIALOGO MODAL : NUEVO-->

        </div> <!-- /container -->

        <?php include('libs/php/piepagina.php'); ?>  
        
        <script type="text/javascript" src="libs/js/jquery.ui.core.js"></script>
        <script type="text/javascript" src="libs/js/jquery-ui.custom.js"></script>        
        <script type="text/javascript" src="libs/js/jquery.ui.mouse.js"></script>
        <script type="text/javascript" src="libs/js/jquery.ui.widget.js"></script>
        <script type="text/javascript" src="libs/js/jquery.ui.sortable.js"></script>
        
        <script type="text/javascript" src="controlador/modulos.js"></script>
        
        <style>
            
            #listado-modulos {  margin: 0px; padding: 10px; padding-left: 10px; width: 250px; }
            #listado-modulos li { margin: 3px; padding: 8px 15px; border: 1px solid #ccc; list-style: none; }
            /*#listado-modulos { margin:0px; padding:0px; margin-left:20px; }
            #listado-modulos { list-style-type: none; margin: 0; padding: 0; width: 100px; }
            #listado-modulos li { margin: 0 3px 3px 3px; padding: 0.4em; padding-left: 1.5em; font-size: 1.4em; height: 18px; border: 1px solid #000; }
            
            .placeHolder div { background-color:white !important; border:dashed 1px gray !important; }
*/
        </style>
    </body></html>