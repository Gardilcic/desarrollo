<?php

session_start();
require_once('../libs/php/sql_sigp.php');
require_once('../libs/php/generales.php');
// isset($_POST['funcion']) && 
if ($_POST['funcion'] == "ListarItemizadoPMO") {
    //echo "ListarUsuarios";

    $var1 = "SELECT REPLACE(codigo,'.','') as orden, id, codigo,descripcion, factor_equivalencia,version_nombre, estado_nombre, unidad_abreviacion, precio_unitario, id_itemizado_pmo, id_unidad, id_estado, id_subproyecto  FROM vista_itemizado_proyecto ";

    if(isset($_POST["idsubproyecto"])){
        $var1 .= " WHERE id_subproyecto = $_POST[idsubproyecto] ";
    }
    
    $var1 .= "ORDER BY orden ASC";
    
    $a = get_datos($var1);
    $contador=0;
    $objeto = "[";
    while (odbc_fetch_row($a)) {
        $objeto .= "{";
        $objeto .= "'orden':'" . odbc_result($a, "orden") . "',";
        $objeto .= "'id':'" . str_replace("'", "", encoder(odbc_result($a, "id"))) . "',";
        $objeto .= "'unidad_abreviacion':'" . str_replace("'", "", encoder(odbc_result($a, "unidad_abreviacion"))) . "',";
        $objeto .= "'codigo':'" . encoder(odbc_result($a, "codigo")) . "',";
        $objeto .= "'descripcion':'" . encoder(odbc_result($a, "descripcion")) . "',";
        $objeto .= "'factor_equivalencia':'" . encoder(odbc_result($a, "factor_equivalencia")) . "',";
        $objeto .= "'version_nombre':'" . encoder(odbc_result($a, "version_nombre")) . "',";
        $objeto .= "'estado_nombre':'" . encoder(odbc_result($a, "estado_nombre")) . "',";
        $objeto .= "'precio':'" . encoder(odbc_result($a, "precio_unitario")) . "',";
        $objeto .= "'itemizado_pmo':'" . encoder(odbc_result($a, "id_itemizado_pmo")) . "',";
        $objeto .= "'id_unidad':'" . encoder(odbc_result($a, "id_unidad")) . "',";
        $objeto .= "'id_estado':'" . encoder(odbc_result($a, "id_estado")) . "',";
        $objeto .= "'nombre':'" . encoder(get_nombre_itemizado(odbc_result($a, "id"))) . "'";
        $objeto .= "},";
        $contador = 1;
    }
    if ($contador >= 1) {
        $objeto = substr($objeto, 0, -1);
    }
    $objeto .= "]";
    echo ($objeto);
}

if ($_POST['funcion'] == "listar_proyectos") {

    $var1 = "select id, nombre from subproyectos order by nombre ASC";

    $a = get_datos_sigp($var1);
    $contador=0;
	$objeto = "[";
    while (odbc_fetch_row($a))
    {
        $objeto.="{";
        $objeto.="'id':'".odbc_result($a, "id")."',";
        $objeto.="'nombre':'".encoder(odbc_result($a, "nombre"))."'";
        $objeto.="},";
        $contador=1;
    }
    if ($contador >= 1) {
        $objeto = substr($objeto, 0, -1);
    }
    $objeto .= "]";
    echo $objeto;
}

if ($_POST['funcion'] == "ObtenerCorrelativoPMO") {

    $var1 = "SELECT dbo.fnGetCorrelativoPMO('".$_POST["idpadre"]."') AS codigo";

    $a = get_datos_sigp($var1);

    while (odbc_fetch_row($a)) {
        for ($contador = 1; $contador <= odbc_num_fields($a); $contador++) {
            $nombre = odbc_field_name($a, $contador);
            $proyectos[$nombre] = odbc_result($a, $contador);
        }
        $objeto[] = $proyectos;
    }
    echo json_encode($objeto);
}


if ($_POST['funcion'] == "GrabarNuevo") {

    $var1 = "";
    $var1 .= "INSERT INTO itemizado_pmo ";
    $var1 .= "            (codigo, ";
    $var1 .= "             id_padre, ";
    $var1 .= "             descripcion, ";
    $var1 .= "             id_estados, ";
    $var1 .= "             fecha_ingreso, ";
    $var1 .= "             id_version, ";
    $var1 .= "             id_unidad, ";
    $var1 .= "             id_usuario, ";
    $var1 .= "             id_empresas, ";
    $var1 .= "             factor_equivalencia ) ";
    $var1 .= "VALUES      ('$_POST[codigo]', ";
    $var1 .= "             '$_POST[idpadre]', ";
    $var1 .= "             '$_POST[descripcion]', ";
    $var1 .= "             '$_POST[idestado]', ";
    $var1 .= "             '".date('Y-m-d')."', ";
    $var1 .= "             '$_POST[idversion]', ";
    $var1 .= "             '$_POST[idunidad]', ";
    $var1 .= "             '$_POST[idempresa]', ";
    $var1 .= "             '1', ";
    $var1 .= "             $_POST[factor] ) " ;

    $a = get_datos_sigp($var1);
    $cns = "SELECT @@IDENTITY AS ID";
    $b = get_datos_sigp($cns);
    while (odbc_fetch_row($b)) {
        $ultimo_id = odbc_result($b, "ID");
    }
    echo $ultimo_id;
}

if ($_POST['funcion'] == "GrabarItemizadoPMO") {

    $var1 = "";
    $var1 .= "UPDATE itemizado_pmo SET ";
    $var1 .= "            descripcion = '$_POST[descripcion]', ";
    $var1 .= "             id_estados = '$_POST[idestado]', ";
    $var1 .= "             id_unidad = '$_POST[idunidad]', ";
    $var1 .= "             factor_equivalencia = '$_POST[factor]' ";
    $var1 .= "WHERE id = '$_POST[id]'";    

    $a = get_datos_sigp($var1);
    
    if ($a === true)
        $respuesta = -1;
    else
        $respuesta = 1;

    echo $respuesta;
}

function get_nombre_itemizado($id)
{
	$cns ="select nombre from itemizado_pmo where id =".$id;
	$a=get_datos($cns);
	$nombre = "No posee";
	while (odbc_fetch_row($a))
	{
        $nombre = odbc_result($a, "nombre");
    }
    if ($nombre=="")
    {
    	$nombre="No posee";
    }
	return $nombre;
}

if ($_POST['funcion'] == "listar_subproyectos") {

    $var1 = "select id, nombre from subproyectos order by nombre ASC";
    //echo $var1;
    $respuesta="";
    $a = get_datos($var1);
    $objeto = "[";
    while (odbc_fetch_row($a))
    {
        $objeto.="{";
        $objeto.="'id':'".odbc_result($a, "id")."',";
        $objeto.="'nombre':'".encoder(odbc_result($a, "nombre"))."'";
        $objeto.="},";
        $contador=1;
    }
    if ($contador >= 1) {
        $objeto = substr($objeto, 0, -1);
    }
    $objeto .= "]";
    echo $objeto;
}

if($_POST['funcion'] == "listar_itemizado_subproyecto"){
    
    
    $var1 = "select id, codigo, descripcion from vista_itemizado_proyecto where id_itemizado_pmo is null AND id_subproyecto=".$_POST['subproyecto']." order by codigo ASC";
    $a=get_datos($var1);
    $objeto = "[";
    while (odbc_fetch_row($a))
    {
        $objeto.="{";
        $objeto.="'id':'".odbc_result($a, "id")."',";
        $objeto.="'nombre':'".encoder(odbc_result($a, "codigo"))." ".encoder(odbc_result($a, "descripcion"))."'";
        $objeto.="},";
        $contador=1;
    }
    if ($contador >= 1) {
        $objeto = substr($objeto, 0, -1);
    }
    $objeto .= "]";
    echo $objeto;
}

if($_POST['funcion'] == "listar_itemizado_pmo"){
    
    
    $var1 = "select id, codigo, descripcion from vista_itemizado_pmo order by codigo ASC";
    $a=get_datos($var1);
    $objeto = "[";
    while (odbc_fetch_row($a))
    {
        $objeto.="{";
        $objeto.="'id':'".odbc_result($a, "id")."',";
        $objeto.="'nombre':'".encoder(odbc_result($a, "codigo"))." ".encoder(odbc_result($a, "descripcion"))."'";
        $objeto.="},";
        $contador=1;
    }
    if ($contador >= 1) {
        $objeto = substr($objeto, 0, -1);
    }
    $objeto .= "]";
    echo $objeto;
}

if($_POST['funcion'] == "entregar_nuevo_id"){

    $padre=$_POST['padre'];
    $cantidad=0;
    $resultado=1;
        $var1 = "select COUNT(codigo) as cant from vista_itemizado_proyecto where id_padre= ".$padre;
        $a=get_datos($var1);

        while (odbc_fetch_row($a))
        {
            $cantidad=odbc_result($a,"cant");
        }
        //echo "var1=".$var1."---";
        if($cantidad==0)
        {
            $resultado=1;
            /*$var1="select codigo from vista_itemizado_proyecto where id=".$padre;
            $a=get_datos($var1);
            while(odbc_fetch_row($a))
            {
                $resultado=odbc_result($a,"codigo");
            }*/
        }
        else
        {
            $var1="select TOP 1(codigo) as codigo from itemizado_subproyecto where id_padre=".$padre." order by codigo DESC";
            $a=get_datos($var1);
            while(odbc_fetch_row($a))
            {
                $resultado=odbc_result($a,"codigo");
                $resultado=$resultado+1;
            }
        }
    echo $resultado;
}

if ($_POST['funcion'] == "Eliminar") {

    //VALIDO SI TIENE HIJOS
    $var1 = "select COUNT(id) as cantidad from itemizado_subproyecto where id_padre=".$_POST["id"];

    $a = get_datos_sigp($var1);
    $cantidad=0;
    while (odbc_fetch_row($a))
    {
        $cantidad=odbc_result($a, "cantidad");
    }
    if($cantidad==0)
    {
        $var1="delete from itemizado_subproyecto where id=".$_POST["id"];
        get_datos($var1);
        $cantidad=0;
    }
    echo json_encode($cantidad);
}


?>
