<?php
session_start();
if(isset($_POST['peso']) && isset($_POST['ruta']) && isset($_POST['extension'])) {
	$errores = array();
	$errores = "";
	$peso_archivo = $_POST["peso"];
	$ruta_destino = $_POST["ruta"];	
	$identificador = $_POST["identificador"]; // para agregar varias imagenes

	$extension_archivo = strtolower($_POST["extension"]);
		
	if( $_FILES["images"]["size"] > 0 && $_FILES["images"]["size"] < $peso_archivo ) { // VERIFICA LOS PESOS DE LA IMAGEN
	    
	    $extension_actual = strtolower(end(explode(".", $_FILES["images"]["name"]))); // SACO LA EXTENSION DEL ARCHIVO A SUBIR
	    $extension_archivo = str_replace("/", " ", $extension_archivo);
	    $variable = stristr($extension_archivo, trim($extension_actual));

	    if(strlen($variable) > 0) {
		    
		    if ($error == UPLOAD_ERR_OK) {
		        $name = date('Ymdhis') . "." . $extension_actual;
		        move_uploaded_file( $_FILES["images"]["tmp_name"], $ruta_destino . $name );
		        $_SESSION[$identificador] = $ruta_destino . $name;
		        $errores = array( 'mensaje' => "Archivo se cargo con exito!");
		        echo var_dump($_SESSION);
		    }
	    }
	    else {
	    	$errores = array( 'mensaje' => "La extension del archivo seleccionado no esta permitida. Use archivos : ".str_replace("/", " ", $extension_archivo));
	    }
    }
    else {
    	$errores = array( 'mensaje' => "Tamano del archivo es muy grande o no es valido.");
    }

}

if(sizeof($errores)>0) {
	echo json_encode($errores);
}
else {
	$errores = array( 'mensaje' => 'Archivo subio con exito' );
	echo json_encode($errores);
}
?>