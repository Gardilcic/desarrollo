<?php
	require_once('../libs/php/sql_sigp.php');
	// isset($_POST['funcion']) && 
	if($_POST['funcion']=="ListarTurnos"){
		//echo "ListarUsuarios";
		
		$cns = "SELECT t.id ".
			   "   ,t.nombre ".
			   "   ,t.id_subproyecto ".
			   "   ,sp.nombre as subproyecto_nombre ".
			   "   ,sp.id_proyectos ".
			   "   ,p.nombre as proyecto_nombre ".
			   "FROM dbo.turnos t INNER JOIN dbo.subproyectos sp ON t.id_subproyecto = sp.id  ".
			   "   INNER JOIN dbo.proyectos p ON sp.id_proyectos = p.id  ";
		
		$a = get_datos_sigp($cns);
		
		$objeto = "[";		
		$con_datos = 0;
		while(odbc_fetch_row($a))
		{
			$objeto .= "{";
			$objeto .= "'id':'".odbc_result($a,"id")."',";
			$objeto .= "'nombre':'".odbc_result($a,"nombre")."',";
			$objeto .= "'id_subproyecto':'".odbc_result($a,"id_subproyecto")."',";
			$objeto .= "'subproyecto_nombre':'".odbc_result($a,"subproyecto_nombre")."',";
			$objeto .= "'id_proyectos':'".odbc_result($a,"id_proyectos")."',";
			$objeto .= "'proyecto_nombre':'".odbc_result($a,"proyecto_nombre")."'";
			$objeto .= "},";
			
			$con_datos = 1;
		}
		if($con_datos == 1) $objeto = substr($objeto,0,-1);
		$objeto .= "]";
		
		echo $objeto;
	}
	if($_POST['funcion']=="ListarPerfiles"){
		//echo "ListarUsuarios";
		
		$cns = "SELECT per.id,per.nombre, ".
				"	est.id as id_estado, est.nombre as estado_nombre ".
				"FROM dbo.adm_perfil as per ".
				"	JOIN dbo.estados as est ON est.id = per.id_estados ".
				"WHERE est.id_tipo = 1 AND est.id = 1  ";
				
		$a = get_datos($cns);
		
		$objeto = "[";		
		while(odbc_fetch_row($a))
		{
			$objeto .= "{";
			$objeto .= "'id':'".odbc_result($a,"id")."',";
			$objeto .= "'nombre':'".odbc_result($a,"nombre")."',";
			$objeto .= "'id_estados':'".odbc_result($a,"id_estado")."',";
			$objeto .= "'estado_nombre':'".odbc_result($a,"estado_nombre")."'";
			$objeto .= "},";
		}
		$objeto = substr($objeto,0,-1);
		$objeto .= "]";
		
		echo $objeto;
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
	
	if($_POST['funcion']=="GrabarNuevo"){
		//echo "ListarUsuarios";
		$ultimo_id = 0; 
		
		$cns = "INSERT INTO dbo.turnos (nombre,id_subproyecto) VALUES ".
           		"('".$_POST['nombre']."','".$_POST['id_subproyecto']."')";
           				
		$a = get_datos_sigp($cns);
		
		$cns = "SELECT @@IDENTITY AS ID";
		
		$b = get_datos_sigp($cns);
		
		while(odbc_fetch_row($b))
		{
			$ultimo_id = odbc_result($b,"ID");
		}

		echo $ultimo_id;
	}
	
	if($_POST['funcion']=="GrabarTurno"){
		//echo "ListarUsuarios";
		
		$cns = "UPDATE dbo.turnos SET nombre = "."'".$_POST['nombre']."',".
					"id_subproyecto = "."'".$_POST['id_subproyecto']."' ".
				" WHERE id = ".$_POST['id'];
					           				
		$a = get_datos_sigp($cns);
		//$a = 1;
		if($a===true)
			$respuesta = -1;
		else
			$respuesta = 1;

		echo $respuesta;
	}

	if($_POST['funcion']=="Eliminar"){
		//echo "ListarUsuarios";
		
		$cns = "DELETE FROM dbo.turnos WHERE id = "."'".$_POST['id']."' ";
					           				
		$a = get_datos_sigp($cns);
		//$a = 1;
		if($a===true)
			$respuesta = -1;
		else
			$respuesta = 1;

		echo $respuesta;
	}


?>
