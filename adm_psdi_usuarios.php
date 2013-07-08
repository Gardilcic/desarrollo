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
    	<legend>Relaci&oacute;n Usuario - Dato Indicador</legend>
    	<form class="inline">
    	<div class="active left">
    	<table border="0">
    		<tr>
    			<td>
    				<label class="control-label" for="perfiles">Elija el usuario a revisar:</label>
    			</td>
    			<td>&nbsp;&nbsp;</td>
    			<td>
    				<select name="lista_usuarios" id="lista_usuarios"></select>
    			</td>
    			<td>&nbsp;&nbsp;</td>
    			<td class="text-right">
    				<button id="btn_guardar" class="btn btn-primary" style="margin-bottom:12px;">Guardar</button>
    			</td>
    		</tr>
	      </table>
		</div>
		<br />
		<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered table-hover" id="example">
			<thead>
				<tr>
					<th>Asignado</th>
					<th>Subproyecto</th>
					<th>Nombre Corto</th>
					<th>Indicador</th>
				</tr>
			</thead>
			<tbody id="tabla_body">
			</tbody>
			<tfoot>
				<tr>
					<th colspan="12" class="pager form-horizontal tablesorter-pager" data-column="0" style="">
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
	</form>
		<!--FIN BUSCADORES-->
	</div>
    
	<?php include('libs/php/piepagina.php'); ?>  
	<script type="text/javascript" src="controlador/psdi_usuarios.js"></script>
	
</body></html>