<?php

session_start();
require_once('../libs/php/sql_sigp.php');
require_once('../libs/php/generales.php');
// isset($_POST['funcion']) && 
if ($_POST['funcion'] == "ListarItemizadoPMO") {
    //echo "ListarUsuarios";

    $var1 = "SELECT REPLACE(codigo,'.','') as orden, id, codigo,descripcion, factor_equivalencia,version_nombre, estado_nombre, unidad_abreviacion, id_estado, id_unidad, id_empresa  FROM vista_itemizado_pmo ORDER BY orden ASC";

    $a = get_datos($var1);
    $contador = 0;
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
        $objeto .= "'id_empresa':'" . encoder(odbc_result($a, "id_empresa")) . "',";
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

if ($_POST['funcion'] == "ListarItemizadoPMO_nuevo") {
    //echo "ListarUsuarios";

    $var1 = "SELECT REPLACE(codigo,'.','') as orden, id, codigo,descripcion, factor_equivalencia,version_nombre, estado_nombre, unidad_abreviacion, id_estado, id_unidad, id_empresa  FROM vista_itemizado_pmo where id_version=" . $_POST['version'] . " ORDER BY orden ASC";

    $a = get_datos($var1);
    $contador = 0;
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
        $objeto .= "'id_empresa':'" . encoder(odbc_result($a, "id_empresa")) . "',";
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

if ($_POST['funcion'] == "listar_empresas") {
    $empresa = $_POST['empresa'];

    $var1 = "select id, nombre from empresas order by nombre ASC";

    $a = get_datos_sigp($var1);
    $contador = 0;
    $objeto = "[";
    while (odbc_fetch_row($a)) {
        $objeto.="{";
        $objeto.="'id':'" . odbc_result($a, "id") . "',";
        $objeto.="'nombre':'" . encoder(odbc_result($a, "nombre")) . "'";
        $objeto.="},";
        $contador = 1;
    }
    if ($contador >= 1) {
        $objeto = substr($objeto, 0, -1);
    }
    $objeto .= "]";
    echo $objeto;
}

if ($_POST['funcion'] == "listar_unidades") {
    $empresa = $_POST['empresa'];

    $var1 = "select id, nombre from unidades_registro order by nombre ASC";

    $a = get_datos_sigp($var1);
    $contador = 0;
    $objeto = "[";
    while (odbc_fetch_row($a)) {
        $objeto.="{";
        $objeto.="'id':'" . odbc_result($a, "id") . "',";
        $objeto.="'nombre':'" . encoder(odbc_result($a, "nombre")) . "'";
        $objeto.="},";
        $contador = 1;
    }
    if ($contador >= 1) {
        $objeto = substr($objeto, 0, -1);
    }
    $objeto .= "]";
    echo $objeto;
}

if ($_POST['funcion'] == "listar_versiones_nuevo") {
    $empresa = $_POST['empresa'];

    $var1 = "select DISTINCT(nombre) as nombre, id from itemizado_pmo_version where id in (select id_version from itemizado_pmo where id_empresas=" . $empresa . ")";
    //echo $var1;

    $a = get_datos_sigp($var1);
    $contador = 0;
    $objeto = "[";
    while (odbc_fetch_row($a)) {
        $objeto.="{";
        $objeto.="'id':'" . odbc_result($a, "id") . "',";
        $objeto.="'nombre':'" . encoder(odbc_result($a, "nombre")) . "'";
        $objeto.="},";
        $contador = 1;
    }
    if ($contador >= 1) {
        $objeto = substr($objeto, 0, -1);
    }
    $objeto .= "]";
    echo $objeto;
}

if ($_POST['funcion'] == "listar_estados") {
    $var1 = "select id, nombre from estados where id_tipo = 1 order by nombre ASC";

    $a = get_datos_sigp($var1);
    $contador = 0;
    $objeto = "[";
    while (odbc_fetch_row($a)) {
        $objeto.="{";
        $objeto.="'id':'" . odbc_result($a, "id") . "',";
        $objeto.="'nombre':'" . encoder(odbc_result($a, "nombre")) . "'";
        $objeto.="},";
        $contador = 1;
    }
    if ($contador >= 1) {
        $objeto = substr($objeto, 0, -1);
    }
    $objeto .= "]";
    echo $objeto;
}

if ($_POST['funcion'] == "listar_versiones") {
    $cns_empresa = "select distinct(id_version) from itemizado_pmo where id_empresas=" . $_POST['empresa'];
    $version = "";
    $a = get_datos($cns_empresa);
    while (odbc_fetch_row($a)) {
        $version.=odbc_result($a, "id_version") . ",";
    }
    $version = substr($version, 0, -1);
    $arr_version = explode(",", $version);
    $largo_version = count($arr_version);
    $contador = 0;
    $var1 = "select id, nombre from itemizado_pmo_version where id in (";
    while ($contador < $largo_version) {
        $var1.=$arr_version[$contador] . ",";
        $contador++;
    }
    $var1 = substr($var1, 0, -1);
    $var1.=") order by nombre ASC";
    //$var1 = "select id, nombre from itemizado_pmo_version order by nombre ASC";

    $a = get_datos_sigp($var1);
    $contador = 0;
    $objeto = "[";
    while (odbc_fetch_row($a)) {
        $objeto.="{";
        $objeto.="'id':'" . odbc_result($a, "id") . "',";
        $objeto.="'nombre':'" . encoder(odbc_result($a, "nombre")) . "'";
        $objeto.="},";
        $contador = 1;
    }
    if ($contador >= 1) {
        $objeto = substr($objeto, 0, -1);
    }
    $objeto .= "]";
    echo $objeto;
}

if ($_POST['funcion'] == "ObtenerCorrelativoPMO") {

    $var1 = "SELECT dbo.fnGetCorrelativoPMO('" . $_POST["idpadre"] . "','" . $_POST["id_version"] . "') AS codigo";

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

if ($_POST['funcion'] == "Eliminar_itm") {

    $var1 = "select count(id) as cantidad from itemizado_subproyecto where id_itemizado_pmo=" . $_POST['itemizado'];
    $a = get_datos_sigp($var1);
    $respuesta = 0;
    while (odbc_fetch_row($a)) {
        $respuesta = odbc_result($a, "cantidad");
    }
    if ($respuesta == 0) {
        $var1 = "delete from itemizado_pmo where id = " . $_POST['itemizado'];
        $a = get_datos($var1);
    }
    echo $respuesta;
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
    $var1 .= "             '" . date('Y-m-d') . "', ";
    $var1 .= "             '$_POST[idversion]', ";
    $var1 .= "             '$_POST[idunidad]', ";
    $var1 .= "             '$_POST[idempresa]', ";
    $var1 .= "             '1', ";
    $var1 .= "             $_POST[factor] ) ";

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

function get_nombre_itemizado($id) {
    $cns = "select nombre from itemizado_pmo where id =" . $id;
    $a = get_datos($cns);
    $nombre = "No posee";
    while (odbc_fetch_row($a)) {
        $nombre = odbc_result($a, "nombre");
    }
    if ($nombre == "") {
        $nombre = "No posee";
    }
    return $nombre;
}

?>
