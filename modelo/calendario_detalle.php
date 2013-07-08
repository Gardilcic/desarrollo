<?php

require_once('../libs/php/sql_sigp.php');
require_once('../libs/php/generales.php');
// isset($_POST['funcion']) && 
if ($_POST['funcion'] == "ListarDetalleCalendario") {

    $var1 = "SELECT CONVERT(VARCHAR(10), d.fecha, 103) AS fecha, DATEPART(DW, d.fecha)
            FROM dbo.calendario n 
                    JOIN dbo.detalle_calendario d ON n.id = d.id_calendario
                    JOIN dbo.estados e ON e.id = n.id_estados WHERE n.id='$_POST[idcalendario]'";

    $a = get_datos_sigp($var1);

    while (odbc_fetch_row($a)) {
        for ($contador = 1; $contador <= odbc_num_fields($a); $contador++) {
            $nombre = odbc_field_name($a, $contador);
            
            
            if($contador==2){
                //$tmp = explode("/", odbc_result($a, $contador));
                //$fechatmp = strtotime($tmp[2]."-".$tmp[1]."-".$tmp[0]);
                //$fecha = date("N",$fechatmp);
                $proyectos[$contador-1] = numero_dia(odbc_result($a, $contador));//odbc_result($a, $contador);
            }
            else
                $proyectos[$contador-1] = odbc_result($a, $contador);
        }
        $objeto[] = $proyectos;
    }
    echo json_encode($objeto);
}

if ($_POST['funcion'] == "ListarDetalleCalendarios") {

    $var1 = "SELECT d.id, d.fecha, 
		n.id as id_calendario,n.descripcion,e.id as id_estado, 
		e.nombre as estado_nombre 
            FROM dbo.calendario n 
                    JOIN dbo.detalle_calendario d ON n.id = d.id_calendario
                    JOIN dbo.estados e ON e.id = n.id_estados";

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

if ($_POST['funcion'] == "NuevoDetalleCalendario") {
    //echo "ListarUsuarios";
    $detalles = $_POST["detalle"];
    foreach ($detalles as $key => $value) {
        $cns = "INSERT INTO [dbo].[detalle_calendario] ([fecha] ,[id_calendario]) VALUES ('$value[fecha]','$_POST[idcalendario]')";
        $a = get_datos($cns);
        $cns = "SELECT @@IDENTITY AS ID";
        $b = get_datos($cns);
    }
/*
    $cns = "SELECT @@IDENTITY AS ID";
    $b = get_datos($cns);
*/
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
if ($_POST['funcion'] == "GenerarRangos") {
    
    $inicio = explode("/", $_POST['fechainicial']);
    $fin = explode("/", $_POST['fechafinal']);
    $rango = $_POST['rango'];            
    
    $inicio = strtotime($inicio[2]."-".$inicio[1]."-".$inicio[0]);
    $fin = strtotime($fin[2]."-".$fin[1]."-".$fin[0]);
    
    $array_i = getdate($inicio);
    $array_f = getdate($fin);
    
    for($tmp=$inicio; $tmp<=$fin; $tmp=strtotime('+'.$rango.' days', $tmp)){
        $fecha = array();
        $fecha[] = date("d/m/Y",$tmp);
        //$fecha["dia"]=date("N",$tmp);
        $fecha[] = numero_dia(date("N",$tmp));
        $fechas[] = $fecha;
    } 
    
    echo json_encode($fechas);
}
if ($_POST['funcion'] == "GenerarRangosMensuales") {
    
    $inicio = explode("/", $_POST['fechainicial']);
    $fin = explode("/", $_POST['fechafinal']);
    $rango = $_POST['rango'];            
    
    $mensuales = strtotime($inicio[2]."-".$inicio[1]."-".$rango);
    $inicio = strtotime($inicio[2]."-".$inicio[1]."-".$inicio[0]);
    $fin = strtotime($fin[2]."-".$fin[1]."-".$fin[0]);

    
    for($tmp=$mensuales; $tmp<=$fin; $tmp=strtotime('+1 month', $tmp)){
        if($mensuales >= $inicio && $mensuales <= $fin){            
            $fecha = array();
            $fecha[] = date("d/m/Y",$tmp);
            //$fecha["dia"]=date("N",$tmp);
            $fecha[] = numero_dia(date("N",$tmp));
            $fechas[] = $fecha;
        }
    } 
    
    echo json_encode($fechas);
}
?>
