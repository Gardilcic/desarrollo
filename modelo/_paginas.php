<?php
session_start();
require_once('../libs/php/sql_sigp.php');
require_once('../libs/php/generales.php');
require_once('../libs/php/funciones_regiones.php');

// isset($_POST['funcion']) && 
if ($_POST['funcion'] == "listar_paginas") {
    //echo "ListarUsuarios";

    $cns = "select id, nombre, url, nombre_estados, nombre_modulos, objetivo, detalle, documento from dbo.vista_usuarios_permisos order by nombre, nombre_modulos ASC";
    $a = get_datos($cns);
    $contador = 0;
    $objeto = "[";
    while (odbc_fetch_row($a)) {
        $objeto .= "{";
        $objeto .= "'id':'" . odbc_result($a, "id") . "',";
        $objeto .= "'nombre':'" . str_replace("'", "", encoder(odbc_result($a, "nombre"))) . "',";
        $objeto .= "'url':'" . encoder(odbc_result($a, "url")) . "',";
        $objeto .= "'estado':'" . encoder(odbc_result($a, "nombre_estados")) . "',";
        $objeto .= "'modulo':'" . encoder(odbc_result($a, "nombre_modulos")) . "',";
        $objeto .= "'objetivo':'" . encoder(odbc_result($a, "objetivo")) . "',";
        $objeto .= "'detalle':'" . encoder(odbc_result($a, "detalle")) . "',";
        $objeto .= "'documento':'" . encoder(odbc_result($a, "documento")) . "'";
        $objeto .= "},";
        $contador = 1;
    }
    if ($contador >= 1) {
        $objeto = substr($objeto, 0, -1);
    }
    $objeto .= "]";

    echo $objeto;
}
if ($_POST['funcion'] == "listar_permisos_por_modulo") {
    //echo "ListarUsuarios";

    $cns = "SELECT * FROM dbo.fnGetPermisosPorUsuario (
                   '$_POST[idUsuario]'
                   ,$_POST[idModulo]) ORDER BY permisos_nombre ASC";

    $a = get_datos($cns);
    $contador = 0;
    $objeto = "[";
    while (odbc_fetch_row($a)) {
        $objeto .= "{";
        $objeto .= "'id':'" . odbc_result($a, "id_permisos") . "',";
        $objeto .= "'nombre':'" . str_replace("'", "", encoder(odbc_result($a, "permisos_nombre"))) . "',";
        $objeto .= "'seleccionar':'" . str_replace("'", "", encoder(odbc_result($a, "seleccionar"))) . "',";
        $objeto .= "'usuario':'" . str_replace("'", "", encoder(odbc_result($a, "usuario"))) . "'";
        $objeto .= "},";
        $contador = 1;
    }
    if ($contador >= 1) {
        $objeto = substr($objeto, 0, -1);
    }
    $objeto .= "]";

    echo $objeto;
}

if ($_POST['funcion'] == "nuevo_permiso")
{
    $archivo = str_replace("../../","",$_SESSION['archivo_cargado']);
    $cns = "EXEC [dbo].[crea_permisos_usuarios] @nombre = N'" . decoder($_POST['nombre']) . "', @url=N'" . decoder($_POST['url']) . "', @modulo=" . decoder($_POST['modulo']) . ", @estado = " . $_POST['estado'].", @objetivo=N'".decoder($_POST['objetivo'])."',@detalle=N'".decoder($_POST['detalle'])."', @archivo=N'".$archivo."'";

    $a = get_datos($cns);

    /* $cns = "SELECT @@IDENTITY AS ID";

      $b = get_datos($cns); */

    while (odbc_fetch_row($a)) {
        $respuesta = odbc_result($a, "respuesta");
    }

    echo $respuesta;
    //echo $cns;
}

if ($_POST['funcion'] == "updt_pagina") {
    //echo "ListarUsuarios";
	$archivo = str_replace("../../","",$_SESSION['archivo_cargado']);
    $cns = "EXEC [dbo].[actualiza_permisos_usuarios] @nombre = N'" . decoder($_POST['nombre']) . "', @url=N'" . decoder($_POST['url']) . "', @modulo=" . decoder($_POST['modulo']) . ", @estado = " . $_POST['estado'] . ", @id = " . $_POST['id'].", @objetivo=N'".decoder($_POST['objetivo'])."',@detalle=N'".decoder($_POST['detalle'])."', @archivo=N'".$archivo."'";

    $a = get_datos($cns);
    while (odbc_fetch_row($a)) {
        $respuesta = odbc_result($a, 'respuesta');
    }
    echo $respuesta;
}

if ($_POST['funcion'] == "listar_estados") {
    //echo "ListarUsuarios";

    $cns = "select id, nombre from estados where id_tipo = 1 order by nombre ASC";

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

if ($_POST['funcion'] == "listar_modulos") {
    //echo "ListarUsuarios";

    $cns = "select id, nombre from dbo.vista_usuarios_modulos order by nombre ASC";

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

if ($_POST['funcion'] == "borrar_permisos_por_modulo") {
    //echo "ListarUsuarios";

    $cns = "DELETE sigp_usuarios_qa.dbo.usuarios_permisos
                FROM sigp_usuarios_qa.dbo.usuarios_permisos p 
                    INNER JOIN sigp_qa.dbo.vista_permisos_usuariospermisos up ON up.id_permisos = p.id_permisos 
            WHERE up.id_modulos = $_POST[idModulo] AND p.usuario = '$_POST[idUsuario]'";

    $a = get_datos($cns);
    
    echo $cns;
}
if ($_POST['funcion'] == "nuevo_permisos_por_modulo") {
    //echo "ListarUsuarios";

    $cns = "EXEC dbo.asignar_permisos_usuario @usuario = N'$_POST[idUsuario]' , @idpermiso = '$_POST[idPermiso]' ";

    $a = get_datos($cns);

    while (odbc_fetch_row($a)) {
        $respuesta = odbc_result($a, "respuesta");
    }

    echo $respuesta;
}
if ($_POST['funcion'] == "grabar_acceso_directo") {
    
    $cns = "EXEC crea_acceso_directo @idusuario = $_POST[idusuario], @idpermiso = $_POST[idpermiso] , @orden = $_POST[orden] ";
     
    $a = get_datos($cns);

    while (odbc_fetch_row($a)) {
        $respuesta+= odbc_result($a, 'respuesta');
    }

    echo $respuesta;
    
}
if ($_POST['funcion'] == "obtener_permisos_por_orden") {
    //echo "ListarUsuarios";

    $cns = "SELECT id_permisos, permisos_nombre, orden_link, color, icono, permisos_url FROM [dbo].[fnGetPermisosPorOrden] ('$_POST[idusuario]') WHERE orden > 0 ORDER BY orden ASC";

    $a = get_datos($cns);

    $objeto = "[";
    $entro = false;
    while (odbc_fetch_row($a)) {
        $objeto .= "{";
        $objeto .= "'idpermiso':'" . odbc_result($a, "id_permisos") . "',";
        $objeto .= "'nombrepermiso':'" . encoder(odbc_result($a, "permisos_nombre")) . "',";
        $objeto .= "'ordenpermiso':'" . encoder(odbc_result($a, "orden_link")) . "',";
        $objeto .= "'color':'" . encoder(odbc_result($a, "color")) . "',";
        $objeto .= "'icono':'" . encoder(odbc_result($a, "icono")) . "',";
        $objeto .= "'url':'" . encoder(odbc_result($a, "permisos_url")) . "'";
        $objeto .= "},";
        $entro = true;
    }
    if ($entro)
        $objeto = substr($objeto, 0, -1);
    $objeto .= "]";

    echo $objeto;
}

if ($_POST['funcion'] == "valida_dependencia") {
    $respuesta = 0;
    $cns0 = "EXEC valida_dependencia_paginas @id_pagina =" . $_POST['pagina'];

    $a = get_datos($cns0);

    while (odbc_fetch_row($a)) {
        $respuesta+= odbc_result($a, 'cant');
    }

    echo $respuesta;
}

if ($_POST['funcion'] == "borra_pagina") {
    $respuesta = 0;

    $cns0 = "EXEC borra_pagina @id_pagina =" . $_POST['pagina'];

    $a = get_datos($cns0);

    $cns0 = "EXEC valida_dependencia_paginas @id_pagina =" . $_POST['pagina'];
    $a = get_datos($cns0);

    while (odbc_fetch_row($a)) {
        $respuesta = odbc_result($a, 'cant');
    }

    echo $respuesta;
}

if($_POST['funcion']=="get_objetivos")
{
	$respuesta = "No hay objetivos especificados.";
	
	$cns0 = "select objetivo from vista_tbl_permisos where url = '".$_POST['url']."'";
	
	$a = get_datos($cns0);
	
	while(odbc_fetch_row($a))
	{
		$respuesta= encoder(odbc_result($a,'objetivo'));
	}
	
	echo $respuesta;
}

if($_POST['funcion']=="get_detalle")
{
	$respuesta = "No hay objetivos especificados.";
	
	$cns0 = "select detalle from vista_tbl_permisos where url = '".$_POST['url']."'";
	
	$a = get_datos($cns0);
	
	while(odbc_fetch_row($a))
	{
		$respuesta= encoder(odbc_result($a,'detalle'));
	}
	
	echo $respuesta;
}

if($_POST['funcion']=="get_doc")
{
	$respuesta = "#";
	
	$cns0 = "select documento from vista_tbl_permisos where url = '".$_POST['url']."'";
	
	$a = get_datos($cns0);
	
	while(odbc_fetch_row($a))
	{
		$respuesta= encoder(odbc_result($a,'documento'));
	}
	
	echo $respuesta;
}

?>