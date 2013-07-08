<?php
session_start();
include('libs/php/valida_pagina_usuario.php');
$_SESSION["Imagenes"] = "";
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

            <legend>Mantenedor de Itemizado de Subproyectos</legend>
            <p style="float: left;">
                Seleccione un Subproyecto :  <select id="subproyectos" class="input-xlarge"></select>
            </p>
            <p style="float: right;">
                <a class='btn btn-success' href='#dlgAgregar' data-toggle='modal' ><i class='icon-file icon-white'></i>Nuevo Item</a>
                <a class='btn btn-info' href='#dlgcargaxls' data-toggle='modal' ><i class='icon-file icon-white'></i>Cargar Desde Archivo</a>
                <a class='btn btn-success' href='#dlgexportaxls' data-toggle='modal' ><i class='icon-file icon-white'></i>Exportar a Excel</a>
            </p>
            
            <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered table-hover" id="example">
                <thead>
                    <tr>
                        <th>Codigo</th>
                        <th>Descripcion</th>
                        <th>Unidad</th>
                        <th>Factor Equivalencia</th>
                        <th>Nombre</th>
                        <th>Estado</th>		
                        <th>Operaciones</th>	
                    </tr>
                </thead>
                <tbody id="tabla_body" style="position: relative;">
                </tbody>
                <tfoot id="buscador" >
                    <tr>
                        <th colspan="7" class="pager form-horizontal tablesorter-pager" data-column="0" style="">
                            <button class="btn first disabled"><i class="icon-step-backward"></i></button>
                            <button class="btn prev disabled"><i class="icon-arrow-left"></i></button>
                            <span class="pagedisplay">1 - 1 / 1 (1)</span> <!-- this can be any element, including an input -->
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
            <br>
            <br>
            <br>

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

            <!-- DIALOGO MODAL : cargar XLS  -->
            <div id="dlgcargaxls" class="modal hide fade" tabindex="-1" role="dialog">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h3 id="myModalLabel">Cargador de Archivo Excel</h3>
                </div>
                <form class="form-horizontal" id="form_nuevo" method="post" action="validador_masivo_item_proyecto.php" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="alert mensajes" style="display:none;">
                            <button type="button" class="close" onclick="$('.alert').hide()">&times;</button>
                            <strong>Mensaje : </strong><span id="mensaje"></span>
                        </div>
                        <fieldset>  
                            <div class="control-group">  
                                <label class="control-label" for="empresas">Subproyecto</label>  
                                <div class="controls">  
                                    <select class="input-xlarge" id="subproyecto" name="subproyecto">
                                        <option value="0">Seleccione</option>
                                    </select>
                                </div>  
                            </div>
                            <div class="control-group">  
                                <label class="control-label" for="padre">Nombre de la carga</label>  
                                <div class="controls">
                                    <input type="text" class="input-xlarge" id="nombre_de_carga" name="nombre_de_carga" placeholder="Nombre de la carga">
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
            <div id="dlgexportaxls" class="modal hide fade" tabindex="-1" role="dialog">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h3 id="myModalLabel">Descargar datos a archivo Excel</h3>
                </div>
                <form class="form-horizontal" id="form_nuevo" method="post" action="exportador_proyecto_xls.php" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="alert mensajes" style="display:none;">
                            <button type="button" class="close" onclick="$('.alert').hide()">&times;</button>
                            <strong>Mensaje : </strong><span id="mensaje"></span>
                        </div>
                        <fieldset>  
                            <div class="control-group">  
                                <label class="control-label" for="empresas">Subproyecto</label>  
                                <div class="controls">  
                                    <select class="input-xlarge" id="xls_subproyecto" name="xls_subproyecto">
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
            <!--AGREGAR ITEMIZADO-->
            <div id="dlgAgregar" class="modal hide fade" tabindex="-1" role="dialog">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h3 id="myModalLabel">Itemizado Subproyecto</h3>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" id="form_nuevo" enctype="multipart/form-data">  
                        <div class="alert mensajes" style="display:none;">
                            <button type="button" class="close" onclick="$('.alert').hide()">&times;</button>
                            <strong>Mensaje : </strong><span id="mensaje"></span>
                        </div>
                        <fieldset>  
                            <div class="control-group">  
                                <label class="control-label" for="empresas">Subproyectos</label>  
                                <div class="controls">  
                                    <select class="input-xlarge" id="nuevo_subproyectos">
                                        <option value="0">Seleccione</option>
                                    </select>
                                </div>  
                            </div>
                            <div class="control-group">  
                                <label class="control-label" for="padre">Item padre</label>  
                                <div class="controls">  
                                    <select class="input-xlarge" id="nuevo_padre">
                                        <option value="0">Ingresar como item padre</option>
                                    </select>
                                </div>  
                            </div>
                            <div class="control-group">  
                                <label class="control-label" for="codigo">Codigo</label>  
                                <div class="controls"> 
                                    <input type="text" class="input-xlarge" id="nuevo_codigo" placeholder="Ingrese su Codigo" readonly="readonly">	
                                </div>  
                            </div>
                            <div class="control-group">  
                                <label class="control-label" for="padre">Itemizado PMO</label>  
                                <div class="controls">  
                                    <select class="input-xlarge" id="nuevo_itm_pmo">
                                        <option value="0">Elija</option>
                                    </select>
                                </div>  
                            </div>
                            <div class="control-group">  
                                <label class="control-label" for="codigo">Precio</label>  
                                <div class="controls"> 
                                    <input type="text" class="input-xlarge" id="nuevo_precio" placeholder="0">	
                                </div>  
                            </div>
                            <div class="control-group">  
                                <label class="control-label" for="descripcion">Descripcion</label>  
                                <div class="controls"> 
                                    <input type="text" class="input-xlarge" id="nueva_descripcion" placeholder="Ingrese la descripcion">	
                                </div>  
                            </div>
                            <div class="control-group">  
                                <label class="control-label" for="factor">Factor Equivalencia</label>  
                                <div class="controls">  
                                    <input type="text" class="input-xlarge" id="nueva_factor" placeholder="Ingrese factor de equivalencia">	
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
            <!--EDITAR ITEMIZADO-->

            <div id="dlgModificar" class="modal hide fade" tabindex="-1" role="dialog">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h3 id="myModalLabel">Modificar Itemizado Subproyecto</h3>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" id="form_nuevo" enctype="multipart/form-data">  
                        <div class="alert mensajes" style="display:none;">
                            <button type="button" class="close" onclick="$('.alert').hide()">&times;</button>
                            <strong>Mensaje : </strong><span id="mensaje"></span>
                        </div>
                        <fieldset> 
                            <input type="hidden" id="midregistro">
                            <div class="control-group">  
                                <label class="control-label" for="padre">C&oacute;digo Itemizado</label>  
                                <div class="controls">  
                                    <input type="text" class="input-xlarge" id="mod_itm_proy" placeholder="0" readonly="readonly">
                                </div>  
                            </div>
                            <div class="control-group">  
                                <label class="control-label" for="padre">Itemizado PMO</label>  
                                <div class="controls">  
                                    <select class="input-xlarge" id="mod_itm_pmo">
                                        <option value="0">Elija</option>
                                    </select>
                                </div>  
                            </div>
                            <div class="control-group">  
                                <label class="control-label" for="codigo">Precio</label>  
                                <div class="controls"> 
                                    <input type="text" class="input-xlarge" id="mod_precio" placeholder="0">	
                                </div>  
                            </div>
                            <div class="control-group">  
                                <label class="control-label" for="descripcion">Descripcion</label>  
                                <div class="controls"> 
                                    <input type="text" class="input-xlarge" id="mod_descripcion" placeholder="Ingrese la descripcion">	
                                </div>  
                            </div>
                            <div class="control-group">  
                                <label class="control-label" for="factor">Factor Equivalencia</label>  
                                <div class="controls">  
                                    <input type="text" class="input-xlarge" id="mod_factor" placeholder="Ingrese factor de equivalencia">	
                                </div>  
                            </div>                                                    
                            <div class="control-group">
                                <label class="control-label" for="unidades">Unidad</label>  
                                <div class="controls">
                                    <select class="input-xlarge" id="mod_unidades">
                                        <option id="0">Seleccione</option>
                                    </select>
                                </div>  
                            </div>
                            <div class="control-group">  
                                <label class="control-label" for="estado">Estados</label>  
                                <div class="controls">  
                                    <select class="input-xlarge" id="mod_estado">
                                        <option id="0">Seleccione</option>
                                    </select>
                                </div>  
                            </div>
                        </fieldset>  
                    </form>  
                </div>
                <div class="modal-footer">
                    <button id="btnActualizarCancelar" class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
                    <button id="btnActualizarAceptar" class="btn btn-primary">Guardar</button>
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
        <script type="text/javascript" src="controlador/carga_xls.js"></script>
    </body></html>
<?php
/* APLICACION DE CARGADOR MASIVO. NO TOCAR */
$a = 0;
/* if(isset($_POST['cargar_archivo']))
  {
  require_once('libs/php/generales.php');
  $archivo_ini = $_FILES['archivo']['tmp_name'];
  $nombre_nuevo=date('Y-m-d-hi');
  $type = $_FILES['archivo'] ['type'];
  $ruta = "libs/cargas_masivas/".$nombre_nuevo.".xls";
  $subio = false;
  copy($archivo_ini, $ruta);
  if (file_exists($ruta))
  {
  Header("Location: validador_masivo_item_pmo.php?file:".$ruta);
  echo "<script type='text/javascript'>window.locationf='validador_masivo_item_pmo.php?file:".$ruta."'</script>";
  }
  else
  {
  alert('Por alguna razón su sulicitud no ha podido concretarse. Por favor reintente.');
  }
  die();
  }/ */
?>