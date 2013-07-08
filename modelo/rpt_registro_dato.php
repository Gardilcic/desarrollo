<?php
session_start();

require_once('../libs/php/sql_sigp.php');
require_once('../libs/php/generales.php');
// isset($_POST['funcion']) && 

if ($_POST['funcion'] == "NumeroRegistros") {
    $fecha1 = explode("/", $_POST[fechainicial]);
    $fecha2 = explode("/", $_POST[fechafinal]);
    $var1 = "SELECT COUNT(*) AS respuesta
            FROM dbo.psdi p 
                    JOIN dbo.psdi_usuarios usu ON usu.id_psdi = p.id 
                    JOIN dbo.indicador_dato dato ON dato.id = p.id_indicador_dato
                    LEFT JOIN dbo.registro_dato r ON r.id_psdi = p.id
            WHERE usu.usuario = '".$_SESSION['usuario']['usuario']."'"; 

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


if ($_POST['funcion'] == "ListarDatos") {
    $fecha1 = explode("/", $_POST["fechainicial"]);
    $fecha2 = explode("/", $_POST["fechafinal"]);
    
    $var1 = "SELECT fechas, id_registro, id_psdi, fecha_ingreso, valor_real, color FROM [dbo].[fnGetRegistroDatosReporte] ($_POST[idpsdi],'".
                $_SESSION['usuario']['usuario']."','".
                $fecha1[2]."-".$fecha1[1]."-".$fecha1[0]."','".
                $fecha2[2]."-".$fecha2[1]."-".$fecha2[0]."')
            ORDER BY dfecha ASC OPTION (MAXRECURSION 365)";

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

if ($_POST['funcion'] == "ListarTitulos") {
    
    // VERIFICO SI TIENE DE NIVEL 2, Y OBTENGO TODOS SUS DATOS NIVEL 1        
    $var1 = "SELECT p.id as id_psdi, p.id_indicador_dato, p.nombre_corto as dato_descripcion, dato.formula,                        
                    ni.id as nivel_id, ni.descripcion as nivel_descripcion
            FROM dbo.psdi p 
                    JOIN dbo.indicador_dato dato ON dato.id = p.id_indicador_dato 
                    JOIN dbo.psdi_usuarios usu ON usu.id_psdi = p.id 
                    JOIN dbo.nivel ni ON ni.id = dato.id_Nivel 
            WHERE usu.usuario = '".$_SESSION['usuario']['usuario']."' AND ni.descripcion = 'Nivel 2'";
    
    $a = get_datos_sigp($var1);
    $ids = [];
    $flag = 0;     
    while (odbc_fetch_row($a)) {        
        $formula = odbc_result($a, "formula");
        $tmp = "";
        for($i=0;$i<strlen($formula);$i++){
            
            if($formula[$i]=="}"){
                $flag = 0;
                // CARGO UN ARREGLO CON LOS ID DE NIVEL 1 QUE FORMAN LOS INDICADORES DE NIVEL 2
                if (!in_array($tmp, $ids)) {
                    $ids[] = $tmp;                     
                }
                $tmp = "";
            }
            if($flag == 1){
                $tmp .= $formula[$i];
            }
            if($formula[$i]=="{"){
                $flag = 1;        
            }
        }
    }
        
    if(count($ids)==0) $ids = '';
    else $ids = implode(",",$ids);
    
    //echo $ids ;
    
    $var1 = "(SELECT p.id as id_psdi, p.id_indicador_dato, p.nombre_corto as dato_descripcion, dato.formula,
                        ni.id as nivel_id, ni.descripcion as nivel_descripcion 
                FROM dbo.psdi p 
                        JOIN dbo.indicador_dato dato ON dato.id = p.id_indicador_dato 
                        JOIN dbo.psdi_usuarios usu ON usu.id_psdi = p.id 
                        JOIN dbo.subproyectos sp ON sp.id = p.id_subproyecto 
                        JOIN dbo.proyectos pr ON pr.id = p.id_proyecto 
                        JOIN dbo.nivel ni ON ni.id = dato.id_Nivel 
                WHERE usu.usuario = '".$_SESSION['usuario']['usuario']."' 
            )
            UNION  
            (SELECT p.id as id_psdi, p.id_indicador_dato, p.nombre_corto as dato_descripcion, dato.formula,                        
                                ni.id as nivel_id, ni.descripcion as nivel_descripcion
                FROM dbo.psdi p 
                        JOIN dbo.indicador_dato dato ON dato.id = p.id_indicador_dato 
                        JOIN dbo.nivel ni ON ni.id = dato.id_Nivel 
                WHERE p.id_indicador_dato IN ($ids) 
            ) ORDER BY nivel_descripcion, dato_descripcion";
    
    /*$var1 = "SELECT p.id as id_psdi, p.id_indicador_dato, p.nombre_corto as dato_descripcion,
                        ic.id as indicador_id,
                        ni.id as nivel_id, ni.descripcion as nivel_descripcion, ic.formula
        FROM dbo.psdi p 
                JOIN dbo.indicador_dato dato ON dato.id = p.id_indicador_dato 
                JOIN dbo.psdi_usuarios usu ON usu.id_psdi = p.id 
                JOIN dbo.subproyectos sp ON sp.id = p.id_subproyecto 
                JOIN dbo.proyectos pr ON pr.id = p.id_proyecto 
                JOIN dbo.indicador_dato ic ON ic.id = p.id_indicador_dato 
                JOIN dbo.nivel ni ON ni.id = ic.id_Nivel 
        WHERE usu.usuario = '".$_SESSION['usuario']['usuario']."' 
        ORDER BY ni.descripcion,dato.descripcion ASC";*/

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
//ActualizarDetalleDatoIndicador
if ($_POST['funcion'] == "NuevoDetalleDatoIndicador") {

    if($_POST["id"]==null)
        $tmp = explode("/",$_POST[fecha]);
            $cns = "INSERT INTO [dbo].[registro_dato]
                    (
                    [id_psdi]
                    ,[fecha_ingreso]
                    ,[fecha_actualizacion]
                    ,[valor_real]
                    ,[valor_esperado]
                    ,[diferencia]
                    ,[porcentaje_cumplimiento]
                    ,[tolerancia1]
                    ,[tolerancia2]
                    ,[tipo])
              VALUES (
               '$_POST[idpsdi]'
               ,'".$tmp[2]."-".$tmp[1]."-".$tmp[0]."'
               ,getdate()
               ,$_POST[valor]
               ,$_POST[valor]
               ,0
               ,100
               ,0
               ,0
               ,1)";
            //echo $cns;
            //echo $cns."<br>";
            $a = get_datos($cns);
            $cns = "SELECT @@IDENTITY AS ID";
            $b = get_datos($cns);
    //    }
    //}
/*
    $cns = "SELECT @@IDENTITY AS ID";
    $b = get_datos($cns);
*/
    while (odbc_fetch_row($b)) {
        $ultimo_id = odbc_result($b, "ID");
    }

    echo $ultimo_id;
}
if ($_POST['funcion'] == "NuevoDetalleDato") {
    //echo "ListarUsuarios";
    $detalles = $_POST["detalle"];    
    foreach($detalles as $keyglobal => $valueglobal) {
        foreach ($valueglobal as $key => $value) {
            
            if(strlen($value["dato_".$keyglobal])<=0) $dato = "NULL"; else $dato = $value["dato_".$keyglobal];
            //echo "ss".$dato;
            $cns = "INSERT INTO [dbo].[registro_dato]
                    (
                    [id_psdi]
                    ,[fecha_ingreso]
                    ,[fecha_actualizacion]
                    ,[valor_real]
                    ,[valor_esperado]
                    ,[diferencia]
                    ,[porcentaje_cumplimiento]
                    ,[tolerancia1]
                    ,[tolerancia2]
                    ,[tipo])
              VALUES (
               '".$value["id_dato_".$keyglobal]."'
               ,'$value[fecha]'
               ,'$value[fecha]'
               ,".$dato."
               ,".$dato."
               ,0
               ,100
               ,0
               ,0
               ,1)";
            //echo $cns."<br>";
            $a = get_datos($cns);
            $cns = "SELECT @@IDENTITY AS ID";
            $b = get_datos($cns);
        }
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

if ($_POST['funcion'] == "ActualizarDetalleDatoIndicador") {
    $cns = "UPDATE dbo.registro_dato SET                 
                [fecha_actualizacion] = getdate()
                ,[valor_real] = $_POST[valor]
                ,[valor_esperado] = $_POST[valor]
                ,[diferencia] = 0 
            WHERE id = $_POST[id]";

    $a = get_datos($cns);
    
    $cns = "SELECT @@ROWCOUNT AS ID";
    $b = get_datos($cns);
    
    while (odbc_fetch_row($b)) {
        $ultimo_id = odbc_result($b, "ID");
    }

    echo $ultimo_id;
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
    
    $inicio = strtotime($inicio[2]."-".$inicio[1]."-".$inicio[0]);
    $fin = strtotime($fin[2]."-".$fin[1]."-".$fin[0]);
    
    $array_i = getdate($inicio);
    $array_f = getdate($fin);
    
    for($tmp=$inicio; $tmp<=$fin; $tmp=strtotime('+1 days', $tmp)){
        $fecha = array();
        $fecha[] = date("d/m/Y",$tmp);
        /*for($x = 0; $x < ($_POST['columnas']-1); $x++){
            $fecha[] = "";            
        } */       
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
