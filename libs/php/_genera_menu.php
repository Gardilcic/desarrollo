<?php
session_start();
require_once('sql_sigp.php');
require_once('generales.php');

$usuario = $_SESSION['usuario']['usuario'];

function get_menu($modulo) {
    $cns = "select nombre,url from dbo.vista_paginas_usuario where usuario = '" . $_SESSION['usuario']['usuario'] . "' and id_estados=1 AND id_modulo =" . $modulo;
    $a = get_datos($cns);
    //alert($cns);
    $objeto = "";
    while (odbc_fetch_row($a)) {
        $objeto .= "<li><a href='" . odbc_result($a, "url") . "'>" . encoder(odbc_result($a, "nombre")) . "</a></li>";
    }
    echo $objeto;
    //return $objeto;
}

if ($_POST['funcion'] == "generar_menu") {
    get_menu($_POST['idmodulo']);
}
?>