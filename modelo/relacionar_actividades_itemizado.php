<?php
session_start();
require_once('../libs/php/sql_sigp.php');
require_once('../libs/php/generales.php');

if ($_POST['funcion'] == "listar_empresas") {

    $var1 = "select distinct(nombre) as nombre, id from empresas where id_estados=1 order by nombre ASC";

    $a = get_datos_sigp($var1);
    $respuesta = '[';
    $contador = 0;
    while (odbc_fetch_row($a)) {
        $respuesta.="{'id':'" . odbc_result($a, "id") . "',";
        $respuesta.="'nombre':'" . odbc_result($a, "nombre") . "'},";
        $contador = 1;
    }
    if ($contador >= 1) {
        $respuesta = substr($respuesta, 0, -1);
    }
    $respuesta.=']';
    echo $respuesta;
}

if ($_POST['funcion'] == "listar_proyectos") {

    $var1 = "select id, nombre from proyectos where id_estados = 1 AND id_empresa = ".$_POST['empresa']." order by nombre ASC";

    $a = get_datos_sigp($var1);
    $respuesta = '[';
    $contador = 0;
    while (odbc_fetch_row($a)) {
        $respuesta.="{'id':'" . odbc_result($a, "id") . "',";
        $respuesta.="'nombre':'" . odbc_result($a, "nombre") . "'},";
        $contador = 1;
    }
    if ($contador >= 1) {
        $respuesta = substr($respuesta, 0, -1);
    }
    $respuesta.=']';
    echo $respuesta;
}

if ($_POST['funcion'] == "listar_subproyectos") {

    $var1 = "select id, nombre from subproyectos where id_estados=1 and id in (select id from vista_sigp_usuarios_usuarios_subproyectos where usuario='".$_SESSION['usuario']['usuario']."') order by nombre ASC";

    $a = get_datos_sigp($var1);
    $respuesta = '[';
    $contador = 0;
    while (odbc_fetch_row($a)) {
        $respuesta.="{'id':'" . odbc_result($a, "id") . "',";
        $respuesta.="'nombre':'" . odbc_result($a, "nombre") . "'},";
        $contador = 1;
    }
    if ($contador >= 1)
    {
        $respuesta = substr($respuesta, 0, -1);
    }
    $respuesta.=']';
    echo $respuesta;
}

if ($_POST['funcion'] == "listar_versiones")
{
    $var1 = "";

    $a = get_datos_sigp($var1);
    $respuesta = '[';
    $contador = 0;
    while (odbc_fetch_row($a)) {
        $respuesta.="{'id':'" . odbc_result($a, "id") . "',";
        $respuesta.="'nombre':'" . odbc_result($a, "nombre") . "'},";
        $contador = 1;
    }
    if ($contador >= 1) {
        $respuesta = substr($respuesta, 0, -1);
    }
    $respuesta.=']';
    echo $respuesta;
}

if ($_POST['funcion'] == "listar_actividades") {
    $var1 = "select id, nombre, nombre_referencia from actividades where id_subproyecto=".$_POST['subproyectos']." AND id_itemizado_subproyecto is null order by nombre ASC";

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

if ($_POST['funcion'] == "listar_relaciones") {
    $var1 = "select id, nombre, descripcion from vista_actividades where id_itemizado_subproyecto is not null and id_subproyecto =".$_POST['subproyectos']." order by nombre ASC";

    $a = get_datos_sigp($var1);

    while (odbc_fetch_row($a)){
        for ($contador = 1; $contador <= odbc_num_fields($a); $contador++) {
            $nombre = odbc_field_name($a, $contador);
            $proyectos[$nombre] = utf8_encode(odbc_result($a, $contador));
        }
        $objeto[] = $proyectos;
    }
    echo json_encode($objeto);
}

if ($_POST['funcion'] == "listar_itemizado_subproyecto") {
    $var1 = "select id, codigo, descripcion from vista_itemizado_proyecto where id_estado=1 AND id_subproyecto =" . $_POST['subproyectos'];

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

if ($_POST['funcion'] == "relacionar_itm_actividad") {
    $var1 = "update actividades set id_itemizado_subproyecto=".$_POST['itm']." where id=".$_POST['id'];
    $a = get_datos_sigp($var1);
    
	$var1="select count(id) as cant from actividades where id_itemizado_subproyecto=".$_POST['itm']." AND id=".$_POST['id'];
	$a=get_datos($var1);
	$respuesta=0;
	while(odbc_fetch_row($a))
	{
		$respuesta=odbc_result($a, "cant");
	}
	echo $respuesta;
}

if ($_POST['funcion'] == "desrelacionar_itm_actividad") {
    $var1 = "update actividades set id_itemizado_subproyecto=NULL where id=".$_POST['id'];
    $a = get_datos_sigp($var1);
    
	$var1="select count(id) as cant from actividades where id_itemizado_subproyecto is NULL AND id=".$_POST['id'];
	$a=get_datos($var1);
	$respuesta=0;
	while(odbc_fetch_row($a))
	{
		$respuesta=odbc_result($a, "cant");
	}
	echo $respuesta;
}

if ($_POST['funcion'] == "ListarActividadesRelacionadas") {
    $var1 = "select id, nombre, descripcion from vista_actividades_relaciones 
                where id_itemizado_subproyecto is not null and id_itemizado_subproyecto = $_POST[iditemizado] order by nombre ASC";

    $a = get_datos_sigp($var1);

    while (odbc_fetch_row($a)){
        for ($contador = 1; $contador <= odbc_num_fields($a); $contador++) {
            $nombre = odbc_field_name($a, $contador);
            $proyectos[$nombre] = utf8_encode(odbc_result($a, $contador));
        }
        $objeto[] = $proyectos;
    }
    echo json_encode($objeto);
}

function get_nombre_itemizado($id)
{
	$cns = "select codigo, descripcion from vista_itemizado_proyecto where id =".$id;
	$a=get_datos($cns);
	while(odbc_fetch_row($a))
	{
		$respuesta=odbc_result($a, "codigo")." ".odbc_result($a, "descripcion");
	}
	return $respuesta;
}
?>