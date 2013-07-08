<?php

	$version=$_POST['nom_version'];
	$empresa=$_POST['xls_empresa'];
	$error="<h4>ERROR!</h4>No se ha podido realizar lo solicitado.";
	if($version !=0 && $empresa!=0)
	{
		require_once('libs/php/exportadores_xls.php');
		//echo get_tabla_pmo($version, $empresa);
		$error="<h4>Solicitud realizada</h4> Precione volver para regresar a la p&aacute;gina anterior.";
		header("Content-Type: application/vnd.ms-excel");
		header("Expires: 0");
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		header("content-disposition: attachment;filename=Respaldo Itemizado".date('Y-m-d H:i:s').".xls");
		echo get_tabla_pmo($version, $empresa);
		exit;
	}
	else
	{
		$error="<h4>ERROR!</h4>No se ha podido realizar lo solicitado.";
	}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <meta content="es-pe" http-equiv="Content-Language"/>
        <meta charset="utf-8">
        <title>Gardilcic :: SIGP</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <meta name="author" content=""/>
        <link rel="icon" type="image/png" href="libs/img/icono.png" />
        <link href="libs/css/bootstrap.css" rel="stylesheet"/>
        <link href="libs/css/bootstrap-responsive.css" rel="stylesheet"/>
        <link href="libs/css/jquery.tablesorter.pager.css" rel="stylesheet"/>
        <link href="libs/css/theme.bootstrap.css" rel="stylesheet"/>
        <!--[if lt IE 9]>
          <script src="../assets/js/html5shiv.js"/></script>
        <![endif]-->
    </head>
<body>
<div class="alert vmensajes" style="display:none;">
    <button type="button" class="close" onclick="">&times;</button>
    <strong>Resultado : </strong><span id="vmensaje">
    	<?php echo $error; ?>
    </span>
</div>
</body>
</html>