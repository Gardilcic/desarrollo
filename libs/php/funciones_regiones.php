<?php

require_once('sql_sigp.php');

function get_nombre_region($id)
{
	$cns="select nombre from regiones where id=".$id;
	$a = get_datos($cns);
	$respuesta="";
	while(odbc_fetch_row($a))
	{
		$respuesta = str_replace("'",' ',odbc_result($a,"nombre"));
	}
	return $respuesta;
}

function get_nombre_pais($id)
{
	$cns="select nombre from pais where id=".$id;
	$a = get_datos($cns);
	$respuesta="";
	while(odbc_fetch_row($a))
	{
		$respuesta = str_replace("'",' ',odbc_result($a,"nombre"));
	}
	return $respuesta;
}

?>