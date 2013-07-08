<?php

require_once('../libs/php/sql_sigp.php');
require_once('../libs/php/generales.php');
require_once('../libs/php/funciones_regiones.php');

if ($_POST['funcion'] == "listar_modulos") {    
    $cns = "EXECUTE [dbo].[sp_vista_usuarios_modulos]";
    $a = get_datos($cns);
    
    while (odbc_fetch_row($a)) {
        for ($contador = 1; $contador <= odbc_num_fields($a); $contador++) {
            $nombre = odbc_field_name($a, $contador);
            $proyectos[$nombre] = utf8_encode(odbc_result($a, $contador));
        }
        $objeto[] = $proyectos;
    }
    echo json_encode($objeto);
}

if ($_POST['funcion'] == "nuevo_modulo") {
    $cns = "EXECUTE [dbo].[crea_modulo_usuarios] @nombre = N'" . decoder($_POST['nombre']) . "', @estado = " . $_POST['estado'] . ", @color = '" . $_POST['color'] . "'";

    $a = get_datos($cns);

    /* $cns = "SELECT @@IDENTITY AS ID";

      $b = get_datos($cns); */

    while (odbc_fetch_row($a)) {
        $respuesta = odbc_result($a, "respuesta");
    }

    echo $respuesta;
    //echo $cns;
}

if ($_POST['funcion'] == "updt_modulo") {
    //echo "ListarUsuarios";

    $cns = "EXEC [dbo].[actualiza_modulo_usuarios] @nombre = N'" . decoder($_POST['nombre']) . "', @estado = " . $_POST['estado'] . ", @color = '" . $_POST['color'] . "', @id = " . $_POST['id'];

    $a = get_datos($cns);
    while (odbc_fetch_row($a)) {
        $respuesta = odbc_result($a, 'respuesta');
    }
    echo $respuesta;
}

if ($_POST['funcion'] == "listar_estados") {
    //echo "ListarUsuarios";

    $cns = "select id, nombre from vista_usuarios_estados order by nombre ASC";

    $a = get_datos($cns);

    $objeto = "[";
    while (odbc_fetch_row($a)) {
        $objeto .= "{";
        $objeto .= "'id':'" . odbc_result($a, "id") . "',";
        $objeto .= "'nombre':'" . encoder(odbc_result($a, "nombre")) . "'";
        $objeto .= "},";
    }
    $objeto = substr($objeto, 0, -1);
    $objeto .= "]";

    echo $objeto;
}

if ($_POST['funcion'] == "valida_dependencia") {
    $respuesta = 0;
    $cns0 = "EXEC valida_dependencias_modulos @id_modulo =" . $_POST['modulo'];

    $a = get_datos($cns0);

    while (odbc_fetch_row($a)) {
        $respuesta+= odbc_result($a, 'cant');
    }

    echo $respuesta;
}

if ($_POST['funcion'] == "borra_modulo") {
    $respuesta = 0;

    $cns0 = "EXEC borra_modulo @id_modulo=" . $_POST['modulo'];

    $a = get_datos($cns0);

    $cns0 = "EXEC valida_dependencias_modulos @id_modulo =" . $_POST['modulo'];
    $a = get_datos($cns0);

    while (odbc_fetch_row($a)) {
        $respuesta = odbc_result($a, 'cant');
    }

    echo $respuesta;
}

if ($_POST['funcion'] == "OrdenaModulos") {
    
    $cns = "DECLARE @registro Temporal;";
    
    foreach ($_POST["modulos"] as $key => $value) {
        $cns .= "INSERT INTO @registro VALUES (".$value["id"].",".$value["orden"].");";
    }    
    
    $respuesta = 0;
    $cns .= "EXEC dbo.actualiza_orden_modulos @r = @registro";

    $a = get_datos($cns);
    
    $respuesta = odbc_fetch_array($a);

    echo count($respuesta);
}
?>