<?php
require_once('../libs/php/sql_sigp.php');

if($_POST['funcion']=="listar_psdi")
{
	$var1 = "select id, nombre_subproyecto, nombre_corto, descripcion_indicador from vista_psdi";

	$a = get_datos_sigp($var1);
	
	while(odbc_fetch_row($a))
	{
		for($contador=1; $contador<=odbc_num_fields($a); $contador++)
		{
			$nombre = odbc_field_name($a, $contador);
			$proyectos[$nombre]=encoder(odbc_result($a,$contador));
		}
		$objeto[]=$proyectos;
	}		
	echo json_encode($objeto);
}

if($_POST['funcion']=="agregar_relaciones")
{
	$cns = "delete from psdi_usuarios where usuario='".$_POST['usuario']."'";
	get_datos_sigp($cns);
	$arreglo = Array();
	$arreglo = explode(',',$_POST['id']);
	$largo = count($arreglo);
	$cont_control=0;
	while($cont_control<$largo)
	{
		$var1 = "insert into psdi_usuarios (id_psdi, usuario) values (".$arreglo[$cont_control].",'".$_POST['usuario']."')";
		$a = get_datos_sigp($var1);
		$cont_control++;
	}
	echo 1;
}

if($_POST['funcion']=="recupera_relacion_usuario")
{
	$cns = "select id_psdi from psdi_usuarios where usuario='".$_POST['usuario']."'";
	$a=get_datos_sigp($cns);
	$retorno ="";
	while(odbc_fetch_row($a))
	{
		$retorno.=odbc_result($a,"id_psdi").",";
	}
	$retorno=substr($retorno, 0,-1);
	echo $retorno;
}

?>