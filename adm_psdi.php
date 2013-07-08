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

function habilita_fecha(modo)
{
	if(modo==0)
	{
		if($('#Nuevo_psdi_frecuencia').val()==0)
		{
			$('#capa_calendario').css("display","block");
			//document.getElementById('capa_calendario').visible="true";
		}
		else
		{
			$('#capa_calendario').css("display","none");
		}
	}
	else
	{
		if($('#mNuevo_psdi_frecuencia').val()==0)
		{
			$('#mcapa_calendario').css("display","block");
			//document.getElementById('capa_calendario').visible="true";
		}
		else
		{
			$('#mcapa_calendario').css("display","none");
		}
	}
}

</script>
  </head>
  <body>
	
	<?php include('libs/php/encabezado.php'); ?>

    <div class="container">
    	<legend>Mantenedor de Dato Indicador</legend>
    	
    	<p style="text-align:right;"><a class='btn btn-success' href='#dlgAgregar' data-toggle='modal'><i class='icon-file icon-white'></i>Nuevo PSDI</a></p>
    	<!--TABLA DE BUSCADORES-->
		<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered table-hover" id="example">
			<thead>
				<tr>
					<th>Proyecto</th>
					<th>Subproyecto</th>
					<th>Dato Ind.</th>
					<th>Frec.</th>
					<th>Cal</th>
					<th>Nom. Corto</th>
					<th>&Aacute;rea</th>
					<th>Perspec.</th>
					<th>Ingres.</th>
					<th>Super.</th>
					<th>Prop.</th>
					<th>Correo</th>
					<th>Cant. Dias</th>
					<th>Acciones</th>
				</tr>
			</thead>
			<tbody id="tabla_body">
			</tbody>
			<tfoot>
				<!--<tr>
					<th data-column="1">Descripci&oacute;n</th>
					<th data-column="2">Unidad</th>
					<th data-column="3">Nivel</th>
					<th data-column="4">Detalle de nivel</th>
					<th data-column="5">Tolerancia 1</th>
					<th data-column="6">Tolerancia 2</th>
					<th data-column="7">Tipo</th>
					<th data-column="8">Estado</th>
					<th data-column="9">Acciones</th>
				</tr>-->
				<tr>
					<th colspan="14" class="pager form-horizontal tablesorter-pager" data-column="0" style="">
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
		
		<!-- DIALOGO MODAL : NUEVO USUARIO -->
		<div id="dlgAgregar" class="modal hide fade" tabindex="-1" role="dialog">
		  <div class="modal-header">
		    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
		    <h3 id="myModalLabel">Nuevo Dato Indicador</h3>
		  </div>
		  <div class="modal-body">
		    <form class="form-horizontal" id="form_nuevo">  
			    <div class="alert mensajes" style="display:none;">
				  <button type="button" class="close" onclick="$('.alert').hide()">&times;</button>
				  <strong>CUIDADO!</strong><span id="mensaje"></span>
				</div>
		        <fieldset>
		        <input type="hidden" id="mid">  
		          <div class="control-group">  
		            <label class="control-label" for="perfiles">Sub-Proyecto</label>  
		            <div class="controls">  
		                <select id="Nuevo_psdi_subproyecto"></select>	            
		            </div>
		          </div>
		          <div class="control-group">  
		            <label class="control-label" for="perfiles">Frecuencia</label>  
		            <div class="controls">  
		                <select id="Nuevo_psdi_frecuencia" onchange="habilita_fecha(0);"></select>	            
		            </div>
		          </div>
		          <div class="control-group" id="capa_calendario" style="display:none">  
		            <label class="control-label" for="perfiles">Calendario</label>  
		            <div class="controls">  
		                <select id="nuevo_psdi_calendar"></select>
		            </div>
		          </div>
		          <div class="control-group">  
		            <label class="control-label" for="perfiles">Dato / Indicador</label>  
		            <div class="controls">  
		                <select id="Nuevo_psdi_indicador"></select>
		            </div>
		          </div>
		          <div class="control-group">  
		            <label class="control-label" for="perfiles">Nombre Corto</label>  
		            <div class="controls">  
		                <input type="text"  id="Nuevo_psdi_nombrecorto">
		            </div>
		          </div>
		         <div class="control-group">  
		            <label class="control-label" for="perfiles">&Aacute;rea</label>  
		            <div class="controls">
		                <select id="Nuevo_psdi_area"></select>
		            </div>
		          </div>
		          <div class="control-group">  
		            <label class="control-label" for="perfiles">Perspectiva</label>  
		            <div class="controls">
		                <select id="Nuevo_psdi_perspectiva"></select>
		            </div>
		          </div>
		          <div class="control-group" id="capa_ingresado_por">  
		            <label class="control-label" for="perfiles">Ingresado por</label>  
		            <div class="controls">  
		                <select id="nuevo_psdi_ingresado"></select>
		            </div>
		          </div>
		          <div class="control-group" id="capa_supervisado_por">  
		            <label class="control-label" for="perfiles">Supervisado por</label>  
		            <div class="controls">  
		                <select id="nuevo_psdi_supervisor"></select>
		            </div>
		          </div>
		          <div class="control-group" id="capa_propietario">  
		            <label class="control-label" for="perfiles">Dato de</label>  
		            <div class="controls">  
		                <select id="nuevo_psdi_propietario"></select>
		            </div>
		          </div>
		          <div class="control-group">  
		            <label class="control-label" for="NuevoNombre">Estado</label>  
		            <div class="controls">
		            <select id="Nuevo_psdi_estado"></select>
		              <!--p class="help-block"></p-->  
		            </div>
		          </div>
		          <div class="control-group" id="capa_correo">  
		            <label class="control-label" for="NuevoNombre">Correo</label>  
		            <div class="controls">
		            	<label class="checkbox inline"> <input name="chkbx_correo" id="chkbx_correo" type="checkbox" checked="checked" /> SI </label>
		              <!--p class="help-block"></p-->  
		            </div>
		          </div>
		          <div class="control-group" id="capa_correo_dias">  
		            <label class="control-label" for="NuevoNombre">Cantidad de d&iacute;as</label>  
		            <div class="controls">
		            <input type="number" min="0" id="Nuevo_psdi_cantdias" class="input-xlarge" placeholder="0" value="0"/>
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
		    <h3 id="myModalLabel">Editar Dato Indicador</h3>
		  </div>
		  <div class="modal-body">
		    <form class="form-horizontal" id="form_nuevo">  
			    <div class="alert mmensajes" style="display:none;">
				  <button type="button" class="close" onclick="$('.alert').hide()">&times;</button>
				  <strong>Warning!</strong><span id="mmensaje"></span>
				</div>
		        <fieldset>
		        	<input type="hidden" id="mid">
		        	<input type="hidden" id="mpos">
		          <div class="control-group">  
		            <label class="control-label" for="perfiles">Sub-Proyecto</label>  
		            <div class="controls">  
		                <select id="mNuevo_psdi_subproyecto"></select>	            
		            </div>
		          </div>
		          <div class="control-group">  
		            <label class="control-label" for="perfiles">Frecuencia</label>  
		            <div class="controls">
		                <select id="mNuevo_psdi_frecuencia" onchange="habilita_fecha(1);"></select>	            
		            </div>
		          </div>
		          <div class="control-group" id="mcapa_calendario" style="display:none">  
		            <label class="control-label" for="perfiles">Calendario</label>  
		            <div class="controls">  
		                <select id="mnuevo_psdi_calendar"></select>
		            </div>
		          </div>
		          <div class="control-group">  
		            <label class="control-label" for="perfiles">Dato / Indicador</label>  
		            <div class="controls">
		            	<input type="text" id="mnuevo_psdi_indicador" readonly="readonly" >
		                <!--<select id="mNuevo_psdi_indicador" readonly="readonly"></select>-->
		            </div>
		          </div>
		          <div class="control-group">  
		            <label class="control-label" for="perfiles">Nombre Corto</label>  
		            <div class="controls">  
		                <input type="text"  id="mNuevo_psdi_nombrecorto">
		            </div>
		          </div>
		         <div class="control-group">  
		            <label class="control-label" for="perfiles">&Aacute;rea</label>  
		            <div class="controls">
		                <select id="mNuevo_psdi_area"></select>
		            </div>
		          </div>
		          <div class="control-group">  
		            <label class="control-label" for="perfiles">Perspectiva</label>  
		            <div class="controls">
		                <select id="mNuevo_psdi_perspectiva"></select>
		            </div>
		          </div>
		          <div class="control-group" id="mcapa_ingresado_por">  
		            <label class="control-label" for="perfiles">Ingresado por</label>  
		            <div class="controls">  
		                <select id="mnuevo_psdi_ingresado"></select>
		            </div>
		          </div>
		          <div class="control-group" id="mcapa_supervisado_por">  
		            <label class="control-label" for="perfiles">Supervisor por</label>  
		            <div class="controls">  
		                <select id="mnuevo_psdi_supervisor"></select>
		            </div>
		          </div>
		          <div class="control-group" id="mcapa_propietario">  
		            <label class="control-label" for="perfiles">Dato de</label>  
		            <div class="controls">  
		                <select id="mnuevo_psdi_propietario"></select>
		            </div>
		          </div>
		          <div class="control-group">  
		            <label class="control-label" for="NuevoNombre">Estado</label>  
		            <div class="controls">
		            <select id="mNuevo_psdi_estado"></select>
		              <!--p class="help-block"></p-->  
		            </div>
		          </div>
		          <div class="control-group" id="mcapa_correo">  
		            <label class="control-label" for="NuevoNombre">Correo</label>  
		            <div class="controls">
		            	<label class="checkbox inline"> <input name="mchkbx_correo" id="mchkbx_correo" type="checkbox" checked="checked" /> SI </label>
		              <!--p class="help-block"></p-->  
		            </div>
		          </div>
		          <div class="control-group" id="mcapa_correo_dias">  
		            <label class="control-label" for="NuevoNombre">Cantidad de d&iacute;as</label>  
		            <div class="controls">
		            <input type="number" min="0" id="mNuevo_psdi_cantdias" class="input-xlarge" placeholder="0" value="0"/>
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
		    <h3 id="myModalLabel">Confirmacion : Eliminar Clasificaci&oacute;n</h3>
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

		
    </div> <!-- /container -->
    
	<?php include('libs/php/piepagina.php'); ?>  
	<script type="text/javascript" src="controlador/psdi.js"></script>
	
</body></html>