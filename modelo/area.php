<?php

require_once('../libs/php/sql_sigp.php');
require_once('../libs/php/generales.php');


// isset($_POST['funcion']) && 

if($_POST['funcion']=="Listar_area"){
		
	$var1 = "select id, codigo, descripcion, nombre_estados from vista_area order by codigo asc" ;	
						
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

if($_POST['funcion']=="listar_clasificaciones"){
		
	$var1 = "select id, nombre from clasificacion order by nombre asc" ;	
						
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

if($_POST['funcion']=="listar_estados"){
		
	$var1 = "select id, nombre from estados where id_tipo = 1 order by nombre asc" ;	
						
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

if($_POST['funcion']=="nueva_area"){
		//echo "ListarUsuarios";
		
		$cns = "insert into area (codigo, descripcion, id_estados) values ('".decoder($_POST['codigo'])."','".$_POST['nombre']."',".$_POST['estado'].")";
		//echo $cns;
		$a = get_datos($cns);
		
		$cns = "SELECT @@IDENTITY AS ID";
		
		$b = get_datos($cns);
		
		while(odbc_fetch_row($b))
		{
			$ultimo_id = odbc_result($b,"ID");
		}

		echo $ultimo_id;
	}
	
if($_POST['funcion']=="updt_area")
{
	$cns = "update area set codigo='".decoder($_POST['codigo'])."', descripcion='".$_POST['nombre']."', id_estados=".$_POST['estado']." where id=".$_POST['id'];
	//echo $cns;
	$a = get_datos($cns);
}

function valida_dependencias($id)
{
	$respuesta = 0;
	$cns0 = "select COUNT(id) as cant from actividades where id_subclasificacion = ".$id;

	$a = get_datos($cns0);
			
	while(odbc_fetch_row($a))
	{
		$respuesta+= odbc_result($a,'cant');
	}
	
	return $respuesta;
}

if($_POST['funcion']=="eliminar_area")
{
	$respuesta = 0;
	$error = 5;
	$cns0="delete from area where id =".$_POST['id'];
	//echo $cns0;
	/*if(valida_dependencias($_POST['id']) == 0)
	{*/
		$a=get_datos($cns0);
		$cns="select count(id) as cant from area where id =".$_POST['id'];
		$a=get_datos($cns);
		while(odbc_fetch_row($a))
		{
			$error=odbc_result($a,"cant");
		}
	/*}
	else
	{
		$error = 5;
	}*/
	echo $error;
}






/*HECHO POR JOHN*/////////////////
if ($_POST['funcion'] == "ListarSubClasificacion") {
    //echo "ListarUsuarios";

    $var1 = "";
    $var1 .= "SELECT c.id, ";
    $var1 .= "       c.nombre, ";
    $var1 .= "       c.id_estados, ";
    $var1 .= "       e.id      AS id_estado_clasificacion, ";
    $var1 .= "       e.nombre  AS nombre_estado_clasificacion, ";
    $var1 .= "       sc.id     AS id_subclasificacion, ";
    $var1 .= "       sc.nombre AS nombre_subclasificacion, ";
    $var1 .= "       e1.id     AS id_estado_subclasificacion, ";
    $var1 .= "       e1.nombre AS nombre_estado_subclasificacion ";
    $var1 .= "FROM   clasificacion c ";
    $var1 .= "       JOIN subclasificacion sc ";
    $var1 .= "         ON c.id = sc.id_clasificacion ";
    $var1 .= "       JOIN estados e ";
    $var1 .= "         ON c.id_estados = e.id ";
    $var1 .= "            AND e.id_tipo = 1 ";
    $var1 .= "       JOIN estados e1 ";
    $var1 .= "         ON sc.id_estados = e1.id ";
    $var1 .= "            AND e1.id_tipo = 1 ";
    $var1 .= "ORDER  BY sc.nombre ASC ";

    $a = get_datos_sigp($var1);

    while (odbc_fetch_row($a)) {
        for ($contador = 1; $contador <= odbc_num_fields($a); $contador++) {
            $nombre = odbc_field_name($a, $contador);
            $proyectos[$nombre] = utf8_encode(odbc_result($a, $contador));
        }
        $objeto[] = $proyectos;
    }
    echo json_encode($objeto);
}

?>
