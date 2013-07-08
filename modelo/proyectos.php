<?php

session_start();
require_once('../libs/php/sql_sigp.php');
// isset($_POST['funcion']) && 
if ($_POST['funcion'] == "ListarProyectos") {
    //echo "ListarUsuarios";

    $cns = "SELECT id , ";
    $cns .= "       nombre , ";
    $cns .= "       numero_contrato , ";
    $cns .= "       archivo_contrato , ";
    $cns .= "       firmante1 , ";
    $cns .= "       firmante2 , ";
    $cns .= "       fecha_inicio , ";
    $cns .= "       fecha_fin , ";
    $cns .= "       monto , ";
    $cns .= "       id_moneda , ";
    $cns .= "       id_empresa as id_empresa_holding , ";
    $cns .= "       id_mandante , ";
    $cns .= "       id_estados  ";
    $cns .= "FROM dbo.proyectos";

    $a = get_datos_sigp($cns);

    $objeto = "[";
    $con_datos = 0;
    while (odbc_fetch_row($a)) {
        $objeto .= "{";
        $objeto .= "'id':'" . odbc_result($a, "id") . "',";
        $objeto .= "'nombre':'" . odbc_result($a, "nombre") . "',";
        $objeto .= "'numero_contrato':'" . odbc_result($a, "numero_contrato") . "',";
        $objeto .= "'archivo_contrato':'" . odbc_result($a, "archivo_contrato") . "',";
        $objeto .= "'firmante1':'" . odbc_result($a, "firmante1") . "',";
        $objeto .= "'firmante2':'" . odbc_result($a, "firmante2") . "',";
        $objeto .= "'fecha_inicio':'" . odbc_result($a, "fecha_inicio") . "',";
        $objeto .= "'fecha_fin':'" . odbc_result($a, "fecha_fin") . "',";
        $objeto .= "'monto':'" . number_format(odbc_result($a, "monto")) . "',";
        $objeto .= "'id_moneda':'" . odbc_result($a, "id_moneda") . "',";
        $objeto .= "'id_empresa_holding':'" . odbc_result($a, "id_empresa_holding") . "',";
        $objeto .= "'id_mandante':'" . odbc_result($a, "id_mandante") . "',";
        $objeto .= "'id_estados':'" . odbc_result($a, "id_estados") . "',";

        $objeto .= "},";

        $con_datos = 1;
    }
    if ($con_datos == 1)
        $objeto = substr($objeto, 0, -1);
    $objeto .= "]";

    echo $objeto;
}

if ($_POST['funcion'] == "ListarProyectosCompleto") {

    $var1 = "SELECT id_proyecto, ";
    $var1 .= "       nombre_proyecto, ";
    $var1 .= "       firmante1, ";
    $var1 .= "       archivo_contrato, ";
    $var1 .= "       numero_contrato, ";
    $var1 .= "       firmante2, ";
    $var1 .= "       id_estados_proyecto, ";
    $var1 .= "       id_mandante, ";
    $var1 .= "       id_empresa as id_empresa_holding, ";
    $var1 .= "       id_moneda, ";
    $var1 .= "       monto, ";
    $var1 .= "       fecha_fin, ";
    $var1 .= "       fecha_inicio, ";
    $var1 .= "       empresa_nombre, ";
    $var1 .= "       empresa_rut, ";
    $var1 .= "       empresa_direccion, ";
    $var1 .= "       empresa_giro, ";
    $var1 .= "       representante_legal, ";
    $var1 .= "       mandante_rut, ";
    $var1 .= "       mandante_nombre, ";
    $var1 .= "       mandante_direccion, ";
    $var1 .= "       mandante_giro, ";
    $var1 .= "       mandante_vigencia, ";
    $var1 .= "       moneda_nombre, ";
    $var1 .= "       moneda_simbolo, ";
    $var1 .= "       estado_nombre ";
    $var1 .= "FROM   dbo.vista_proyectos ";

    $a = get_datos_sigp($var1);
	//echo($var1);
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

if ($_POST['funcion'] == "GrabarNuevo") {

    $nombre_archivo = $_SESSION["Imagenes"];

    $var1 = "INSERT INTO dbo.proyectos ";
    $var1 .= "            (nombre, ";
    $var1 .= "             numero_contrato, ";
    $var1 .= "             archivo_contrato, ";
    $var1 .= "             firmante1, ";
    $var1 .= "             firmante2, ";
    $var1 .= "             fecha_inicio, ";
    $var1 .= "             fecha_fin, ";
    $var1 .= "             monto, ";
    $var1 .= "             id_moneda, ";
    $var1 .= "             id_empresa, ";
    $var1 .= "             id_mandante, ";
    $var1 .= "             id_estados) ";
    $var1 .= "VALUES      ('".$_POST[nombre]."', ";
    $var1 .= "             '".$_POST[numero]."', ";
    $var1 .= "             '".$nombre_archivo."', ";
    $var1 .= "             '".$_POST[firmante1]."', ";
    $var1 .= "             '".$_POST[firmante2]."', ";
    $var1 .= "             '".$_POST[fechainicio]."', ";
    $var1 .= "             '".$_POST[fechafinal]."', ";
    $var1 .= $_POST[monto].", ";
    $var1 .= $_POST[idmoneda].", ";
    $var1 .= $_POST[idempresa].", ";
    $var1 .= $_POST[idmandante].", ";
    $var1 .= $_POST[idestado]." ) ";

    $a = get_datos_sigp($var1);

    $cns = "SELECT @@IDENTITY AS ID";

    $b = get_datos_sigp($cns);

    while (odbc_fetch_row($b)) {
        $ultimo_id = odbc_result($b, "ID");
    }

    echo $ultimo_id;
}

if ($_POST['funcion'] == "GrabarProyecto") {

    $nombre_archivo = $_SESSION["Imagenes"];

    $var1 = "UPDATE dbo.proyectos SET  ";
    $var1 .= "             nombre = '" . $_POST['nombre'] . "',";
    $var1 .= "             numero_contrato = '" . $_POST['numero'] . "',";
    $var1 .= "             archivo_contrato = '" . $nombre_archivo . "',";
    $var1 .= "             firmante1 = '" . $_POST['firmante1'] . "',";
    $var1 .= "             firmante2 = '" . $_POST['firmante2'] . "',";
    $var1 .= "             fecha_inicio = '" . $_POST['fechainicio'] . "',";
    $var1 .= "             fecha_fin = '" . $_POST['fechafinal'] . "',";
    $var1 .= "             monto = " . $_POST['monto'] . ",";
    $var1 .= "             id_moneda = " . $_POST['idmoneda'] . ",";
    $var1 .= "             id_empresa = " . $_POST['idempresa'] . ",";
    $var1 .= "             id_mandante = " . $_POST['idmandante'] . ",";
    $var1 .= "             id_estados = " . $_POST['idestado'];
    $var1 .= " WHERE id = " . $_POST['id'];

    $a = get_datos_sigp($var1);
    //$a = 1;
    if ($a === true)
        $respuesta = -1;
    else
        $respuesta = 1;

    echo $respuesta;
}

if($_POST['funcion']=="valida_dependencia")
{
	$respuesta = 0;
	$cns0 = "select count(id) as cant from subproyectos where id_proyectos =".$_POST['proyecto'];

	$a = get_datos($cns0);
			
	while(odbc_fetch_row($a))
	{
		$respuesta+= odbc_result($a,'cant');
	}
	
	echo $respuesta;
}

if($_POST['funcion']=="borra_proyecto")
{
	$respuesta = 0;
	
	$cns0 = "delete from proyectos where id=".$_POST['proyecto'];
	
	$a = get_datos($cns0);
	
	$cns0 = "select COUNT(id) as cant from proyectos where id=".$_POST['proyecto'];
	$a = get_datos($cns0);
	
	while(odbc_fetch_row($a))
	{
		$respuesta= odbc_result($a,'cant');
	}
	
	echo $respuesta;
}

?>