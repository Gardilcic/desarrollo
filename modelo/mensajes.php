<?php
	session_start();
	require_once('../libs/php/sql_sigp.php');
	require_once('../libs/php/generales.php');
	require_once('../libs/php/funciones_regiones.php');
	
	// isset($_POST['funcion']) && 
	if($_POST['funcion']=="listar_mensajes")
	{
		//echo "ListarUsuarios";
		
		$cns = "select id,emisor, titulo, fecha, id_estados from mensajes where receptor = '".$_SESSION['usuario']['usuario']."' order by fecha DESC";
				
		$a = get_datos($cns);
		$contador=0;
		$objeto = "[";
		while(odbc_fetch_row($a))
		{
			$objeto .= "{";
			$estado=encoder(get_texto_estado(odbc_result($a,"id_estados")));
			if($estado=='Enviado')
			{
				$estado = 'Recibido';
			}
			$objeto .= "'estado':'".$estado."',";
			$objeto .= "'id':'".odbc_result($a,"id")."',";
			$objeto .= "'emisor':'".encoder(odbc_result($a,"emisor"))."',";
			$objeto .= "'titulo':'".encoder(odbc_result($a,"titulo"))."',";
			$objeto .= "'fecha':'".encoder(odbc_result($a,"fecha"))."'";
			$objeto .= "},";
			$contador=1;
		}
		if($contador>=1)
		{
			$objeto = substr($objeto,0,-1);
		}
		$objeto .= "]";
		
		echo $objeto;
	}
	
	if($_POST['funcion']=="muestra_mensaje")
	{
		$cns = "select emisor, mensaje, id_estados, Convert(varchar(15), fecha, 103) as fecha, titulo from mensajes where id=".$_POST['id_mensaje'];
		
		$a = get_datos($cns);
		$respuesta="<table cellpadding='0' cellspacing='0' border='0' class='table table-striped table-bordered table-hover'>";
		$respuesta.="<tr><td style='width:10%;'><strong>Emisor</strong></td><td style='width:10%;'><strong>Fecha</strong></td><td style='width:20%;'><strong>T&iacute;tulo</strong></td><td style='width:60%;'><strong>Mensaje</strong></td></tr>";
		while(odbc_fetch_row($a))
		{
			$respuesta.="<tr><td>".encoder(odbc_result($a,"emisor"))."</td>";
			$respuesta.="<td>".encoder(odbc_result($a,"fecha"))."</td>";
			$respuesta.="<td>".encoder(odbc_result($a,"titulo"))."</td>";
			$respuesta.="<td>".encoder(odbc_result($a,"mensaje"))."</td></tr>";
		}
		$respuesta.="</table>";
		echo $respuesta;
		$texto_leido=get_id_estado('Leído');
		$cns="update mensajes set id_estados = ".$texto_leido." where id=".$_POST['id_mensaje'];
		get_datos($cns);
		//echo $cns;
	}
	
	if($_POST['funcion']=="nuevo_mensaje")
	{
		$cns = "insert into mensajes (emisor, receptor, mensaje, id_estados, titulo) values('".$_SESSION['usuario']['usuario']."','".decoder($_POST['receptor'])."','".decoder($_POST['mensaje'])."',17,'".decoder($_POST['titulo'])."')";
		$a = get_datos($cns);
	}
	
	if($_POST['funcion']=="listar_estados"){
		//echo "ListarUsuarios";
		
		$cns = "select id, nombre from vista_usuarios_estados order by nombre ASC";
				
		$a = get_datos($cns);
		
		$objeto = "[";		
		while(odbc_fetch_row($a))
		{
			$objeto .= "{";
			$objeto .= "'id':'".odbc_result($a,"id")."',";
			$objeto .= "'nombre':'".encoder(odbc_result($a,"nombre"))."'";
			$objeto .= "},";
		}
		$objeto = substr($objeto,0,-1);
		$objeto .= "]";
		
		echo $objeto;
	}

function get_id_estado($texto)
{
	$id = 0;
	$cns0="select id from estados where nombre = '".decoder($texto)."' and id_tipo=6";
	$a = get_datos($cns0);
	while(odbc_fetch_row($a))
	{
		$id=odbc_result($a, "id");
	}
	return $id;
}

function get_texto_estado($id)
{
	$retorno = 0;
	$cns="select nombre from estados where id=".$id;
	$a = get_datos($cns);
	while(odbc_fetch_row($a))
	{
		$retorno=odbc_result($a, "nombre");
	}
	return $retorno;
}

?>