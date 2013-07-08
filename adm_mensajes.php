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
    </head>
    <body>

        <?php include('libs/php/encabezado.php'); ?>

        <div class="container">
            <legend>Mis mensajes</legend>
			<p style="text-align:right; margin-left:300px;">
                <a class='btn btn-success' href='#dlgAgregar' data-toggle='modal'>
                    <i class='icon-file icon-white'></i>Nuevo mensaje
                </a>&nbsp;
            </p>
            <p style="text-align:left;">
				Mensajes existentes: <select name="lista_mensajes" id="lista_mensajes"></select>
			</p>
            <!--TABLA DE BUSCADORES-->
            <div id="info_mensaje" style="width:800px; height:200px; margin-left:100px;"></div>

             <!--DIALOGO MODAL : NUEVO -->
            <div id="dlgAgregar" class="modal hide fade" tabindex="-1" role="dialog">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h3 id="myModalLabel">Nuevo Mensaje</h3>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" id="form_nuevo">  
                        <div class="alert mensajes" style="display:none;">
                            <button type="button" class="close" onclick="$('.alert').hide()">&times;</button>
                            <strong>CUIDADO!</strong><span id="mensaje"></span>
                        </div>
                        <fieldset>  
                            <div class="control-group">  
                                <label class="control-label" for="perfiles">Mensaje para: </label>  
                                <div class="controls">  
                                    <select id="receptor"></select>	            
                                </div>  
                            </div>
                            <div class="control-group">  
                                <label class="control-label" for="NuevoNombre">T&iacute;tulo:</label>  
                                <div class="controls">
                                    <input type="text" class="input-xlarge" id="mensaje_titulo" placeholder="Nuevo Módulo">
                                    <!--p class="help-block"></p-->  
                                </div>
                            </div>
                            <div class="control-group">  
                                <label class="control-label" for="NuevoNombre">Mensaje:</label>  
                                <div class="controls">
                                    <textarea rows="12" cols="30" id="mensaje_mensaje"></textarea>
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
                    <h3 id="myModalLabel">Modificar perfil</h3>
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
            
            <!-- DIALOGO MODAL : ASOCIAR PERFIL A USUARIO -->
            <div id="dlgAsociar" class="modal hide fade" tabindex="-1" role="dialog">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h3 id="myModalLabel">Asociar Perfil a Usuario</h3>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" id="form_nuevo">  
                        <div class="alert mensajes" style="display:none;">
                            <button type="button" class="close" onclick="$('.alert').hide()">&times;</button>
                            <strong>Aviso!</strong><span id="mensaje"></span>
                        </div>
                        <fieldset>  
                            <div class="control-group">  
                                <label class="control-label" for="usuarios">Usuarios</label>  
                                <div class="controls">  
                                    <select id="usuarios"></select>
                                </div>  
                            </div>
                            <div class="control-group">  
                                <label class="control-label" for="perfiles">Perfiles</label>  
                                <div class="controls">
                                    <select id="perfiles"></select>
                                </div>
                            </div>
                        </fieldset>
                    </form>  
                </div>
                <div class="modal-footer">
                    <button id="btnAsociarCancelar" class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
                    <button id="btnAsociarAceptar" class="btn btn-primary">Guardar</button>
                </div>
            </div>
            <!-- FIN DIALOGO MODAL : ASOCIAR PERFIL A USUARIO -->            

            <!-- DIALOGO MODAL : ASIGNAR PERMISO A PERFIL -->
            <div id="dlgAsignar" class="modal hide fade" tabindex="-1" role="dialog">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h3 id="myModalLabel">Asignar Permisos a Usuario</h3>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" id="form_nuevo">  
                        <div class="alert mensajes" style="display:none;">
                            <button type="button" class="close" onclick="$('.alert').hide()">&times;</button>
                            <strong>Aviso!</strong><span id="mensaje"></span>
                        </div>
                        <fieldset>  
                            <div class="control-group">  
                                <label class="control-label" for="ausuarios">Usuarios</label>  
                                <div class="controls">  
                                    <select id="ausuarios"></select>
                                </div>  
                            </div>
                            <div class="control-group">  
                                <label class="control-label" for="modulos">Modulos</label>  
                                <div class="controls">
                                    <select id="modulos"></select>
                                </div>
                            </div>                            
                            <div class="control-group">  
                                <label class="control-label" for="permisos">Permisos</label>  
                                <div class="controls">
                                    <select id="permisos" class="input-xlarge" size="15"></select>
                                </div>
                            </div>
                        </fieldset>
                    </form>  
                </div>
                <div class="modal-footer">
                    <button id="btnAsignarCancelar" class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
                    <button id="btnAsignarAceptar" class="btn btn-primary">Guardar</button>
                </div>
            </div>
            <!-- FIN DIALOGO MODAL : ASIGNAR PERMISO A PERFIL -->     
            
            <!-- DIALOGO MODAL : ASIGNAR SUBPROYECTO A USUARIO -->
            <div id="dlgSubproyecto" class="modal hide fade" tabindex="-1" role="dialog" style="left: 45%;width: 700px;">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h3 id="myModalLabel">Asignar Subproyecto a Usuario</h3>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" id="form_nuevo">  
                        <div class="alert mensajes" style="display:none;">
                            <button type="button" class="close" onclick="$('.alert').hide()">&times;</button>
                            <strong>Aviso!</strong><span id="mensaje"></span>
                        </div>
                        <fieldset>  
                            <div class="control-group">  
                                <label class="control-label" for="susuarios">Usuarios</label>  
                                <div class="controls">  
                                    <select id="susuarios"></select>
                                </div>  
                            </div>                          
                            <div class="control-group">  
                                <label class="control-label" for="subproyectos">Subproyectos</label>  
                                <div class="controls">
                                    <select id="subproyectos" class="input-xlarge" size="15" style="width: 400px;">                                        
                                    </select>
                                    <label class="checkbox inline">
                                        <input type="checkbox" name="marca" id="marca" />Marcar Todos 
                                    </label>
                                    
                                </div>
                            </div>
                        </fieldset>
                    </form>  
                </div>
                <div class="modal-footer">
                    <button id="btnAsignarSubProyectoCancelar" class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
                    <button id="btnAsignarSubProyectoAceptar" class="btn btn-primary">Guardar</button>
                </div>
            </div>
            <!-- FIN DIALOGO MODAL : ASIGNAR SUBPROYECTO A USUARIO  -->      
            
        </div> <!-- /container -->

        <?php include('libs/php/piepagina.php'); ?>  
        <script type="text/javascript" src="controlador/mensajes.js"></script>

    </body></html>