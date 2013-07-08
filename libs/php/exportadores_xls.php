<?php
require_once('sql_sigp.php');
require_once('generales.php');

function get_tabla_pmo($version, $empresa)
{
	$cns="select codigo, descripcion, fecha, unidad_nombre, unidad_abreviacion, version_nombre, estado_nombre, id_empresa from vista_itemizado_pmo where id_version=".$version." AND id_empresa=".$empresa." order by codigo ASC";
	$tabla="<table><tr><td>N</td><td>Código</td><td>Descripción</td><td>Fecha de ingreso</td><td>Unidad de medida</td><td>Abreviación unidad</td><td>Versión</td><td>Estado</td><td>Empresa</td></tr>";
	$contador=1;
	$a=get_datos($cns);
	while(odbc_fetch_row($a))
	{
		$tabla.="<tr><td>".$contador."</td>";
		$tabla.="<td>".odbc_result($a, "codigo")."</td>";
		$tabla.="<td>".odbc_result($a, "descripcion")."</td>";
		$tabla.="<td>".odbc_result($a, "fecha")."</td>";
		$tabla.="<td>".odbc_result($a, "unidad_nombre")."</td>";
		$tabla.="<td>".odbc_result($a, "unidad_abreviacion")."</td>";
		$tabla.="<td>".odbc_result($a, "version_nombre")."</td>";
		$tabla.="<td>".odbc_result($a, "estado_nombre")."</td>";
		$tabla.="<td>".odbc_result($a, "id_empresa")."</td></tr>";
		$contador++;
	}
	$tabla.="</table>";
	return decoder($tabla);
}


function get_tabla_proyectos($subproyecto)
{
	$cns="select codigo, descripcion, fecha, id_usuario, unidad_nombre, factor_equivalencia, estado_nombre,unidad_abreviacion, id_subproyecto from vista_itemizado_proyecto where id_subproyecto = ".$subproyecto;
	$tabla="<table><tr><td>N</td><td>Código</td><td>Descripción</td><td>Fecha de ingreso</td><td>Usuario</td><td>Estado</td><td>Factor de equivalencia</td><td>Unidad</td><td>Subproyecto</td></tr>";
	$contador=1;
	$a=get_datos($cns);
	while(odbc_fetch_row($a))
	{
		$tabla.="<tr><td>".$contador."</td>";
		$tabla.="<td>".odbc_result($a, "codigo")."</td>";
		$tabla.="<td>".odbc_result($a, "descripcion")."</td>";
		$tabla.="<td>".odbc_result($a, "fecha")."</td>";
		$tabla.="<td>".odbc_result($a, "id_usuario")."</td>";
		$tabla.="<td>".odbc_result($a, "estado_nombre")."</td>";
		$tabla.="<td>".odbc_result($a, "factor_equivalencia")."</td>";
		$tabla.="<td>".odbc_result($a, "unidad_nombre")."</td>";
		$tabla.="<td>".odbc_result($a, "unidad_abreviacion")."</td>";
		$tabla.="<td>".odbc_result($a, "id_subproyecto")."</td></tr>";
		$contador++;
	}
	$tabla.="</table>";
	return decoder($tabla);
}

/*function get_nombre_subproyecto($id)
{
	$cns= "select nombre from subproyecto where id=".$id;
	$a=get_datos($cns);
	while(odbc_fetch_row($a))
	{
		$id=odbc_result($a, "nombre");
	}
	return $id;
}*/

?>