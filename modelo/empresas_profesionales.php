<?php
	require_once('../libs/php/sql_sigp.php');
	require_once('../libs/php/generales.php');
	
	// isset($_POST['funcion']) && 
	if($_POST['funcion']=="listar_personas_empresa")
	{
		//echo "ListarUsuarios";
		
		$cns = "select id, nombre, id_empresas, vigencia, id_estados from empresas_profesionales order by nombre ASC";
				
		$a = get_datos($cns);
		$contador=0;
		$objeto = "[";		
		while(odbc_fetch_row($a))
		{
			$objeto .= "{";
			$objeto .= "'id':'".odbc_result($a,"id")."',";
			$objeto .= "'nombre':'".str_replace("'","",encoder(odbc_result($a,"nombre")))."',";
			$objeto .= "'vigencia':'".encoder(odbc_result($a,"vigencia"))."',";
			$objeto .= "'empresa':'".encoder(get_empresa_nombre(odbc_result($a,"id_empresas")))."',";
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
	
	if($_POST['funcion']=="nuevo_profesional")
	{
		$cns = "insert into empresas_profesionales (nombre, id_empresas, id_estados) values ('".decoder($_POST['nombre'])."',".$_POST['empresa'].",".$_POST['estado'].") ";
				
		$a = get_datos($cns);
		
		$cns = "SELECT COUNT(id) as id from empresas_profesionales where nombre ='".decoder($_POST['nombre'])."' AND id_empresas = ".$_POST['empresa'];
		
		$b = get_datos($cns);
		$respuesta = 0;
		while(odbc_fetch_row($b))
		{
			$respuesta = odbc_result($b,"id");
		}

		echo $respuesta;
		//echo $cns;
	}
	
	if($_POST['funcion']=="updt_profesional")
	{
		//echo "ListarUsuarios";
		$cns="update empresas_profesionales set nombre = '".decoder($_POST['nombre'])."', id_empresas = ".$_POST['empresa'];
		//if($_POST['estado']!=1)
		//{
			$fecha=date('Y-m-d H:i:s');
			$cns.= ", vigencia ='".$fecha."', id_estados=".$_POST['estado'];
		//}
		$cns.=" where id =".$_POST['id'];
		$a = get_datos($cns);
		
		echo 1;
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
	
	if($_POST['funcion']=="listar_empresas"){
		//echo "ListarUsuarios";
		
		$cns = "select id, nombre from empresas where id_tipo = 1 order by nombre ASC";
				
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

function get_empresa_nombre($id)
{
	$cns="select nombre from empresas where id =".$id;
	$a = get_datos($cns);
	while(odbc_fetch_row($a))
	{
		$respuesta = odbc_result($a,'nombre');
	}
	return $respuesta;
}
?>