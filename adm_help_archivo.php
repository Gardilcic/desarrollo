<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
        <title>SIGP - Ayuda Detalle del programa</title>
        <link rel="icon" type="image/png" href="libs/img/logo.png" />
        <link href="libs/css/bootstrap.css" rel="stylesheet"/>
        <link href="libs/css/bootstrap-responsive.css" rel="stylesheet"/>
        <link href="libs/css/jquery.tablesorter.pager.css" rel="stylesheet"/>
        <link href="libs/css/theme.bootstrap.css" rel="stylesheet"/>
        <script type="text/javascript" src="libs/js/jquery.js"></script>
        <script type="text/javascript">
			$.ajax(
			{
			 	type: "POST",
			    url: "modelo/paginas.php",
			    data: {
			 	   funcion: "get_doc",
			 	   url:<?php
                                            $url = $_REQUEST['url'];
                                            $url = explode('/', $url);
                                            echo "'".end($url)."'";
                                        ?>
			    },
			    success: function(datos)
			    {
			 	   if(datos!='')
			 	   {
			 	   		location.href=datos;
			 	   		
			 	   }
			 	   else
			 	   {
			 	   	$('#mensaje').text('No existe archivo para este programa');
			 	   }
			 	   //window.close();
			 	   //alert(datos);
			 	   //$('#p_detalle').val(datos);
			    }
			 });
		</script>
    </head>
    <body style="background-color:#F3F3F8;">
        <br/><br/>
        <center>
        	<label id="mensaje"></label>
        	<button class="btn btn-primary" onclick="window.close()">Cerrar</button>
        	
        </center>
    </body>
</html>