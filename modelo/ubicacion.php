<?php

session_start();
require_once('../libs/php/sql_sigp.php');
// isset($_POST['funcion']) && 

if ($_POST['funcion'] == "ListarUbicaciones") {

    $var1 = "";
    $var1 .= "SELECT id, ";
    $var1 .= "       nombre, ";
    $var1 .= "       region, ";
    $var1 .= "       id_regiones, ";
    $var1 .= "       nombre_regiones, ";
    $var1 .= "       simbolo_regiones, ";
    $var1 .= "       id_pais, ";
    $var1 .= "       nombre_pais, ";
    $var1 .= "       codigo_pais ";
    $var1 .= "FROM dbo.vista_ubicaciones";

    $a = get_datos_sigp($var1);

    $contador = 1;
    while (odbc_fetch_row($a)) {
        for ($contador = 1; $contador <= odbc_num_fields($a); $contador++) {
            $nombre = odbc_field_name($a, $contador);
            $proyectos[$nombre] = odbc_result($a, $contador);
        }
        $objeto[] = $proyectos;
    }
    echo json_encode($objeto);
}

if ($_POST['funcion'] == "updt_ubicacion") {
    
    $cns = "UPDATE [dbo].[ubicaciones] SET [nombre] = '".utf8_decode($_POST["nombre"])."',[region] = $_POST[region] WHERE id = $_POST[id]";
    
    //echo $cns;
    
 //update regiones set nombre='" . decoder($_POST['nombre']) . "', simbolo ='" . decoder($_POST['abb']) . "', id_pais=" . $_POST['pais'] . " where id=" . $_POST['id'];

    $a = get_datos($cns);
    
}
?>
