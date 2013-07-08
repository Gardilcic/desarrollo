<?php

require_once('../libs/php/sql_sigp.php');
// isset($_POST['funcion']) && 
if ($_POST['funcion'] == "ListarCalendarios") {

    $var1 = "SELECT n.id,n.descripcion,e.id as id_estado, e.nombre as estado_nombre 
                            FROM dbo.calendario n JOIN dbo.estados e ON e.id = n.id_estados";

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

if ($_POST['funcion'] == "NuevoCalendario") {
    //echo "ListarUsuarios";

    $cns = "INSERT INTO dbo.calendario (descripcion, id_estados) values ('" . $_POST['descripcion'] . "','1')";

    $a = get_datos($cns);

    $cns = "SELECT @@IDENTITY AS ID";

    $b = get_datos($cns);

    while (odbc_fetch_row($b)) {
        $ultimo_id = odbc_result($b, "ID");
    }

    echo $ultimo_id;
}

if ($_POST['funcion'] == "ActualizarCalendario") {
    //echo "ListarUsuarios";

    $cns = "update calendario set descripcion='" . $_POST['descripcion'] . "', id_estados ='" . $_POST['id_estado'] . "' where id=" . $_POST['id'];

    $a = get_datos($cns);
}

if ($_POST['funcion'] == "EliminarCalendarios") {
    $respuesta = 0;

    $cns = "delete from calendario where id =" . $_POST['id'];
    $a = get_datos($cns);

    $cns = "SELECT @@ROWCOUNT as respuesta";
    $a = get_datos($cns);

    while (odbc_fetch_row($a)) {
        $respuesta = odbc_result($a, 'respuesta');
    }
    
    echo $respuesta;
}
?>
