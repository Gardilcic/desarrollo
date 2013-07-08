<?php
	//require_once('sql_sigp.php');
	//require_once('generales.php');
	
function get_usuarios($sql)
{
	//$cns = "select * from proyectos";
	$a = get_datos($sql);
	$cont=1;
	$respuesta="<tr><td>N</td><td>Nombre</td><td>Apellidos</td><td>RUT</td><td>Estado</td><td>Perfil</td></tr>";
	while(odbc_fetch_row($a))
	{
		$respuesta.="<tr><td>".$cont."</td>";
		$respuesta.="<td>".odbc_result($a,"")."</td>";
		$respuesta.="<td>".odbc_result($a,"apellidos")."</td>";
		$respuesta.="<td>".odbc_result($a,"rut")."</td>";
		$respuesta.="<td>".odbc_result($a,"estado")."</td>";
		$respuesta.="<td>".odbc_result($a,"perfil")."</td></tr>";
		$cont++;
	}
	return $respuesta;
}

function get_itemizado_pmo()
{
	$cns = "select id, codigo,descripcion from itemizado_pmo order by descripcion, codigo ASC";
	$a = get_datos($cns);
	$respuesta="";
	while(odbc_fetch_row($a))
	{
		$respuesta.="<option value='".odbc_result($a,"id")."'>";
		$respuesta.=encoder(odbc_result($a,"codigo")." - ".odbc_result($a,"descripcion"));
		$respuesta.="</option>";
	}
	return $respuesta;
}

function get_estados()
{
	$cns = "select id, nombre from estados order by id";
	$a = get_datos($cns);
	$respuesta="";
	while(odbc_fetch_row($a))
	{
		$respuesta.="<option value='".odbc_result($a,"id")."'>";
		$respuesta.=encoder(odbc_result($a,"nombre"))."</option>";
	}
	return $respuesta;
}
?>