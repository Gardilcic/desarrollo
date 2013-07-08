<?php
require_once('generales.php');

function print_error($codigo)
{
	switch($codigo)
	{
		case 1000:
			alert('Los datos ingresados no coinciden con los existentes. Por favor revise que los ha ingresado correctamente.');
			break;
	}
}

?>