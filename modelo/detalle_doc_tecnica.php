<?php
	session_start();
	require_once('../libs/php/sql_sigp.php');
	require_once('../libs/php/generales.php');
	// isset($_POST['funcion']) && 
	if($_POST['funcion']=="listar_paginas"){
		//echo "ListarUsuarios";
		
		$cns = "select id, usuario, fecha, detalle from documentacion_tecnica";
				
		$a = get_datos($cns);
		
		$objeto = "[";		
		while(odbc_fetch_row($a))
		{
			$objeto .= "{";
			$objeto .= "'id':'".odbc_result($a,"id")."',";
			$objeto .= "'usuario':'".encoder(odbc_result($a,"usuario"))."',";
			$objeto .= "'fecha':'".encoder(odbc_result($a,"fecha"))."',";
			$objeto .= "'detalle':'".encoder(odbc_result($a,"detalle"))."'";
			$objeto .= "},";
		}
		$objeto = substr($objeto,0,-1);
		$objeto .= "]";
		
		echo $objeto;
	}
	
	if($_POST['funcion']=="get_usuario"){
		//echo "ListarUsuarios";
		echo $_SESSION['usuario']['usuario'];
	}
	
	if($_POST['funcion']=="listar_detalle_filtro"){
		//echo "ListarUsuarios";
		
		$cns = "select id, usuario, fecha, detalle from documentacion_tecnica where id_pagina = ".$_POST['filtro'];
				
		$a = get_datos($cns);
		
		$objeto = "[";
		$contador = 0;		
		while(odbc_fetch_row($a))
		{
			$objeto .= "{";
			$objeto .= "'id':'".odbc_result($a,"id")."',";
			$objeto .= "'usuario':'".encoder(odbc_result($a,"usuario"))."',";
			$objeto .= "'fecha':'".encoder(odbc_result($a,"fecha"))."',";
			$objeto .= "'detalle':'".encoder(odbc_result($a,"detalle"))."'";
			$objeto .= "},";
			$contador =1;
		}
		if($contador==1)
		{
			$objeto = substr($objeto,0,-1);
		}
		$objeto .= "]";
		
		echo $objeto;
	}
	
	if($_POST['funcion']=="updt_detalle")
	{
		$cns = "update documentacion_tecnica set fecha='".$_POST['fecha']."', detalle ='".decoder($_POST['info'])."' where id=".$_POST['id'];
				
		$a = get_datos($cns);
	}
	
	if($_POST['funcion']=="listar_modulos_sel"){
		//echo "ListarUsuarios";
		
		$cns = "select id, nombre from vista_usuarios_modulos order by nombre ASC";
				
		$a = get_datos($cns);
		
		$objeto = "[";		
		while(odbc_fetch_row($a))
		{
			$objeto .= "{";
			$objeto .= "'id':'".odbc_result($a,"id")."',";
			$objeto .= "'nombre':'".encoder(odbc_result($a,"nombre"))."'";;
			$objeto .= "},";
		}
		$objeto = substr($objeto,0,-1);
		$objeto .= "]";
		
		echo $objeto;
	}
	
	if($_POST['funcion']=="listar_paginas_sel"){
		//echo "ListarUsuarios";
		
		$cns = "select id, nombre from vista_usuarios_permisos where id_modulos=".$_POST['modulo'];
				
		$a = get_datos($cns);
		
		$objeto = "[";		
		while(odbc_fetch_row($a))
		{
			$objeto .= "{";
			$objeto .= "'id':'".odbc_result($a,"id")."',";
			$objeto .= "'nombre':'".encoder(odbc_result($a,"nombre"))."'";;
			$objeto .= "},";
		}
		$objeto = substr($objeto,0,-1);
		$objeto .= "]";
		
		echo $objeto;
	}
	
	if($_POST['funcion']=="add_info")
	{
		$cns = "insert into documentacion_tecnica (usuario, fecha, detalle, id_pagina) values('".$_POST['usuario']."','".$_POST['fecha']."','".decoder($_POST['info'])."',".$_POST['pag'].")";
					           				
		$a = get_datos($cns);
		
		echo $respuesta;
	}


if($_POST['funcion']=="borra_detalle")
{
	$respuesta = 0;
	
	$cns0 = "delete from documentacion_tecnica where id=".$_POST['id'];
	
	$a = get_datos($cns0);
	
	$cns0 = "select COUNT(id) as cant from documentacion_tecnica where id=".$_POST['id'];
	$a = get_datos($cns0);
	
	while(odbc_fetch_row($a))
	{
		$respuesta= odbc_result($a,'cant');
	}
	
	echo $respuesta;
}

if($_POST['funcion']=="get_objetivos")
{
	$url=$_POST['url'];
	$arr_url=explode('//',$url);
	$arr_url= explode('/',$arr_url[1]);
	$url=$arr_url[1];
	$url=explode('#',$url);
	$url=$url[0];
	
	$respuesta = "No hay objetivos especificados.";
	
	$cns0 = "select objetivo from vista_tbl_permisos where url = '".$url."'";
	
	$a = get_datos($cns0);
	
	while(odbc_fetch_row($a))
	{
		$respuesta= encoder(odbc_result($a,'objetivo'));
	}
	
	echo $respuesta;
}

if($_POST['funcion']=="get_detalle")
{
	$url=$_POST['url'];
	$arr_url=explode('//',$url);
	$arr_url= explode('/',$arr_url[1]);
	$url=$arr_url[1];
	$url=explode('#',$url);
	$url=$url[0];
	
	$respuesta = "No hay objetivos especificados.";
	
	$cns0 = "select detalle from vista_tbl_permisos where url = '".$url."'";
	
	$a = get_datos($cns0);
	
	while(odbc_fetch_row($a))
	{
		$respuesta= encoder(odbc_result($a,'detalle'));
	}
	
	echo $respuesta;
}

if($_POST['funcion']=="get_doc")
{
	$url=$_POST['url'];
	$arr_url=explode('//',$url);
	$arr_url= explode('/',$arr_url[1]);
	$url=$arr_url[1];
	$url=explode('#',$url);
	$url=$url[0];
	
	$respuesta = "#";
	
	$cns0 = "select documento from vista_tbl_permisos where url = '".$url."'";
	
	$a = get_datos($cns0);
	
	while(odbc_fetch_row($a))
	{
		$respuesta= encoder(odbc_result($a,'documento'));
	}
	
	echo $respuesta;
}
?>