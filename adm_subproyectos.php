<?php
	session_start();
	$_SESSION['nombre']="pepe";
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
        <!--[if lt IE 9]>
          <script src="../assets/js/html5shiv.js"></script>
        <![endif]-->	
    </head>

    <body>

        <?php include('./libs/php/encabezado.php'); ?>

        <div class="container">

            <legend>Mantenedor de Sub-Proyectos</legend>

            <p style="text-align:right;"><a class='btn btn-success' href='#dlgAgregar' data-toggle='modal'><i class='icon-file icon-white'></i>Nuevo Subproyecto</a></p>

            <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered table-hover" id="example">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Fecha Inicio</th>
                        <th>Fecha Termino</th>
                        <th>Monto</th>
                        <th>Modena</th>
                        <th>Proyecto</th>
                        <th>Ubicacion</th>
                        <th>Estados</th>
                        <th>Operaciones</th>
                    </tr>
                </thead>
                <tbody id="tabla_body">
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="9" class="pager form-horizontal tablesorter-pager" data-column="0" style="">
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

            <!-- DIALOGO MODAL : VER -->
            <div id="dlgVer" class="modal hide fade" tabindex="-1" role="dialog">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h3 id="myModalLabel">Sub-Proyecto</h3>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" id="form_ver">  
                        <div class="alert vmensajes" style="display:none;">
                            <button type="button" class="close" onclick="$('.alert').hide()">&times;</button>
                            <strong>Mensaje : </strong><span id="vmensaje"></span>
                        </div>
                        <fieldset>  
                            <div class="control-group">  
                                <label class="control-label" for="vproyecto">Proyecto</label>  
                                <div class="controls">  
                                    <select class="input-xlarge" id="vproyecto" disabled="disabled">
                                        <option id="0">Seleccione</option>
                                    </select>
                                </div>  
                            </div>
                            <div class="control-group">  
                                <label class="control-label" for="vnombre">Sub-Proyecto</label>  
                                <div class="controls"> 
                                    <input type="text" class="input-xlarge" id="vnombre" placeholder="Ingrese el Nombre" readonly="readonly">	
                                </div>  
                            </div>
                            <div class="control-group">  
                                <label class="control-label" for="vfechainicio">Fecha Inicio</label>  
                                <div class="controls">  
                                    <input type="date" class="input-xlarge" id="vfechainicio" placeholder="Ingrese Fecha de Inicio" readonly="readonly">	
                                </div>  
                            </div>
                            <div class="control-group">  
                                <label class="control-label" for="vfechafinal">Fecha Fin</label>  
                                <div class="controls">  
                                    <input type="date" class="input-xlarge" id="vfechafinal" placeholder="Ingrese Fecha de Termino" readonly="readonly">		              <!--p class="help-block"></p-->  
                                </div>  
                            </div>	
                            <div class="control-group">  
                                <label class="control-label" for="vmonto">Monto</label>  
                                <div class="controls">  
                                    <select class="input-medium" id="vmoneda" disabled="disabled">
                                        <option id="0">Seleccione</option>
                                    </select>
                                    <input type="text" class="input-small" id="vmonto" placeholder="Monto del Contrato" readonly="readonly" >	
                                </div>  
                            </div>
                            <div class="control-group">  
                                <label class="control-label" for="vempresa">Empresa</label>  
                                <div class="controls">  
                                    <select class="input-xlarge" id="vempresa" disabled="disabled">
                                        <option id="0">Seleccione</option>
                                    </select>
                                </div>  
                            </div>
                            <div class="control-group">  
                                <label class="control-label" for="vmandante">Mandante</label>  
                                <div class="controls">  
                                    <select class="input-xlarge" id="vmandante" disabled="disabled">
                                        <option id="0">Seleccione</option>
                                    </select>
                                </div>  
                            </div>
                            <div class="control-group">  
                                <label class="control-label" for="vestado">Estados</label>  
                                <div class="controls">  
                                    <select class="input-xlarge" id="vestado" disabled="disabled">
                                        <option id="0">Seleccione</option>
                                    </select>
                                </div>  
                            </div>
                        </fieldset>  
                    </form>  
                </div>
                <div class="modal-footer">
                    <button id="btnVerCancelar" class="btn" data-dismiss="modal" aria-hidden="true">Cerrar</button>
                </div>
            </div>
            <!-- FIN DIALOGO MODAL : VER -->

            <!-- DIALOGO MODAL : NUEVO -->
            <div id="dlgAgregar" class="modal hide fade" tabindex="-1" role="dialog">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h3 id="myModalLabel">Nuevo Sub-Proyecto</h3>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" id="form_nuevo">  
                        <div class="alert mensajes" style="display:none;">
                            <button type="button" class="close" onclick="$('.alert').hide()">&times;</button>
                            <strong>Mensaje : </strong><span id="mensaje"></span>
                        </div>
                        <fieldset>  
                            <div class="control-group">  
                                <label class="control-label" for="proyecto">Proyecto</label>  
                                <div class="controls">  
                                    <input type="hidden" name="idregistro" id="idregistro" />
                                    <select class="input-xlarge" id="proyecto">
                                        <option id="0">Seleccione</option>
                                    </select>
                                </div>  
                            </div>
                            <div class="control-group">  
                                <label class="control-label" for="nombre">Sub-Proyecto</label>  
                                <div class="controls"> 
                                    <input type="text" class="input-xlarge" id="nombre" placeholder="Ingrese el Nombre">	
                                </div>  
                            </div>
                            <div class="control-group">  
                                <label class="control-label" for="fechainicio">Fecha Inicio</label>  
                                <div class="controls">  
                                    <input type="date" class="input-xlarge" id="fechainicio" placeholder="Ingrese Fecha de Inicio">	
                                </div>  
                            </div>
                            <div class="control-group">  
                                <label class="control-label" for="fechafinal">Fecha Fin</label>  
                                <div class="controls">  
                                    <input type="date" class="input-xlarge" id="fechafinal" placeholder="Ingrese Fecha de Termino">		              <!--p class="help-block"></p-->  
                                </div>  
                            </div>	
                            <div class="control-group">  
                                <label class="control-label" for="monto">Monto</label>  
                                <div class="controls">  
                                    <select class="input-medium" id="moneda">
                                        <option id="0">Seleccione</option>
                                    </select>
                                    <input type="text" class="input-small" id="monto" placeholder="Monto del Contrato">	
                                </div>  
                            </div>
                            <div class="control-group">  
                                <label class="control-label" for="ubicacion">Ubicacion</label>  
                                <div class="controls">  
                                    <select class="input-xlarge" id="ubicacion" >
                                        <option id="0">Seleccione</option>
                                    </select>
                                </div>  
                            </div>
                            <div class="control-group">  
                                <label class="control-label" for="empresa">Empresa</label>  
                                <div class="controls">  
                                    <select class="input-xlarge" id="empresa" >
                                        <option id="0">Seleccione</option>
                                    </select>
                                </div>  
                            </div>
                            <div class="control-group">  
                                <label class="control-label" for="mandante">Mandante</label>  
                                <div class="controls">  
                                    <select class="input-xlarge" id="mandante">
                                        <option id="0">Seleccione</option>
                                    </select>
                                </div>  
                            </div>
                            <div class="control-group">  
                                <label class="control-label" for="estado">Estados</label>  
                                <div class="controls">  
                                    <select class="input-xlarge" id="estado">
                                        <option id="0">Seleccione</option>
                                    </select>
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
            <!-- FIN DIALOGO MODAL : NUEVO -->

            <!-- DIALOGO MODAL : MODIFICAR -->
            <div id="dlgModificar" class="modal hide fade" tabindex="-1" role="dialog">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h3 id="myModalLabel">Editar Usuario</h3>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" id="form_nuevo">  
                        <div class="alert mmensajes" style="display:none;">
                            <button type="button" class="close" onclick="$('.alert').hide()">&times;</button>
                            <strong>Mensaje : </strong><span id="mmensaje"></span>
                        </div>
                        <fieldset>  
                            <div class="control-group">  
                                <label class="control-label" for="mproyecto">Proyecto</label>  
                                <div class="controls">  
                                    <input type="hidden" name="midregistro" id="midregistro" />
                                    <select class="input-xlarge" id="mproyecto">
                                        <option id="0">Seleccione</option>
                                    </select>
                                </div>  
                            </div>
                            <div class="control-group">  
                                <label class="control-label" for="mnombre">Sub-Proyecto</label>  
                                <div class="controls"> 
                                    <input type="text" class="input-xlarge" id="mnombre" placeholder="Ingrese el Nombre">	
                                </div>  
                            </div>
                            <div class="control-group">  
                                <label class="control-label" for="mfechainicio">Fecha Inicio</label>  
                                <div class="controls">  
                                    <input type="date" class="input-xlarge" id="mfechainicio" placeholder="Ingrese Fecha de Inicio">	
                                </div>  
                            </div>
                            <div class="control-group">  
                                <label class="control-label" for="mfechafinal">Fecha Fin</label>  
                                <div class="controls">  
                                    <input type="date" class="input-xlarge" id="mfechafinal" placeholder="Ingrese Fecha de Termino">		              <!--p class="help-block"></p-->  
                                </div>  
                            </div>	
                            <div class="control-group">  
                                <label class="control-label" for="mmonto">Monto</label>  
                                <div class="controls">  
                                    <select class="input-medium" id="mmoneda">
                                        <option id="0">Seleccione</option>
                                    </select>
                                    <input type="text" class="input-small" id="mmonto" placeholder="Monto del Contrato">	
                                </div>  
                            </div>
                            <div class="control-group">  
                                <label class="control-label" for="mubicacion">Ubicacion</label>  
                                <div class="controls">  
                                    <select class="input-xlarge" id="mubicacion" >
                                        <option id="0">Seleccione</option>
                                    </select>
                                </div>  
                            </div>
                            <div class="control-group">  
                                <label class="control-label" for="mempresa">Empresa</label>  
                                <div class="controls">  
                                    <select class="input-xlarge" id="mempresa" >
                                        <option id="0">Seleccione</option>
                                    </select>
                                </div>  
                            </div>
                            <div class="control-group">  
                                <label class="control-label" for="mmandante">Mandante</label>  
                                <div class="controls">  
                                    <select class="input-xlarge" id="mmandante">
                                        <option id="0">Seleccione</option>
                                    </select>
                                </div>  
                            </div>
                            <div class="control-group">  
                                <label class="control-label" for="mestado">Estados</label>  
                                <div class="controls">  
                                    <select class="input-xlarge" id="mestado">
                                        <option id="0">Seleccione</option>
                                    </select>
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
            <!-- FIN DIALOGO MODAL : MODIFICAR -->

            <!-- DIALOGO MODAL : ELIMINAR -->
            <div id="dlgEliminar" class="modal hide fade" tabindex="-1" role="dialog">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h3 id="myModalLabel">Confirmaci&oacute;n : Eliminar Registro</h3>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" id="form_nuevo">  
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
        <script type="text/javascript" src="controlador/subproyectos.js"></script>

    </body></html>