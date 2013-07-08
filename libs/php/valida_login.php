<?php
require_once('sql_sigp.php');

function valida_datos_login($usuario, $clave)
{
	$cns="select COUNT(id) as id from vista_usuarios where rut = '".$usuario."' and clave = '".$clave."'";
	$a = get_datos($cns);
	$respuesta="";
	while(odbc_fetch_row($a))
	{
		$respuesta=odbc_result($a,"id");
	}
	return $respuesta;
}

function get_nombre_apellidos($rut)
{
	$cns="select nombre_usuario, apellidos from vista_usuarios where rut ='".$rut."'";
	$a = get_datos($cns);
	$respuesta="";
	while(odbc_fetch_row($a))
	{
		$respuesta=odbc_result($a,"nombre_usuario")." ".odbc_result($a,"apellidos");
	}
	return $respuesta;
}

function get_id_usuario($rut)
{
	$cns="select id from vista_usuarios where rut ='".$rut."'";
	$a = get_datos($cns);
	$respuesta="";
	while(odbc_fetch_row($a))
	{
		$respuesta=odbc_result($a,"id");
	}
	return $respuesta;
}
?>