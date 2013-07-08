<?php
	require_once('../libs/php/sql_sigp.php');
	require_once('../libs/php/generales.php');
	require_once('../libs/php/funciones_regiones.php');
	require_once('../libs/php/sys_log.php');
	
	// isset($_POST['funcion']) && 
	if($_POST['funcion']=="listar_ubicaciones")
	{
		//echo "ListarUsuarios";
		
		$cns = "select id, nombre, region from ubicaciones order by nombre ASC";
		registra_log($cns,1, 'ubicaciones');
		$a = get_datos($cns);
		
		$objeto = "[";		
		while(odbc_fetch_row($a))
		{
			$objeto .= "{";
			$objeto .= "'id':'".odbc_result($a,"id")."',";
			$objeto .= "'nombre':'".str_replace("'","",encoder(odbc_result($a,"nombre")))."',";
			$objeto .= "'region':'".str_replace("'","",encoder(get_region(odbc_result($a,"region"))))."'";
			$objeto .= "},";
		}
		$objeto = substr($objeto,0,-1);
		$objeto .= "]";
		
		echo $objeto;
	}
	
	if($_POST['funcion']=="nueva_ubicacion")
	{
		$cns = "insert into ubicaciones (nombre, region) values('".decoder($_POST['nombre'])."',".$_POST['region'].")";
				
		$a = get_datos($cns);
		registra_log($cns, 2, 'ubicaciones');
		$cns = "SELECT @@IDENTITY AS ID";
		
		$b = get_datos($cns);
		
		while(odbc_fetch_row($b))
		{
			$ultimo_id = odbc_result($b,"ID");
		}

		echo $ultimo_id;
		//echo $cns;
	}
	
	if($_POST['funcion']=="listar_regiones"){
		//echo "ListarUsuarios";
		
		$cns = "select id, nombre from regiones order by nombre ASC";
				
		$a = get_datos($cns);
		
		$objeto = "[";		
		while(odbc_fetch_row($a))
		{
			$objeto .= "{";
			$objeto .= "'id':'".odbc_result($a,"id")."',";
			$objeto .= "'nombre':'".str_replace("'","",encoder(odbc_result($a,"nombre")))."'";
			$objeto .= "},";
		}
		$objeto = substr($objeto,0,-1);
		$objeto .= "]";
		
		echo $objeto;
	}

	function get_region($id)
	{
		$cns="select nombre from regiones where id=".$id;
		$b = get_datos($cns);
		while(odbc_fetch_row($b))
		{
			$nombre = odbc_result($b,"nombre");
		}
		return $nombre;
	}
	
	if($_POST['funcion']=="get_dependencia_ubicacion"){
		//echo "ListarUsuarios";
		
		$cns = "select COUNT(id) as cant from subproyectos where id_ubicacion =".$_POST['id'];
				
		$a = get_datos($cns);
		
		$objeto = 0;		
		while(odbc_fetch_row($a))
		{
			$objeto = odbc_result($a,"cant");
		}
		
		echo $objeto;
	}
	
	if($_POST['funcion']=="borrar_ubicaciones")
	{	
		$cns = "delete from ubicaciones where id=".$_POST['id'];
		//echo $cns;
		$a = get_datos($cns);
		$contador=0;
		if(get_dependencia_ubicacion($_POST['id'])==0)
		{
			$contador=0;
		}
		else
		{
			$contador=1;
		}
		echo $contador;
	}
	
	function get_dependencia_ubicacion($id)
	{
		//echo "ListarUsuarios";
		
		$cns = "select COUNT(id) as cant from subproyectos where id_ubicacion =".$id;
				
		$a = get_datos($cns);
		
		$objeto = 0;		
		while(odbc_fetch_row($a))
		{
			$objeto = odbc_result($b,"cant");
		}
		return $objeto;
	}
?>
