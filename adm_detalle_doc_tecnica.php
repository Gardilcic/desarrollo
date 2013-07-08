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
    	
		function popup_obj()
		{
		window.open("adm_help_obj.php?url="+location.pathname, "SIGP - Ayuda", "directories=no, menubar =no,status=no,toolbar=no,location=no,scrollbars=no,fullscreen=no,height=450,width=350,left=200,top=200")
		}
		
		function popup_det()
		{
			window.open("adm_help_det.php?url="+location.pathname, "SIGP - Ayuda", "directories=no, menubar =no,status=no,toolbar=no,location=no,scrollbars=no,fullscreen=no,height=450,width=350,left=200,top=200")
		}
		
		function popup_doc()
		{
			window.open("adm_help_archivo.php?url="+location.pathname, "SIGP - Ayuda", "directories=no, menubar =no,status=no,toolbar=no,location=no,scrollbars=no,fullscreen=no,height=150,width=150,left=200,top=200")
		}

	</script>
  </head>
  <body>
	<?php include('libs/php/encabezado.php'); ?>

    <div class="container">
    	<legend>Mantenedor de documentaci&oacute;n T&eacute;cnica</legend>
    	<!--<p style="text-align:right;"><a class='btn btn-success' href='#dlgAgregar' data-toggle='modal'><i class='icon-file icon-white'></i>Nuevo pa&iacute;s</a></p>
    	<!--TABLA DE BUSCADORES-->
    	<select id="lista_modulos"></select>
    	&nbsp;&nbsp;&nbsp;
    	<select id="lista_paginas"></select>
		<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered table-hover" id="example">
			<thead>
				<tr>
					<th>Usuario</th>
					<th>Fecha</th>
					<th>Informaci&oacute;n</th>
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
		
		<!-- DIALOGO MODAL : MODIFICAR-->
		<div id="dlgModificar" class="modal hide fade" tabindex="-1" role="dialog">
		  <div class="modal-header">
		    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
		    <h3 id="myModalLabel">Editar detalle</h3>
		  </div>
		  <div class="modal-body">
		    <form class="form-horizontal" id="form_nuevo">  
			    <div class="alert mmensajes" style="display:none;">
				  <button type="button" class="close" onclick="$('.alert').hide()">&times;</button>
				  <strong>Warning!</strong><span id="mmensaje"></span>
				</div>
		        <fieldset>
		        	<input type="hidden" id="mid"> 
		          <div class="control-group">  
		            <label class="control-label" for="perfiles">Usuario</label>  
		            <div class="controls">  
		                <input type="text" class="input-xlarge" id="mod_nombre" placeholder="Usuario" readonly="readonly">	            
		            </div>  
		          </div>
		          <div class="control-group">  
		            <label class="control-label" for="NuevoNombre">Fecha</label>  
		            <div class="controls">  
		              <input type="date" class="input-xlarge" id="mod_fecha" placeholder="fecha">
		              <!--p class="help-block"></p-->
		            </div>
		          </div>
		          <div class="control-group">  
		            <label class="control-label" for="NuevoNombre">Informaci&oacute;n</label>  
		            <div class="controls">  
		              <textarea id="mod_detalle" style="width:270px; height:160px;"></textarea>
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
		
		
		<div id="dlg_objetivos" class="modal hide fade" tabindex="-1" role="dialog">
		  <div class="modal-header">
		    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
		    <h3 id="myModalLabel">Objetivos del programa</h3>
		  </div>
		  <div class="modal-body">
		    <form class="form-horizontal" id="form_nuevo">
			    <div class="alert mmensajes" style="display:none;">
				  <button type="button" class="close" onclick="$('.alert').hide()">&times;</button>
				  <strong>Warning!</strong><span id="mmensaje"></span>
				</div>
				<fieldset>
		        	<input type="hidden" id="mid"> 
		          <div class="control-group">  
		            <label class="control-label" for="perfiles">Objetivos</label>  
		            <div class="controls">  
		                <textarea id="p_objetivos" cols="30" rows="12" readonly="readonly" style="width:250px; height:100px;"></textarea>            
		            </div>  
		          </div>
		        </fieldset>		        
			</form>  
		  </div>
		  <div class="modal-footer">
		    <!--<button id="btn_obj_cerrar" class="btn btn-primary">Cerrar</button>-->
		  </div>
		</div>
		<div id="dlg_detalle" class="modal hide fade" tabindex="-1" role="dialog">
		  <div class="modal-header">
		    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
		    <h3 id="myModalLabel">Detalle de la aplicación</h3>
		  </div>
		  <div class="modal-body">
		    <form class="form-horizontal" id="form_nuevo">
			    <div class="alert mmensajes" style="display:none;">
				  <button type="button" class="close" onclick="$('.alert').hide()">&times;</button>
				  <strong>Warning!</strong><span id="mmensaje"></span>
				</div>
				<fieldset>
		        	<input type="hidden" id="mid">
		          <div class="control-group">  
		            <label class="control-label" for="perfiles">Detalle</label>  
		            <div class="controls">  
		                <textarea cols="30" rows="12" id="p_detalle" readonly="readonly" style="width:280px; height:210px;"></textarea>         
		            </div>  
		          </div>
		        </fieldset>		        
			</form>  
		  </div>
		  <div class="modal-footer">
		    <!--<button id="btn_obj_cerrar" class="btn btn-primary close">Cerrar</button>-->
		  </div>
		</div>
		
		<div id="dlg_doc" class="modal hide fade" tabindex="-1" role="dialog">
		  <div class="modal-header">
		    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
		    <h3 id="myModalLabel">Documento de la aplicación</h3>
		  </div>
		  <div class="modal-body">
		    <form class="form-horizontal" id="form_nuevo">
			    <div class="alert mmensajes" style="display:none;">
				  <button type="button" class="close" onclick="$('.alert').hide()">&times;</button>
				  <strong>Warning!</strong><span id="mmensaje"></span>
				</div>
				<fieldset>
		        	<input type="hidden" id="mid"> 
		          <div class="control-group">  
		            <div class="controls" id="capa_link">
		                	            
		            </div>  
		          </div>
		        </fieldset>		        
			</form>  
		  </div>
		  
		  <div class="modal-footer">
		    <!--<button id="btn_obj_cerrar" class="btn btn-primary">Cerrar</button>-->
		  </div>
		</div>
	<p style="padding: 10px; text-align: right;">
		<a id="btnReporte" class="btn btn-success"><i class="icon-file icon-white"></i> Obtener Reporte en PDF</a>
    </p>
    </div> <!-- /container -->
    
	<?php include('libs/php/piepagina.php'); ?>  
	<script type="text/javascript" src="controlador/detalle_doc_tecnica.js"></script>
	
</body></html>