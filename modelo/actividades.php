<?php

session_start();
require_once('../libs/php/sql_sigp.php');
// isset($_POST['funcion']) && 
if ($_POST['funcion'] == "GrabarActividades") {
    //echo "ListarUsuarios";
    $resultado = [];
    foreach ($_POST['actividades'] as $key => $value) {
        if($value["accion"]=="crear") { 
            $var1 = "";
            $var1 .= "EXECUTE crea_actividad ";
            $var1 .= "  @nombre = '$value[nombre]', ";
            $var1 .= "  @referencia = '$value[referencia]', ";
            $var1 .= "  @alcance = '$value[alcance]', ";
            $var1 .= "  @responsable = '$value[responsable]', ";
            $var1 .= "  @unidad_registro = '$value[unidadregistro]', ";
            $var1 .= "  @unidad_control = '$value[unidadcontrol]', ";
            $var1 .= "  @usuario = '" . $_SESSION['usuario']['usuario'] . "', ";
            $var1 .= "  @subclasificacion = $value[subclasificacion], ";
            $var1 .= "  @subproyecto = '$value[subproyecto]',";
            $var1 .= "  @itemizado = $value[itemizado]";

            //$_SESSION["usuario"]['usuario']

            $a = get_datos($var1);

            while (odbc_fetch_row($a)) {
                $respuesta = odbc_result($a, "respuesta");
            }

            $resultado[] = $respuesta;
        }else if($value["accion"]=="actualizar") { 
            $var1 = "";
            $var1 .= "EXECUTE [actualiza_actividad] ";
            $var1 .= "  @id = '$value[id]', ";
            $var1 .= "  @nombre = '$value[nombre]', ";
            $var1 .= "  @referencia = '$value[referencia]', ";
            $var1 .= "  @alcance = '$value[alcance]', ";
            $var1 .= "  @responsable = '$value[responsable]', ";
            $var1 .= "  @unidad_registro = '$value[unidadregistro]', ";
            $var1 .= "  @unidad_control = '$value[unidadcontrol]', ";
            $var1 .= "  @subclasificacion = $value[subclasificacion], ";
            $var1 .= "  @itemizado = $value[itemizado]";

            //$_SESSION["usuario"]['usuario']

            $a = get_datos($var1);

            while (odbc_fetch_row($a)) {
                $respuesta = odbc_result($a, "respuesta");
            }

            $resultado[] = $respuesta;
        }
    }

    echo json_encode($resultado);
}
if ($_POST['funcion'] == "ListarActividades") {
    //echo "ListarUsuarios";
    //$resultado = [];
    //foreach ($_POST['actividades'] as $key => $value) {
    $var1 = "SELECT [id]
                    ,[nombre]
                    ,[nombre_referencia]
                    ,[alcance]
                    ,[fecha_registro]
                    ,[id_usuario]
                    ,[responsable]
                    ,[id_subproyecto]
                    ,[unidad_control_id]
                    ,[unidad_control]
                    ,[unidad_control_abbr]
                    ,[unidad_registro_id]
                    ,[unidad_registro]
                    ,[unidad_registro_abbr]
                    ,[id_itemizado_subproyecto]
                    ,[codigo]
                    ,[descripcion]
                    ,[unidad_nombre]
                    ,[abreviacion]
                FROM [dbo].[fnGetActividades] ( $_POST[subproyecto] )";

    //$_SESSION["usuario"]['usuario']

    $a = get_datos_sigp($var1);

    while (odbc_fetch_row($a)) {
        for ($contador = 1; $contador <= odbc_num_fields($a); $contador++) {
            $nombre = odbc_field_name($a, $contador);
            $proyectos[$nombre] = odbc_result($a, $contador);
        }
        $objeto[] = $proyectos;
    }
    echo json_encode($objeto);
    //}
    //echo json_encode($resultado);
}
/* if ($_POST['funcion'] == "ListarSubProyectos") {
  //echo "ListarUsuarios";
  $subproyectos_permitidos = implode( ',',$_SESSION['usuario']['subproyectos']);

  $var1 = "";
  $var1 .= "SELECT id_subproyectos, ";
  $var1 .= "       nombre, ";
  $var1 .= "       fecha_inicio, ";
  $var1 .= "       fecha_termino, ";
  $var1 .= "       monto, ";
  $var1 .= "       id_moneda, ";
  $var1 .= "       moneda_nombre, ";
  $var1 .= "       moneda_simbolo, ";
  $var1 .= "       id_ubicacion, ";
  $var1 .= "       ubicacion_nombre, ";
  $var1 .= "       id_estado, ";
  $var1 .= "       estado_nombre, ";
  $var1 .= "       id_mandante, ";
  $var1 .= "       id_empresas, ";
  $var1 .= "       id_proyectos, ";
  $var1 .= "       proyecto_nombre, ";
  $var1 .= "       empresa_nombre ";
  $var1 .= "FROM   sigp.dbo.vista_subproyectos WHERE id_subproyectos in ( $subproyectos_permitidos ) ";

  $a = get_datos($var1);

  while (odbc_fetch_row($a)) {
  for ($contador = 1; $contador <= odbc_num_fields($a); $contador++) {
  $nombre = odbc_field_name($a, $contador);
  $proyectos[$nombre] = odbc_result($a, $contador);
  }
  $objeto[] = $proyectos;
  }
  echo json_encode($objeto);
  }


  if ($_POST['funcion'] == "ListarSubProyectosPorProyecto") {
  //echo "ListarUsuarios";

  $sql = "SELECT sp.id , ";
  $sql .= "       sp.nombre , ";
  $sql .= "       sp.fecha_inicio , ";
  $sql .= "       sp.fecha_termino , ";
  $sql .= "       sp.monto , ";
  $sql .= "       sp.id_moneda , ";
  $sql .= "       sp.id_proyectos , ";
  $sql .= "       sp.id_ubicacion , ";
  $sql .= "       sp.id_estados , ";
  $sql .= "       sp.id_mandante , ";
  $sql .= "       sp.id_empresas , ";
  $sql .= "       p.nombre  ";
  $sql .= "FROM sigp.dbo.subproyectos sp ";
  $sql .= "INNER JOIN sigp.dbo.proyectos p ON p.id = sp.id_proyectos WHERE p.id = " . $_POST["idproyecto"];

  $a = get_datos($sql);

  $objeto = "[";
  $con_datos = 0;
  while (odbc_fetch_row($a)) {
  $objeto .= "{";
  $objeto .= "'id':'" . odbc_result($a, "id") . "',";
  $objeto .= "'nombre':'" . odbc_result($a, "nombre") . "'";
  $objeto .= "},";

  $con_datos = 1;
  }
  if ($con_datos == 1)
  $objeto = substr($objeto, 0, -1);
  $objeto .= "]";

  echo $objeto;
  }

  if ($_POST['funcion'] == "GrabarNuevo") {

  $var1 = "";
  $var1 .= "INSERT INTO sigp.dbo.subproyectos ";
  $var1 .= "            (nombre, ";
  $var1 .= "             fecha_inicio, ";
  $var1 .= "             fecha_termino, ";
  $var1 .= "             monto, ";
  $var1 .= "             id_moneda, ";
  $var1 .= "             id_proyectos, ";
  $var1 .= "             id_ubicacion, ";
  $var1 .= "             id_estados, ";
  $var1 .= "             id_mandante, ";
  $var1 .= "             id_empresas) ";
  $var1 .= "VALUES      ('$_POST[nombre]', ";
  $var1 .= "             '$_POST[fechainicio]', ";
  $var1 .= "             '$_POST[fechafinal]', ";
  $var1 .= "             $_POST[monto], ";
  $var1 .= "             '$_POST[idmoneda]', ";
  $var1 .= "             '$_POST[idproyecto]', ";
  $var1 .= "             '$_POST[idubicacion]', ";
  $var1 .= "             '$_POST[idestado]', ";
  $var1 .= "             '$_POST[idmandante]', ";
  $var1 .= "             '$_POST[idempresa]' ) " ;

  $a = get_datos($var1);
  $cns = "SELECT @@IDENTITY AS ID";
  $b = get_datos($cns);
  while (odbc_fetch_row($b)) {
  $ultimo_id = odbc_result($b, "ID");
  }
  echo $ultimo_id;
  }

  if ($_POST['funcion'] == "GrabarSubProyecto") {

  $var1 = "UPDATE sigp.dbo.subproyectos SET  ";
  $var1 .= "             nombre = '" . $_POST['nombre'] . "',";
  $var1 .= "             fecha_inicio = '" . $_POST['fechainicio'] . "',";
  $var1 .= "             fecha_termino = '" . $_POST['fechafinal'] . "',";
  $var1 .= "             monto = " . $_POST['monto'] . ",";
  $var1 .= "             id_moneda = '" . $_POST['idmoneda'] . "',";
  $var1 .= "             id_proyectos = '" . $_POST['idproyecto'] . "',";
  $var1 .= "             id_ubicacion = '" . $_POST['idubicacion'] . "',";
  $var1 .= "             id_estados = '" . $_POST['idestado'] . "',";
  $var1 .= "             id_mandante = '" . $_POST['idmandante'] . "',";
  $var1 .= "             id_empresas = '" . $_POST['idempresa'] . "' ";
  $var1 .= " WHERE id = " . $_POST['id'];

  $a = get_datos($var1);
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
  $cns0 = "select count(id) as cant from itemizado_subproyecto where id_subproyectos =".$_POST['subproyecto'];

  $a = get_datos($cns0);

  while(odbc_fetch_row($a))
  {
  $respuesta+= odbc_result($a,'cant');
  }

  echo $respuesta;
  }

  if($_POST['funcion']=="borra_subproyecto")
  {
  $respuesta = 0;

  $cns0 = "delete from subproyectos where id=".$_POST['subproyecto'];

  $a = get_datos($cns0);

  $cns0 = "select COUNT(id) as cant from subproyectos where id=".$_POST['subproyecto'];
  $a = get_datos($cns0);

  while(odbc_fetch_row($a))
  {
  $respuesta= odbc_result($a,'cant');
  }

  echo $respuesta;
  }
 */
?>