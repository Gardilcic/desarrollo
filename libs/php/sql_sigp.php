<?php
function get_datos($cns)
{
	// Se define la cadena de conexiÃ³n
	$dsn = "Driver={SQL Server};Server=GARDILCIC-014;Database=sigp;Integrated Security=SSPI;Persist Security Info=False;";
	// Se realiza la conexÃ³n con los datos especificados anteriormente
	$conn = odbc_connect( $dsn, 'sigp', 's1gp4ssw0rd' );
	//$conn = odbc_connect( $dsn, 'indumotora', '' );
	if (!$conn)
	{
		exit( "Error al conectar: " . $conn);
	}
	// Se define la consulta que va a ejecutarse, como en sql
	//$sql = "select nombre, descripcion from estacion";
	// Se ejecuta la consulta y se guardan los resultados en el recordset rs
	$rs = odbc_exec( $conn, $cns );
	if ( !$rs )
	{
		exit( "Error en la consulta SQL ".$cns  );
	}
	// Se muestran los resultados
	/*while ( odbc_fetch_row($rs) ) 
	{
		$resultado=odbc_result($rs,"nombre");
		echo $resultado;
		$resultado=odbc_result($rs,"descripcion");
		echo $resultado;
	}*/
	// Se cierra la conexiÃ³n
	//odbc_close( $conn );
	return $rs;
	odbc_close( $conn );
}

function get_datos_sigp($cns)
{
	// Se define la cadena de conexiÃ³n
	$dsn = "Driver={SQL Server};Server=GARDILCIC-014;Database=sigp;Integrated Security=SSPI;Persist Security Info=False;";
	// Se realiza la conexÃ³n con los datos especificados anteriormente
	$conn = odbc_connect( $dsn, 'sigp', 's1gp4ssw0rd' );
	//$conn = odbc_connect( $dsn, 'indumotora', '' );
	if (!$conn)
	{
		exit( "Error al conectar: " . $conn);
	}
	// Se define la consulta que va a ejecutarse, como en sql
	//$sql = "select nombre, descripcion from estacion";
	// Se ejecuta la consulta y se guardan los resultados en el recordset rs
	$rs = odbc_exec( $conn, $cns );
	if ( !$rs )
	{
		exit( "Error en la consulta SQL ".$cns  );
	}
	// Se muestran los resultados
	/*while ( odbc_fetch_row($rs) ) 
	{
		$resultado=odbc_result($rs,"nombre");
		echo $resultado;
		$resultado=odbc_result($rs,"descripcion");
		echo $resultado;
	}*/
	// Se cierra la conexiÃ³n
	//odbc_close( $conn );
	return $rs;
	odbc_close( $conn );
}


function cierra_conn()
{
	//odbc_close( $conn );
	$a="";
}

function set_datos($cns)
{
	// Se define la cadena de conexiÃ³n
	$dsn = "Driver={SQL Server};Server=GARDILCIC-014;Database=sigp;Integrated Security=SSPI;Persist Security Info=False;";
	// Se realiza la conexÃ³n con los datos especificados anteriormente
	$conn = odbc_connect( $dsn, 'gestiondocs', 's1gp4ssw0rd' );
	//$conn = odbc_connect( $dsn, 'indumotora', '' );
	if (!$conn)
	{
		exit( "Error al conectar: " . $conn);
	}
	// Se define la consulta que va a ejecutarse, como en sql
	//$sql = "select nombre, descripcion from estacion";
	// Se ejecuta la consulta y se guardan los resultados en el recordset rs
	$rs = odbc_exec( $conn, $cns );
	// Se cierra la conexiÃ³n
	odbc_close( $conn );
}
?>