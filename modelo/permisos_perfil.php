<?php
	require_once('../libs/php/sql_sigp.php');
	require_once('../libs/php/generales.php');
	require_once('../libs/php/funciones_regiones.php');
	
	// isset($_POST['funcion']) && 
	if($_POST['funcion']=="listar_permisos_perfil")
	{
		//echo "ListarUsuarios";
		
		$cns = "select id, nombre_perfil, nombre_permisos, url from dbo.vista_usuarios_permisos_perfil order by nombre_perfil ASC";
				
		$a = get_datos($cns);
		$contador=0;
		$objeto = "[";		
		while(odbc_fetch_row($a))
		{
			$objeto .= "{";
			$objeto .= "'id':'".odbc_result($a,"id")."',";
			$objeto .= "'nombre_perfil':'".str_replace("'","",encoder(odbc_result($a,"nombre_perfil")))."',";
			$objeto .= "'nombre_permisos':'".encoder(odbc_result($a,"nombre_permisos"))." (".encoder(odbc_result($a,"url")).")'";
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
	
	if($_POST['funcion']=="limpia_todos_permiso")
	{
		$cns = "EXEC [dbo].[limpia_perfil] @perfil =".$_POST['id_perfil'];
		get_datos($cns);
		echo 1;
	}
	
	if($_POST['funcion']=="nuevo_permiso")
	{
		$cns = "EXEC [dbo].[crea_asociacion_perfil_cargo] @id_perfil =".$_POST['id_perfil'].", @id_permiso= ".$_POST['id_permiso'];
				
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
	
	if($_POST['funcion']=="updt_permiso")
	{
		//echo "ListarUsuarios";

		$cns = "EXEC [dbo].[actualiza_permisos_usuarios] @nombre = N'".decoder($_POST['nombre'])."', @url=N'".decoder($_POST['url'])."', @modulo=".decoder($_POST['modulo']).", @estado = ".$_POST['estado'].", @id = ".$_POST['id'];
				
		$a = get_datos($cns);
		while(odbc_fetch_row($a))
		{
			$respuesta = odbc_result($a,'respuesta');
		}
		echo $respuesta;
	}
	
	if($_POST['funcion']=="borra_permiso")
	{
		//echo "ListarUsuarios";

		$cns = "EXEC [dbo].[elimina_asociacion_permisos_perfil] @id =".$_POST['id'];
				
		$a = get_datos($cns);
		while(odbc_fetch_row($a))
		{
			$respuesta = odbc_result($a,'respuesta');
		}
		echo $respuesta;
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
	
	if($_POST['funcion']=="listar_permisos")
	{		
		$cns = "select id, nombre from dbo.vista_usuarios_permisos order by nombre ASC";// where id not in (select id_permisos from dbo.vista_usuarios_permisos_perfil)";
				
		$a = get_datos($cns);
		$controlador=0;
		$objeto = "[";		
		while(odbc_fetch_row($a))
		{
			$cns0="select COUNT(id_perfil) as cant from vista_permisos_perfil_textos where id_permisos = ".odbc_result($a,"id");
			$b=get_datos($cns0);
			$respuesta=0;
			while(odbc_fetch_row($b))
			{
				$respuesta=odbc_result($b, "cant");
			}
			$objeto .= "{";
			$objeto .= "'id':'".odbc_result($a,"id")."',";
			$objeto .= "'nombre':'".encoder(odbc_result($a,"nombre"))."',";
			$objeto .= "'relacionado':'".encoder($respuesta)."'";
			$objeto .= "},";
			$controlador=1;
		}
		if($controlador==1)
		{
			$objeto = substr($objeto,0,-1);
		}
		$objeto .= "]";
		
		echo $objeto;
	}
	
	if($_POST['funcion']=="listar_perfiles"){
		//echo "ListarUsuarios";
		
		$cns = "select id, nombre from dbo.vista_usuarios_perfil order by nombre ASC";
				
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

?>