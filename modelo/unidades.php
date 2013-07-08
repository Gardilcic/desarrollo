<?php

session_start();
require_once('../libs/php/sql_sigp.php');
// isset($_POST['funcion']) && 

if ($_POST['funcion'] == "ListarUnidades") {

    $var1 = "";
    $var1 .= "SELECT id, ";
    $var1 .= "       nombre+' ('+abreviacion+')' as nombre, ";
    $var1 .= "       abreviacion, ";
    $var1 .= "       id_estados ";    
    $var1 .= "FROM dbo.unidades_registro ORDER BY nombre ";

    $a = get_datos_sigp($var1);

    $contador = 1;
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
