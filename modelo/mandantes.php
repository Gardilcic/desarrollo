<?php
	require_once('../libs/php/sql_sigp.php');
	
	if($_POST['funcion']=="ListarMandantes"){
		
		$var1 = "select * from dbo.empresas_mandantes m INNER JOIN dbo.empresas e ON m.id_empresa = e.id" ;	
							
		$a = get_datos_sigp($var1);
		
		while(odbc_fetch_row($a)){
			for($contador=1; $contador<=odbc_num_fields($a); $contador++)
			{
				$nombre = odbc_field_name($a, $contador);
				$proyectos[$nombre]=odbc_result($a,$contador);
			}
			$objeto[]=$proyectos;
		}		
		echo json_encode($objeto);
	}



?>
