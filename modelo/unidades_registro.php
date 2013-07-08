<?php
	require_once('../libs/php/sql_sigp.php');
	require_once('../libs/php/generales.php');
	
	// isset($_POST['funcion']) && 
	if($_POST['funcion']=="listar_unidades")
	{
		//echo "ListarUsuarios";
		
		$cns = "select id, nombre, abreviacion, id_estados from unidades_registro order by nombre ASC";
				
		$a = get_datos($cns);
		$contador=0;
		$objeto = "[";		
		while(odbc_fetch_row($a))
		{
			$objeto .= "{";
			$objeto .= "'id':'".odbc_result($a,"id")."',";
			$objeto .= "'nombre':'".str_replace("'","",encoder(odbc_result($a,"nombre")))."',";
			$objeto .= "'abreviacion':'".str_replace("'","",encoder(odbc_result($a,"abreviacion")))."',";
			$objeto .= "'estado':'".encoder(get_estados(odbc_result($a,"id_estados")))."'";
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
	
	if($_POST['funcion']=="nueva_unidad")
	{
		$cns = "EXEC [dbo].[crea_unidad_registro] @nombre = N'".decoder($_POST['nombre'])."', @abb = '".$_POST['abb']."', @estado = ".$_POST['estado'];
				
		$a = get_datos($cns);
		
		/*$cns = "SELECT @@IDENTITY AS ID";
		
		$b = get_datos($cns);*/
		
		while(odbc_fetch_row($a))
		{
			$respuesta = odbc_result($a,"respuesta");
		}

		echo $respuesta;
		//echo $cns;
	}
	
	if($_POST['funcion']=="updt_unidad")
	{
		//echo "ListarUsuarios";

		$cns = "EXEC [dbo].[actualiza_unidad_registro] @nombre = N'".decoder($_POST['nombre'])."', @abb = '".$_POST['abb']."', @estado = ".$_POST['estado'].", @id = ".$_POST['id'];
				
		$a = get_datos($cns);
		while(odbc_fetch_row($a))
		{
			$respuesta = odbc_result($a,'respuesta');
		}
		echo $respuesta;
	}
	
	if($_POST['funcion']=="listar_estados"){
		//echo "ListarUsuarios";
		
		$cns = "select id, nombre from estados where id_tipo = 1 order by nombre ASC";
				
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

function get_estados($id)
{
	$cns="select nombre from estados where id =".$id;
	$a = get_datos($cns);
	while(odbc_fetch_row($a))
	{
		$respuesta = odbc_result($a,'nombre');
	}
	return $respuesta;
}

if($_POST['funcion']=="valida_dependencia")
{
	$respuesta = 0;
	$cns0 = "select count(id) as cant from actividades where id_unidad_registro=".$_POST['ur'];

	$a = get_datos($cns0);
			
	while(odbc_fetch_row($a))
	{
		$respuesta+= odbc_result($a,'cant');
	}
	
	echo $respuesta;
}

if($_POST['funcion']=="borra_unidad")
{
	$respuesta = 0;
	
	$cns0 = "delete from unidades_registro where id=".$_POST['proyecto'];
	
	$a = get_datos($cns0);
	
	$cns0 = "select COUNT(id) as cant from unidades_registro where id=".$_POST['proyecto'];
	$a = get_datos($cns0);
	
	while(odbc_fetch_row($a))
	{
		$respuesta= odbc_result($a,'cant');
	}
	
	echo $respuesta;
}


?>