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
                        
                            
                        
                        </div>
                    </div>
                </div>
            </div>
            <p>
            	<span class="span5" style="margin-left:60%;">
            		<a class='btn btn-success' href='#dlgAgregar' data-toggle='modal' ><i class='icon-file icon-white'></i>Nuevo Item PMO</a>
            		<a class='btn btn-info' href='#dlgcargaxls' data-toggle='modal' ><i class='icon-file icon-white'></i>Cargar Desde Archivo</a>
            		<a class='btn btn-success' href='#dlgexportaxls' data-toggle='modal' ><i class='icon-file icon-white'></i>Exportar a Excel</a>
				</span>
			</p>
			<br />
            <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered table-hover" id="example">
                <thead>
                    <tr>
                        <th>Codigo</th>
                        <th>Descripcion</th>
                        <th>Unidad</th>
                        <th>Factor Equivalencia</th>
                        <th>Version</th>
                        <th>Nombre</th>
                        <th>Estado</th>		
                        <th>Operaciones</th>	
                    </tr>
                </thead>
                <tbody id="tabla_body">
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="8" class="pager form-horizontal tablesorter-pager" data-column="0" style="">
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
                                <label class="control-label" for="empresas">Versi&oacute;n</label>  
                                <div class="controls">  
                                    <select class="input-xlarge" id="nversion">
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
                                    <input type="text" class="input-xlarge" id="ndescripcion" placeholder="Ingrese la descripcion">	
                                </div>  
                            </div>
                            <div class="control-group">  
                                <label class="control-label" for="factor">Factor Equivalencia</label>  
                                <div class="controls">  
                                    <input type="text" class="input-xlarge" id="nfactor" placeholder="Ingrese factor de equivalencia">	
                                </div>  
                            </div>                                                    
                            <div class="control-group">  
                                <label class="control-label" for="unidades">Unidad</label>  
                                <div class="controls">  
                                    <select class="input-xlarge" id="nunidades">
                                        <option id="0">Seleccione</option>
                                    </select>
                                </div>  
                            </div>
                            <div class="control-group">  
                                <label class="control-label" for="estado">Estados</label>  
                                <div class="controls">  
                                    <select class="input-xlarge" id="nestado">
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
            <!-- FIN DIALOGO MODAL : VER -->

            <!-- DIALOGO MODAL : cargar XLS  -->
            <div id="dlgcargaxls" class="modal hide fade" tabindex="-1" role="dialog">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h3 id="myModalLabel">Cargador de Archivo Excel</h3>
                </div>
                <form class="form-horizontal" id="form_nuevo" method="post" action="validador_masivo_item_pmo.php" enctype="multipart/form-data">
                	<div class="modal-body">
                        <div class="alert mensajes" style="display:none;">
                            <button type="button" class="close" onclick="$('.alert').hide()">&times;</button>
                            <strong>Mensaje : </strong><span id="mensaje"></span>
                        </div>
                        <fieldset>  
                            <div class="control-group">  
                                <label class="control-label" for="empresas">Empresa</label>  
                                <div class="controls">  
                                    <select class="input-xlarge" id="empresa" name="empresa">
                                        <option value="0">Seleccione</option>
                                    </select>
                                </div>  
                            </div>
                            <div class="control-group">  
                                <label class="control-label" for="padre">Nombre de la Versi&oacute;n</label>  
                                <div class="controls">
                                    <input type="text" class="input-xlarge" id="nombre_de_version" name="nombre_de_version" placeholder="Nueva versi&oacute;n">
                                </div>
                            </div>
                            <div class="control-group">  
                                <label class="control-label" for="codigo">Archivo:</label>  
                                <div class="controls"> 
                                    <input type="file" class="input-xlarge" id="archivo" name="archivo" placeholder="Archivo">	
                                </div>  
                            </div>
	                    </fieldset>  
                </div>
                <div class="modal-footer">
                    <button id="btnNuevoCancelar" class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
                    <input type="submit" value="Cargar" name="cargar_archivo" id="cargar_archivo" class="btn btn-primary">
                </div>
               </form> 
            </div>
            <!-- FIN DIALOGO MODAL : NUEVO -->
			<!-- CUADRO DE EXPORTACION -->
			<div id="dlgexportaxls" class="modal hide fade" tabindex="-1" role="dialog">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h3 id="myModalLabel">Descargar datos a archivo Excel</h3>
                </div>
                <form class="form-horizontal" id="form_nuevo" method="post" action="exportador_pmo_xls.php" enctype="multipart/form-data">
                	<div class="modal-body">
                        <div class="alert mensajes" style="display:none;">
                            <button type="button" class="close" onclick="$('.alert').hide()">&times;</button>
                            <strong>Mensaje : </strong><span id="mensaje"></span>
                        </div>
                        <fieldset>  
                            <div class="control-group">  
                                <label class="control-label" for="empresas">Empresa</label>  
                                <div class="controls">  
                                    <select class="input-xlarge" id="xls_empresa" name="xls_empresa" onchange="">
                                        <option value="0">Seleccione</option>
                                    </select>
                                </div>  
                            </div>
                            <div class="control-group">  
                                <label class="control-label" for="padre">Nombre de la Versi&oacute;n</label>  
                                <div class="controls">
                                    <select class="input-xlarge" id="nom_version" name="nom_version">
                                        <option value="0">Seleccione</option>
                                    </select>
                                </div>
                            </div>
                        </fieldset>  
                </div>
                <div class="modal-footer">
                    <button id="btnNuevoCancelar" class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
                    <input type="submit" value="Descargar" name="cargar_archivo" id="cargar_archivo" class="btn btn-primary">
                </div>
               </form> 
            </div>
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
        <script type="text/javascript" src="controlador/carga_itemizado_pmo.js"></script>
    </body></html>