<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
        <title>SIGP - Ayuda Objetivos del programa</title>
        <link rel="icon" type="image/png" href="libs/img/logo.png" />
        <link href="libs/css/bootstrap.css" rel="stylesheet"/>
        <link href="libs/css/bootstrap-responsive.css" rel="stylesheet"/>
        <link href="libs/css/jquery.tablesorter.pager.css" rel="stylesheet"/>
        <link href="libs/css/theme.bootstrap.css" rel="stylesheet"/>
        <script type="text/javascript" src="libs/js/jquery.js"></script>
    </head>
    <body style="background-color:#F3F3F8;">
        <center><h4>Objetivos del programa</h4></center>
        <hr style="color:#000048; background-color:#000048;"/>
        <div id="dlg_objetivos" class="modal fade" tabindex="-1" role="dialog">
            <h3 id="myModalLabel">Objetivos del programa</h3>
        </div>
        <div class="modal-body">
            <form class="form-horizontal" id="form_nuevo">
                <div class="alert mmensajes" style="display:none;">
                    <button type="button" class="close" onclick="$('.alert').hide()">&times;</button>
                    <strong>Warning!</strong><span id="mmensaje"></span>
                </div>
                <fieldset>
                    <div class="control-group">  
                        <label class="control-label" for="perfiles"></label>  
                        <div class="controls">  
                            <textarea id="p_objetivos" cols="30" rows="12" readonly="readonly" style="width:260px; height:300px;">
								
                            </textarea>            
                        </div>  
                    </div>
                </fieldset>		        
            </form>
        </div>
    </body>
</html>
<script type="text/javascript">
    
$.ajax(
{
 	type: "POST",
    url: "modelo/paginas.php",
    data: {
 	   funcion: "get_objetivos",
 	   url:<?php
                    $url = $_REQUEST['url'];
                    $url = explode('/',$url);
                    echo "'".end($url)."'";
                ?>
    },
    success: function(datos)
    {
 	   if(datos !='')
 	   {
 	   		$('#p_objetivos').val(datos);
 	   }
 	   else
 	   {
 	   		$('#p_objetivos').val('No existe información para esta página');
 	   }
    }
 });
</script>