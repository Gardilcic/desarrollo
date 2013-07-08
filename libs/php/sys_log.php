<?php

/*funcion que genera el syslog en la base de datos*/
/*INFORMACION DE ARQUITECTURA
ACCIONES:
1: lectura
2: escritura
3: ejecutar procedimiento
4: Validacion de usuario en pagina


**************************************************/
require_once('sql_sigp.php');
@session_start();

function registra_log($script, $accion, $tabla)
{
	$hora = date('H:i:s');
	$script = str_replace("'","|",$script);
	$cns="insert into sys_log (accion, tabla_ejecucion, script, usuario_ejecutor, hora) values ";
	$cns.=" ('".$accion."','".$tabla."','".$script."','".$_SESSION["usuario"]['usuario']."','".$hora."')";
	$a = get_datos($cns);
}

?>