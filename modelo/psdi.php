<?php

require_once('../libs/php/sql_sigp.php');
require_once('../libs/php/generales.php');


// isset($_POST['funcion']) && 

if($_POST['funcion']=="Listar_indicadores"){
		
	$var1 = "select id, nombre_proyecto, nombre_subproyecto,descripcion_frecuencia,id_indicador, descripcion_indicador, descripcion_calendario, nombre_corto, descripcion_area, descripcion_perspectiva, ingresado_por, supervisado_por, dato_de, case when correo =1 then 'SI' else 'NO' end as correo, num_dias, case nivel_nombre when 'Nivel 1' then 1 else 0 end as nivel from vista_psdi";

	$a = get_datos_sigp($var1);
	
	while(odbc_fetch_row($a)){
		for($contador=1; $contador<=odbc_num_fields($a); $contador++)
		{
			$nombre = odbc_field_name($a, $contador);
			$proyectos[$nombre]=encoder(odbc_result($a,$contador));
		}
		$objeto[]=$proyectos;
	}		
	echo json_encode($objeto);
}

if($_POST['funcion']=="Listar_frecuencia"){
		
	$var1 = "select id, descripcion from frecuencia order by descripcion ASC";

	$a = get_datos_sigp($var1);
	
	while(odbc_fetch_row($a)){
		for($contador=1; $contador<=odbc_num_fields($a); $contador++)
		{
			$nombre = odbc_field_name($a, $contador);
			$proyectos[$nombre]=encoder(odbc_result($a,$contador));
		}
		$objeto[]=$proyectos;
	}		
	echo json_encode($objeto);
}

if($_POST['funcion']=="listar_area"){
		
	$var1 = "select id, codigo, descripcion from area where id_estados=1 order by descripcion ASC";	
						
	$a = get_datos_sigp($var1);
	
	while(odbc_fetch_row($a)){
		for($contador=1; $contador<=odbc_num_fields($a); $contador++)
		{
			$nombre = odbc_field_name($a, $contador);
			$proyectos[$nombre]=encoder(odbc_result($a,$contador));
		}
		$objeto[]=$proyectos;
	}		
	echo json_encode($objeto);
}

if($_POST['funcion']=="listar_indicador"){
		
	$var1 = "select id, descripcion, case descripcion_nivel when 'Nivel 1' then 1 else 0 end as nivel from vista_indicador_dato where id_estados =1 order by descripcion asc";	
						
	$a = get_datos_sigp($var1);
	
	while(odbc_fetch_row($a)){
		for($contador=1; $contador<=odbc_num_fields($a); $contador++)
		{
			$nombre = odbc_field_name($a, $contador);
			$proyectos[$nombre]=encoder(odbc_result($a,$contador));
		}
		$objeto[]=$proyectos;
	}		
	echo json_encode($objeto);
}

if($_POST['funcion']=="listar_calendarios"){
		
	$var1 = "select id, descripcion from calendario where id_estados = 1";	
						
	$a = get_datos_sigp($var1);
	
	while(odbc_fetch_row($a)){
		for($contador=1; $contador<=odbc_num_fields($a); $contador++)
		{
			$nombre = odbc_field_name($a, $contador);
			$proyectos[$nombre]=encoder(odbc_result($a,$contador));
		}
		$objeto[]=$proyectos;
	}		
	echo json_encode($objeto);
}

if($_POST['funcion']=="listar_estados"){
		
	$var1 = "select id, nombre from estados where id_tipo = 1 order by nombre asc";	
						
	$a = get_datos_sigp($var1);
	
	while(odbc_fetch_row($a)){
		for($contador=1; $contador<=odbc_num_fields($a); $contador++)
		{
			$nombre = odbc_field_name($a, $contador);
			$proyectos[$nombre]=odbc_result($a,$contador);
		}
		$objeto[]=$proyectos;
	}		
	echo json_encode($objeto);
}

if($_POST['funcion']=="listar_perspectiva"){
		
	$var1 = "select id, descripcion from perspectiva where id_estados = 1 order by descripcion asc";	
						
	$a = get_datos_sigp($var1);
	
	while(odbc_fetch_row($a)){
		for($contador=1; $contador<=odbc_num_fields($a); $contador++)
		{
			$nombre = odbc_field_name($a, $contador);
			$proyectos[$nombre]=odbc_result($a,$contador);
		}
		$objeto[]=$proyectos;
	}		
	echo json_encode($objeto);
}

if($_POST['funcion']=="get_nivel")
{		
	//$var1 = "select descripcion from nivel where id in (select id_nivel from indicador_dato where id = ".$_POST['indicador'].")";
	$var1="select  case descripcion when 'Nivel 1' then 1 else 0 end as resultado from nivel where id in (select id_nivel from indicador_dato where id = ".$_POST['indicador'].")";
	$a = get_datos_sigp($var1);
	$nivel="";
	$respuesta=2;//no es dato. Es indicador (nivel 2)
	while(odbc_fetch_row($a))
	{
		$nivel=encoder(odbc_result($a,"resultado"));
	}
	if($nivel == '1')
	{
		$respuesta=1;//Nivel 1, es dato
	}
	echo $respuesta;
}

if($_POST['funcion']=="listar_subproyectos"){
		
	$var1 = "select id, nombre from subproyectos where id_estados=1 order by nombre ASC";	
						
	$a = get_datos_sigp($var1);
	
	while(odbc_fetch_row($a)){
		for($contador=1; $contador<=odbc_num_fields($a); $contador++)
		{
			$nombre = odbc_field_name($a, $contador);
			$proyectos[$nombre]=encoder(odbc_result($a,$contador));
		}
		$objeto[]=$proyectos;
	}		
	echo json_encode($objeto);
}


if($_POST['funcion']=="nuevo_psdi"){
		//echo "ListarUsuarios";
		
		if($_POST['fecha']=='')
		{
			$fecha = 'NULL';
		}
		$codigo_area = get_codigo_area($_POST['area']);
		$id_proyecto = get_id_proyecto($_POST['subproyecto']);
		$codigo_proyecto=get_nombre_proyecto($id_proyecto);
		$codigo_subpro=get_codigo_subproyecto($_POST['subproyecto']);
		
		$codigo= $codigo_proyecto." ".$codigo_subpro." ".$codigo_area;
		//$codigo=0;
		$existe = 0;
		$cns = "select count (id ) as cant from psdi where codigo ='".$codigo."'";
		$a = get_datos($cns);
		while(odbc_fetch_row($a))
		{
			$existe=odbc_result($a, "cant");
		}
		
		/*if($existe == 0)
		{*/
			$cns = "insert into psdi (codigo,id_frecuencia,id_calendario,id_indicador_dato,id_area,";
			$cns.="id_perspectiva,ingresado_por,supervisado_por,dato_de,id_subproyecto,id_proyecto,id_estados, nombre_corto, correo, num_dias)";
			$cns .=" values (";
			$cns.="'".$codigo."',";
			$cns.=$_POST['frecuencia'].",";
			$cns.="".$_POST['fecha'].",";
			$cns.=$_POST['indicador'].",";
			$cns.=$_POST['area'].",";
			$cns.=$_POST['perspectiva'].",";
			$cns.="'".$_POST['ingresado_por']."',";
			$cns.="'".$_POST['supervisor']."',";
			$cns.="'".$_POST['propietario']."',";
			$cns.=$_POST['subproyecto'].",";
			$cns.=$id_proyecto.",";
			$cns.=$_POST['estado'].",";
			$cns.="'".$_POST['nombre_corto']."',";
			$cns.=$_POST['correo'].",";
			$cns.=$_POST['cant_dias'].")";
			
			
			$a = get_datos($cns);
			
			$cns2 = "SELECT @@IDENTITY AS ID";
			
			$b = get_datos($cns2);
			
			while(odbc_fetch_row($b))
			{
				$ultimo_id = odbc_result($b,"ID");
			}
		/*}
		else
		{
			$ultimo_id=0;
		}*/
		//echo $cns;
		echo $ultimo_id;
	}

if($_POST['funcion']=="updt_psdi")
{
	
	
	$cns = "update psdi set ";//id_calendario,,id_area,";
			//$cns.="id_perspectiva,ingresado_por,supervisado_por,dato_de,id_subproyecto,id_proyecto,id_estados, nombre_corto)";
			$cns.="id_frecuencia=".$_POST['frecuencia'].",";
			$cns.="id_calendario=".$_POST['calendario'].",";
			$cns.="id_indicador_dato=".$_POST['indicador'].",";
			$cns.="id_area=".$_POST['area'].",";
			$cns.="id_perspectiva=".$_POST['perspectiva'].",";
			$cns.="ingresado_por='".$_POST['ingresado']."',";
			$cns.="supervisado_por='".$_POST['supervisor']."',";
			$cns.="dato_de='".$_POST['propietario']."',";
			$cns.="id_estados=".$_POST['estado'].",";
			$cns.="nombre_corto='".$_POST['nombre_corto']."',";
			$cns.=" correo=".$_POST['correo'].",";
			$cns.="num_dias=".$_POST['cant_dias']." ";
			$cns.=" where id = ".$_POST['id'];

	//echo $cns;
	
	//$cns = "update area set codigo='".decoder($_POST['codigo'])."', descripcion='".$_POST['nombre']."', id_estados=".$_POST['estado']." where id=".$_POST['id'];
	
	$a = get_datos($cns);
	//echo $cns;
}

function valida_dependencias($id)
{
	$respuesta = 0;
	$cns0 = "select COUNT(id) as cant from actividades where id_subclasificacion = ".$id;

	$a = get_datos($cns0);
			
	while(odbc_fetch_row($a))
	{
		$respuesta= odbc_result($a,'cant');
	}
	
	return $respuesta;
}

if($_POST['funcion']=="eliminar_psdi")
{
	$respuesta = 0;
	$error = 5;
	$cns0="delete from psdi where id =".$_POST['id'];
	//echo $cns0;
	//if(valida_dependencias($_POST['id']) == 0)
	//{
		$a=get_datos($cns0);
		$cns="select count(id) as cant from psdi where id =".$_POST['id'];
		$a=get_datos($cns);
		while(odbc_fetch_row($a))
		{
			$error=odbc_result($a,"cant");
		}
	echo $error;
}


function get_codigo_area($id)
{
	$cns="select codigo from area where id =".$id;
	$a = get_datos($cns);
	$codigo=0;
	while(odbc_fetch_array($a))
	{
		$codigo=odbc_result($a,"codigo");
	}
	return $codigo;
}

function get_codigo_subproyecto($id)
{
	$cns="select nombre from subproyectos where id = ".$id;
	$a = get_datos($cns);
	$codigo=0;
	while(odbc_fetch_array($a))
	{
		$codigo=odbc_result($a,"nombre");
	}
	return $codigo;
}

function get_nombre_proyecto($id)
{
	$cns="select nombre from proyectos where id = ".$id;
	$a = get_datos($cns);
	$codigo=0;
	while(odbc_fetch_array($a))
	{
		$codigo=odbc_result($a,"nombre");
	}
	return $codigo;
}

function get_id_proyecto($id)
{
	$cns="select id from proyectos where id in (select id_proyectos from subproyectos where id=".$id.")";
	$a = get_datos($cns);
	$codigo=0;
	while(odbc_fetch_array($a))
	{
		$codigo=odbc_result($a,"id");
	}
	return $codigo;
}

?>
