<?php

require_once('../libs/php/sql_sigp.php');

if ($_POST['funcion'] == "ListarVersiones") {

    $var1 = "SELECT v.id, v.nombre, v.fecha_creacion, v.id_estados, e.nombre as estado_nombre
                            FROM dbo.itemizado_pmo_version v JOIN dbo.estados e ON v.id_estados = e.id
                        WHERE e.id_tipo = 1 and e.id = 1";

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
?>
