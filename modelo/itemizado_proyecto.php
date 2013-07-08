<?php

session_start();
require_once('../libs/php/sql_sigp.php');
// isset($_POST['funcion']) && 
if ($_POST['funcion'] == "ListarItemizadoProyectoFiltro") {
    //echo "ListarUsuarios";
    $var1 = "SELECT REPLACE(codigo,'.','') as orden,* FROM dbo.vista_itemizado_proyecto 
        WHERE id_subproyecto = ($_POST[idsubproyecto]) 
        ORDER BY orden ASC";

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
if ($_POST['funcion'] == "ListarItemizadoProyecto") {
    //echo "ListarUsuarios";
    $var1 = "SELECT REPLACE(codigo,'.','') as orden,* FROM dbo.vista_itemizado_proyecto 
        ORDER BY orden ASC";

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
if ($_POST['funcion'] == "ListarItemizadoProyectoRelacionado") {
    //echo "ListarUsuarios";
    $var1 = "SELECT REPLACE(codigo,'.','') as orden,* FROM dbo.vista_itemizado_proyecto WHERE id_itemizado_pmo = $_POST[iditemizadopmo] AND id_subproyecto = $_POST[idsubproyecto]  ORDER BY orden ASC";

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
if ($_POST['funcion'] == "ListarItemizadoProyectoNoRelacionado") {
    //echo "ListarUsuarios";
    //OR id_itemizado_pmo <> ($_POST[iditemizadopmo])
    $var1 = "SELECT REPLACE(codigo,'.','') as orden,* FROM dbo.vista_itemizado_proyecto WHERE ( id_itemizado_pmo is null OR id_itemizado_pmo <> ($_POST[iditemizadopmo]) ) AND id_subproyecto = $_POST[idsubproyecto] ORDER BY orden ASC";

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
if ($_POST['funcion'] == "RelacionarItemizado") {
    //echo "ListarUsuarios";
    $var1 = "UPDATE dbo.itemizado_subproyecto SET id_itemizado_pmo = $_POST[iditemizadopmo] WHERE id = $_POST[iditemizadoproyecto]";

    $a = get_datos($var1);
}
if ($_POST['funcion'] == "EliminarRelacionItemizado") {
    //echo "ListarUsuarios";
    $var1 = "UPDATE dbo.itemizado_subproyecto SET id_itemizado_pmo = null WHERE id_itemizado_pmo = $_POST[iditemizadopmo] AND id = $_POST[iditemizadoproyecto]";

    $a = get_datos($var1);
}

if ($_POST['funcion'] == "GrabarNuevo") {
    $cns = "insert into itemizado_subproyecto (codigo, id_padre, descripcion, id_estados, id_usuario, fecha_ingreso,factor_equivalencia, precio_unitario, id_unidades_registro, id_itemizado_pmo)";
    $cns.="values(";
    $cns.="'" . $_POST['codigo'] . "',";
    $cns.="" . $_POST['idpadre'] . ",";
    $cns.="'" . $_POST['descripcion'] . "',";
    $cns.="" . $_POST['idestado'] . ",";
    $cns.="'" . $_SESSION['usuario']['usuario'] . "', ";
    $cns.="'" . date('Y-m-d') . "',";
    $cns.="" . $_POST['factor'] . ",";
    $cns.="" . $_POST['precio'] . ",";
    $cns.="" . $_POST['idunidad'] . ",";
    $cns.="" . $_POST['itemizado_pmo'] . "";
    $cns.=")";
//echo $cns;    
    get_datos($cns);
    $cns = "select count(id) as id from itemizado_subproyecto where codigo=" . $_POST['codigo'] . " AND id_padre=" . $_POST['idpadre'];
    $a = get_datos($cns);
    $resultado = 0;
    while (odbc_fetch_row($a)) {
        $resultado = odbc_result($a, "id");
    }
    echo $resultado;
}

if ($_POST['funcion'] == "actualiza_itemizado") {
    $cns = "update itemizado_subproyecto set ";
    $cns.="descripcion='" . $_POST['descripcion'] . "',";
    $cns.="id_estados=" . $_POST['estado'] . ",";
    $cns.="factor_equivalencia=" . $_POST['factor'] . ",";
    $cns.="precio_unitario=" . $_POST['precio'] . ",";
    $cns.="id_unidades_registro=" . $_POST['unidad'] . ",";
    $cns.="id_itemizado_pmo=" . $_POST['itm_pmo'] . ", ";
    $cns.="fecha_ingreso='" . date('Y-m-d') . "',";
    $cns.="id_usuario='" . $_SESSION['usuario']['usuario'] . "'";
    $cns.=" where id =" . $_POST['id'];
//echo $cns;    
    get_datos($cns);
    /* $cns="select count(id) as id from itemizado_subproyecto where codigo=".$_POST['codigo']." AND id_padre=".$_POST['idpadre'];
      $a=get_datos($cns);
      $resultado=0;
      while(odbc_fetch_row($a))
      {
      $resultado=odbc_result($a,"id");
      }
      echo $resultado; */
}
?>
