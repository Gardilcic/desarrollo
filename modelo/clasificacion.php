<?php
	require_once('../libs/php/sql_sigp.php');
	require_once('../libs/php/generales.php');
	
	// isset($_POST['funcion']) && 
	if($_POST['funcion']=="Listar_clasificacion"){
		
		$var1 = "select id_clasificacion, nombre_clasificacion, nombre_estados  from vista_clasificacion" ;	
							
		$a = get_datos_sigp($var1);
		
		while(odbc_fetch_row($a)){
			for($contador=1; $contador<=odbc_num_fields($a); $contador++)
			{
				$nombre = odbc_field_name($a, $contador);
				$proyectos[$nombre]=odbc_result($a,$contador);
			}
			$objeto[]=$proyectos;
		}
		echo json_encode($objeto);
	}

	if($_POST['funcion']=="listar_estados"){
		//echo "ListarUsuarios";
		
		$cns = "select id, nombre from estados where id_tipo=1 order by nombre ASC";
				
		$a = get_datos($cns);
		
		$objeto = "[";		
		while(odbc_fetch_row($a))
		{
			$objeto .= "{";
			$objeto .= "'id':'".odbc_result($a,"id")."',";
			$objeto .= "'nombre':'".odbc_result($a,"nombre")."'";
			$objeto .= "},";
		}
		$objeto = substr($objeto,0,-1);
		$objeto .= "]";
		
		echo $objeto;
	}
	if($_POST['funcion']=="nueva_clasificacion"){
		//echo "ListarUsuarios";
		
		$cns = "insert into clasificacion (nombre, id_estados) values ('".decoder($_POST['nombre'])."',".$_POST['estado'].")";
				
		$a = get_datos($cns);
		
		$cns = "SELECT @@IDENTITY AS ID";
		
		$b = get_datos($cns);
		
		while(odbc_fetch_row($b))
		{
			$ultimo_id = odbc_result($b,"ID");
		}

		echo $ultimo_id;
	}
	
	if($_POST['funcion']=="updt_clasificacion"){
		//echo "ListarUsuarios";
		
		$cns = "update clasificacion set nombre='".decoder($_POST['nombre'])."', id_estados =".$_POST['estado']." where id=".$_POST['id'];
				
		$a = get_datos($cns);
		//echo $cns;
	}
	
	
	if($_POST['funcion']=="ListarEstados"){
		//echo "ListarUsuarios";
		
		$cns = "SELECT est.id, est.nombre, est.id_tipo ".
				" FROM dbo.estados as est ".
				" WHERE est.id_tipo = 1 ".
				" ORDER BY est.nombre asc ";
				
		$a = get_datos($cns);
		
		$objeto = "[";		
		while(odbc_fetch_row($a))
		{
			$objeto .= "{";
			$objeto .= "'id':'".odbc_result($a,"id")."',";
			$objeto .= "'nombre':'".odbc_result($a,"nombre")."',";
			$objeto .= "'id_tipo':'".odbc_result($a,"id_tipo")."',";
			$objeto .= "},";
		}
		$objeto = substr($objeto,0,-1);
		$objeto .= "]";
		
		echo $objeto;
	}
	
	
function valida_dependencias($id)
{
	$respuesta = 0;
	$cns0 = "select COUNT(id) as cantidad from subclasificacion where id_clasificacion=".$id;

	$a = get_datos($cns0);
			
	while(odbc_fetch_row($a))
	{
		$respuesta+= odbc_result($a,'cant');
	}
	
	return $respuesta;
}

if($_POST['funcion']=="eliminar_clasificacion")
{
	$respuesta = 0;
	$error = 5;
	$cns0="delete from clasificacion where id =".$_POST['id'];
	if(valida_dependencias($_POST['id']) == 0)
	{
		$a=get_datos($cns0);
		$cns="select count(id) as cant from clasificacion where id =".$_POST['id'];
		$a=get_datos($cns);
		while(odbc_fetch_row($a))
		{
			$error=odbc_result($a,"cant");
		}
	}
	else
	{
		$error = 5;
	}
	echo $error;
}

?>
