<?php

require_once('../libs/php/sql_sigp.php');
// isset($_POST['funcion']) && 
if ($_POST['funcion'] == "ListarMonedas") {

    $var1 = "SELECT * FROM dbo.monedas";

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

if ($_POST['funcion'] == "listar_monedas") {
    //echo "ListarUsuarios";

    $cns = "select id, nombre, simbolo from monedas order by nombre ASC";

    $a = get_datos($cns);

    $objeto = "[";
    while (odbc_fetch_row($a)) {
        $objeto .= "{";
        $objeto .= "'id':'" . odbc_result($a, "id") . "',";
        $objeto .= "'nombre':'" . odbc_result($a, "nombre") . "',";
        $objeto .= "'simbolo':'" . odbc_result($a, "simbolo") . "'";
        $objeto .= "},";
    }
    $objeto = substr($objeto, 0, -1);
    $objeto .= "]";

    echo $objeto;
}
if ($_POST['funcion'] == "nueva_moneda") {
    //echo "ListarUsuarios";

    $cns = "insert into monedas (nombre, simbolo) values ('" . $_POST['nombre'] . "','" . $_POST['simbolo'] . "')";

    $a = get_datos($cns);

    $cns = "SELECT @@IDENTITY AS ID";

    $b = get_datos($cns);

    while (odbc_fetch_row($b)) {
        $ultimo_id = odbc_result($b, "ID");
    }

    echo $ultimo_id;
}

if ($_POST['funcion'] == "updt_moneda") {
    //echo "ListarUsuarios";

    $cns = "update monedas set nombre='" . $_POST['nombre'] . "', simbolo ='" . $_POST['simbolo'] . "' where id=" . $_POST['id'];

    $a = get_datos($cns);
}


if ($_POST['funcion'] == "ListarEstados") {
    //echo "ListarUsuarios";

    $cns = "SELECT est.id, est.nombre, est.id_tipo " .
            " FROM dbo.estados as est " .
            " WHERE est.id_tipo = 1 " .
            " ORDER BY est.nombre asc ";

    $a = get_datos($cns);

    $objeto = "[";
    while (odbc_fetch_row($a)) {
        $objeto .= "{";
        $objeto .= "'id':'" . odbc_result($a, "id") . "',";
        $objeto .= "'nombre':'" . odbc_result($a, "nombre") . "',";
        $objeto .= "'id_tipo':'" . odbc_result($a, "id_tipo") . "',";
        $objeto .= "},";
    }
    $objeto = substr($objeto, 0, -1);
    $objeto .= "]";

    echo $objeto;
}

if ($_POST['funcion'] == "GrabarNuevoUsuario") {
    //echo "ListarUsuarios";
    $ultimo_id = 0;

    $cns = "INSERT INTO sigp_usuarios.dbo.usuarios (nombre,apellidos,rut,clave,id_estados,id_perfil) VALUES " .
            "('" . $_POST['nombre'] . "','" . $_POST['apellidos'] . "','" . $_POST['rut'] . "','" . $_POST['clave'] . "','" . $_POST['idEstado'] . "','" . $_POST['idPerfil'] . "')";

    $a = get_datos($cns);

    $cns = "SELECT @@IDENTITY AS ID";

    $b = get_datos($cns);

    while (odbc_fetch_row($b)) {
        $ultimo_id = odbc_result($b, "ID");
    }

    echo $ultimo_id;
}

if ($_POST['funcion'] == "GrabarUsuario") {
    //echo "ListarUsuarios";

    $cns = "UPDATE sigp_usuarios.dbo.usuarios SET nombre = " . "'" . $_POST['nombre'] . "'," .
            "apellidos = " . "'" . $_POST['apellidos'] . "'," .
            "rut = " . "'" . $_POST['rut'] . "'," .
            "id_estados = " . "'" . $_POST['idEstado'] . "'," .
            "id_perfil = " . "'" . $_POST['idPerfil'] . "' " .
            " WHERE id = " . $_POST['id'];

    $a = get_datos($cns);
    //$a = 1;
    if ($a === true)
        $respuesta = -1;
    else
        $respuesta = 1;

    echo $respuesta;
}

if ($_POST['funcion'] == "valida_dependencia") {
    $respuesta = 0;
    $cns0 = "select count(id) as cant from proyectos where id_moneda =" . $_POST['moneda'];

    $a = get_datos($cns0);

    while (odbc_fetch_row($a)) {
        $respuesta+= odbc_result($a, 'cant');
    }

    echo $respuesta;
}

if ($_POST['funcion'] == "borra_moneda") {
    $respuesta = 0;
    $cns0 = "delete from monedas_cambio where id_moneda=" . $_POST['moneda'];
    $a = get_datos($cns0);
    $cns0 = "delete from monedas where id=" . $_POST['moneda'];

    $a = get_datos($cns0);

    $cns0 = "select COUNT(id) as cant from monedas where id=" . $_POST['moneda'];
    $a = get_datos($cns0);

    while (odbc_fetch_row($a)) {
        $respuesta = odbc_result($a, 'cant');
    }

    echo $respuesta;
}
?>
