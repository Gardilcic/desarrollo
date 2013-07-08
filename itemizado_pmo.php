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
        <!--[if lt IE 9]>
          <script src="../assets/js/html5shiv.js"></script>
        <![endif]-->	

    </head>

    <body>

        <?php include('./libs/php/encabezado.php'); ?>

        <div class="container">

            <div class="row-fluid">
                <div class="span12">
                    <div class="row-fluid">
                        <div class="span10">
                            <legend>Mantenedor de Itemizado PMO</legend>
                        </div>
                        <div class="span2" style="float: right !important; margin-top: 15px; right: 0px !important; ">
                            <a class='btn btn-success' href='#dlgAgregar' data-toggle='modal' ><i class='icon-file icon-white'></i>Nuevo Item PMO</a>
                        </div>
                    </div>
                </div>
            </div>

            <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered table-hover" id="example">
                <thead>
                    <tr>
                        <th>Codigo</th>
                        <th>Descripcion</th>
                        <th>Unidad</th>
                        <th>Factor Equivalencia</th>
                        <th>Version</th>
                        <th>Estado</th>		
                        <th>Operaciones</th>	
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

            <!-- DIALOGO MODAL : VER -->
            <div id="dlgVer" class="modal hide fade" tabindex="-1" role="dialog">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h3 id="myModalLabel">Proyecto</h3>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" id="form_ver">  
                        <div class="alert vmensajes" style="display:none;">
                            <button type="button" class="close" onclick="$('.alert').hide()">&times;</button>
                            <strong>Mensaje : </strong><span id="vmensaje"></span>
                        </div>
                        <fieldset>  
                            <div class="control-group">  
                                <label class="control-label" for="codigo">Codigo</label>  
                                <div class="controls"> 
                                    <input type="text" class="input-xlarge" id="codigo1" placeholder="Ingrese su Codigo" readonly="readonly">	
                                </div>  
                            </div>
                            <div class="control-group">  
                                <label class="control-label" for="vnumero">Nro. de Contrato</label>  
                                <div class="controls"> 
                                    <input type="text" class="input-xlarge" id="vnumero" placeholder="Ingrese el Nro de Contrato" readonly="readonly">	
                                </div>  
                            </div>
                            <div class="control-group">  
                                <label class="control-label" for="varchivo">Archivo</label>  
                                <div class="controls">  
                                    <span id="varchivo"></span>            
                                </div>  
                            </div>
                            <div class="control-group">  
                                <label class="control-label" for="vfirmante1">Firmante 1</label>  
                                <div class="controls">  
                                    <input type="text" class="input-xlarge" id="vfirmante1" placeholder="Ingrese Nombre del Firmante 1" readonly="readonly">	
                                </div>  
                            </div>
                            <div class="control-group">  
                                <label class="control-label" for="vfirmante2">Firmante 2</label>  
                                <div class="controls">  
                                    <input type="text" class="input-xlarge" id="vfirmante2" placeholder="Ingrese Nombre del Firmante 2" readonly="readonly">		              <!--p class="help-block"></p-->  
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

            <!-- DIALOGO MODAL : NUEVO  -->
            <div id="dlgAgregar" class="modal hide fade" tabindex="-1" role="dialog">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h3 id="myModalLabel">Itemizado PMO</h3>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" id="form_nuevo" enctype="multipart/form-data">  
                        <div class="alert mensajes" style="display:none;">
                            <button type="button" class="close" onclick="$('.alert').hide()">&times;</button>
                            <strong>Mensaje : </strong><span id="mensaje"></span>
                        </div>
                        <fieldset>  
                            <div class="control-group">  
                                <label class="control-label" for="empresas">Empresa</label>  
                                <div class="controls">  
                                    <select class="input-xlarge" id="empresas">
                                        <option value="0">Seleccione</option>
                                    </select>
                                </div>  
                            </div>
                            <div class="control-group">  
                                <label class="control-label" for="padre">Item padre</label>  
                                <div class="controls">  
                                    <select class="input-xlarge" id="padre">
                                        <option value="0">Ingresar como item padre</option>
                                    </select>
                                </div>  
                            </div>
                            <div class="control-group">  
                                <label class="control-label" for="codigo">Codigo</label>  
                                <div class="controls"> 
                                    <input type="text" class="input-xlarge" id="codigo" placeholder="Ingrese su Codigo" readonly="readonly">	
                                </div>  
                            </div>
                            <div class="control-group">  
                                <label class="control-label" for="descripcion">Descripcion</label>  
                                <div class="controls"> 
                                    <input type="text" class="input-xlarge" id="descripcion" placeholder="Ingrese la descripcion">	
                                </div>  
                            </div>
                            <div class="control-group">  
                                <label class="control-label" for="factor">Factor Equivalencia</label>  
                                <div class="controls">  
                                    <input type="text" class="input-xlarge" id="factor" placeholder="Ingrese factor de equivalencia">	
                                </div>  
                            </div>                                                    
                            <div class="control-group">  
                                <label class="control-label" for="unidades">Unidad</label>  
                                <div class="controls">  
                                    <select class="input-xlarge" id="unidades">
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
                    <h3 id="myModalLabel">Editar Proyecto</h3>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" id="form_modificar">  
                        <div class="alert mmensajes" style="display:none;">
                            <button type="button" class="close" onclick="$('.alert').hide()">&times;</button>
                            <strong>Mensaje : </strong><span id="mmensaje"></span>
                        </div> 
                        <fieldset>                              
                            <div class="control-group">  
                                <label class="control-label" for="mcodigo">Codigo</label>  
                                <div class="controls"> 
                                    <input type="hidden" class="input-xlarge" id="midregistro" >	
                                    <input type="text" class="input-xlarge" id="mcodigo" placeholder="Ingrese su Codigo" readonly="readonly">	
                                </div>  
                            </div>
                            <div class="control-group">  
                                <label class="control-label" for="mdescripcion">Descripcion</label>  
                                <div class="controls"> 
                                    <input type="text" class="input-xlarge" id="mdescripcion" placeholder="Ingrese la descripcion">	
                                </div>  
                            </div>
                            <div class="control-group">  
                                <label class="control-label" for="mfactor">Factor Equivalencia</label>  
                                <div class="controls">  
                                    <input type="text" class="input-xlarge" id="mfactor" placeholder="Ingrese factor de equivalencia">	
                                </div>  
                            </div>                                                    
                            <div class="control-group">  
                                <label class="control-label" for="munidades">Unidad</label>  
                                <div class="controls">  
                                    <select class="input-xlarge" id="munidades">
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
        <script type="text/javascript" src="controlador/itemizado_pmo.js"></script>

    </body></html>