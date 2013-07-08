<?php

function encoder($texto)
{
	return utf8_encode($texto);
}

function decoder($texto)
{
	return utf8_decode($texto);
}

function alert($texto)
{
	echo "<script type='text/javascript'>alert('".$texto."');</script>";
}

function numero_dia($nro)
{
	$respuesta="Lunes";
	switch($nro)
	{
		case 1:
			$respuesta="Lunes";
			break;
		case 2:
			$respuesta="Martes";
			break;
		case 3:
			$respuesta="Miércoles";
			break;
		case 4:
			$respuesta="Jueves";
			break;
		case 5:
			$respuesta="Viernes";
			break;
		case 6:
			$respuesta="Sábado";
			break;
		case 7:
			$respuesta="Domingo";
			break;
	}
	return $respuesta;
}

?>