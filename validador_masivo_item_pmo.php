<?php 
    session_start();
    /*if(isset($_POST['cargar_archivo']))
	{*/
            
		require_once('libs/php/generales.php');
                
		$archivo_ini = $_FILES['archivo']['tmp_name'];
	    $nombre_nuevo=date('Y-m-d-hi');
	    $type = $_FILES['archivo'] ['type'];
	    $ruta = "libs/cargas_masivas/".$nombre_nuevo.".xls";
		$subio = false;
		copy($archivo_ini, $ruta);
		if (!file_exists($ruta))
		{
			alert('Por alguna razón su sulicitud no ha podido concretarse. Por favor reintente.');
			//header("Location: carga_itemizado_pmo.php");
		}
		$version=$_REQUEST['nombre_de_carga'];
		//die();
	//}
    //include('libs/php/valida_pagina_usuario.php');
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
            <?php
            	//$version=$_REQUEST['nombre_de_carga'];
            	$version=$_POST['nombre_de_version'];
            	echo "Cargando: ".$version;
            	$archivo= $nombre_nuevo.".xls";
            	
            	$empresa=$_POST['empresa'];
            	print "<br/>Intentando leer archivo: ".$archivo."<br/>";
            	if(file_exists('libs/cargas_masivas/'.$archivo))
            	{
               		require_once('libs/php/funciones_cargas_masivas.php');
            		lectura_pmo("libs/cargas_masivas/".$archivo, $version, $empresa);
                        
            	}
            	else
            	{
            		print "No se ha podido abrir el archivo.";// <a href='adm_cargar_xls.php'>Volver</a>";
            	}
            ?>
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
		</div>
            

        <?php include('libs/php/piepagina.php'); ?>  
    </body></html>
    
    